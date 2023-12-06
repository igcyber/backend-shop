@extends('front-end.layouts.master')

@section('title', 'Keranjang')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
    <div class="container" style="padding-top: 20vh">
        <div class="title text-center pb-5">
            <h2>RINGKASAN PESANAN</h2>
            <div class="custom-horizontal-line"></div>
        </div>
        <div class="container-fluid">
            <div class="row px-xl-5">
                <div class="col-sm-6 mx-auto">
                    <div class="card">
                        <form action="{{ route('app.order', auth()->user()->id) }}" method="POST">
                            @csrf
                            {{-- <h5 class="card-header bg-primary text-light">Total Bayar</h5> --}}
                            <div class="card-body">
                                {{-- @dd($carts) --}}
                                <h5 class="card-title">Barang : </h5>
                                @if ($nonZeroQuantityCarts->count() > 0)
                                    @foreach ($nonZeroQuantityCarts as $cart)
                                        <input type="hidden" name="detail_id[]" value="{{ $cart->detail_id }}">
                                        <input type="hidden" name="qty_duz[]" value="{{ $cart->qty_duz }}">
                                        <input type="hidden" name="qty_pak[]" value="{{ $cart->qty_pak }}">
                                        <input type="hidden" name="qty_pcs[]" value="{{ $cart->qty_pcs }}">
                                        <input type="hidden" name="price_duz[]"
                                            value="{{ $cart->productDetail->sell_price_duz }}">
                                        <input type="hidden" name="price_pak[]"
                                            value="{{ $cart->productDetail->sell_price_pak }}">
                                        <input type="hidden" name="price_pcs[]"
                                            value="{{ $cart->productDetail->sell_price_pcs }}">

                                        <ul style="margin-bottom: 0rem">
                                            @foreach (['duz', 'pak', 'pcs'] as $unit)
                                                @php
                                                    $quantity = $cart->{"qty_$unit"};
                                                @endphp
                                                @if ($quantity > 0)
                                                    <li>{{ $quantity . " $unit " . $cart->productDetail->product->title }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endforeach
                                @else
                                    <p>No items with non-zero quantities in the cart.</p>
                                @endif
                                <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                                <h5 class="card-title mt-2">Total Pembayaran : {{ moneyFormat($subtotal) }}</h5>
                                <p>
                                    <small style="font-weight: bolder">*Bayar Saat Sales Datang Ke Toko Anda</small>
                                    <br>
                                    <small style="font-weight: bolder">*Pastikan Pesanan Anda Sudah Sesuai</small>
                                </p>
                                {{-- <a href="{{ route('app.checkout', auth()->user()->id) }}" class="btn btn-primary">Checkout</a> --}}
                                <a href="{{ route('app.cart.get', auth()->user()->id) }}"
                                    class="btn btn-sm btn-danger">Kembali</a>
                                <button type="submit" class="btn btn-sm btn-success">Pesan Sekarang</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection
@push('scripts')
@endpush
