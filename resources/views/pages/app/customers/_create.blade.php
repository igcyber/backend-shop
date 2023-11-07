<div class="card">
    <div class="card-header">
        <h4>Tambah Outlet</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('app.customers.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="outlet">Outlet</label>
                        <select name="outlet_id" id="outlet"
                            class="form-control @error('outlet_id') is-invalid @enderror">
                            <option disabled selected>PILIH OUTLET</option>
                            @foreach ($outlets as $outlet)
                                <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                            @endforeach
                        </select>
                        @error('outlet_id')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="nomor">Nomor Outlet</label>
                    <input type="text" id="nomor" class="form-control @error('nomor') is-invalid @enderror"
                        name="nomor" placeholder="Tuliskan Nomor Outlet" value="{{ old('nomor') }}">
                    @error('nomor')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>
            <div class="form-row mt-3">

                <div class="col-md-4">
                    <label for="telp">No. Telp</label>
                    <input id="telp" name="no_telp" type="text" value="{{ old('no_telp') }}"
                        placeholder="Tuliskan No. Telp" class="form-control @error('no_telp') is-invalid @enderror">
                    @error('no_telp')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="klasifikasi">Klasifikasi</label>
                    <select name="klasifikasi" id="klasifikasi"
                        class="form-control @error('klasifikasi') is-invalid @enderror">
                        <option disabled selected>PILIH KLASIFIKASI</option>
                        <option value="Toko">Toko</option>
                        <option value="Perorangan">Perorangan</option>
                        <option value="MT">MT</option>
                        <option value="Ps. Basah">Ps. Basah</option>
                        <option value="Grosir">Grosir</option>
                        <option value="Toko">Toko</option>
                        <option value="Retail">Retail</option>
                    </select>
                    @error('klasifikasi')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="seller">Sales</label>
                        <select name="seller_id" id="seller"
                            class="form-control @error('seller_id') is-invalid @enderror">
                            <option disabled selected>PILIH SALES</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('seller_id')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-row mt-3">
                <div class="col-md-12">
                    <label for="address" style="font-weight: bold">Alamat Outlet</label>
                    <textarea id="address" name="address" class="summernote-simple @error('address') is-invalid @enderror">
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
