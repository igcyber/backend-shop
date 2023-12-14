@extends('layouts.app')

@section('title', 'Perbarui Hak Akses')

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
                                <h4>HAK AKSES</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('app.roles.update', $role->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ $role->name }}">
                                        @error('name')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Izin Akses</label>
                                        <br>
                                        @foreach ($permissions as $permission)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                                    value="{{ $permission->id }}" id="role-{{ $permission->id }}"
                                                    {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="role-{{ $permission->id }}">
                                                    {{ $permission->name }}
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
                                <a href="{{ route('app.roles.index') }}" class="btn btn-lg btn-outline-info">
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
