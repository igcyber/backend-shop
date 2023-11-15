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
    <section id="collection" class="py-5 mx-3 font-gone">
        @include('front-end.layouts._about')
    </section>

    {{-- main content --}}
    <div class="container">
        <div class="title text-center mt-5">
            <h2>PRODUK KAMI</h2>
            <div class="custom-horizontal-line"></div>
        </div>

        <div class="row g-0">
            <div class="d-flex flex-wrap justify-content-center mt-5 filter-button-group">
                <button type="button" class="btn m-2 text-dark shadow active-filter-btn" data-filter="*">SEMUA</button>
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
                                    <img class="card-img-top"
                                        src="{{ Storage::exists($detail->product->image) ? Storage::url($detail->product->image) : asset('img/no-image.png') }}"
                                        alt="Image"" alt="Product Image" />
                                    <!-- Product details-->
                                    <div class="card-body p-3">

                                        <span class="badge bg-info py-1">Nama Produk</span>
                                        <h5 class="card-title mt-1 mb-2" style="font-size: 1rem">
                                            {{ $detail->product->title }}</h5>
                                        <span class="badge bg-success py-1">Persediaan</span>
                                        <p class="mb-1{{ $detail->product->stock == 0 ? 'd-none' : '' }}">
                                            {{ $detail->product->stock }}
                                            duz</p>
                                        <p class="mb-1 {{ $detail->product->stock_baal == 0 ? 'd-none' : '' }}">
                                            {{ $detail->product->stock_baal }}
                                            baal</p>
                                        <p class="mb-1 {{ $detail->product->stock_pack == 0 ? 'd-none' : '' }}">
                                            {{ $detail->product->stock_pack }}
                                            pack</p>
                                        <p class="{{ $detail->product->stock_pcs == 0 ? 'd-none' : '' }}">
                                            {{ $detail->product->stock_pcs }}
                                            pcs</p>
                                        <button type="button" class="btn btn-sm btn-info d-inline" data-bs-toggle="modal"
                                            data-bs-target="#detailModal-{{ $detail->id }}">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                        @guest
                                            {{-- direct to login page --}}
                                            <a href="{{ route('login') }}" class="btn btn-sm btn-success" target="_blank">
                                                <i class="fas fa-cart-plus"></i> Tambah
                                            </a>
                                        @else
                                            <a href="{{ route('app.cart.add', [$detail->id, auth()->user()->id]) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="fas fa-cart-plus"></i> Tambah
                                            </a>
                                        @endguest


                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Tombol "Lihat Lebih Lengkap" -->
                    <div class="container text-end">
                        <a href="#" class="btn btn-primary shadow">Lihat Lebih Lengkap <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </section>


        </div>
    </div>

    <!-- Modal -->
    @include('front-end.layouts._modal')

@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script>
        AOS.init();
    </script>
@endpush
