@extends('layouts.app')

@section('title', 'Order Invoice')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Halaman Order</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="invoice">
                            <div class="invoice-print">
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-md">
                                                <tr>
                                                    <th data-width="40">No</th>
                                                    <th>Nama Item</th>
                                                    <th>Jumlah Satuan</th>
                                                    <th>Harga</th>
                                                    <th>Total</th>
                                                </tr>
                                                @foreach ($order->orderProducts as $product)
                                                    <tr>
                                                        <td class="text-center">{{ ++$loop->index }}</td>
                                                        <td>{{ $product->product_name }}</td>
                                                        <td>{{ $product->qty }}</td>
                                                        <td>{{ moneyFormat($product->unit_price) }}</td>
                                                        <td>{{ moneyFormat($product->qty * $product->unit_price) }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-4">
                                                <div>Keterangan : </div>
                                                <p class="section-lead">PASTIKAN PRODUK YANG DI PESAN PADA APLIKASI SESUAI
                                                    DENGAN DI LAPANGAN</p>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="invoice-detail-item">
                                                    <span class="invoice-detail-name mr-4">Jumlah Item :
                                                    </span>
                                                    <span class="ml-5 pl-5">
                                                        {{ $order->product_qty }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="invoice-detail-item">
                                                    <span class="invoice-detail-name" style="margin-right: 20%">Sub
                                                        Total :
                                                    </span>
                                                    <span class="ml-5 pl-3" style="font-weight: bolder">
                                                        {{ moneyFormat($order->sub_total) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="status">Status Order</label>
                                    <div class="form-group col-md-3">
                                        <select name="order_status" id="status" data-id="{{ $order->id }}"
                                            class="form-control">
                                            <option {{ $order->order_status == 'pending' ? 'selected' : '' }}
                                                value="pending">Pending</option>
                                            <option {{ $order->order_status == 'clear' ? 'selected' : '' }} value="clear">
                                                Clear</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#status').on('change', function() {
                let status = $(this).val();
                let id = $(this).data('id');

                $.ajax({
                    method: 'GET',
                    url: '{{ route('app.order.status.change') }}',
                    data: {
                        status: status,
                        id: id
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            toastr.success(data.message)
                        }
                        // console.log(data)
                    },
                    error: function(data) {
                        console.log(data)
                    }
                })
                // alert('Hello');
            });
        })
    </script>
@endpush
