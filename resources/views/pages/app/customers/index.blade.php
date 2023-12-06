@extends('layouts.app')

@section('title', 'Outlet')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Outlet</h4>
                                <a href="{{ route('app.customers.create') }}" class="btn btn-primary ml-auto">
                                    <i class="fas fa-plus"></i> Tambah Outlet
                                </a>
                            </div>
                            <div class="card-body">
                                <form action="#" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="q"
                                            placeholder="Cari Berdasarkan Nama Outlet">
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
                                                <th scope="col" style="width: 5%">No. Urut</th>
                                                <th scope="col">Nomor Outlet</th>
                                                <th scope="col">Nama Outlet</th>
                                                <th scope="col">Klasifikasi</th>
                                                <th scope="col">Telp. Kantor</th>
                                                <th scope="col">Alamat</th>
                                                <th scope="col">Petugas Sales</th>
                                                <th scope="col" style="width: 15%">Pilihan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customers as $no => $customer)
                                                <tr>
                                                    <th scope="row">
                                                        {{ ++$no + ($customers->currentPage() - 1) * $customers->perPage() }}
                                                    </th>
                                                    <td>
                                                        {{ $customer->nomor }}
                                                    </td>
                                                    <td>
                                                        {{ $customer->outlet->name }}
                                                    </td>
                                                    <td>
                                                        {{ $customer->klasifikasi }}
                                                    </td>
                                                    <td>
                                                        {{ $customer->no_telp }}
                                                    </td>
                                                    <td>
                                                        {!! $customer->address !!}
                                                    </td>
                                                    <td>
                                                        {{ $customer->seller->name }}
                                                    </td>
                                                    <td class="text-center">

                                                        <a href="{{ route('app.roles.edit', $customer->id) }}"
                                                            class="btn btn-success btn-sm">
                                                            <i class="fa fa-pencil-alt me-1" title="Edit Hak Akses">
                                                            </i>
                                                        </a>


                                                        <button onclick="Delete(this.id)" id="{{ $customer->id }}"
                                                            class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                                                title="Hapus Hak Akses"></i>
                                                        </button>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer pull-right">
                                {{ $customers->links('vendor.pagination.bootstrap-4') }}
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
    {{-- <script>
        if (jQuery().summernote) {
            $(".summernote-simple").summernote({
                dialogsInBody: true,
                minHeight: 150,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['para', ['paragraph']]
                ]
            });
        }
    </script> --}}

    <script>
        function resetPage() {
            window.location.reload();
        }
    </script>

    {{-- <script>
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
    </script> --}}
    <!-- Page Specific JS File -->
@endpush
