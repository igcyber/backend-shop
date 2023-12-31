@extends('layouts.app')

@section('title', 'Pengguna')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h4>DATA PENGGUNA</h4>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('app.users.import.excel') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row mb-3">
                                        <label for="img" style="font-weight: bold">Pilih File Excel</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="far fa-file-excel"></i>
                                                </div>
                                            </div>
                                            <input type="file" name="excel_file" id="excel_file"
                                                class="form-control col-md-2 @error('excel_file') @enderror">
                                            <button type="submit" class="btn btn-outline-info">IMPORT DATA</button>
                                        </div>
                                        @error('excel_file')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </form>
                                <hr>
                                <form action="{{ route('app.users.index') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="q"
                                            placeholder="Cari Nama Pengguna">
                                        {{-- <button class="btn btn-primary input-group-text" type="submit">
                                            <i class="fa fa-search me-2 text-white"></i>
                                        </button> --}}
                                        <button class="btn btn-outline-primary input-group-text" onclick="resetPage()">
                                            <i class="fas fa-sync-alt me-2"></i>
                                        </button>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-m">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%">No</th>
                                                <th scope="col">Kode</th>
                                                <th scope="col">Nama Lengkap</th>
                                                <th scope="col">Nama Pengguna</th>
                                                <th scope="col">Hak Akses</th>
                                                <th scope="col" style="width: 15%">Pilihan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $no => $user)
                                                <tr>
                                                    <th scope="row">
                                                        {{ ++$no + ($users->currentPage() - 1) * $users->perPage() }}
                                                    </th>
                                                    <td>
                                                        {{ $user->kode }}
                                                    </td>
                                                    <td>
                                                        {{ $user->name }}
                                                    </td>
                                                    <td>
                                                        {{ $user->username }}
                                                    </td>
                                                    <td>
                                                        @foreach ($user->roles as $role)
                                                            <span class="badge badge-primary border-0 ms-2 mb-2">
                                                                {{ $role->name }}
                                                            </span>
                                                        @endforeach
                                                    </td>
                                                    <td class="text-center">

                                                        @can('roles.edit')
                                                            <a href="{{ route('app.users.edit', $user->id) }}"
                                                                class="btn btn-outline-success btn-sm">
                                                                <i class="fa fa-pencil-alt me-1" title="Edit Hak Akses">
                                                                </i>
                                                            </a>
                                                        @endcan
                                                        @can('roles.delete')
                                                            <button onclick="Delete(this.id)" id="{{ $user->id }}"
                                                                class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"
                                                                    title="Hapus Hak Akses"></i>
                                                            </button>
                                                        @endcan

                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer pull-right">
                                {{ $users->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        @include('pages.app.users._create')
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script>
        function resetPage() {
            window.location.reload();
        }
    </script>

    <script>
        function Delete(id) {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");

            swal({
                title: "APAKAH KAMU YAKIN ?",
                text: "INGIN MENGHAPUS DATA INI!",
                icon: "warning",
                buttons: [
                    'TIDAK',
                    'YA'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    //ajax delete
                    jQuery.ajax({
                        url: "/app/users/" + id,
                        data: {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function(response) {
                            if (response.status == "success") {
                                swal({
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIHAPUS!',
                                    icon: 'success',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                swal({
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIHAPUS!',
                                    icon: 'error',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }
                        }
                    });

                } else {
                    return true;
                }
            })
        }
    </script>
    <!-- Page Specific JS File -->
@endpush
