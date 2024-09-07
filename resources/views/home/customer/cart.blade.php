@extends('layouts.main')

@section('title', 'Menu')
@section('breadcrumb-item', 'Katering')

@section('breadcrumb-item-active', 'Keranjang')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Keranjang</h4>
                </div>
                <div class="card-body">
                    {{-- list keranjang --}}
                    @if ($cartItems->count() > 0)
                        @foreach ($cartItems as $cart)
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <img src="{{ asset('images/menu/' . $cart->attributes->image) }}" class="img-fluid" style="max-height: 128px; object-fit: cover;" alt="{{ $cart->name }}">
                                    {{-- <img src="{{ asset('images/menu/' . $cart->attributes->image) }}" class="img-thumbnail" alt="{{ $cart->name }}" style="width: 256px; height: 128px; object-fit: cover;" /> --}}
                                </div>
                                <div class="col-md-9">
                                    <h5>{{ $cart->name }}</h5>
                                    <p class="text-muted mb-0">Catering: {{ $cart->attributes->merchant }}</p>
                                    <p class="text-muted mb-0">Rp{{ number_format($cart->price, 0, ',', '.') }}</p>
                                    <p class="text-muted mb-0">Quantity: {{ $cart->quantity }}</p>
                                    <p class="text-muted mb-0">Total: Rp{{ number_format($cart->getPriceSum(), 0, ',', '.'); }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>Keranjang kosong</p>
                    @endif
                </div> 
                <div class="card-footer">
                    <h4 class="text-end">Total: Rp{{ number_format(\Cart::getTotal(), 0, ',', '.') }}</h4>
                </div>   
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Informasi Pengiriman</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('customer.store-cart')}}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="delivery_date" class="form-label">Tanggal Pengiriman</label>
                            <input type="date" class="form-control @error('delivery_date') is-invalid @enderror" id="delivery_date" name="delivery_date" value="{{ old('delivery_date') }}">
                            @error('delivery_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="address" class="form-label">Alamat Pengiriman</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" placeholder="Masukkan Alamat Pengiriman">{{ old('address', auth()->user()->customer->address) }}</textarea>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="note" class="form-label">Catatan</label>
                            <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note" rows="3" placeholder="Masukkan Catatan">{{ old('note') }}</textarea>
                            @error('note')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary w-100">Pesan Sekarang</button>
                        </div> 
                    </form>
                </div>    
            </div>
        </div>
    </div>

@endsection

@section('scripts')
@endsection
