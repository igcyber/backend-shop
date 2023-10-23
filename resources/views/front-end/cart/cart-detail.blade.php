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
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="bg-primary text-light">Gambar Produk</th>
                                <th class="bg-primary text-light">Nama Barang</th>
                                <th class="bg-primary text-light">Kuantitas Duz</th>
                                <th class="bg-primary text-light">Kuantitas Pack</th>
                                <th class="bg-primary text-light">Kuantitas Pcs</th>
                                <th class="bg-primary text-light">Harga</th>
                                <th class="bg-primary text-light">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="elemenHapus">
                                <td><img src="img/produk upindo/ALFITO ( 6 PACK x 20 PCS ).jpg" alt=""
                                        style="width: 150px" /></td>
                                <td>ALFITO</td>
                                <td>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(-1)">-</button>
                                    <span id="totalClicks">0</span>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(1)">+</button>
                                </td>
                                <td>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(-1)">-</button>
                                    <span id="totalClicks">0</span>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(1)">+</button>
                                </td>
                                <td>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(-1)">-</button>
                                    <span id="totalClicks">0</span>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(1)">+</button>
                                </td>
                                <td>Rp.50.000</td>
                                <td class="text-center" style="padding-top: 45px"><button id="tombolTutup" type="button"
                                        class="btn-close" aria-label="Close"></button></td>
                            </tr>

                            <tr>
                                <td><img src="img/produk upindo/ALTO EGG ROLL ( 6 PACK x 20 PCS ).jpg" alt=""
                                        style="width: 150px" /></td>
                                <td>ALTO EGG ROLL</td>
                                <td>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(-1)">-</button>
                                    <span id="totalClicks">0</span>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(1)">+</button>
                                </td>
                                <td>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(-1)">-</button>
                                    <span id="totalClicks">0</span>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(1)">+</button>
                                </td>
                                <td>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(-1)">-</button>
                                    <span id="totalClicks">0</span>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(1)">+</button>
                                </td>
                                <td>Rp.50.000</td>
                                <td class="text-center" style="padding-top: 45px"><button type="button" class="btn-close"
                                        aria-label="Close"></button></td>
                            </tr>

                            <tr>
                                <td><img src="img/produk upindo/APALLA ( 6 PACK x 20 PCS ).jpg" alt=""
                                        style="width: 150px" /></td>
                                <td>APALLA</td>
                                <td>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(-1)">-</button>
                                    <span id="totalClicks">0</span>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(1)">+</button>
                                </td>
                                <td>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(-1)">-</button>
                                    <span id="totalClicks">0</span>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(1)">+</button>
                                </td>
                                <td>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(-1)">-</button>
                                    <span id="totalClicks">0</span>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(1)">+</button>
                                </td>
                                <td>Rp.50.000</td>
                                <td class="text-center" style="padding-top: 45px"><button type="button" class="btn-close"
                                        aria-label="Close"></button></td>
                            </tr>

                            <tr>
                                <td><img src="img/produk upindo/BAKSO UDANG ( 6 PACK x 20 PCS ).jpg" alt=""
                                        style="width: 150px" /></td>
                                <td>BAKSO UDANG</td>
                                <td>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(-1)">-</button>
                                    <span id="totalClicks">0</span>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(1)">+</button>
                                </td>
                                <td>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(-1)">-</button>
                                    <span id="totalClicks">0</span>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(1)">+</button>
                                </td>
                                <td>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(-1)">-</button>
                                    <span id="totalClicks">0</span>
                                    <button class="bg-primary border-0 text-light" onclick="totalClick(1)">+</button>
                                </td>
                                <td>Rp.50.000</td>
                                <td class="text-center" style="padding-top: 45px"><button type="button"
                                        class="btn-close" aria-label="Close"></button></td>
                            </tr>

                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
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
@endsection

@push('scripts')
    <!-- JS Libraries -->
@endpush
