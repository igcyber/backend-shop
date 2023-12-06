@foreach ($orders as $key => $order)
    <div class="modal fade" id="detailModal-{{ $order->id }}" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog">
            <form class="shopping-cart-form" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Pesanan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        @foreach ($order->orderDetails as $orderDetail)
                            <li style="line-height: 16px;list-style-type: none;">
                                @if ($orderDetail->qty_duz > 0 || $orderDetail->qty_pak > 0 || $orderDetail->qty_pcs > 0)
                                    @if ($orderDetail->qty_duz > 0)
                                        <label for=""> {{ $orderDetail->productDetail->product->title }}</label>
                                        <input type="text" name="qty_duz" class="form-control col-md-4"
                                            value="{{ $orderDetail->qty_duz }}">
                                    @endif
                                    @if ($orderDetail->qty_pak > 0)
                                        {{ $orderDetail->qty_pak }} Pak
                                    @endif
                                    @if ($orderDetail->qty_pcs > 0)
                                        {{ $orderDetail->qty_pcs }} Pcs
                                    @endif
                                @endif

                            </li>
                        @endforeach
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Perbarui
                            Pesanan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach
