@extends('layouts.app')

@section('title', 'Pesanan')

@push('style')
@endpush

@section('main')
    <div class="main-content" style="padding-left:28px; !important">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-md-5 col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h4>UBAH PESANAN</h4>
                                <a href="{{ route('app.sales') }}" class="btn btn-sm btn-primary ml-auto">
                                    <i class="fas fa-arrow-left"></i> KEMBALI
                                </a>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('app.sales.updateOrderDetail', $order->id) }}">
                                    @csrf
                                    @method('put')
                                    Pesanan No.Trans : {{ $order->transaction_id }}
                                    <!-- Display order details or perform other actions as needed -->
                                    @foreach ($orderDetails as $orderDetail)
                                        <div class="form-row">
                                            <input type="text" class="form-control col-md-8 mt-3 mx-1"
                                                value="{{ $orderDetail->productDetail->product->title }}" readonly>
                                            <input type="text"
                                                class="form-control col-md-2 mt-3 {{ $orderDetail->qty_duz == 0 ? 'd-none' : '' }}"
                                                value="{{ $orderDetail->qty_duz }}" name="qty_duz[]"> /Dus
                                            <input type="text"
                                                class="form-control col-md-2 mt-3 {{ $orderDetail->qty_pak == 0 ? 'd-none' : '' }}"
                                                value="{{ $orderDetail->qty_pak }}" name="qty_pak[]"> /Pak
                                            <input type="text"
                                                class="form-control col-md-2 mt-3 {{ $orderDetail->qty_pcs == 0 ? 'd-none' : '' }}"
                                                value="{{ $orderDetail->qty_pcs }}" name="qty_pcs[]"> /Pcs
                                            <button type="button" class="btn btn-sm btn-danger col-md-1 mt-3 mx-1"
                                                onclick="#" id="#">
                                                <i class="fa
                                            fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach


                                    <button type="submit" class="btn btn-sm btn-info mt-4">Perbarui Pesanan</button>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-lg-7">
                        <div class="card">
                            <div class="card-header">
                                <h4>DATA PRODUK</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-product" id="table-1">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 2%" class="align-middle">
                                                    No. Urut
                                                </th>
                                                <th scope="col" style="width: 20%">Nama Produk</th>
                                                <th scope="col" style="width: 10%">Detail Stok</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($detailProducts as $key => $detail)
                                                <tr>
                                                    <td class="text-center align-middle" style="padding: 0px 0px;">
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td class="align-middle" style="padding: 0px 0px;">
                                                        {{ $detail->product->title }}
                                                    </td>
                                                    <td class="align-middle">
                                                        <ul style="padding: 0; list-style-type: none; line-height:18px;">
                                                            @if ($detail->product->stock_duz > 0)
                                                                <li>{{ $detail->product->stock_duz }} dus</li>
                                                            @endif
                                                            @if ($detail->product->stock_pak > 0)
                                                                <li>{{ $detail->product->stock_pak }} pak</li>
                                                            @endif
                                                            @if ($detail->product->stock_pcs > 0)
                                                                <li>{{ $detail->product->stock_pcs }} pcs</li>
                                                            @endif
                                                        </ul>
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
    <script>
        $("#table-1").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [1]
            }],
        });
    </script>
@endpush
