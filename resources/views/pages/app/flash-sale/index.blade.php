@extends('layouts.app')

@section('title', 'Flash Sale')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-md-8 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Flash Sale</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%" class="align-middle">
                                                    No. Urut
                                                </th>
                                                <th scope="col" style="width: 20%">Nama Produk</th>
                                                <th scope="col" style="width: 2%">Diskon</th>
                                                <th scope="col" style="width: 5%" class="text-center">Status</th>
                                                <th scope="col" style="width: 10%">Pilihan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($flashSaleItems as $key => $item)
                                                <tr>
                                                    <td class="text-center align-middle">
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td class="align-middle">
                                                        <a href="{{ route('app.detail-products.edit', $item->detailProduct->id) }}"
                                                            style="color: #23160a;text-decoration: none;">
                                                            {{ $item->detailProduct->product->title }}
                                                        </a>

                                                    </td>
                                                    <td class="align-middle">
                                                        {{ number_format($item->detailProduct->discount, 0) }}%
                                                    </td>
                                                    <td>

                                                        @if ($item->status)
                                                            <label class="custom-switch mt-2">
                                                                <input type="checkbox" checked name="custom-switch-checkbox"
                                                                    data-id="{{ $item->id }}"
                                                                    class="custom-switch-input change-status">
                                                                <span class="custom-switch-indicator"></span>
                                                            </label>
                                                        @else
                                                            <label class="custom-switch mt-2">
                                                                <input type="checkbox" name="custom-switch-checkbox"
                                                                    data-id="{{ $item->id }}"
                                                                    class="custom-switch-input change-status">
                                                                <span class="custom-switch-indicator"></span>
                                                            </label>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        <button onclick="Delete(this.id)" id="{{ $item->id }}"
                                                            class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                                                title="Hapus Produk"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="card">
                            <div class="card-body p-2 mx-2">
                                <label style="font-weight: bold" class="mb-0 pb-0">TANGGAL SELESAI</label>
                                <hr>
                                <form action="{{ route('app.flash.sales.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group">
                                        <div class="col-md-12">
                                            @if ($flashSale)
                                                <input type="text" class="form-control datepicker" name="end_date"
                                                    value="{{ date('d-m-Y', strtotime($flashSale->end_date)) }}">
                                            @else
                                                <!-- Handle the case where $flashSale is null -->
                                                <input type="text" class="form-control datepicker" name="end_date">
                                            @endif
                                        </div>

                                    </div>
                                    <hr>
                                    <button type="submit" class="btn btn-primary mt-2">SUBMIT</button>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body p-2 mx-2">
                                <label style="font-weight: bold" class="mb-0 pb-0">PRODUK</label>
                                <hr>
                                <form action="{{ route('app.flash.sales.addProduct') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group">
                                        <div class="col-md-12">
                                            <select name="product_flash" class="form-control select2">
                                                <option selected disabled>PILIH PRODUK</option>
                                                @foreach ($detailProducts as $detail)
                                                    @if (!in_array($detail->id, $existingDetailIds))
                                                        <option style="line-height: 41px" value="{{ $detail->id }}">
                                                            {{ $detail->product->title }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('product_flash')
                                                <div class="invalid-feedback" style="display: block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <select name="status"
                                                class="form-control mt-2 @error('status') is-invalid @enderror">
                                                <option selected disabled>Status Flash Sales</option>
                                                <option value="1">Aktif</option>
                                                <option value="0">Tidak Aktif</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback" style="display: block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr>
                                    <button type="submit" class="btn btn-primary mt-2">SUBMIT</button>
                                </form>
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
                "targets": [1, 2, 4]
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
                                    text: 'DATA GAGAL DIPERBARUI',
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
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('app.change.status') }}",
                    method: 'PUT',
                    data: {
                        status: isChecked,
                        id: id
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            swal({
                                title: 'BERHASIL!',
                                text: 'DATA BERHASIL DIPERBARUI',
                                icon: 'success',
                                timer: 1000,
                                showConfirmButton: false,
                                showCancelButton: false,
                                buttons: false,
                            }).then(function() {
                                location.reload();
                            });
                        } else if (response.status == "error") {
                            swal({
                                title: 'GAGAL!',
                                text: 'DATA GAGAL DIPERBARUI!',
                                icon: 'error',
                                timer: 1000,
                                showConfirmButton: false,
                                showCancelButton: false,
                                buttons: false,
                            }).then(function() {
                                location.reload(true);
                            });
                        }
                    }
                })
            })
        });
    </script>
@endpush
