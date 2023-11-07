@extends('front-end.layouts.master')

@section('title', 'Login Page')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
    <div class="row justify-content-center align-items-center" style="padding-top: 20vh;">
        <div class="col-lg-4 col-md-8">
            <div class="card">
                <div class="card-header text-center bg-success text-light">Login</div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('front-end/img/loogoo (3).png') }}"
                            class="mx-auto d-block img-fluid rounded-circle" alt="..." style="max-width: 60%" />
                    </div>
                    <form action="{{ route('loginPage.login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Username</label>
                            <input type="text" class="form-control" id="name" placeholder="Masukkan Email Anda"
                                name="name" />
                        </div>
                        <div class="text-end">
                            {{-- <a href="index.html" class="btn btn-secondary">Login</a> --}}
                            <button type="submit" class="btn btn-sm btn-secondary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
