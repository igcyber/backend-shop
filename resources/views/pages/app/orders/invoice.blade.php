@extends('layouts.app')

@section('title', 'Order Invoice')

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
                    <div class="col-md-12">
                        <div class="invoice">
                            <div class="invoice-print">
                                <div class="row">
                                    <img src="{{ asset('front-end/img/loogoo (3).png') }}" alt="" width="16%;">
                                    <div class="col-lg-5 my-5 mx-0">
                                        <h4 class="d-inline" style="font-weight: bolder">FAKTUR PENJUALAN</h4><br>
                                        <h5 class="" style="font-weight: bold">PT. UPINDO RAYA SEMESTA BORNEO</h5>
                                        <p style="font-size: 1.2em">
                                            JL.MUGIREJO RT.14 NO.2A </br>
                                            (0541)282657 / 7074778 <br>
                                            082158111409
                                        </p>
                                    </div>
                                    <div class="col-lg-5 mt-5">
                                        <p class="mb-0">No Transaksi : {{ $order->transaction_id }}</p>
                                        <p class="mt-0 mb-0">Tanggal : {{ dateID($order->created_at) }}</p>
                                        <p class="mt-0 mb-0">Kode Sales : {{ $order->sales }}</p>
                                        <p class="mt-0 mb-0">Pelanggan : {{ $order->outlet }}</p>
                                        <p class="mt-0">Alamat : {{ $order->order_address }}</p>
                                    </div>

                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-md">
                                                <tr>
                                                    <th data-width="40">No</th>
                                                    <th>Nama Item</th>
                                                    <th>Jumlah Satuan</th>
                                                    <th>Harga</th>
                                                    <th>Total</th>
                                                </tr>
                                                @foreach ($order->orderProducts as $product)
                                                    <tr>
                                                        <td class="text-center">{{ ++$loop->index }}</td>
                                                        <td>{{ $product->product_name }}</td>
                                                        <td>{{ $product->qty }}</td>
                                                        <td>{{ moneyFormat($product->unit_price) }}</td>
                                                        <td>{{ moneyFormat($product->qty * $product->unit_price) }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-4">
                                                <div>Keterangan : </div>
                                                <p class="section-lead">TIDAK MENERIMA KOMPLAIN SETELAH FAKTUR DITANDA
                                                    TANGANI</p>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="invoice-detail-item">
                                                    <span class="invoice-detail-name mr-4">Jumlah Item :
                                                    </span>
                                                    <span class="ml-5 pl-5">
                                                        {{ $order->product_qty }}
                                                    </span>
                                                </div>
                                                <div class="invoice-detail-item">
                                                    <span class="invoice-detail-name" style="margin-right: 11.5%">Potongan :
                                                    </span>
                                                    <span class="ml-5 pl-5">
                                                        {{-- {{ $order->product_qty }} --}} 0
                                                    </span>
                                                </div>
                                                <div class="invoice-detail-item">
                                                    <span class="invoice-detail-name" style="margin-right: 19.5%">Pajak :
                                                    </span>
                                                    <span class="ml-5 pl-5">
                                                        {{-- {{ $order->product_qty }} --}} 0
                                                    </span>
                                                </div>
                                                <div class="invoice-detail-item">
                                                    <span class="invoice-detail-name" style="margin-right: 6.5%">Jatuh
                                                        Tempo :
                                                    </span>
                                                    <span class="ml-5 pl-5">
                                                        {{-- {{ $order->product_qty }} --}} 0
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="invoice-detail-item">
                                                    <span class="invoice-detail-name" style="margin-right: 20%">Sub
                                                        Total :
                                                    </span>
                                                    <span class="ml-5 pl-3" style="font-weight: bolder">
                                                        {{ moneyFormat($order->sub_total) }}
                                                    </span>
                                                </div>
                                                <div class="invoice-detail-item">
                                                    <span class="invoice-detail-name" style="margin-right: 17%">Total
                                                        Akhir :
                                                    </span>
                                                    <span class="ml-5 pl-3" style="font-weight: bolder">
                                                        {{-- {{ moneyFormat($order->sub_total) }} --}} 0
                                                    </span>
                                                </div>
                                                <div class="invoice-detail-item">
                                                    <span class="invoice-detail-name" style="margin-right: 24.5%">DP PO :
                                                    </span>
                                                    <span class="ml-5 pl-3" style="font-weight: bolder">
                                                        {{-- {{ moneyFormat($order->sub_total) }} --}} 0
                                                    </span>
                                                </div>
                                                <div class="invoice-detail-item">
                                                    <span class="invoice-detail-name" style="margin-right: 27.7%">Tunai:
                                                    </span>
                                                    <span class="ml-5 pl-3" style="font-weight: bolder">
                                                        {{-- {{ moneyFormat($order->sub_total) }} --}} 0
                                                    </span>
                                                </div>
                                                <div class="invoice-detail-item">
                                                    <span class="invoice-detail-name" style="margin-right: 26.7%">Kredit:
                                                    </span>
                                                    <span class="ml-5 pl-3" style="font-weight: bolder">
                                                        {{-- {{ moneyFormat($order->sub_total) }} --}} 0
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="text-md-right">
                                <div class="float-lg-left mb-lg-0 mb-3">
                                    <a href="{{ route('app.order.admin.invoice') }}"
                                        class="btn btn-danger btn-icon icon-left">
                                        <i class="fas fa-times"></i> Kembali
                                    </a>
                                </div>
                                <button class="btn btn-warning btn-icon icon-left btn_print"><i class="fas fa-print"></i>
                                    Print</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('.btn_print').on('click', function() {
                // alert('Hello')
                let printBody = $('.invoice-print');
                let originalContents = $('body').html();
                $('body').html(printBody.html());
                window.print();
                $('body').html(originalContents);
            })
        })
    </script>
@endpush
