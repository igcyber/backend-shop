@extends('front-end.layouts.master')

@section('title', 'Keranjang')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
    <div class="container" style="padding-top: 20vh">
        <div class="title text-center pb-5">
            <h2>PESANAN ANDA</h2>
            <div class="custom-horizontal-line"></div>
        </div>
        <div class="container-fluid">
            <div class="row px-xl-5">
                <div class="col-md-12 table-responsive mb-5">
                    <form id="formUpdate" action="{{ route('app.cart.update', auth()->user()->id) }}" method="POST">
                        @csrf
                        <table class="table table-bordered text-center mb-0">
                            <thead class="bg-secondary text-dark">
                                <tr>
                                    <th class="bg-primary text-light pb-3" scope="col" width="25%">Barang</th>
                                    <th class="bg-primary text-light pb-3" scope="col" width="10%">Stok</th>
                                    <th class="bg-primary text-light pb-3" scope="col" width="25%">Harga Satuan
                                    </th>
                                    <th class="bg-primary text-light pb-3" scope="col" width="15%">Satuan</th>
                                    <th class="bg-primary text-light pb-3" scope="col" width="20%">Total</th>
                                    <th class="bg-primary text-light pb-3" scope="col" width="15%">
                                        Pilihan
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @foreach ($carts as $key => $item)
                                    <tr>
                                        <td style="text-align: left">
                                            {{ $item->productDetail->product->title }}
                                        </td>
                                        <td>
                                            @if ($item->productDetail->product->stock_duz !== 0)
                                                {{ $item->productDetail->product->stock_duz }} dus
                                            @endif
                                            <br>
                                            @if ($item->productDetail->product->stock_pak !== 0)
                                                <span>{{ $item->productDetail->product->stock_pak }} pak</span>
                                            @endif
                                            <br>
                                            @if ($item->productDetail->product->stock_pcs !== 0)
                                                <span>{{ $item->productDetail->product->stock_pcs }} pcs</span>
                                            @endif
                                        </td>
                                        <td style="text-align: left">
                                            <ul>
                                                <li>{{ moneyFormat($item->productDetail->sell_price_duz) }}/dus</li>
                                                @if ($item->productDetail->sell_price_duz !== $item->productDetail->sell_price_pak)
                                                    <li>{{ moneyFormat($item->productDetail->sell_price_pak) }}/pak</li>
                                                @endif
                                                @if ($item->productDetail->sell_price_pcs != 0)
                                                    <li>{{ moneyFormat($item->productDetail->sell_price_pcs) }}/pcs</li>
                                                @endif
                                            </ul>
                                        </td>

                                        <td class="align-middle">
                                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                                <input type="text" class="form-control form-control-sm text-center"
                                                    value="{{ $item->qty_duz }}"
                                                    name="updates[{{ $item->detail_id }}][qty_duz]">
                                            </div>
                                            <div class="input-group quantity mx-auto mt-1" style="width: 100px;">
                                                <input type="text" class="form-control form-control-sm text-center"
                                                    value="{{ $item->qty_pak }}" placeholder="pak"
                                                    name="updates[{{ $item->detail_id }}][qty_pak]">
                                            </div>
                                            <div class="input-group quantity mx-auto mt-1" style="width: 100px;">
                                                <input type="text" class="form-control form-control-sm text-center "
                                                    value="{{ $item->qty_pcs }}" placeholder="pcs"
                                                    name="updates[{{ $item->detail_id }}][qty_pcs]">
                                            </div>
                                        </td>

                                        <td class="align-middle">

                                            {{ moneyFormat($item->qty_duz * $item->productDetail->sell_price_duz + $item->qty_pak * $item->productDetail->sell_price_pak + $item->qty_pcs * $item->productDetail->sell_price_pcs) }}
                                        </td>
                                        <td>
                                            <input type="hidden" id="">
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="deleteItem(this.id)" id="{{ $item->id }}">
                                                <i class="fa
                                                fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                                {{-- JIKA TIDAK ADA PESANAN --}}
                                @if (count($carts) == 0)
                                    <tr>
                                        <td colspan="7">
                                            Keranjang Kosong !
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="col-md-8 mt-2">
                            <button type="submit" class="btn btn-sm btn-info">Perbarui Keranjang</button>
                        </div>
                    </form>
                </div>


                <div
                    class="col-sm-6 mx-auto {{ App\Models\Cart::where('outlet_id', auth()->user()->id)->count('detail_id') == 0 ? 'd-none' : '' }}">
                    <div class="card">
                        {{-- <h5 class="card-header bg-primary text-light">Total Bayar</h5> --}}
                        <div class="card-body">
                            <h5 class="card-title">Total Pembayaran :</h5>
                            <span id="sub_total">{{ moneyFormat($subtotal) }}</span>
                            <p>
                                <small class="text-muted">Bayar Saat Sales Datang Ke Toko Anda</small>
                            </p>
                            <a href="{{ route('app.checkout', auth()->user()->id) }}" class="btn btn-primary ">Checkout</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection
@push('scripts')
    <script>
        function deleteItem(itemId) {
            var id = itemId;
            var token = $("meta[name='csrf-token']").attr("content");
            var user_id = {{ $user_id }}

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
                        url: '/app/cart/delete/' + itemId + '/' + user_id,
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
