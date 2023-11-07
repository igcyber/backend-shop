<div class="card">
    <div class="card-header">
        <h4>Tambah Produk</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('app.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- INPUT GAMBAR PRODUK --}}
            {{-- <div class="col-md-6">
                <img src="" alt="" id="img">
            </div> --}}
            <div class="form-row">
                <div class="col-md-6 mt-2">
                    <label for="img" style="font-weight: bold">Gambar</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="far fa-image"></i>
                            </div>
                        </div>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                            onChange="showImage(this)">
                        @error('image')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mt-2">
                    <label style="font-weight: bold">Tanggal Kadaluarsa</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-calendar"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control datepicker" name="exp_date">
                    </div>
                </div>

            </div>
            {{-- INPUT NAMA & NOMOR --}}
            <div class="form-row">
                <div class="col-md-6 mt-2">
                    <label for="title" style="font-weight: bold">Nama</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-box"></i>
                            </div>
                        </div>
                        <input type="text" id="title" class="form-control @error('title') is-invalid @enderror"
                            name="title" placeholder="Tuliskan Nama Produk" value="{{ old('title') }}">
                        @error('title')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mt-2">
                    <label for="serial" style="font-weight: bold">Nomor</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-barcode"></i>
                            </div>
                        </div>
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
            </div>
            {{-- INPUT PABRIKAN DAN TIPE PRODUK --}}
            <div class="form-row">
                <div class="col-md-6 mt-2">
                    <label for="vendor" style="font-weight: bold">Pabrikan</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-industry"></i>
                            </div>
                        </div>
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
                </div>

                <div class="col-md-6 mt-2">
                    <label for="tipe" style="font-weight: bold">Tipe</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-tag"></i>
                            </div>
                        </div>
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
            </div>
            {{-- LABEL STOCK PRODUK --}}
            <div class="form-row mt-3 mb-2">
                <div class="col-md-12" style="font-weight:bold">
                    <label class="breadcrumb bg-secondary text-white justify-content-center">JUMLAH STOK</label>
                </div>
                <span class="badge bg-danger text-white">Perhatian : Kosongkan Satuan Yang Tidak Ada Stok</span>
            </div>
            {{-- INPUT Stok & Unit PRODUK  --}}
            {{-- Stock Dengan Masing-Masing Satuan --}}
            <div class="form-row">
                {{-- stock dus --}}
                <div class="col-md-3 mt-2">
                    <div class="input-group">
                        <input type="text" class="form-control @error('stock') is-invalid @enderror"
                            value="{{ old('stock') }}" name="stock" id="stock" placeholder="0">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-secondary">
                                Dus
                            </div>
                        </div>
                    </div>
                    @error('stock')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- stock baal --}}
                <div class="col-md-3 mt-2">
                    <div class="input-group">
                        <input type="text" class="form-control @error('stock_baal') is-invalid @enderror"
                            value="{{ old('stock_baal') }}" name="stock_baal" placeholder="0">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-secondary">
                                Baal
                            </div>
                        </div>
                    </div>
                    @error('stock_baal')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- stock pack --}}
                <div class="col-md-3 mt-2">
                    <div class="input-group">
                        <input type="text" class="form-control @error('stock_pack') is-invalid @enderror"
                            value="{{ old('stock_pack') }}" name="stock_pack" placeholder="0">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-secondary">
                                Pack
                            </div>
                        </div>
                    </div>
                    @error('stock_pack')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- stock pcs --}}
                <div class="col-md-3 mt-2">
                    <div class="input-group">
                        <input type="text" class="form-control @error('stock_pcs') is-invalid @enderror"
                            value="{{ old('stock_pcs') }}" name="stock_pcs" placeholder="0">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-secondary">
                                Pcs
                            </div>
                        </div>
                    </div>
                    @error('stock_pcs')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            {{-- INPUT DESKRIPSI SINGKAT --}}
            <div class="form-row mt-3">
                <div class="col-md-12">
                    <label for="desc" style="font-weight: bold">Deskripsi Singkat</label>
                    <textarea id="desc" class="summernote-simple @error('short_descriptions') is-invalid @enderror"
                        name="short_description">
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
