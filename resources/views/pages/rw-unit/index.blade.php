@extends('layouts.app')

@section('content')
<div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Master Data RW</h1>
                    <a href="/rw-unit/create"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-plus fa-sm text-white-50"></i> TAMBAH DATA
                    </a>
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
                        <h6 class="m-0 font-weight-bold text-primary">Daftar RW</h6>
                    </div>
                    <div class="card-body" style="overflow-x: auto">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th class="text-center">RW (Nomor)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                @if (count($rw_units) < 1)
                                    <tbody>
                                        <tr>
                                            <td colspan="13" class="text-center">
                                                <span>Tidak Ada Data RW</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                @else
                                    <tbody>
                                        @foreach ($rw_units as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration + $rw_units->firstItem() - 1  }}</td>
                                                <td>RW {{ $item->number }}</td>
                                                <td>
                                                        <div class="text-wrap d-flex justify-content-center gap-5">
                                                            <a href="/rw-unit/{{ $item->id }}" class="btn btn-warning btn-sm d-inline-block mr-2">
                                                                <i class="fas fa-pen"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-danger btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#confirmationDelete-{{ $item->id }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                </td>
                                            </tr>
                                            @include('pages.rw-unit.confirmation-delete')
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                    </div>
                    @if ($rw_units->lastPage() > 1)
                        <div class="card-footer">
                            {{ $rw_units->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
            </div>
</div>
@endsection


