@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .marquee {
            overflow: hidden;
            white-space: nowrap;
            position: relative;
            box-sizing: border-box;
            width: 100%;
            height: 50px;
            border: 1px solid rgb(204, 204, 204);
            background-color: rgba(167, 211, 147, 0.8);

        }

        #wisdomText {
            position: absolute;
            width: 100%;
            height: 100%;
            margin: 0;
            line-height: 50px;
            text-align: center;
            animation: marquee 15s linear infinite;
        }

        @keyframes marquee {
            0% {
                left: 50%;
            }

            100% {
                left: -50%;
            }
        }
    </style>
@endpush

@section('main')
    <div class="main-content" style="{{ auth()->user()->hasRole('Supervisor')? '': 'padding-left:14px;' }}">
        <section class="section">
            <div class="section-header">
                <h1>Selamat Datang di PT. UPINDO RAYA SEMESTA BORNEO</h1>
                @role('Admin Gudang')
                    <a href="{{ route('app.products.index') }}" class="btn btn-lg btn-info ml-auto">
                        <i class="fas fa-window-restore"></i>
                        <span>KELOLA BARANG</span>
                    </a>
                @endrole
                @role('Sales')
                    <a class="btn btn-lg btn-info ml-auto" href="{{ route('app.sales') }}">
                        <i class="fas fa-cart-arrow-down"></i>
                        <span>LIHAT ORDER</span>
                    </a>
                @endrole
                @role('Admin Sales')
                    {{-- {{ setActive(['app.order.*']) }} --}}
                    <a class="btn btn-lg btn-info ml-auto" href="#">
                        <i class="fas fa-cart-arrow-down"></i>
                        <span>Faktur Order</span></a>
                    </a>
                @endrole
                @role('Outlet')
                    <a class="btn btn-lg btn-info ml-auto" href="{{ route('front.home') }}">
                        <i class="fas fa-globe"></i>
                        <span>WEBSITE</span>
                    </a>
                @endrole
            </div>
            <div class="marquee mb-3">
                <p id="wisdomText" style="font-weight: bolder" class="text-uppercase text-white"></p>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Nama/Hak Akses</h4>
                            </div>
                            <div class="card-body">
                                <p>{{ Auth()->user()->name }} / @foreach (Auth()->user()->roles as $role)
                                        {{ $role->name }}
                                    @endforeach
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Tanggal/Jam</h4>
                            </div>
                            <div class="card-body">
                                <p id="real-date"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
    <script>
        function updateRealTimeDate() {
            var currentDate = new Date();
            var options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                timeZoneName: 'short'
            };
            var formattedDate = currentDate.toLocaleDateString('id-ID', options);

            document.getElementById('real-date').innerText = formattedDate;
        }

        // Panggil fungsi updateRealTimeDate setiap detik
        setInterval(updateRealTimeDate, 1000);
    </script>
    <script>
        const wisdomArray = [
            'Man Jadda WaJada, "Barangsiapa bersungguh-sungguh pasti akan mendapatkan hasil".',
        ];

        let index = 0;
        const wisdomTextElement = document.getElementById("wisdomText");

        function changeWisdomText() {
            wisdomTextElement.textContent = wisdomArray[index];
            index = (index + 1) % wisdomArray.length;
        }

        // Ganti kata bijak setiap 10 detik
        setInterval(changeWisdomText, 10000);
    </script>
@endpush
