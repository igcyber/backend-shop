@extends('layouts.error')
@section('main')
    <div class="container">
        <div class="mx-auto">
            <img src="{{ asset('front-end/img/loogoo (3).png') }}" alt="site icon" width="15%" />
            <span class="text-uppercase ms-2 text-size-custom"
                style="font-size: 1rem !important; font-family: 'Poppins', sans-serif;
                        font-family: 'Roboto', sans-serif;">
                PT. Upindo Raya Semesta
                Borneo
            </span>
        </div>
        <div class="alert alert-danger">
            <p style="font-size: 1.5rem;text-align: center">
                {{ __('Maaf, Halaman Tidak Ada') }}
            </p>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

        </div>
        <button onclick="document.getElementById('logout-form').submit()" class="btn btn-lg btn-primary">Halaman
            Beranda</button>
    </div>
@endsection
