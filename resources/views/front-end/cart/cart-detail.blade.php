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
                                    <th class="bg-primary text-light pb-3" scope="col" width="25%">Produk</th>
                                    <th class="bg-primary text-light pb-3" scope="col" width="15%">Harga Satuan</th>
                                    <th class="bg-primary text-light pb-3" scope="col" width="10%">Satuan</th>
                                    <th class="bg-primary text-light pb-3">Total</th>
                                    <th class="bg-primary text-light pb-3 ">
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
                                        <td style="text-align: left">
                                            <ul>
                                                <li>{{ moneyFormat($item->productDetail->sell_price_duz) }}/dus</li>
                                                <li>{{ moneyFormat($item->productDetail->sell_price_pak) }}/pak</li>
                                                <li>{{ moneyFormat($item->productDetail->sell_price_pcs) }}/pcs</li>
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
                                                    value="{{ $item->qty_pak }}"
                                                    name="updates[{{ $item->detail_id }}][qty_pak]">
                                            </div>
                                            <div class="input-group quantity mx-auto mt-1" style="width: 100px;">
                                                <input type="text" class="form-control form-control-sm text-center"
                                                    value="{{ $item->qty_pcs }}"
                                                    name="updates[{{ $item->detail_id }}][qty_pcs]">
                                            </div>
                                        </td>

                                        <td class="align-middle">
                                            {{ moneyFormat($item->qty_duz * $item->productDetail->sell_price_duz + $item->qty_pak * $item->productDetail->sell_price_pak + $item->qty_pcs * $item->productDetail->sell_price_pcs) }}
                                        </td>
                                        <td>
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
                    class="row {{ App\Models\Cart::where('outlet_id', auth()->user()->id)->count('detail_id') == 0 ? 'd-none' : '' }}">
                    <div class="col-sm-6 mx-auto">
                        <div class="card">
                            {{-- <h5 class="card-header bg-primary text-light">Total Bayar</h5> --}}
                            <div class="card-body">
                                <h5 class="card-title">Total Pembayaran :</h5>
                                <span id="sub_total"></span>
                                <p>
                                    <small class="text-muted">Bayar Saat Sales Datang Ke Toko Anda</small>
                                </p>
                                <a href="#" class="btn btn-primary">Checkout</a>
                            </div>
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
            if (confirm("Are you sure you want to delete this item?")) {
                // Perform your delete action using AJAX or other methods
                // You can include the necessary information in the request, such as the item ID
                // For example:
                $.ajax({
                    url: 'http://127.0.0.1:8000/app/cart/delete/' + itemId,
                    type: 'DELETE',
                    data: {
                        _token: 'AJpwhwj17wgiHwG0EsAyPEFkhIxsg9py9OseQSXg'
                    },
                    success: function(response) {
                        // Handle success response
                    },
                    error: function(error) {
                        // Handle error
                    }
                });
                console.log('Item ' + itemId + ' deleted');
            }
        }
    </script>
@endpush
