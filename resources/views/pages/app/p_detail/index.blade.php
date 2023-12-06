@extends('layouts.app')

@section('title', 'Detail Produk')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Detail Produk</h4>
                                <a href="{{ route('app.detail-products.create') }}" class="btn btn-primary ml-auto">
                                    <i class="fas fa-plus"></i> Tambah Detail Produk
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%" class="align-middle">
                                                    No. Urut
                                                </th>
                                                <th scope="col" style="width: 25%">Nama Produk</th>
                                                <th scope="col" style="width: 5%">Total Stok</th>
                                                <th scope="col" style="width: 7%">Detail Stok</th>
                                                <th scope="col" style="width: 5%">Diskon</th>
                                                <th scope="col" style="width: 8%">Harga Jual</th>
                                                <th scope="col" style="width: 5%">Jenis Pajak</th>
                                                <th scope="col" style="width: 5%">Periode</th>
                                                <th scope="col" style="width: 10%">Tanggal Kadaluarsa</th>
                                                <th scope="col" style="width: 5%">Pilihan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($detailProducts as $key => $detail)
                                                <tr>
                                                    @php
                                                        $min_stok = $detail->product->dus_pak * $detail->product->pak_pcs;
                                                    @endphp
                                                    <td class="text-center align-middle" style="padding: 0px 0px;">
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td class="align-middle" style="padding: 0px 0px;">
                                                        @can('products.edit')
                                                            <a href="{{ route('app.detail-products.edit', $detail->id) }}"
                                                                style="text-decoration: none; color:#2f2222">
                                                                {{ $detail->product->title }}
                                                            </a>
                                                        @endcan
                                                    </td>
                                                    <td class="align-middle">
                                                        <span
                                                            class="badge badge-{{ $detail->product->total_stock < $min_stok ? 'danger' : 'success' }}">
                                                            {{ $detail->product->total_stock }}
                                                            {{ $detail->product->withoutPcs == 0 ? 'pcs' : 'pak' }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <ul style="padding: 0; list-style-type: none; line-height:18px;">
                                                            @if ($detail->product->stock_duz > 0)
                                                                <li>{{ $detail->product->stock_duz }} dus</li>
                                                            @endif
                                                            @if ($detail->product->stock_pak > 0)
                                                                <li>{{ $detail->product->stock_pak }} pak</li>
                                                            @endif
                                                            @if ($detail->product->stock_pcs > 0)
                                                                <li>{{ $detail->product->stock_pcs }} pcs</li>
                                                            @endif
                                                        </ul>
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ number_format($detail->discount, 0) }}%
                                                    </td>
                                                    <td style="padding: 0px 0px;">
                                                        <ul
                                                            style="padding: 0; list-style-type: none; line-height: 19px;margin-top:5%;">
                                                            <li>{{ moneyFormat($detail->sell_price_duz) }}/dus</li>
                                                            @if ($detail->sell_price_duz !== $detail->sell_price_pak)
                                                                <li>{{ moneyFormat($detail->sell_price_pak) }}/pak</li>
                                                            @endif
                                                            @if ($detail->sell_price_pcs != 0)
                                                                <li>{{ moneyFormat($detail->sell_price_pcs) }}/pcs</li>
                                                            @endif
                                                        </ul>
                                                    </td>
                                                    <td class="align-middle" style="padding: 0px 0px;">
                                                        {{ $detail->tax_type }}
                                                    </td>
                                                    <td class="align-middle" style="padding: 0px 0px;">
                                                        {{ $detail->periode }}
                                                    </td>
                                                    <td class="align-middle" style="padding: 0px 0px;">
                                                        {{ dateID($detail->product->exp_date) }}
                                                    </td>
                                                    <td class="align-middle text-center" style="padding: 0px 0px;">
                                                        {{-- @can('products.edit')
                                                            <a href="{{ route('app.detail-products.edit', $detail->id) }}"
                                                                class="btn btn-success btn-sm">
                                                                <i class="fa fa-pencil-alt me-1" title="Edit Produk">
                                                                </i>
                                                            </a>
                                                        @endcan --}}
                                                        @can('products.delete')
                                                            <button onclick="Delete(this.id)" id="{{ $detail->id }}"
                                                                class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                                                    title="Hapus Produk"></i>
                                                            </button>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script>
        $("#table-1").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [1, 2, 5]
            }],
            "iDisplayLength": 25
        });
    </script>

    <!-- Page Specific JS File -->
    <script>
        function Delete(id) {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");

            swal({
                title: "APAKAH KAMU YAKIN ?",
                text: "INGIN MENGHAPUS DATA INI!",
                icon: "warning",
                buttons: [
                    'TIDAK',
                    'YA'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    //ajax delete
                    jQuery.ajax({
                        url: "/app/users/" + id,
                        data: {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function(response) {
                            if (response.status == "success") {
                                swal({
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIHAPUS!',
                                    icon: 'success',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                swal({
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIHAPUS!',
                                    icon: 'error',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }
                        }
                    });

                } else {
                    return true;
                }
            })
        }
    </script>
@endpush
