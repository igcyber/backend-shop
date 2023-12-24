@extends('layouts.app')

@section('title', 'Perbarui Data Produk')

@push('style')
    <style>
        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        #blink {
            animation: blink 3s infinite;
            /* 1s adalah durasi animasi, infinite agar animasi berulang terus-menerus */
        }
    </style>
@endpush

@section('main')
    <div class="main-content" style="padding-left:14px; !important">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('app.products.update', $product->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-row">
                                        <div class="col-md-6 mt-2">
                                            <label for="img" style="font-weight: bold">Gambar</label>
                                            <span id="blink" class="badge bg-success text-white mb-2">
                                                <i class="fas fa-exclamation-triangle"></i> Boleh Tidak Diisi
                                            </span>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="far fa-image"></i>
                                                    </div>
                                                </div>
                                                <input type="file" name="image"
                                                    class="form-control @error('image') is-invalid @enderror">
                                                @error('image')
                                                    <div class="invalid-feedback" style="display: block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label style="font-weight: bold">Tanggal Kadaluarsa</label>
                                            <span id="blink" class="badge bg-success text-white mb-2">
                                                <i class="fas fa-exclamation-triangle"></i> Boleh Tidak Diisi
                                            </span>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control datepicker" name="exp_date">
                                            </div>
                                        </div>

                                    </div>
                                    {{-- INPUT NAMA & NOMOR --}}
                                    <div class="form-row">
                                        <div class="col-md-6 mt-2">
                                            <label for="title" style="font-weight: bold">Nama</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-box"></i>
                                                    </div>
                                                </div>
                                                <input type="text" id="title"
                                                    class="form-control @error('title') is-invalid @enderror" name="title"
                                                    placeholder="Tuliskan Nama Produk" value="{{ $product->title }}">
                                                @error('title')
                                                    <div class="invalid-feedback" style="display: block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label for="serial" style="font-weight: bold">Nomor</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-barcode"></i>
                                                    </div>
                                                </div>
                                                <input type="text" name="serial_number"
                                                    class="form-control @error('serial_number') is-invalid @enderror"
                                                    placeholder="Tuliskan Nomor Produk"
                                                    value="{{ $product->serial_number }}">
                                                @error('serial_number')
                                                    <div class="invalid-feedback" style="display: block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- INPUT PABRIKAN DAN TIPE PRODUK --}}
                                    <div class="form-row">
                                        <div class="col-md-6 mt-2">
                                            <i class="fas fa-industry"></i>
                                            <label for="vendor" style="font-weight: bold">Pabrikan</label>
                                            <div class="input-group">
                                                <select name="vendor_id" id="vendor"
                                                    class="form-control @error('vendor_id') is-invalid @enderror select2">
                                                    <option disabled selected>PILIH PABRIKAN</option>
                                                    @foreach ($vendors as $v)
                                                        <option value="{{ $v->id }}"
                                                            @if ($product->vendor_id == $v->id) selected @endif>
                                                            {{ $v->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('vendor_id')
                                                    <div class="invalid-feedback" style="display: block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <i class="fas fa-tag"></i>
                                            <label for="tipe" style="font-weight: bold">Tipe</label>
                                            <div class="input-group">
                                                <select name="category_id" id="tipe"
                                                    class="form-control @error('vendor_id') is-invalid @enderror select2">
                                                    <option disabled selected>PILIH TIPE</option>
                                                    @foreach ($categories as $c)
                                                        <option value="{{ $c->id }}"
                                                            @if ($product->category_id == $c->id) selected @endif>
                                                            {{ $c->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <div class="invalid-feedback" style="display: block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- INPUT Stok & Unit PRODUK  --}}
                                    {{-- Stock Dengan Masing-Masing Satuan --}}
                                    <div class="form-row">
                                        <div class="col-md-3 col-lg-3 mt-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-secondary" style="font-weight: bolder">
                                                        Pak/Dus
                                                    </div>
                                                </div>
                                                <input type="text"
                                                    class="form-control @error('dus_pak') is-invalid @enderror"
                                                    value="{{ $product->dus_pak }}" name="dus_pak" placeholder="0"
                                                    readonly>
                                            </div>
                                            @error('dus_pak')
                                                <div class="invalid-feedback" style="display: block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3 col-lg-3 mt-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-secondary"
                                                        style="font-weight: bolder">
                                                        Pcs/Pak
                                                    </div>
                                                </div>
                                                <input type="text"
                                                    class="form-control @error('pak_pcs') is-invalid @enderror"
                                                    value="{{ $product->pak_pcs }}" name="pak_pcs" placeholder="0"
                                                    title="Banyaknya Pcs/Pak" readonly>
                                            </div>
                                            @error('pak_pcs')
                                                <div class="invalid-feedback" style="display: block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3 col-lg-3 mt-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-secondary"
                                                        style="font-weight: bolder">
                                                        Total Duz
                                                    </div>
                                                </div>
                                                <input type="text"
                                                    class="form-control @error('total_stock') is-invalid @enderror"
                                                    value="{{ old('total_stock') }}" name="total_stock" placeholder="0"
                                                    title="Jumlah Stok Satuan Terkecil">
                                            </div>
                                            @error('total_stock')
                                                <div class="invalid-feedback" style="display: block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3 col-lg-3 mt-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <input type="checkbox" name="without_pcs" readonly
                                                            value="{{ $product->withoutpcs }}"
                                                            @if ($product->withoutpcs == 1) checked @endif>
                                                    </div>
                                                </div>
                                                <span class="form-control">Tanpa Pcs</span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12 mt-3" style="min-height:80px;">
                                            <label for="desc" style="font-weight: bold">Deskripsi Singkat</label>
                                            <textarea id="desc" class="summernote-simple @error('short_descriptions') is-invalid @enderror"
                                                name="short_description">
                                                {{ old('short_descriptions') }}
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-lg btn-outline-primary" type="submit">
                                            <i class="fa fa-paper-plane"></i> SUBMIT</button>
                                    </div>

                                </form>
                            </div>
                            <hr>
                            <div class="card-footer ml-auto">
                                <a href="{{ route('app.products.index') }}" class="btn btn-lg btn-outline-success ml-3">
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
