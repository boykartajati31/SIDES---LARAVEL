@extends('layouts.app')

@section('content')
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">ADUAN</h1>
            <a href="/complaint/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-plus fa-sm text-white-50"></i> BUAT ADUAN </a>
        </div>

        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body py-3">
                        <h6 class="m-px font-weight-bold text-primary">List Aduan</h6>
                            <table class="table table-bordered table-hovered table-responsive">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
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
                                                <td>{{ $item->title }}</td>
                                                <td>{!! wordwrap($item->content, 50, "<br>\n") !!}</td>
                                                <td>{{ $item->status_label }}</td>
                                                <td>
                                                    @if (isset($item->photo_proof))
                                                        <a href="{{ $item->photo_proof }}">
                                                            <img src="{{ $item->photo_proof }}" alt="foto_bukti" style="max-width: 300px;">
                                                        </a>
                                                    @else
                                                        Tidak Ada
                                                    @endif
                                                </td>
                                                <td>{{ $item->report_date_label }}</td>

                                                <td>
                                                    <div class="text-wrap d-flex justify-content-center gap-5">
                                                        <a href="/complaint/{{ $item->id }}" class="btn btn-warning btn-sm d-inline-block mr-2">
                                                            <i class="fas fa-pen">
                                                            </i>
                                                        </a>
                                                        <button type="button"  class="btn btn-danger btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#confirmationDelete-{{ $item->id }}">
                                                            <i class="fas fa-trash">
                                                            </i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
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
        </div>
@endsection
