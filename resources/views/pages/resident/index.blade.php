@extends('layouts.app')

@section('content')
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Penduduk</h1>
            <a href="/resident/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-plus fa-sm text-white-50"></i> TAMBAH DATA PENDUDUK</a>
        </div>

        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body py-3">
                        <h6 class="m-px font-weight-bold text-primary">List Penduduk</h6>
                            <table class="table table-bordered table-hovered table-responsive">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>NIK</th>
                                        <th>NAME</th>
                                        <th>JENIS KELAMIN</th>
                                        <th>TEMPAT LAHIR</th>
                                        <th>TANGGAL LAHIR</th>
                                        <th>ALAMAT</th>
                                        <th>AGAMA</th>
                                        <th>STATUS PERKAWINAN</th>
                                        <th>PEKERJAAN</th>
                                        <th>TELEPON</th>
                                        <th>STATUS PENDUDUK</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                @if (count($residents) < 1)
                                    <tbody>
                                        <tr>
                                            <td colspan="13" class="text-center">
                                                <span>Tidak Ada Data Penduduk</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                @else
                                    <tbody>
                                        @foreach ($residents as $resident)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $resident->nik }}</td>
                                                <td>{{ $resident->name }}</td>
                                                <td>{{ $resident->gender }}</td>
                                                <td>{{ $resident->birth_place  }}</td>
                                                <td>{{ $resident->birth_date }}</td>
                                                <td>{{ $resident->address }}</td>
                                                <td>{{ $resident->religion }}</td>
                                                <td>{{ $resident->marital_status }}</td>
                                                <td>{{ $resident->occupation }}</td>
                                                <td>{{ $resident->phone }}</td>
                                                <td>{{ $resident->status }}</td>

                                                <td>
                                                    <div class="text-wrap d-flex justify-content-center gap-5">
                                                        <a href="/resident/{{ $resident->id }}" class="btn btn-warning btn-sm d-inline-block mr-2">
                                                            <i class="fas fa-pen">
                                                            </i>
                                                        </a>
                                                        <a href="/resident/{{ $resident->id }}" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash">
                                                            </i>
                                                        </a>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                    </div>
                </div>
            </div>
        </div>
@endsection
