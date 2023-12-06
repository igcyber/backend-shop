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

    <!-- banner promosi -->
    <section
        class="py-2 mx-5 {{ $flashSaleItems->where('detail_id', '!=', 0)->where('status', 1)->isEmpty()? 'd-none': '' }}">
        @include('front-end.layouts._promotion')
    </section>

    {{-- main content --}}
    <div class="container">
        <div class="title text-center mt-5">
            <h2>PRODUK KAMI</h2>
            <div class="custom-horizontal-line"></div>
        </div>

        <div class="row g-0">
            <div class="d-flex flex-wrap justify-content-center mt-2 filter-button-group">
                <button type="button" class="btn m-2 text-dark shadow active-filter-btn" data-filter="*">SEMUA</button>
                @foreach ($categories as $key => $category)
                    <button type="button" class="btn m-2 text-dark shadow"
                        data-filter=".category-{{ $key }}">{{ $category->name }}</button>
                @endforeach

            </div>

            <!-- bagian foto produk -->
            <section class="py-3">
                <div class="container px-4 px-lg-5 mt-3">
                    <div class="collection-list mt-2 row gx-0 gy-3" style="height: 2000px;">
                        @foreach ($detailProducts as $key => $detail)
                            <div class="col mb-2 col-lg-4 col-xl-3 p-2 category-{{ $key }}">
                                <div class="card h-100 shadow">
                                    <!-- Product details-->
                                    @if ($flashSaleItems->where('detail_id', $detail->id)->where('status', 1)->isNotEmpty())
                                        <span class="badge bg-info mb-0" style="text-align: left">
                                            <i class="fas fa-bell">
                                                {{ number_format($detail->discount, 0) }}
                                            </i>
                                            % Diskon
                                        </span>
                                    @else
                                        <span class="badge bg-primary mb-0">
                                            <i class="fas fa-bell text-primary">
                                            </i>
                                        </span>
                                    @endif
                                    <div class="card-body p-1">
                                        <p class="mb-2 mt-0 text-small text-gray-700" style="font-size:0.8rem">
                                            {{ $detail->product->title }}
                                        </p>
                                        @guest
                                            {{-- direct to login page --}}
                                            <a href="{{ route('login') }}" target="_blank">
                                            @else
                                                <a href="{{ route('app.cart.add', [$detail->id, auth()->user()->id]) }}">
                                                @endguest
                                                <!-- Product image-->
                                                @php
                                                    $imageSource = Storage::exists($detail->product->image) ? Storage::url($detail->product->image) : asset('img/no-image.png');
                                                @endphp
                                                <img class="card-img-top" src="{{ $imageSource }}" alt="Image"
                                                    alt="Product Image" />
                                            </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Tombol "Lihat Lebih Lengkap" -->
                    <div class="container text-end">
                        <a href="#" class="btn btn-default shadow">Lihat Semua Produk <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </section>


        </div>
    </div>

@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script>
        AOS.init();
    </script>
@endpush
