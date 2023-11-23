@extends('layouts.app')

@section('title', 'Order')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Halaman Order</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Order</h4>
                                <a href="{{ route('app.take.order') }}" class="btn btn-primary ml-auto">
                                    <i class="fas fa-cart-plus"></i> Tambah Keranjang
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%">
                                                    No. Urut
                                                </th>
                                                <th scope="col" style="width: 10%">Nomor Transaksi</th>
                                                <th scope="col" style="width: 15%">Outlet</th>
                                                <th scope="col" style="width: 35%">Alamat</th>
                                                <th>Detail Pesanan</th>
                                                <th>Status Pesanan</th>
                                                <th scope="col" style="width: 10%">Pilihan</th>
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
                                                        {!! $order->customer_address !!}
                                                    </td>
                                                    <td class="align-left">
                                                        <ul style="padding: 0;">
                                                            @foreach ($order->orderDetails as $orderDetail)
                                                                <li style="line-height: 16px;">
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
                                                        <span
                                                            class="badge {{ $order->order_status === 0 ? 'badge-warning' : ($order->order_status === 1 ? 'badge-success' : 'badge-danger') }}">
                                                            {{ $order->order_status === 0 ? 'Pending' : ($order->order_status === 1 ? 'Compeleted' : 'Canceled') }}
                                                        </span>
                                                    </td>
                                                    <td>

                                                        <button type="button" class="btn btn-sm btn-info d-inline"
                                                            data-toggle="modal" title="Detail Order"
                                                            data-target="#detailModal-{{ $order->id }}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <a href="#" class="btn btn-sm btn-warning"
                                                            title="Hapus Order">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
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

    <!-- Modal Update -->
    @include('pages.app.sales._modal')
    <!-- Modal Create -->
    @include('pages.app.sales._modal_create')
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
