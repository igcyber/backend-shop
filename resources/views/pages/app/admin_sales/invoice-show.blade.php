@extends('layouts.app')

@section('title', 'Order Invoice')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="invoice">
                            {{-- @dd($order) --}}
                            <div class="invoice-print">
                                <div class="row ml-2">
                                    <img src="{{ asset('front-end/img/loogoo (3).png') }}" alt="" width="16%;">
                                    <div class="col-md-5 my-5 mx-0">
                                        <h4 class="d-inline" style="font-weight: bolder">FAKTUR PENJUALAN</h4><br>
                                        <h5 class="" style="font-weight: bold">PT. UPINDO RAYA SEMESTA BORNEO</h5>
                                        <p style="font-size: 1.2em">
                                            JL.MUGIREJO RT.14 NO.2A </br>
                                            (0541)282657 / 7074778 <br>
                                            082158111409
                                        </p>
                                    </div>
                                    <div class="col-md-5 mt-5">
                                        <table>
                                            <thead>
                                                <th scope="col" style="width:200px"></th>
                                                <th scope="col" style="width:200px"></th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="font-size: 1.1rem">
                                                        Jumlah Item
                                                    </td>
                                                    <td style="font-weight: bolder;font-size: 1.1rem">
                                                        : {{ $order->orderDetails->count() }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 1.1rem">
                                                        Potongan
                                                    </td>
                                                    <td style="font-size: 1.1rem">
                                                        : 0
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 1.1rem">Pajak</td>
                                                    <td style="font-size: 1.1rem">: 0</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 1.1rem">Tanggal</td>
                                                    <td style="font-size: 1.1rem">: 0</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p class="mb-0">No. Transaksi <span style="margin-left:10.7%">:</span>
                                            {{ $order->transaction_id }}</p>
                                        <p class="mt-0 mb-0 mr-5">Tanggal <span style="margin-left:17.6%">:</span>
                                            {{ $order->formatted_created_at }}
                                        </p>
                                        <p class="mt-0 mb-0">Kode Sales <span style="margin-left:12.9%">:</span>
                                            {{ $order->sales->name }}</p>
                                        <p class="mt-0 mb-0">Pelanggan <span style="margin-left:13.3%">:</span>
                                            {{ $order->customer_id }}-{{ $order->outlet->name }}{{ $order->customer_phone && $order->customer_phone !== '-' ? '-' . $order->customer_phone : '' }}
                                        </p>
                                        <p class="mt-0">Alamat <span style="margin-left:16.8%">:</span>
                                            {{ $order->customer_address }}</p>
                                    </div>

                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-md">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">Kode Item</th>
                                                        <th scope="col">Nama Item</th>
                                                        <th scope="col">Jumlah Satuan</th>
                                                        <th scope="col">Cek</th>
                                                        <th scope="col">Harga</th>
                                                        <th scope="col">Pot</th>
                                                        <th scope="col">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->orderDetails as $orderDetail)
                                                        <tr>
                                                            <td>{{ ++$loop->index }}</td>
                                                            <td>{{ $orderDetail->productDetail->product->serial_number }}
                                                            </td>
                                                            <td>{{ $orderDetail->productDetail->product->title }}
                                                            </td>
                                                            <td>
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
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" checked class="form-control">
                                                            </td>
                                                            <td>
                                                                @if ($orderDetail->qty_duz > 0 || $orderDetail->qty_pak > 0 || $orderDetail->qty_pcs > 0)
                                                                    @if ($orderDetail->qty_duz > 0)
                                                                        {{ moneyFormat($orderDetail->price_duz) }}
                                                                    @endif
                                                                    @if ($orderDetail->qty_pak > 0)
                                                                        {{ moneyFormat($orderDetail->price_pak) }}
                                                                    @endif
                                                                    @if ($orderDetail->qty_pcs > 0)
                                                                        {{ moneyFormat($orderDetail->price_pcs) }}
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($orderDetail->qty_duz > 0 || $orderDetail->qty_pak > 0 || $orderDetail->qty_pcs > 0)
                                                                    <!-- Tambahkan form input diskon per-item -->
                                                                    <input type="number" step="0.01"
                                                                        class="form-control" placeholder="Diskon"
                                                                        id="disc_atas_{{ $orderDetail->id }}">
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($orderDetail->qty_duz > 0 || $orderDetail->qty_pak > 0 || $orderDetail->qty_pcs > 0)
                                                                    @if ($orderDetail->qty_duz > 0)
                                                                        {{ moneyFormat($orderDetail->price_duz * $orderDetail->qty_duz) }}
                                                                    @endif
                                                                    @if ($orderDetail->qty_pak > 0)
                                                                        {{ moneyFormat($orderDetail->price_pak * $orderDetail->qty_pak) }}
                                                                    @endif
                                                                    @if ($orderDetail->qty_pcs > 0)
                                                                        {{ moneyFormat($orderDetail->price_pcs * $orderDetail->qty_pcs) }}
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-3">
                                                <div style="font-size: 0.9rem">KETERANGAN : </div>
                                                <p class="section-lead text-center">TIDAK MENERIMA
                                                    KOMPLAIN SETELAH FAKTUR
                                                    DITANDA
                                                    TANGANI</p>
                                            </div>
                                            <div class="col-md-4 ml-auto" style="padding-left: 15%">
                                                <table>
                                                    <thead>
                                                        <th scope="col" style="width:200px"></th>
                                                        <th scope="col" style="width:200px"></th>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="font-size: 1.1rem">
                                                                Jumlah Item
                                                            </td>
                                                            <td style="font-weight: bolder;font-size: 1.1rem">
                                                                : {{ $order->orderDetails->count() }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 1.1rem">
                                                                Potongan
                                                            </td>
                                                            <td style="font-size: 1.1rem">
                                                                : 0
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 1.1rem">Pajak</td>
                                                            <td style="font-size: 1.1rem">: 0</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 1.1rem">Tanggal</td>
                                                            <td style="font-size: 1.1rem">: 0</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-4" style="padding-left: 10%">
                                                <table>
                                                    <thead>
                                                        <th scope="col" style="width:200px"></th>
                                                        <th scope="col" style="width:200px"></th>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="font-size: 1.1rem">
                                                                Subtotal
                                                            </td>
                                                            <td style="font-weight: bolder;font-size: 1.1rem">
                                                                : {{ moneyFormat($order->total) }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 1.1rem">
                                                                Total Akhir
                                                            </td>
                                                            <td style="font-size: 1.1rem">
                                                                : {{ moneyFormat($order->total) }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 1.1rem">DP PO</td>
                                                            <td style="font-size: 1.1rem">: 0</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 1.1rem">Tunai</td>
                                                            <td style="font-size: 1.1rem">: 0</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 1.1rem">Kredit</td>
                                                            <td style="font-weight: bolder;font-size: 1.1rem">:
                                                                {{ moneyFormat($order->total) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="text-md-right">
                                <div class="float-lg-left mb-lg-0 mb-3">

                                </div>
                                <button class="btn btn-outline-warning btn-lg"><i class="fas fa-print"></i>
                                    PRINT</button>
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
