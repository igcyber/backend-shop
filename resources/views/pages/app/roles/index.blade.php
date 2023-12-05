@extends('layouts.app')

@section('title', 'Hak Akses')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Hak Akses</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('app.roles.index') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="q"
                                            placeholder="cari berdasarkan hak akses">
                                        <button class="btn btn-primary input-group-text" type="submit">
                                            <i class="fa fa-search me-2 text-white"></i>
                                        </button>
                                        <button class="btn btn-primary input-group-text" onclick="resetPage()">
                                            <i class="fas fa-sync-alt me-2 text-white"></i>
                                        </button>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-m">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%">No</th>
                                                <th scope="col">Nama Hak Akses</th>
                                                <th scope="col">Nama Hak Izin</th>
                                                <th scope="col" style="width: 15%">Pilihan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $no => $role)
                                                <tr>
                                                    <th scope="row">
                                                        {{ ++$no + ($roles->currentPage() - 1) * $roles->perPage() }}
                                                    </th>
                                                    <td>
                                                        {{ $role->name }}
                                                    </td>
                                                    <td>
                                                        @foreach ($role->permissions as $permission)
                                                            <span
                                                                class="badge badge-primary shadow border-0 ms-2 mb-1 mt-1">
                                                                {{ $permission->name }}
                                                            </span>
                                                        @endforeach
                                                    </td>
                                                    <td class="text-center">

                                                        @can('roles.edit')
                                                            <a href="{{ route('app.roles.edit', $role->id) }}"
                                                                class="btn btn-success btn-sm">
                                                                <i class="fa fa-pencil-alt me-1" title="Edit Hak Akses">
                                                                </i>
                                                            </a>
                                                        @endcan
                                                        @can('roles.delete')
                                                            <button onclick="Delete(this.id)" id="{{ $role->id }}"
                                                                class="btn btn-danger btn-sm"><i class="fa fa-trash"
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
                                {{ $roles->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        @include('pages.app.roles._create')
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
                        url: "/app/roles/" + id,
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
