@extends('layouts.app')

@section('title', 'Detail Produk')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>PERBARUI DETAIL PRODUK</h4>
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
                                    <div class="form-row">
                                        <div class="col-md-4 mt-3">
                                            <label for="per" style="font-weight: bold">Periode</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-history"></i>
                                                    </div>
                                                </div>
                                                <select name="periode" id="per"
                                                    class="form-control @error('periode') is-invalid @enderror">
                                                    @foreach (['Reguler', 'Seasonal'] as $option)
                                                        <option value="{{ $option }}"
                                                            {{ $option == $detailProduct->periode ? 'selected' : '' }}>
                                                            {{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mt-3">
                                            <label for="tax" style="font-weight: bold">Jenis Pajak</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-percentage"></i>
                                                    </div>
                                                </div>
                                                <select name="tax_type" id="tax"
                                                    class="form-control @error('tax_type') is-invalid @enderror">
                                                    @foreach (['NON-PPN', 'PPN'] as $option)
                                                        <option value="{{ $option }}"
                                                            {{ $option == $detailProduct->tax_type ? 'selected' : '' }}>
                                                            {{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-right mt-4">
                                        <button class="btn btn-lg btn-outline-primary" type="submit">
                                            <i class="fa fa-paper-plane"></i> UPDATE</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-right">
                                <a href="{{ route('app.detail-products.index') }}" class="btn btn-lg btn-outline-success">
                                    <i class="fas fa-arrow-left"></i>
                                    KEMBALI
                                </a>
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
