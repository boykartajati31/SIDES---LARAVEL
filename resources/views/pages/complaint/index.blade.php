@extends('layouts.app')

@section('content')
<div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ auth()->user()->role_id == \App\Models\Role::role_admin ? 'ADUAN WARGA' : 'ADUAN' }}</h1>
                @if(Auth::user()->role != 'admin')
                    <a href="/complaint/create"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-plus fa-sm text-white-50"></i> TAMBAH ADUAN
                    </a>
                @endif
        </div>

        @if (session('error'))
            <script>
                Swal.fire({
                title: "Terjadi Kesalahan ..!",
                text: "{{ session()->get('error') }}",
                icon: "error"
                });
            </script>
        @elseif (session('success'))
            <script>
                Swal.fire({
                title: "Sukses",
                text: "{{ session()->get('success') }}",
                icon: "success"
                });
            </script>
        @endif

            <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Aduan Masyarakat</h6>
                    </div>
                    <div class="card-body" style="overflow-x: auto">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        @if (auth()->user()->role_id == \App\Models\Role::role_admin)
                                            <th>NAMA PENDUDUK</th>
                                        @endif
                                        <th>JUDUL</th>
                                        <th>ISI ADUAN</th>
                                        <th>STATUS</th>
                                        <th>FOTO BUKTI</th>
                                        <th>TANGGAL LAPORAN</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                @if (count($complaints) < 1)
                                    <tbody>
                                        <tr>
                                            <td colspan="13" class="text-center">
                                                <span>Tidak Ada Data Aduan</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                @else
                                    <tbody>
                                        @foreach ($complaints as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration + $complaints->firstItem() - 1  }}</td>
                                                @if (auth()->user()->role_id == \App\Models\Role::role_admin)
                                                    <td>{{ $item->resident->name }}</td>
                                                @endif
                                                <td>{{ $item->title }}</td>
                                                <td>{{ Str::limit($item->content, 100) }}</td>
                                                {{-- <td>{{ $item->status_label }}</td> --}}
                                                <td>
                                                      <span class="badge badge-{{ $item->status_label == 'Baru' ? 'info' : ($item->status_label == 'Sedang di Proses' ? 'warning' : ($item->status_label == 'Selesai' ? 'success' : 'secondary')) }}">
                                                        {{ $item->status_label }}
                                                </span>
                                                </td>
                                                <td>
                                                     @if($item->photo_proof)
                                                        @if(Storage::disk('public')->exists($item->photo_proof))
                                                            <img src="{{ asset('storage/' . $item->photo_proof) }}"
                                                                alt="Foto Bukti"
                                                                class="img-thumbnail"
                                                                style="width: 80px; height: 60px; object-fit: cover;"
                                                                data-toggle="modal"
                                                                data-target="#imageModal{{ $item->id }}"
                                                                style="cursor:pointer;">
                                                        @else
                                                            <span class="text-muted">File tidak ditemukan</span>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">Tidak ada foto</span>
                                                    @endif
                                                </td>
                                                <td>{{ $item->report_date_label }}</td>
                                                <td>
                                                    @if (auth()->check() && auth()->user()->role_id == \App\Models\Role::role_user && strtolower($item->status) == 'new')
                                                        <div class="text-wrap d-flex justify-content-center gap-5">
                                                            <a href="/complaint/{{ $item->id }}" class="btn btn-warning btn-sm d-inline-block mr-2">
                                                                <i class="fas fa-pen"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-danger btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#confirmationDelete-{{ $item->id }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    @elseif (auth()->user()->role_id == \App\Models\Role::role_admin)
                                                        <form id="formChangeStatus-{{ $item->id }}" action="/complaint/update-status/{{ $item->id }}" method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <div class="form-group">
                                                                <select name="status" class="form-control" style="min-width: 150px"
                                                                        onchange="document.getElementById('formChangeStatus-{{ $item->id }}').submit()">
                                                                    @foreach ([
                                                                        ['label' => 'Baru', 'value' => 'new'],
                                                                        ['label' => 'Sedang di Proses', 'value' => 'processing'],
                                                                        ['label' => 'Selesai', 'value' => 'completed'],
                                                                    ] as $status)
                                                                        <option value="{{ $status['value'] }}"
                                                                                @selected(strtolower($item->status) == strtolower($status['value']))>
                                                                            {{ $status['label'] }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>

                                            <!-- Modal untuk gambar -->
                                            @if($item->photo_proof && Storage::disk('public')->exists($item->photo_proof))
                                            <div class="modal fade" id="imageModal{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Foto Bukti - {{ $item->title }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset('storage/' . $item->photo_proof) }}"
                                                                alt="Foto Bukti"
                                                                class="img-fluid">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                        @include('pages.complaint.confirmation-delete')
                                            @if (!is_null($item->user_id))
                                                @include('pages.complaint.detailAccount')
                                            @endif
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                    </div>
                    @if ($complaints->lastPage() > 1)
                        <div class="card-footer">
                            {{ $complaints->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
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

