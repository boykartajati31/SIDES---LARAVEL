@extends('layouts.app')

@section('content')
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> ACCOUNTS REQUEST </h1>
        </div>

        @if (session('success'))
            <script>
                Swal.fire({
                title: "Success ..!",
                text: "{{ session()->get('success') }}",
                icon: "success"
                });
            </script>
        @endif

        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body py-3">
                        <h6 class="m-px font-weight-bold text-primary">List accounts-request </h6>
                            <div style="overflow-x: auto">
                                <table class="table table-bordered table-hovered" style="min-width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th>NAME</th>
                                            <th>EMAIL</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    @if (count($users) < 1)
                                        <tbody>
                                            <tr>
                                                <td colspan="3" class="text-center">
                                                    <span>Tidak Ada Data Penduduk</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    @else
                                        <tbody>
                                            @foreach ($users as $item)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td>
                                                        <div class="text-wrap d-flex justify-content-center gap-5">

                                                            <button type="button"  class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmationReject-{{ $item->id }}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>

                                                            <button type="button"  class="btn btn-success btn-sm mx-2" data-bs-toggle="modal" data-bs-target="#confirmationApprove-{{ $item->id }}">
                                                                <i class="fas fa-check-circle"></i>
                                                            </button>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @include('pages.account-request.confirmation-approve')
                                            @include('pages.account-request.confirmation-reject')
                                            @endforeach
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
