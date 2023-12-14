<div class="card">
    <div class="card-header">
        <h4>TAMBAH PABRIKAN</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('app.vendors.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
                    name="name" placeholder="Tuliskan Nama Pabrikan" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback" style="display: block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                    <option disabled selected>PILIH STATUS</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
                @error('status')
                    <div class="invalid-feedback" style="display: block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="text-right mt-3">
                <button class="btn btn-lg btn-outline-primary p-2 px-4" type="submit">
                    <i class="fa fa-paper-plane"></i> SUBMIT </button>
            </div>
        </form>
    </div>
</div>
