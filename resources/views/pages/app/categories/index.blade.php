@extends('layouts.app')

@section('title', 'Pengguna')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Halaman Tipe Produk</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Tipe Produk</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    {{-- <table class="table table-bordered table-m">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%">No</th>
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
                                                        {{ $user->name }}
                                                    </td>
                                                    <td>
                                                        {{ $user->username }}
                                                    </td>
                                                    <td>
                                                        @foreach ($user->roles as $role)
                                                            <span class="badge badge-primary shadow border-0 ms-2 mb-2">
                                                                {{ $role->name }}
                                                            </span>
                                                        @endforeach
                                                    </td>
                                                    <td class="text-center">

                                                        @can('roles.edit')
                                                            <a href="{{ route('app.users.edit', $user->id) }}"
                                                                class="btn btn-success btn-sm">
                                                                <i class="fa fa-pencil-alt me-1" title="Edit Hak Akses">
                                                                </i>
                                                            </a>
                                                        @endcan
                                                        @can('roles.delete')
                                                            <button onclick="Delete(this.id)" id="{{ $user->id }}"
                                                                class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                                                    title="Hapus Hak Akses"></i>
                                                            </button>
                                                        @endcan

                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table> --}}
                                </div>
                            </div>
                            <div class="card-footer pull-right">
                                {{-- {{ $users->links('vendor.pagination.bootstrap-4') }} --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        {{-- @include('pages.app.users._create') --}}
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
