@extends('layouts.main')

@section('title', 'Menu')
@section('breadcrumb-item', 'Katering')

@section('breadcrumb-item-active', 'Daftar Menu')

@section('content')
    <div class="row justify-content-center mb-3">
        <div class="col-md-6">
            <form action="{{ route('customer.pilih-menu') }}" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Cari menu" value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @foreach ($menus as $key => $menu)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 d-flex flex-column">
                                    <img src="{{ asset('images/menu/' . $menu->image) }}" class="card-img-top w-100" style="height: 200px; object-fit: cover;" alt="{{ $menu->name }}">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $menu->name }} - Rp{{ number_format($menu->price, 0, ',', '.') }}</h5>
                                        <p class="card-text text-truncate" style="max-height: 3rem; overflow: hidden;">{{ $menu->description }}</p>
                                        <p class="text-muted mb-1">Catering: {{ $menu->merchant->name }}</p>
                    
                                        <div class="align-self-start">
                                            @if ($menu->type == 'makanan')
                                                <span class="badge bg-secondary">Makanan</span>
                                            @elseif ($menu->type == 'snack')
                                                <span class="badge bg-warning">Snack</span>
                                            @elseif ($menu->type == 'minuman')
                                                <span class="badge bg-success">Minuman</span>
                                            @endif
                                        </div>
                    
                                        <div class="mt-auto">
                                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $key }}">Pilih</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="exampleModal{{ $key }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $menu->name }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <img src="{{ asset('images/menu/' . $menu->image) }}" class="img-fluid" alt="{{ $menu->name }}">
                                                </div>
                                                <div class="col-md-12">
                                                    <p class="text-muted my-1">Deskripsi:</p>
                                                    <p>{{ $menu->description }}</p>
                                                    {{-- harga --}}
                                                    <p class="text-muted mb-1">Harga:</p>
                                                    <p>Rp{{ number_format($menu->price, 0, ',', '.') }}</p>
                                                    {{-- catering --}}
                                                    <p class="text-muted mb-1">Catering:</p>
                                                    <p>{{ $menu->merchant->name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('customer.add-to-cart', ['id' => encrypt($menu->id)]) }}" method="POST" class="w-100">
                                                @csrf
                                                <div class="d-flex w-100">
                                                    <input type="number" name="qty" class="form-control me-2" value="1" min="1" required>
                                                    <button type="submit" class="btn btn-primary">Masukkan ke Keranjang</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $menus->links() }}
                </div>    
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @if (session('cart-success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('cart-success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @elseif (session('cart-error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ session('cart-error') }}',
                });
            </script>
    @endif
@endsection
