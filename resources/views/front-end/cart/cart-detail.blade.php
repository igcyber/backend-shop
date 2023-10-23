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
                <div class="col-lg-12 table-responsive mb-5">
                    <table class="table table-bordered text-center mb-0">
                        <thead class="bg-secondary text-dark">
                            <tr>
                                <th class="bg-primary text-light pb-3">Produk</th>
                                <th class="bg-primary text-light pb-3">Harga</th>
                                <th class="bg-primary text-light" scope="col" width="10%">Kuantitas (Duz/Bal)</th>
                                <th class="bg-primary text-light" scope="col" width="10%">Kuantitas (Pack)</th>
                                <th class="bg-primary text-light" scope="col" width="10%">Kuantitas (Pcs)</th>
                                <th class="bg-primary text-light pb-3">Total</th>
                                <th class="bg-primary text-light pb-3">Hapus</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            <tr id="elemenHapus">
                                <td class="align-middle"><img src="img/product-1.jpg" alt="" style="width: 50px;">
                                    ALTO EGG ROLL</td>
                                <td class="align-middle">Rp.50.000</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm text-center"
                                            value="1">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm text-center"
                                            value="1">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm text-center"
                                            value="1">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">Rp.100.000</td>
                                <td class="align-middle" id="tombolTutup"><button class="btn btn-sm btn-primary"><i
                                            class="fa fa-times"></i></button></td>
                            </tr>
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
@endpush
