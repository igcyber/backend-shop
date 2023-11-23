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
                            @foreach ($products as $item)
                                @if (!in_array($item->id, $existProducIds))
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endif
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
                    <label for="rupiahInput" style="font-weight: bold; padding-right:3%;">Harga Jual</label>
                    <span id="blink" class="badge bg-info text-white">
                        <i class="fas fa-exclamation-triangle"></i> Pastikan Harga Jual Sesuai
                    </span>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-money-bill"></i>
                            </div>
                        </div>
                        <input type="text" name="sell_price_duz"
                            class="form-control @error('sell_price_duz') is-invalid @enderror" placeholder="0"
                            id="rupiahInput">
                        @error('sell_price_duz')
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

            <div class="text-right mt-3">
                <button class="btn btn-sm btn-primary" type="submit">
                    <i class="fa fa-paper-plane"></i> Submit</button>
                <button class="btn btn-sm btn-warning" type="reset">
                    <i class="fa fa-redo"></i> Reset</button>
            </div>
        </form>
    </div>
</div>
