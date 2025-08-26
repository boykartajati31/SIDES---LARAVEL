@extends('layouts.app')

@section('content')
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Data Aduan</h1>
        </div>

        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body py-3">
            <form action="/complaint/{{ $complaint->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group ">
                                <label for="title">JUDUL</label>
                                <input type="text"  id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $complaint->title) }}" >
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="content">ISI ADUAN</label>
                                <input type="text" class="form-control @error('content') is-invalid @enderror" id="content" name="content" value="{{ old('content', $complaint->content) }}" >
                                @error('content')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        <div class="form-group">
                            <label for="photo_proof">FOTO BUKTI</label>

                            <!-- Tampilkan gambar yang sudah ada -->
                            @if($complaint->photo_proof)
                                <div class="mb-3">
                                    <p>Gambar saat ini:</p>
                                    @if(Storage::disk('public')->exists('uploads/' . basename($complaint->photo_proof)))
                                        <img src="{{ asset('storage/' . basename($complaint->photo_proof)) }}"
                                             alt="Foto Bukti"
                                             class="img-thumbnail"
                                             style="max-width: 300px; max-height: 300px;">
                                    @elseif(Storage::exists($complaint->photo_proof))
                                        <img src="{{ Storage::url($complaint->photo_proof) }}"
                                             alt="Foto Bukti"
                                             class="img-thumbnail"
                                             style="max-width: 300px; max-height: 300px;">
                                    @else
                                        <div class="alert alert-warning">
                                            File gambar tidak ditemukan. Path: {{ $complaint->photo_proof }}
                                        </div>
                                    @endif
                                    <br>
                                    <small class="text-muted">Path: {{ $complaint->photo_proof }}</small>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    Tidak ada gambar yang diupload sebelumnya.
                                </div>
                            @endif

                            <input type="file" class="form-control @error('photo_proof') is-invalid @enderror" id="photo_proof" name="photo_proof">
                            <small class="form-text text-muted">
                                Biarkan kosong jika tidak ingin mengubah gambar. Format: PNG, JPG, JPEG. Maks: 2MB
                            </small>
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
