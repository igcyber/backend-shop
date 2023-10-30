@extends('front-end.layouts.master')

@section('title', 'Keranjang')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
    <div class="container" style="padding-top: 20vh">
        <div class="title text-center pb-5">
            <h2>PESANAN ANDA</h2>
            <div class="custom-horizontal-line"></div>
        </div>
        <div class="container-fluid">
            <div class="row px-xl-5">
                <div class="col-md-12 table-responsive mb-5">
                    <table class="table table-bordered text-center mb-0">
                        <thead class="bg-secondary text-dark">
                            <tr>
                                <th class="bg-primary text-light pb-3" scope="col" width="40%">Produk</th>
                                <th class="bg-primary text-light" scope="col" width="10%">Kuantitas (Duz/Bal)</th>
                                <th class="bg-primary text-light" scope="col" width="10%">Kuantitas (Pack)</th>
                                <th class="bg-primary text-light" scope="col" width="10%">Kuantitas (Pcs)</th>
                                <th class="bg-primary text-light pb-3">Total</th>
                                <th class="bg-primary text-light pb-3">Hapus</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @foreach ($cartItems as $item)
                                <tr id="elemenHapus">
                                    <td style="text-align: left">
                                        {{ $item->name }}
                                    </td>

                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <button class="btn btn-sm btn-primary btn-minus duz-dec">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <input type="text" class="form-control form-control-sm text-center duz-qty"
                                                value="{{ $item->qty }}" data-rowid="{{ $item->rowId }}">
                                            <button class="btn btn-sm btn-primary btn-plus duz-inc">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <button class="btn btn-sm btn-primary btn-minus pack-dec">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <input type="text" class="form-control form-control-sm text-center pack-qty"
                                                value="{{ $item->options->pack_qty }}">
                                            <button class="btn btn-sm btn-primary btn-plus pack-inc">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <button class="btn btn-sm btn-primary btn-minus pcs-dec">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <input ttype="text" class="form-control form-control-sm text-center pcs-qty"
                                                value="{{ $item->options->pcs_qty }}">
                                            <button class="btn btn-sm btn-primary btn-plus pcs-inc">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>

                                    <td class="align-middle" id="{{ $item->rowId }}">
                                        {{ moneyFormat($item->price * $item->qty) }}</td>
                                    <td class="align-middle" id="tombolTutup"><button class="btn btn-sm btn-primary"><i
                                                class="fa fa-times"></i></button></td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-6 mx-auto">
                        <div class="card">
                            <h5 class="card-header bg-primary text-light">Total Belajaan</h5>
                            <div class="card-body">
                                <h5 class="card-title">Sub Total :</h5>
                                <span>Rp.500.000</span>
                                <p class="card-text"></p>
                                <a href="verifikasi.html" class="btn btn-primary">Pesan Sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.duz-inc').on('click', function() {
                let input = $(this).siblings('.duz-qty');
                let qty = parseInt(input.val());
                let rowId = input.data('rowid');
                // console.log(qty)

                $.ajax({
                    url: "{{ route('updateCart') }}",
                    method: 'POST',
                    data: {
                        rowId: rowId,
                        qty: qty
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            let productId = '#' + rowId;
                            $(productId).text(data.product_total)
                            toastr.success(data.message);
                        }
                    },
                    error: function(data) {
                        if (data.status == 'error') {
                            toastr.success(data.message);
                        }
                    }
                })
            })
        })
    </script>
@endpush
