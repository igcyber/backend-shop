@foreach ($detailProducts as $detail)
    <div class="modal fade" id="detailModal-{{ $detail->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="shopping-cart-form" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Produk</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span class="badge bg-info py-1">Nama Produk</span>
                        <h5 class="card-title mt-1 mb-0" style="font-size: 1rem">
                            {{ $detail->product->title }}</h5>
                        <span class="badge bg-secondary mt-2">Keterangan</span>
                        <p class="card-text mb-0">{{ $detail->product->short_description }}
                        </p>
                        <div class="">
                            <span class="badge bg-success py-1">Stok Barang</span>
                            <span class="badge bg-primary py-1 px-5 ">Harga</span>
                        </div>
                        <div class="mb-3">
                            <p class="mb-0 {{ $detail->product->stock == 0 ? 'd-none' : '' }}">
                                {{ $detail->product->stock }}
                                duz <span style="margin-left: 15.4%;">{{ moneyFormat($detail->sell_price_duz) }}</span>
                            </p>
                            <p class="mb-0 {{ $detail->product->stock_baal == 0 ? 'd-none' : '' }}">
                                {{ $detail->product->stock_baal }}
                                baal <span style="margin-left: 8%;">{{ moneyFormat($detail->sell_price_baal) }}</span>
                            </p>
                            <p class="mb-0 {{ $detail->product->stock_pack == 0 ? 'd-none' : '' }}">
                                {{ $detail->product->stock_pack }}
                                pack <span style="margin-left: 11%;">{{ moneyFormat($detail->sell_price_pack) }}</span>
                            </p>
                            <p class="mb-0 {{ $detail->product->stock_pcs == 0 ? 'd-none' : '' }}">
                                {{ $detail->product->stock_pack }}
                                pcs <span style="margin-left: 13%;">{{ moneyFormat($detail->sell_price_pcs) }}</span>
                            </p>

                        </div>
                        <hr>

                        {{-- REQUEST FROM HERE --}}
                        <input type="hidden" name="id" value="{{ $detail->id }}">
                        <div class="row" style="padding-right: 20px;">
                            <h5>Banyak Pesanan</h5>
                            <div class="col-md-3 {{ $detail->product->stock == 0 ? 'd-none' : '' }}">
                                <span class="badge bg-success py-1 mb-2">Dus</span>
                                <input type="number" class="form-control-sm col-sm-12 d-block mb-3 number_area mx-0"
                                    value="0" name="qty">
                            </div>
                            <div class="col-md-3 {{ $detail->product->stock_baal == 0 ? 'd-none' : '' }}">
                                <span class="badge bg-success py-1 mb-2">Baal</span>
                                <input type="number" class="form-control-sm col-sm-12 d-block mb-3 number_area mx-0"
                                    value="0" name="baal_qty">
                            </div>
                            <div class="col-md-3 {{ $detail->product->stock_pack == 0 ? 'd-none' : '' }}">
                                <span class="badge bg-success py-1 mb-2">Pack</span>
                                <input type="number" class="form-control-sm col-sm-12 d-block mb-3 number_area"
                                    value="0" name="pack_qty">
                            </div>
                            <div class="col-md-3 {{ $detail->product->stock_pcs == 0 ? 'd-none' : '' }}">
                                <span class="badge bg-success py-1 mb-2">Pcs</span>
                                <input type="number" class="form-control-sm col-sm-12 d-block mb-3 number_area"
                                    value="0" name="pcs_qty">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah
                            Pesanan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach
