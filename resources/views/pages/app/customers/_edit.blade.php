@extends('layouts.app')

@section('title', 'Perbarui Outlet')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <div class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>PERBARUI OUTLET</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('app.customers.update', $customer->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="outlet">Nama Outlet</label>
                                                <select name="outlet_id" id="outlet"
                                                    class="form-control @error('outlet_id') is-invalid @enderror" readonly>
                                                    <option selected>{{ $customer->outlet->name }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sales">Sales</label>
                                                <select name="sales_id" id="sales"
                                                    class="form-control @error('sales_id') is-invalid @enderror" readonly>
                                                    <option selected>{{ $customer->seller->name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row mt-1">
                                        <div class="col-md-3">
                                            <label for="nomor">Nomor</label>
                                            <input type="text" id="nomor"
                                                class="form-control @error('nomor') is-invalid @enderror" name="nomor"
                                                placeholder="Tuliskan Nomor Outlet" value="{{ $customer->nomor }}">
                                            @error('nomor')
                                                <div class="invalid-feedback" style="display: block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="klasifikasi">Klasifikasi</label>
                                            <select name="klasifikasi" id="klasifikasi"
                                                class="form-control @error('klasifikasi') is-invalid @enderror">
                                                <option disabled>PILIH KLASIFIKASI</option>
                                                @foreach (['Toko', 'Perorangan', 'MT', 'Ps. Basah', 'Grosir', 'Retail'] as $option)
                                                    <option value="{{ $option }}"
                                                        {{ $option == $customer->klasifikasi ? 'selected' : '' }}>
                                                        {{ $option }}</option>
                                                @endforeach
                                            </select>
                                            @error('klasifikasi')
                                                <div class="invalid-feedback" style="display: block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="telp">No. Telp</label>
                                            <input id="telp" name="no_telp" type="text"
                                                value="{{ $customer->no_telp }}" placeholder="Tuliskan No. Telp Outlet"
                                                class="form-control @error('no_telp') is-invalid @enderror">
                                            @error('no_telp')
                                                <div class="invalid-feedback" style="display: block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label for="hrg_jual">Harga Jual</label>
                                            <input id="hrg_jual" name="hrg_jual" type="text"
                                                value="{{ $customer->hrg_jual }}" placeholder="Tuliskan Harga Jual"
                                                class="form-control @error('hrg_jual') is-invalid @enderror">
                                            @error('hrg_jual')
                                                <div class="invalid-feedback" style="display: block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="form-row mt-3">
                                        <div class="col-md-12">
                                            <label for="address" style="font-weight: bold">Alamat Outlet</label>
                                            <textarea id="address" name="address" class="summernote-simple @error('address') is-invalid @enderror">
                                            {{ $customer->address }}
                                        </textarea>
                                        </div>
                                    </div>
                                    <div class="text-right mt-3">
                                        <button class="btn btn-lg btn-outline-primary" type="submit">
                                            <i class="fa fa-paper-plane"></i> PERBARUI</button>

                                    </div>
                                </form>
                            </div>
                            <hr>
                            <div class="card-footer text-right">
                                <a href="{{ route('app.customers.index') }}" class="btn btn-lg btn-outline-success">
                                    <i class="fas fa-arrow-left"></i>
                                    KEMBALI
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
