<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') &mdash; PT. Upindo Raya Semesta Borneo</title>
    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <!-- custom css -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    {{-- Sweet Alert --}}
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" id="theme-styles">
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;1,400;1,500&family=Roboto:wght@500&display=swap"
        rel="stylesheet">
    {{-- Custom Css --}}
    <link rel="stylesheet" href="{{ asset('front-end/css/style.css') }}" />
    <style>
        .mapouter {
            position: relative;
            text-align: right;
            width: 100%;
            height: 304px;
        }

        .gmap_canvas {
            overflow: hidden;
            background: none !important;
            width: 100%;
            height: 304px;
        }

        .gmap_iframe {
            height: 304px !important;
        }
    </style>
    @stack('style')
</head>

<body>
    <div
        style="background-image: url({{ URL::asset('front-end/img/bg/vector2.jpg') }}); background-repeat: no-repeat; background-size: cover; background-attachment: fixed; min-height: 100vh; overflow: hidden">

        <!-- navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 fixed-top shadow-sm">
            @include('front-end.layouts._navbar')
        </nav>
        <!-- end of navbar -->

        <!-- Start Produk Kami -->
        <section id="collection" class="py-0">
            @yield('content')
        </section>
        <!-- end Produk Kami -->

        <!-- Start Footer  -->
        <footer class="mt-5">
            @include('front-end.layouts._footer')
        </footer>

    </div>

    <script src="{{ asset('front-end/js/jquery-3.7.1.js') }}"></script>
    <!-- isotope js -->
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script>
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <!-- custom js -->
    <script src="{{ asset('front-end/js/script.js') }}"></script>
    {{-- AOS Library --}}
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    {{-- Sweet Alert --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    @stack('scripts')

    <script>
        @if (session()->has('success'))
            swal({
                type: "success",
                icon: "success",
                title: "BERHASIL!",
                text: "{{ session('success') }}",
                timer: 1500,
                showConfirmButton: false,
                showCancelButton: false,
                buttons: false,
            });
        @elseif (session()->has('error'))
            swal({
                type: "error",
                icon: "error",
                title: "GAGAL!",
                text: "{{ session('error') }}",
                timer: 3500,
                showConfirmButton: false,
                showCancelButton: false,
                buttons: false,
            });
        @elseif (session()->has('warning'))
            swal({
                type: "warning",
                icon: "warning",
                title: "PENGINGAT!",
                text: "{{ session('warning') }}",
                timer: 2500,
                showConfirmButton: false,
                showCancelButton: false,
                buttons: false,
            });
        @endif
    </script>

</body>

</html>
