@extends('layouts.app')

@section('content')
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah RW</h1>
        </div>

        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body py-3">
                        <form action="/rw-unit" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="form-group ">
                                <label for="number">RW</label>
                                <input type="text" id="number" name="number" class="form-control @error('number') is-invalid @enderror" value="{{ old('number') }}" >
                                @error('number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                    <div class="">
                        <div class="d-flex justify-content-end" style="gap: 5px;">
                            <a href="/rw-unit" class="btn btn-outline-secondary mr-2">
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


