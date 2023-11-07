<div class="card">
    <div class="card-header">
        <h4>Tambah Detail Produk</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('app.detail-products.store') }}" method="POST">
            @csrf
            {{-- SELECT PRODUCT & INPUT BUY PRICE --}}
            <div class="form-row">
                <div class="col-md-6 mt-2">
                    <label for="product" style="font-weight: bold">Produk</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-boxes"></i>
                            </div>
                        </div>
                        <select name="product_id" id="product"
                            class="form-control @error('product_id') is-invalid @enderror">
                            <option disabled selected>PILIH PRODUCT</option>
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}">{{ $p->title }}</option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mt-2">
                    <label for="rupiahInput" style="font-weight: bold">Harga Beli</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-money-bill"></i>
                            </div>
                        </div>
                        <input type="text" name="buy_price"
                            class="form-control @error('buy_price') is-invalid @enderror" placeholder="0"
                            id="rupiahInput">
                        @error('buy_price')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- SELECT JENIS PAJAK & PERIODE --}}
            <div class="form-row">
                <div class="col-md-6 mt-2">
                    <label for="tax" style="font-weight: bold">Jenis Pajak</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-percentage"></i>
                            </div>
                        </div>
                        <select name="tax_type" id="tax"
                            class="form-control @error('tax_type') is-invalid @enderror">
                            <option disabled selected>PILIH JENIS</option>
                            <option value="PPN">PPN</option>
                            <option value="NON-PPN">NON-PPN</option>
                        </select>
                        @error('tax_type')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mt-2">
                    <label for="per" style="font-weight: bold">Periode</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-history"></i>
                            </div>
                        </div>
                        <select name="periode" id="per"
                            class="form-control @error('periode') is-invalid @enderror">
                            <option disabled selected>PILIH PERIODE</option>
                            <option value="Reguler">Reguler</option>
                            <option value="Seasonal">Seasonal</option>
                        </select>
                        @error('periode')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- LABEL STOCK PRODUK --}}
            <div class="form-row mt-3 mb-2">
                <div class="col-md-12" style="font-weight:bold">
                    <label class="breadcrumb bg-secondary text-white justify-content-center">HARGA JUAL</label>
                </div>
                <span class="badge bg-danger text-white">Perhatian : Kosongkan Satuan Yang Tidak Ada Harga Jual</span>
            </div>

            {{-- INPUT Stok & Unit PRODUK  --}}
            {{-- Harga Dengan Masing-Masing Satuan --}}
            <div class="form-row">
                {{-- stock dus --}}
                <div class="col-md-3 mt-2">
                    <div class="input-group">
                        <input type="text" class="form-control @error('sell_price_duz') is-invalid @enderror"
                            value="{{ old('sell_price_duz') }}" name="sell_price_duz" placeholder="0" id="hargaDuz">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-secondary">
                                Dus
                            </div>
                        </div>
                    </div>
                    @error('sell_price_duz')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- stock baal --}}
                <div class="col-md-3 mt-2">
                    <div class="input-group">
                        <input type="text" class="form-control @error('sell_price_baal') is-invalid @enderror"
                            value="{{ old('sell_price_baal') }}" name="sell_price_baal" placeholder="0" id="hargaBaal">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-secondary">
                                Baal
                            </div>
                        </div>
                    </div>
                    @error('sell_price_baal')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- stock pack --}}
                <div class="col-md-3 mt-2">
                    <div class="input-group">
                        <input type="text" class="form-control @error('sell_price_pack') is-invalid @enderror"
                            value="{{ old('sell_price_pack') }}" name="sell_price_pack" placeholder="0" id="hargaPack">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-secondary">
                                Pack
                            </div>
                        </div>
                    </div>
                    @error('sell_price_pack')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- stock pcs --}}
                <div class="col-md-3 mt-2">
                    <div class="input-group">
                        <input type="text" class="form-control @error('sell_price_pcs') is-invalid @enderror"
                            value="{{ old('sell_price_pcs') }}" name="sell_price_pcs" placeholder="0"
                            id="hargaPcs">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-secondary">
                                Pcs
                            </div>
                        </div>
                    </div>
                    @error('sell_price_pcs')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="text-right mt-3">
                <button class="btn btn-sm btn-primary" type="submit">
                    <i class="fa fa-paper-plane"></i> Submit</button>
                <button class="btn btn-sm btn-warning" type="reset">
                    <i class="fa fa-redo"></i> Reset</button>
            </div>
        </form>
    </div>
</div>
