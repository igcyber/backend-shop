@extends('layouts.app')

@section('title', 'Tipe Produk')

@push('style')
    <style>
        #category-table {
            width: 100% !important
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h4>DATA TIPE PRODUK</h4>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('app.categories.import.excel') }}" method="post"
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
                                <div class="table table-responsive table-l">

                                    {{ $dataTable->table() }}

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        @include('pages.app.categories._create')
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
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
                        url: "/app/categories/" + id,
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

    <script>
        $(document).ready(function() {
            $('body').on('click', '.change-status', function() {
                var token = $("meta[name='csrf-token']").attr("content");
                let status = $(this).is(':checked');
                let id = $(this).data('id');
                // console.log(typeof(isChecked));
                jQuery.ajax({
                    url: "{{ route('app.categories.change-status') }}",
                    method: 'PUT',
                    data: {
                        status: status,
                        id: id,
                        _token: token
                    },
                    success: function(data) {
                        swal({
                            title: 'BERHASIL!',
                            text: 'STATUS BERHASIL DIPERBARUI!',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                            showCancelButton: false,
                            buttons: false,
                        }).then(function() {
                            location.reload();
                        });
                    }
                })
            })
        })
    </script>
@endpush
