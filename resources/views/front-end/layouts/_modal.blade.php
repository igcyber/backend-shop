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
                            <span class="badge bg-primary py-1 ">Harga</span>
                        </div>
                        <div class="mb-3">
                            <span class="mb-0">{{ $detail->product->stock }}
                                {{ $detail->product->unit }}</span>

                            <span class="mb-0 px-5">{{ moneyFormat($detail->sell_price_duz) }}
                            </span>
                        </div>
                        <hr>

                        {{-- REQUEST FROM HERE --}}
                        <input type="hidden" name="id" value="{{ $detail->id }}">
                        <div class="row">
                            <h5>Masukan Kuantitas Pesanan</h5>
                            <div class="col-md-4">
                                <span class="badge bg-success py-1 mb-2">Kuantitas(Duz)</span>
                                <input type="number" class="form-control-sm col-sm-6 d-block mb-3 number_area mx-0"
                                    min="0" max="100" value="0" name="qty">
                            </div>
                            <div class="col-md-4">
                                <span class="badge bg-success py-1 mb-2">Kuantitas(Pack)</span>
                                <input type="number" class="form-control-sm col-sm-6 d-block mb-3 number_area"
                                    min="0" max="100" value="0" name="pack_qty">
                            </div>
                            <div class="col-md-4">
                                <span class="badge bg-success py-1 mb-2">Kuantitas(Pcs)</span>
                                <input type="number" class="form-control-sm col-sm-6 d-block mb-3 number_area"
                                    min="0" max="100" value="0" name="pcs_qty">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah
                            Pesanan</button>
                    </div>
            </form>
        </div>
    </div>
    </div>
@endforeach
