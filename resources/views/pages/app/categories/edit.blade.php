@extends('layouts.app')

@section('title', 'Tipe Produk')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Halaman Tipe Produk</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Tipe</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('app.categories.update', $category->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name">Nama Tipe</label>
                                        <input type="text" id="name"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            placeholder="Tuliskan Nama Tipe" value="{{ $category->name }}">
                                        @error('name')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status Tipe</label>
                                        <select name="status" id="status"
                                            class="form-control @error('status') is-invalid @enderror">
                                            <option disabled>PILIH STATUS</option>
                                            <option value="1"{{ $category->status == 1 ? 'selected' : '' }}>Aktif
                                            </option>
                                            <option value="0"{{ $category->status == 0 ? 'selected' : '' }}>Tidak Aktif
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="text-right mt-3">
                                        <button class="btn btn-sm btn-primary" type="submit">
                                            <i class="fa fa-paper-plane"></i> Update</button>
                                        <a href="{{ route('app.categories.index') }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-arrow-back"></i> Kembali</a>
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
