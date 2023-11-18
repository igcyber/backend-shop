@extends('layouts.app')

@section('title', 'Produk')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Halaman Produk</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Produk</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 10%">
                                                    No. Urut
                                                </th>
                                                <th>Nomor Transaksi</th>
                                                <th>Outlet</th>
                                                <th>Alamat</th>
                                                <th>Detail Pesanan</th>
                                                <th>Pilihan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $key => $order)
                                                <tr>
                                                    <td class="text-center align-middle">
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td class="align-middle">{{ $order->transaction_id }}</td>
                                                    <td class="align-middle">
                                                        {{ $order->customer_name }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $order->customer_address }}
                                                    </td>
                                                    <td class="align-middle">
                                                        <ul>
                                                            @foreach ($order->orderDetails as $orderDetail)
                                                                @if ($orderDetail->qty_duz > 0 || $orderDetail->qty_pak > 0 || $orderDetail->qty_pcs > 0)
                                                                    <li>
                                                                        @if ($orderDetail->qty_duz > 0)
                                                                            Qty Duz: {{ $orderDetail->qty_duz }},
                                                                        @endif
                                                                        @if ($orderDetail->qty_pak > 0)
                                                                            Qty Pak: {{ $orderDetail->qty_pak }},
                                                                        @endif
                                                                        @if ($orderDetail->qty_pcs > 0)
                                                                            Qty Pcs: {{ $orderDetail->qty_pcs }}
                                                                        @endif
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    {{-- <td></td> --}}
                                                    <td>
                                                        <a href="#">Edit</a> | <a href="#">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
    <script>
        $("#table-1").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [1, 2, 5]
            }]
        });
    </script>

    <!-- Page Specific JS File -->
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
    </script> --}}
@endpush
