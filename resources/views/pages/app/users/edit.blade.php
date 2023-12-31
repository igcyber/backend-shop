@extends('layouts.app')

@section('title', 'Perbarui Data Pengguna')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Perbarui Data Pengguna</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('app.users.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label>Kode</label>
                                        <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                            name="kode" value="{{ $user->kode }}">
                                        @error('kode')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ $user->name }}">
                                        @error('name')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Pengguna</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                                            name="username" value="{{ $user->username }}">
                                        @error('username')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat E-Mail</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ $user->email }}">
                                        @error('email')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="fw-bold">Password</label>
                                        <input class="form-control" name="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Hak Akses</label>
                                        <br>
                                        @foreach ($roles as $role)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="roles[]"
                                                    value="{{ $role->id }}" id="role-{{ $role->id }}"
                                                    {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="role-{{ $role->id }}">
                                                    {{ $role->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="text-right mt-3">
                                        <div class="text-right mt-3">
                                            <button class="btn btn-lg btn-outline-primary p-2 px-4" type="submit">
                                                <i class="fa fa-paper-plane"></i> PERBARUI </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <hr>
                            <div class="card-footer">
                                <a href="{{ route('app.users.index') }}" class="btn btn-lg btn-outline-info text-right">
                                    <i class="fa fa-arrow-left"></i> KEMBALI</a>
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
    <!-- Page Specific JS File -->
@endpush
