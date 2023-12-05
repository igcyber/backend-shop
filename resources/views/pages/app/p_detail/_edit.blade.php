@extends('layouts.app')

@section('title', 'Tambah Detil Produk')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Halaman Diskon Produk</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Perbarui Diskon Produk</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('app.detail-products.update', $detailProduct->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    {{-- SELECT PRODUCT & INPUT BUY PRICE --}}
                                    <div class="form-row">
                                        <div class="col-md-4 mt-2">
                                            <label for="product" style="font-weight: bold">Produk</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-boxes"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control"
                                                    value="{{ $detailProduct->product->title }}" readonly>
                                                <input type="hidden" value="{{ $detailProduct->product_id }}"
                                                    name="product_id">
                                            </div>
                                        </div>

                                        <div class="col-md-4 mt-2">
                                            <label for="rupiahInput" style="font-weight: bold; padding-right:3%;">Harga
                                                Jual</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-money-bill"></i>
                                                    </div>
                                                </div>
                                                <input type="text" name="sell_price_duz" class="form-control"
                                                    value=" {{ moneyFormat($detailProduct->sell_price_duz) }}" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mt-2">
                                            <label for="discount" style="font-weight: bold">Diskon (%)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-percent"></i>
                                                    </div>
                                                </div>
                                                <input type="text" name="discount"
                                                    class="form-control @error('discount') is-invalid @enderror"
                                                    placeholder="0" id="discount" value="{{ $detailProduct->discount }}">
                                                @error('discount')
                                                    <div class="invalid-feedback" style="display: block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-right mt-3">
                                        <button class="btn btn-sm btn-primary" type="submit">
                                            <i class="fa fa-paper-plane"></i> Update</button>
                                        <a href="{{ route('app.detail-products.index') }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-arrow-left"></i>
                                            Kembali
                                        </a>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush
