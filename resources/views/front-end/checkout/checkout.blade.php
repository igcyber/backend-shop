@extends('front-end.layouts.master')

@section('title', 'Keranjang')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
    <div class="container" style="padding-top: 20vh">
        <div class="container-fluid">
            <div class="row my-1">
                <div class="col-sm-6 mx-auto">
                    <div class="card">
                        <h5 class="card-header bg-primary text-light">Informasi Outlet</h5>
                        <div class="card-body">
                            <form action="{{ route('app.submit') }}" method="POST">
                                @csrf
                                <input type="hidden" name="transaction_id" value="{{ $transaction_id }}">
                                <h5 class="card-title">Nama Outlet: {{ Auth::user()->name }}</h5>
                                <input type="hidden" name="outlet" value="{{ $outlet }}">
                                <h5 class="card-title">Petugas Sales: {{ $seller }}</h5>
                                <input type="hidden" name="seller" value="{{ $seller }}">
                                <h5 class="card-title">Total Bayar: {{ moneyFormat(getCartTotal()) }}</h5>
                                <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                                <h5 class="card-title pull-left">Alamat :</h5>
                                <span id="sub_total">{!! $cmr_address !!}</span>
                                <input type="hidden" name="order_address" value="{!! $cmr_address !!}">

                                <button type="submit" class="btn btn-sm btn-info d-block mt-4">Pesan Produk</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@push('scripts')
@endpush
