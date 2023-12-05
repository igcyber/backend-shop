<div class="container-fluid">
    <div class="p-2 p-lg-2 text-center">
        <div class="row m-2 m-lg-2">
            <div class="ms-auto col-lg-4 col-md-12 text-lg-end">
                <img src="{{ asset('front-end/img/banner/banner.png') }}" class="img-fluid" style="max-height: 100vh;">
            </div>
            <div class="col-lg-6 col-md-12 text-lg-start">

                <h2 class="display-5 fw-bold mt-5">Diskon Sampai
                    {{ number_format($maxDiscount, 0) }}% </h2>
                <p class="fs-3 m-0">Yuk Buruan</p>
                <span class="badge bg-primary">Berlaku Sampai</span>
                @if ($flashSaleItems->count() > 0)
                    @php
                        $item = $flashSaleItems->first();
                    @endphp
                    <p class="fs-4">{{ dateID($item->flashSale->end_date) }}</p>
                    {{-- Your other Blade code --}}
                @endif
            </div>
        </div>
    </div>
</div>
