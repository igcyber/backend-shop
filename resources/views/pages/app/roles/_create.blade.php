<div class="card">
    <div class="card-header">
        <h4>Tambah Hak Akses</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('app.roles.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Hak Akses</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name">
                @error('name')
                    <div class="invalid-feedback" style="display: block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Hak Izin</label>
                <br>
                @foreach ($permissions as $permission)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="{{ $permission->name }}"
                            id="check-{{ $permission->id }}" name="permissions[]"
                            @error('permission') is-invalid @enderror>
                        <label class="form-check-label"
                            for="check-{{ $permission->id }}">{{ $permission->name }}</label>
                    </div>
                @endforeach
                @error('permissions')
                    <div class="invalid-feedback" style="display: block">
                        {{ $message }}
                    </div>
                @enderror
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
