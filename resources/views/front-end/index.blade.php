@extends('front-end.layouts.master')

@section('title', 'Beranda')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
    <!-- header -->
    <section id="carousel">
        @include('front-end.layouts._carousel')
    </section>
    <!-- end of header -->

    <!-- about us -->
    <section id="collection" class="py-5 mx-3">
        @include('front-end.layouts._about')
    </section>

    <div class="container">
        <div class="title text-center">
            <h2>PRODUK KAMI</h2>
            <div class="custom-horizontal-line"></div>
        </div>

        <div class="row g-0">
            <div class="d-flex flex-wrap justify-content-center mt-5 filter-button-group">
                <button type="button" class="btn m-2 text-dark shadow active-filter-btn" data-filter="*">All</button>
                @foreach ($categories as $key => $category)
                    <button type="button" class="btn m-2 text-dark shadow"
                        data-filter=".category-{{ $key }}">{{ $category->name }}</button>
                @endforeach

            </div>

            <!-- bagian foto produk -->
            <section class="py-3">
                <div class="container px-4 px-lg-5 mt-3">
                    <div class="collection-list mt-2 row gx-0 gy-3">
                        @foreach ($detailProducts as $key => $detail)
                            <div class="col mb-5 col-lg-4 col-xl-3 p-2 category-{{ $key }}">
                                <div class="card h-100 shadow">
                                    <!-- Product image-->
                                    <img class="card-img-top" src="{{ asset($detail->product->image) }}"
                                        alt="Product Image" />
                                    <!-- Product details-->
                                    <div class="card-body p-3">

                                        <span class="badge bg-info py-1">Nama Barang</span>
                                        <h5 class="card-title mt-1 mb-2" style="font-size: 1rem">
                                            {{ $detail->product->title }}</h5>
                                        <span class="badge bg-success py-1">Stok Barang</span>
                                        <p class="mt-1 mb-2">{{ $detail->product->stock }}
                                            {{ $detail->product->unit }}</p>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#detailModal-{{ $detail->id }}">
                                            <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                                        </button>


                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Tombol "Lihat Lebih Lengkap" -->
            <div class="container text-end pb-5">
                <a href="#" class="btn btn-primary shadow">Lihat Lebih Lengkap <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('front-end.layouts._modal')

@endsection

@push('scripts')
    <!-- JS Libraries -->
@endpush
