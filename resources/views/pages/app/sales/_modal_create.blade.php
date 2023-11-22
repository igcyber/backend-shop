<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="outlet">Outlet</label><br>
                    <select name="customer_name" id="outlet" class="form-control">
                        {{-- handle a situation where the customers variable might be undefined --}}
                        @isset($customers)
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->outlet->name }}">{{ $customer->outlet->name }}</option>
                            @endforeach
                        @endisset
                    </select>
                    <label for="order">Barang Pesanan</label>
                </div>
                <div class="form-group">
                    <label for=""></label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
