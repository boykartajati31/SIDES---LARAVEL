@extends('layouts.app')

@section('content')
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Data Penduduk</h1>
        </div>

        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body py-3">
                        <form action="/resident/{{ $resident->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group ">
                                <label for="nik">NIK</label>
                                <input type="number"  id="nik" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $resident->nik) }}" >
                                @error('nik')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $resident->name) }}" >
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group" value="{{ old('gender') }}">
                                <label for="gender">Jenis Kelamin</label>
                                <select class="form-control" id="gender" name="gender" >
                                    @foreach ([
                                        (object) [
                                             "label" => "Laki-laki",
                                             "value" => "male",
                                        ],
                                        (object) [
                                             "label" => "Perempuan",
                                             "value" => "female",
                                        ]
                                    ] as $gender)
                                        <option value="{{ $gender->value }}" @selected(old('gender', $resident->gender) == $gender->value)>{{ $gender->label }}</option>
                                    @endforeach
                                    <option value="male">Laki-laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="birth_place">Tempat Lahir</label>
                                <input type="text" class="form-control @error('birth_place') is-invalid @enderror" id="birth_place" name="birth_place" value="{{ old('birth_place', $resident->birth_place) }}" >
                                @error('birth_place')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="birth_date">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date', $resident->birth_date) }}" >
                                @error('birth_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="address">Alamat</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $resident->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group" value="{{ old('religion') }}">
                                <label for="religion">Agama</label>
                                <input type="text" class="form-control @error('religion') is-invalid @enderror" id="religion" name="religion" value="{{ old('religion', $resident->religion) }}" >
                                @error('religion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group" value="{{ old('marital_status') }}">
                                <label for="marital_status">Status Perkawinan</label>
                                <select class="form-control" id="marital_status" name="marital_status" >
                                    @foreach ([
                                        (object) [
                                            "label" => "Belum Menikah",
                                            "value" => "single",
                                ],
                                        (object) [
                                            "label" => "Sudah Menikah",
                                            "value" => "married",
                                ],
                                        (object) [
                                            "label" => "Cerai",
                                            "value" => "divorced",
                                ],
                                        (object) [
                                            "label" => "Janda/Duda",
                                            "value" => "widowed",
                                ],
                                    ] as $item)
                                        <option value="{{ $item->value }}" @selected(old('marital_status', $resident->marital_status) == $item->value)>{{ $item->label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="occupation">Pekerjaan</label>
                                <input type="text" class="form-control @error('occupation') is-invalid @enderror" id="occupation" name="occupation" value="{{ old('occupation', $resident->occupation) }}" >
                                @error('occupation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">Telepon</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" inputmode="numeric" value="{{ old('phone', $resident->phone) }}" >
                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group" value="{{ old('status') }}">
                                <label for="status">Status Penduduk</label>
                                <select class="form-control" id="status" name="status" >
                                    @foreach ([
                                        (object) [
                                            "label" => "Aktif",
                                            "value" => "active",
                                        ],
                                        (object) [
                                            "label" => "Pindah",
                                            "value" => "moved",
                                        ],
                                        (object) [
                                            "label" => "Wafat",
                                            "value" => "deceased",
                                ],
                                    ] as $item)
                                        <option value="{{ $item->value }}" @selected(old('status', $resident->status) == $item->value)>{{ $item->label }}</option>
                                    @endforeach
                                </select>
                            </div>

                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end" style="gap: 5px;">
                            <a href="/resident" class="btn btn-outline-secondary mr-2">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-outline-warning">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
@endsection
