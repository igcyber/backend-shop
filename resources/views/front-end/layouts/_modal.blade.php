@foreach ($detailProducts as $detail)
    <div class="modal fade" id="detailModal-{{ $detail->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Produk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="badge bg-info py-1">Nama Barang</span>
                    <h5 class="card-title mt-1 mb-2" style="font-size: 1rem">
                        {{ $detail->product->title }}</h5>
                    <span class="badge bg-success py-1">Stok Barang</span>
                    <p class="mt-1 mb-2">{{ $detail->product->stock }}
                        {{ $detail->product->unit }}</p>
                    <span class="badge bg-primary py-1">Harga</span>
                    <p class="mt-1 mb-0">{{ moneyFormat($detail->sell_price_duz) }}
                    </p>
                    <span class="badge bg-secondary mt-2">Keterangan</span>
                    <p class="card-text mb-2">{{ $detail->product->short_description }}
                    </p>
                    <form class="shopping-cart-form d-inline" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $detail->id }}">
                        <span class="badge bg-success py-1 mb-2">Kuantitas Pesanan</span>
                        <input type="number" class="form-control-sm col-sm-4 d-block mb-3 number_area" min="1"
                            max="100" value="1" name="qty">
                        <button type="submit" class="btn btn-sm btn-info px-2 py-1 add_cart">
                            <i class="fas fa-shopping-cart"></i> Pesan
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
