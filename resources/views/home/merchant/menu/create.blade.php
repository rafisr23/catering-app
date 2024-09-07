@extends('layouts.main')

@section('title', 'Menu')
@section('breadcrumb-item', 'Menu')

@section('breadcrumb-item-active', 'Daftar Menu')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Daftar Menu</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('merchant.menu.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="name" class="form-label">Nama Menu</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama Menu">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="type" class="form-label">Jenis Menu</label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                                    <option value="">Pilih Jenis Menu</option>
                                    <option value="makanan" {{ old('type') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                                    <option value="snack" {{ old('type') == 'snack' ? 'selected' : '' }}>Snack</option>
                                    <option value="minuman" {{ old('type') == 'minuman' ? 'selected' : '' }}>Minuman</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" placeholder="Masukkan Slug Menu">
                                @error('slug')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="description" class="form-label">Deskripsi Menu</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Masukkan Deskripsi Menu">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="price" class="form-label">Harga Menu</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" placeholder="Masukkan Harga Menu">
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="image" class="form-label">Gambar Menu</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('merchant.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const name = $('#name');
        const slug = $('#slug');
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#name').on('keyup', function() {
            fetch('/merchant/menu/check-slug?name=' + name.val(), {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            })
            .then(response => response.json())
            .then(data => slug.val(data.slug));
        });

    </script>
@endsection
