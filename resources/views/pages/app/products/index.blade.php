@extends('layouts.app')

@section('title', 'Produk')

@section('main')
    <div class="main-content" style="padding-left:14px; !important">
        <section class="section">
            <div class="section-header">
                <h4>DATA PRODUK</h4>
                <div class="ml-auto">
                    <a href="{{ route('app.products.create') }}" class="btn btn-outline-primary ml-auto">
                        <i class="fas fa-plus"></i> TAMBAH PRODUK
                    </a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('app.products.import.excel') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row mb-3">
                                        <label for="img" style="font-weight: bold">Pilih File Excel</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="far fa-file-excel"></i>
                                                </div>
                                            </div>
                                            <input type="file" name="excel_file" id="excel_file"
                                                class="form-control col-md-2 @error('excel_file') @enderror">
                                            <button type="submit" class="btn btn-outline-info">IMPORT DATA</button>
                                        </div>
                                        @error('excel_file')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </form>
                                <hr>
                                <div class="table table-striped">
                                    <table class="display" id="table-1" style="width: 100% !important">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%">
                                                    No.
                                                </th>
                                                <th scope="col">Kode</th>
                                                <th scope="col" style="width: 25%">Nama</th>
                                                <th>Total</th>
                                                <th scope="col" style="width: 8%">Stok</th>
                                                <th>Tipe</th>
                                                <th scope="col" style="width: 13%">Pabrikan</th>
                                                <th>Pilihan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $key => $product)
                                                <tr>
                                                    @php
                                                        //hitung minimal produk kuantitas berdasarkan satuan terkecil
                                                        $min_stok = $product->dus_pak * $product->pak_pcs;
                                                    @endphp
                                                    <td class="text-center align-middle">
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td class="align-middle">
                                                        <!-- Display SVG barcode for the current product -->
                                                        @if (isset($svgBarcodes[$key]))
                                                            <p style="margin:0; !important">
                                                                {!! $svgBarcodes[$key]['svg_barcode'] !!}
                                                            </p>
                                                            <span
                                                                style="font-weight: bolder">{{ $svgBarcodes[$key]['serial_number'] }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle">
                                                        @can('products.edit')
                                                            <a href="{{ route('app.products.edit', $product->id) }}"
                                                                style="text-decoration: none;color:rgb(80, 84, 87);">
                                                                <i class="far fa-edit" title="Perbarui Data"></i>
                                                                {{ $product->title }}
                                                            </a>
                                                        @endcan

                                                    </td>
                                                    <td class="align-middle">
                                                        <span
                                                            class="badge badge-{{ $product->total_stock < $min_stok ? 'danger' : 'success' }}">
                                                            {{ $product->total_stock }}
                                                            {{ $product->withoutPcs == 0 ? 'pcs' : 'pak' }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <ul style="padding: 0; list-style-type: none; line-height:18px;">
                                                            @if ($product->stock_duz > 0)
                                                                <li>{{ $product->stock_duz }} dus</li>
                                                            @endif
                                                            @if ($product->stock_pak > 0)
                                                                <li>{{ $product->stock_pak }} pak</li>
                                                            @endif
                                                            @if ($product->stock_pcs > 0)
                                                                <li>{{ $product->stock_pcs }} pcs</li>
                                                            @endif
                                                        </ul>
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $product->category->name }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $product->vendor->name }}
                                                    </td>
                                                    {{-- <td></td> --}}
                                                    <td class="align-middle">
                                                        @can('products.delete')
                                                            <button onclick="Delete(this.id)" id="{{ $product->id }}"
                                                                class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"
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
                "sortable": true,
                "targets": [1, 2, 3, 4, 5, 6, 7]
            }],
            "iDisplayLength": 25,
            responsive: true,
            scrollX: true,
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
