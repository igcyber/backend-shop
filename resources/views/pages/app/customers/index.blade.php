@extends('layouts.app')

@section('title', 'Outlet')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div id="loading-container">
        <div id="loading-spinner"></div>
    </div>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h4>PEMBAGIAN OUTLET</h4>
                <div class="ml-auto">
                    <a href="{{ route('app.customers.create') }}" class="btn btn-outline-primary ml-auto">
                        <i class="fas fa-plus"></i> TAMBAH OUTLET
                    </a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('app.customer.import') }}" method="POST"
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
                                <form action="{{ route('app.customers.index') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="q"
                                            placeholder="Cari Nama Outlet">
                                        <button class="btn btn-outline-primary input-group-text" onclick="resetPage()">
                                            <i class="fas fa-sync-alt me-2"></i>
                                        </button>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-m">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%">No.</th>
                                                <th scope="col" style="width: 20%;">Sales</th>
                                                <th scope="col">Outlet</th>
                                                <th scope="col">Klasifikasi</th>
                                                <th scope="col">Alamat</th>
                                                <th scope="col" style="width: 15%">Pilihan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customers as $no => $customer)
                                                <tr>
                                                    <th scope="row">
                                                        {{ ++$no + ($customers->currentPage() - 1) * $customers->perPage() }}
                                                    </th>
                                                    <td>
                                                        <select class="form-control select2"
                                                            onchange="changeSales(this, {{ $customer->id }})">
                                                            @foreach ($salesOptions as $salesOption)
                                                                <option value="{{ $salesOption->id }}"
                                                                    {{ $customer->seller->id == $salesOption->id ? 'selected' : '' }}>
                                                                    {{ $salesOption->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        {{ $customer->outlet->name }}
                                                    </td>
                                                    <td>
                                                        {{ $customer->klasifikasi }}
                                                    </td>
                                                    <td>
                                                        {!! $customer->address !!}
                                                    </td>
                                                    <td class="text-center">

                                                        <a href="{{ route('app.customers.edit', $customer->id) }}"
                                                            class="btn btn-outline-success btn-sm">
                                                            <i class="fa fa-pencil-alt me-1" title="Perbarui Outlet">
                                                            </i>
                                                        </a>
                                                        <button onclick="Delete(this.id)" id="{{ $customer->id }}"
                                                            class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"
                                                                title="Hapus Outlet"></i>
                                                        </button>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer pull-right">
                                {{ $customers->links('vendor.pagination.bootstrap-4') }}
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
        function changeSales(selectElement, customerId) {
            var newSalesId = selectElement.value;
            // Get the CSRF token from the meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Make an AJAX request to update the sales for the customer
            $.ajax({
                type: 'PUT',
                url: '/app/update-sales/' + customerId,
                data: {
                    sales_id: newSalesId,
                    _token: csrfToken
                },
                success: function(response) {
                    // Update the table cell with the new sales name
                    // $(selectElement).closest('td').html(response.newSalesName);

                    // Update the select option with the new sales name
                    $('#salesSelect option:selected').text(response.newSalesName);
                },
                error: function(error) {
                    console.error('Error updating sales:', error);
                }
            });
        }
    </script>

    <script>
        function resetPage() {
            window.location.reload();
        }
    </script>

    {{-- <script>
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
                        url: "/app/roles/" + id,
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
    </script> --}}
    <!-- Page Specific JS File -->
@endpush
