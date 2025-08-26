@extends('layouts.app')

@section('content')
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Aduan</h1>
        </div>

        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body py-3">
                        <form action="/complaint" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="form-group ">
                                <label for="title">JUDUL</label>
                                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" >
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="content">ISI ADUAN</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" cols="30" rows="10" value="{{ old('content') }}"></textarea>
                                @error('content')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="photo_proof">FOTO BUKTI</label>
                                <input type="file" class="form-control @error('photo_proof') is-invalid @enderror" id="photo_proof" name="photo_proof" value="{{ old('photo_proof') }}" >
                                @error('photo_proof')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end" style="gap: 5px;">
                            <a href="/complaint" class="btn btn-outline-secondary mr-2">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-outline-primary">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
@endsection


