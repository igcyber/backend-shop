@extends('layouts.app')

@section('title', 'Pesanan')

@push('style')
@endpush

@section('main')
    <div class="main-content" style="padding-left:14px; !important">
        <section class="section">
            <div class="section-header">
                <h1>Halaman Pesanan</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Pesanan</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-stripe" id="table-1">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%">
                                                    No. Urut
                                                </th>
                                                <th scope="col" style="width: 10%">No. Transaksi</th>
                                                <th>Nama Outlet</th>
                                                <th>Total Pembayaran</th>
                                                <th>Banyak Pesanan</th>
                                                <th scope="col" style="width: 20%">Alamat</th>
                                                <th>Status Order</th>
                                                <th>Tanggal Order</th>
                                                <th>Pilihan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $key => $item)
                                                <tr>
                                                    <td class="text-center align-middle">
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td class="align-middle">{{ $item->transaction_id }}</td>
                                                    <td class="align-middle">{{ $item->outlet }}</td>
                                                    <td class="align-middle">{{ moneyFormat($item->sub_total) }}</td>
                                                    <td class="align-middle">{{ $item->product_qty }} Item</td>
                                                    <td class="align-middle">{{ $item->order_address }}</td>
                                                    <td class="align-middle">
                                                        @if ($item->order_status == 'pending')
                                                            <span
                                                                class="badge badge-danger">{{ $item->order_status }}</span>
                                                        @elseif ($item->order_status == 'clear')
                                                            <span
                                                                class="badge badge-success">{{ $item->order_status }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle">{{ dateID($item->created_at) }}</td>
                                                    <td class="align-middle">
                                                        @role('Admin Sales')
                                                            <a href="{{ route('app.order.print-invoice', $item->id) }}"
                                                                class="btn btn-info btn-sm">
                                                                <i class="fas fa-file-invoice" title="Invoice"></i>
                                                            </a>
                                                        @endrole
                                                        @role('Sales')
                                                            <a href="{{ route('app.order.show', $item->id) }}"
                                                                class="btn btn-info btn-sm">
                                                                <i class="fas fa-file-invoice" title="Invoice"></i>
                                                            </a>
                                                        @endrole
                                                        @can('orders.edit')
                                                            <a href="{{ route('app.order.edit', $item->id) }}"
                                                                class="btn btn-success btn-sm">
                                                                <i class="fa fa-pencil-alt me-1" title="Edit Produk">
                                                                </i>
                                                            </a>
                                                        @endcan
                                                        @can('orders.delete')
                                                            <button onclick="Delete(this.id)" id="{{ $item->id }}"
                                                                class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                                                    title="Hapus Produk"></i>
                                                            </button>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12">
                        {{-- @include('pages.app.products._create') --}}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script>
        $("#table-1").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [2, 3, 4, 5, 8]
            }]
        });
    </script>

    <!-- Page Specific JS File -->
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
@endpush
