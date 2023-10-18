<div class="card">
    <div class="card-header">
        <h4>Tambah Outlet</h4>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            @csrf
            <div class="form-row">
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

                <div class="col-md-6">
                    <label for="name">Nama Outlet</label>
                    <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
                        name="name" placeholder="Tuliskan Nama Outlet" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-row mt-3">
                <div class="col-md-6">
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="user">Sales</label>
                        <select name="user_id" id="tipe"
                            class="form-control @error('user_id') is-invalid @enderror">
                            <option disabled selected>PILIH SALES</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-row mt-3">
                <div class="col-md-6">
                    <label for="telp">No. Telp</label>
                    <input id="telp" name="no_telp" type="text" value="{{ old('no_telp') }}"
                        placeholder="Tuliskan No. Telp" class="form-control @error('no_telp') is-invalid @enderror">
                    @error('no_telp')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="address">Alamat Outlet</label>
                    <textarea name="address" class="summernote-simple"></textarea>
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
