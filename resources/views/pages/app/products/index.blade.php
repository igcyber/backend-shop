@extends('layouts.app')

@section('title', 'Produk')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Halaman Produk</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Produk</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%">
                                                    No. Urut
                                                </th>
                                                <th scope="col">No. Produk</th>
                                                <th scope="col" style="width: 15%">Nama Produk</th>
                                                <th>Total Stok</th>
                                                <th>Detail Stok</th>
                                                <th>Tipe Produk</th>
                                                <th>Pabrikan</th>
                                                <th>Pilihan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $key => $product)
                                                <tr>
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
                                                        {{ $product->title }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $product->total_stock }} pcs
                                                    </td>
                                                    <td>
                                                        <ul style="padding: 0; list-style-type: none; line-height:18px;">
                                                            <li>{{ $product->stock_duz }} dus</li>
                                                            <li>{{ $product->stock_pak }} pak</li>
                                                            <li>{{ $product->stock_pcs }} pcs</li>
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
                                                        @can('products.edit')
                                                            <a href="{{ route('app.products.edit', $product->id) }}"
                                                                class="btn btn-success btn-sm">
                                                                <i class="fa fa-pencil-alt me-1" title="Edit Produk">
                                                                </i>
                                                            </a>
                                                        @endcan

                                                        @can('products.delete')
                                                            <button onclick="Delete(this.id)" id="{{ $product->id }}"
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
                    <div class="col-12 col-md-6 col-lg-12">
                        @include('pages.app.products._create')
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- Page Specific JS File -->
    {{-- <script>
        function showImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#img').attr('src', e.target.result).width(200).height(180);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script> --}}

    <!-- JS Libraies -->
    <script>
        $("#table-1").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [1, 2, 5]
            }]
        });
    </script>


    <!-- JS Libraies -->
    {{-- <script>
        if (jQuery().summernote) {
            $(".summernote-simple").summernote({
                dialogsInBody: true,
                minHeight: 150,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['para', ['paragraph']]
                ]
            });
        }
    </script> --}}

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
