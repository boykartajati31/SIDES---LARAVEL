


@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">List Aduan</h1>
        <a href="{{ route('complaint.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Aduan
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Aduan Masyarakat</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>JUDUL</th>
                            <th>ISI ADUAN</th>
                            <th>STATUS</th>
                            <th>FOTO BUKTI</th>
                            <th>TANGGAL LAPORAN</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaints as $index => $complaint)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $complaint->title }}</td>
                            <td>{{ Str::limit($complaint->content, 100) }}</td>
                            <td>
                                <span class="badge badge-{{ $complaint->status == 'Baru' ? 'primary' : ($complaint->status == 'Proses' ? 'warning' : 'success') }}">
                                    {{ $complaint->status }}
                                </span>
                            </td>
                            <td>
                                @if($complaint->photo_proof)
                                    @if(Storage::disk('public')->exists($complaint->photo_proof))
                                        <img src="{{ asset('storage/' . $complaint->photo_proof) }}"
                                             alt="Foto Bukti"
                                             class="img-thumbnail"
                                             style="width: 80px; height: 60px; object-fit: cover;"
                                             data-toggle="modal"
                                             data-target="#imageModal{{ $complaint->id }}"
                                             style="cursor: pointer;">
                                    @else
                                        <span class="text-muted">File tidak ditemukan</span>
                                    @endif
                                @else
                                    <span class="text-muted">Tidak ada foto</span>
                                @endif
                            </td>
                            <td>{{ $complaint->created_at->format('d M Y H:i:s') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('complaint.show', $complaint->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('complaint.edit', $complaint->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('complaint.destroy', $complaint->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus aduan ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal untuk gambar -->
                        @if($complaint->photo_proof && Storage::disk('public')->exists($complaint->photo_proof))
                        <div class="modal fade" id="imageModal{{ $complaint->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Foto Bukti - {{ $complaint->title }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('storage/' . $complaint->photo_proof) }}"
                                             alt="Foto Bukti"
                                             class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data aduan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($complaints->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $complaints->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .table th {
        background-color: #f8f9fa;
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
    }

    .table td {
        vertical-align: middle;
    }

    .badge {
        font-size: 0.85em;
        padding: 0.4em 0.6em;
    }

    .btn-group .btn {
        margin-right: 2px;
    }

    .img-thumbnail {
        transition: transform 0.2s;
    }

    .img-thumbnail:hover {
        transform: scale(1.1);
    }
</style>
@endsection

@section('scripts')
<script>
    // Script untuk modal gambar
    $(document).ready(function() {
        $('.img-thumbnail').click(function() {
            var modalId = $(this).data('target');
            $(modalId).modal('show');
        });
    });
</script>
@endsection


