<div class="card">
    <div class="card-header">
        <h4>Tambah Produk</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('app.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- INPUT GAMBAR PRODUK --}}
            <div class="form-group">
                <label for="img">Gambar Produk</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                @error('image')
                    <div class="invalid-feedback" style="display: block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- INPUT NAMA & NOMOR --}}
            <div class="form-row">
                <div class="col-md-6">
                    <label for="title">Nama Produk</label>
                    <input type="text" id="title" class="form-control @error('title') is-invalid @enderror"
                        name="title" placeholder="Tuliskan Nama Produk" value="{{ old('title') }}">
                    @error('title')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="serial">Nomor Produk</label>
                    <input type="text" name="serial_number"
                        class="form-control @error('serial_number') is-invalid @enderror"
                        placeholder="Tuliskan Nomor Produk" value="{{ old('serial_number') }}">
                    @error('serial_number')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            {{-- INPUT PABRIKAN DAN TIPE PRODUK --}}
            <div class="form-row mt-3">
                <div class="col-md-6">
                    <label for="vendor">Pabrikan Produk</label>
                    <select name="vendor_id" id="vendor"
                        class="form-control @error('vendor_id') is-invalid @enderror">
                        <option disabled selected>PILIH PABRIKAN</option>
                        @foreach ($vendors as $v)
                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                        @endforeach
                    </select>
                    @error('vendor_id')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="tipe">Tipe Produk</label>
                    <select name="category_id" id="tipe"
                        class="form-control @error('vendor_id') is-invalid @enderror">
                        <option disabled selected>PILIH TIPE</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            {{-- INPUT JENIS PAJAK & PERIODE PRODUK --}}
            <div class="form-row mt-3">
                <div class="col-md-6">
                    <label for="tax">Jenis Pajak</label>
                    <select name="tax_type" id="tax" class="form-control @error('tax_type') is-invalid @enderror">
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

                <div class="col-md-6">
                    <label for="per">Periode</label>
                    <select name="periode" id="per" class="form-control @error('periode') is-invalid @enderror">
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

            {{-- INPUT Stok & Unit PRODUK --}}
            <div class="form-row mt-3">
                <div class="col-md-6">
                    <label for="stock">Stok Produk</label>
                    <input type="number" class="form-control @error('stock') is-invalid @enderror"
                        value="{{ old('stock') }}" name="stock" id="stock" min="0"
                        placeholder="Stok Produk">
                    @error('stock')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="unit">Satuan</label>
                    <select name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror">
                        <option disabled selected>PILIH SATUAN</option>
                        <option value="Duz">Duz</option>
                        <option value="Baal">Baal</option>
                        <option value="Pack">Pack</option>
                        <option value="Pcs">Pcs</option>
                    </select>
                    @error('unit')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            {{-- INPUT HARGA BELI --}}
            <div class="form-row mt-3">
                <div class="col-md-12">
                    <label for="buy">Harga Beli</label>
                    <input type="text" id="buy" class="form-control @error('buy_price') is-invalid @enderror"
                        name="buy_price" placeholder="Rp. " value="{{ old('buy_price') }}">
                    @error('buy_price')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>

            {{-- INPUT HARGA JUAL --}}
            <div class="form-row mt-3">
                <div class="col-md-4">
                    <label for="duz">Harga Jual Duz/Baal</label>
                    <input type="text" id="duz"
                        class="form-control @error('sell_price_duz') is-invalid @enderror" name="sell_price_duz"
                        placeholder="Rp. " value="{{ old('sell_price_duz') }}">
                    @error('sell_price_duz')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="pack">Harga Jual Pack</label>
                    <input type="text" id="pack"
                        class="form-control @error('sell_price_pack') is-invalid @enderror" name="sell_price_pack"
                        placeholder="Rp. " value="{{ old('sell_price_pack') }}">
                    @error('sell_price_pack')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="pcs">Harga Jual Pcs</label>
                    <input type="text" id="pcs"
                        class="form-control @error('sell_price_pcs') is-invalid @enderror" name="sell_price_pcs"
                        placeholder="Rp. " value="{{ old('sell_price_pcs') }}">
                    @error('sell_price_pcs')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            {{-- INPUT PRODUK TERBAIK --}}
            <div class="form-row mt-3">
                <div class="col-md-12">
                    <label for="top">Produk Terbaik</label>
                    <select name="is_top" id="top"
                        class="form-control @error('is_top') is-invalid @enderror">
                        <option disabled selected>PILIH STATUS</option>
                        <option value="1">Tampilkan</option>
                        <option value="0">Sembunyikan</option>
                    </select>
                    @error('is_top')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            {{-- INPUT DESKRIPSI SINGKAT --}}
            <div class="form-row mt-3">
                <div class="col-md-12">
                    <label for="desc">Deskripsi Singkat</label>
                    <textarea id="desc" class="summernote-simple @error('short_descriptions') is-invalid @enderror"
                        name="short_descriptions">
                        {{ old('short_descriptions') }}
                    </textarea>
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
