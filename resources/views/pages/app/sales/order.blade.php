@extends('layouts.app')

@section('title', 'Buat Pesanan')

@push('style')
@endpush

@section('main')
    <div class="main-content" style="padding-left:14px; !important">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-md-5 col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h4>BUAT PESANAN</h4>
                                <a href="{{ route('app.sales') }}" class="btn btn-sm btn-warning ml-auto">
                                    <i class="fas fa-arrow-left"></i>
                                    KEMBALI
                                </a>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('app.sales.cart.update', auth()->user()->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-user-alt"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" value="{{ Auth::user()->name }}"
                                                readonly>
                                            <input type="hidden" name="sales_id" value="{{ Auth::user()->id }}">
                                        </div>
                                        <div class="input-group mt-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-shop"></i>
                                                </div>
                                            </div>
                                            <select name="outlet_id" id="outlet_id" class="form-control">
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->outlet->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @if (!$salesCart->isEmpty())
                                        <div class="form-group">

                                            <p class="mb-0 bg bg-success text-white p-2 text-uppercase">
                                                <i class="fas fa-shopping-cart"></i> Keranjang Pesanan
                                            </p>
                                            @if ($errors->any())
                                                <ul style="list-style: none;">
                                                    @foreach ($errors->unique() as $error)
                                                        <div class="alert alert-danger mt-3 mr-5 text-center text-uppercase fs-10"
                                                            style="font-weight: bolder; line-height: 12px; !important">
                                                            <li>{{ $error }}</li>
                                                        </div>
                                                    @endforeach
                                                </ul>
                                            @endif
                                            @foreach ($salesCart as $key => $item)
                                                <div class="form-row">
                                                    <input type="text" class="form-control col-md-7 mt-3"
                                                        value="{{ $item->productDetail->product->title }}">
                                                    <input type="hidden" class="form-control" name="detail_id[]"
                                                        value="{{ $item->detail_id }}">
                                                    <input type="text" class="form-control col-md-2 mt-3"
                                                        name="qty_product[]" placeholder="Banyak">

                                                    <select name="satuan[]" class="form-control col-md-2 mt-3">
                                                        <option value="duz">dus</option>
                                                        <option value="pak">pak</option>
                                                        <option value="pcs">pcs</option>
                                                    </select>
                                                    <button type="button" class="btn btn-sm btn-danger col-md-1 mt-3"
                                                        onclick="deleteItem(this.id)" id="{{ $item->id }}">
                                                        <i
                                                            class="fa
                                                    fa-times"></i>
                                                    </button>
                                                </div>
                                            @endforeach

                                        </div>

                                        <div class="text-right mt-3">
                                            <button class="btn btn-sm btn-primary" type="submit">
                                                <i class="fa fa-paper-plane"></i> Submit</button>
                                        </div>
                                    @endif
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
                                                <th scope="col" style="width: 10%">Harga Jual</th>
                                                <th scope="col" style="width: 2%">Pilihan</th>
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
                                                    <td style="padding: 0px 0px;">
                                                        <ul
                                                            style="padding: 0; list-style-type: none; line-height: 19px;margin-top:5%;">
                                                            <li>{{ moneyFormat($detail->sell_price_duz) }}/dus</li>
                                                            @if ($detail->sell_price_duz !== $detail->sell_price_pak)
                                                                <li>{{ moneyFormat($detail->sell_price_pak) }}/pak</li>
                                                            @endif
                                                            @if ($detail->sell_price_pcs != 0)
                                                                <li>{{ moneyFormat($detail->sell_price_pcs) }}/pcs</li>
                                                            @endif
                                                        </ul>
                                                    </td>
                                                    <td class="align-middle">
                                                        <a href="{{ route('app.sales.cart', [$detail->id, auth()->user()->id]) }}"
                                                            class="btn btn-sm btn-success">
                                                            <i class="fas fa-cart-plus"></i>
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

@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script>
        $("#table-1").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [1, 2, 4]
            }],
        });
    </script>

    <script>
        function deleteItem(itemId) {
            var id = itemId;
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

                    $.ajax({
                        url: '/app/sales/delete/' + itemId,
                        type: 'DELETE',
                        data: {
                            _token: token
                        },
                        success: function(response) {
                            location.reload();
                        },
                        error: function(error) {
                            location.reload();
                        }
                    });

                } else {
                    return true;
                }
            })
        }
    </script>
@endpush
