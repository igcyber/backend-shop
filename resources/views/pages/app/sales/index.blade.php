@extends('layouts.app')

@section('title', 'Pesanan')

@push('style')
@endpush

@section('main')
    <div class="main-content" style="padding-left:28px; !important">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>DATA PESANAN</h4>
                                <a href="{{ route('app.sales.order') }}" class="btn btn-primary ml-auto">
                                    <i class="fas fa-cart-plus"></i> TAMBAH PESANAN
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table table-striped">
                                    <table class="display" id="table-1" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 2%">
                                                    No.
                                                </th>
                                                <th scope="col" style="width: 10%">No. Trans</th>
                                                <th scope="col" style="width: 12%">Tgl Pesan</th>
                                                <th scope="col" style="width: 12%">Outlet</th>
                                                <th scope="col" style="width: 20%">Alamat</th>
                                                <th scope="col" style="width: 20%">Pesanan</th>
                                                <th scope="col" style="width: 10%">Total</th>
                                                <th scope="col" style="width: 5%">Status</th>
                                                <th scope="col" style="width: 10%">Pilihan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $key => $order)
                                                <tr>
                                                    <td class="text-center align-middle p-1">
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td class="align-middle px-2">
                                                        <a href="{{ route('app.sales.editOrderDetail', $order->id) }}"
                                                            style="text-decoration:none;color:rgb(37, 34, 34);">
                                                            <i class="far fa-edit"></i> {{ $order->transaction_id }}
                                                        </a>
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ dateID($order->created_at) }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $order->customer_name }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {!! $order->customer_address !!}
                                                    </td>
                                                    <td class="align-left">
                                                        <ul style="padding: 0;">
                                                            @foreach ($order->orderDetails as $orderDetail)
                                                                <li style="line-height: 20px; width:200px;">
                                                                    @if ($orderDetail->qty_duz > 0 || $orderDetail->qty_pak > 0 || $orderDetail->qty_pcs > 0)
                                                                        @if ($orderDetail->qty_duz > 0)
                                                                            {{ $orderDetail->qty_duz }} Dus
                                                                        @endif
                                                                        @if ($orderDetail->qty_pak > 0)
                                                                            {{ $orderDetail->qty_pak }} Pak
                                                                        @endif
                                                                        @if ($orderDetail->qty_pcs > 0)
                                                                            {{ $orderDetail->qty_pcs }} Pcs
                                                                        @endif
                                                                    @endif
                                                                    {{ $orderDetail->productDetail->product->title }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        {{ moneyFormat($order->total) }}
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $order->order_status === 0 ? 'badge-warning' : ($order->order_status === 1 ? 'badge-success' : 'badge-danger') }}">
                                                            {!! $order->order_status === 0
                                                                ? '<i class="fas fa-clock" title="PENDING ORDER"></i>'
                                                                : ($order->order_status === 1
                                                                    ? '<i class="fas fa-check" title="SUCCESS ORDER"></i>'
                                                                    : '<i class="fas fa-times" title="CANCELED ORDER"></i>') !!}
                                                        </span>

                                                    </td>
                                                    <td>
                                                        <div class="dropdown d-inline mr-2">
                                                            <button class="btn btn-sm btn-info dropdown-toggle"
                                                                type="button" id="dropdownMenuButton3"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                <i class="fas fa-info"></i>
                                                            </button>
                                                            <div class="dropdown-menu" x-placement="bottom-start"
                                                                style="position: absolute; transform: translate3d(0px, 29px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('app.confirmation', ['accept', $order->id]) }}">Konfirmasi
                                                                    Pesanan</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('app.confirmation', ['decline', $order->id]) }}">Batalkan
                                                                    Pesanan</a>
                                                                <a class="dropdown-item" href="#">Hapus Pesanan</a>
                                                            </div>
                                                        </div>
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

    <!-- Modal Create -->
    @include('pages.app.sales._modal_create')
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script>
        $("#table-1").dataTable({
            "columnDefs": [{
                "sortable": true,
                "targets": [1, 2, 5]
            }],
            "iDisplayLength": 25,
            responsive: true,
            scrollX: true,
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
