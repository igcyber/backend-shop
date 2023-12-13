@extends('layouts.app')

@section('title', 'Pesanan')

@push('style')
@endpush

@section('main')
    <div class="main-content" style="padding-left:28px; !important">
        <section class="section">
            <div class="section-header">
                <h1>PESANAN BARU DARI OUTLET</h1>
                <a class="btn btn-lg btn-info ml-auto" href="{{ route('app.sales') }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>SEMUA PESANAN</span>
                </a>
            </div>
            <div class="section-body">
                <div class="row">
                    @if ($markedProducts->isNotEmpty())
                        @foreach ($markedProducts->groupBy('user_id') as $userOrders)
                            <div class="col-md-3 col-lg-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>
                                            <i class="fas fa-store text-muted"></i>
                                            {{ $userOrders->first()->user->name }}
                                        </h4>
                                        <div class="card-header-action">
                                            <a href="#" class="btn btn-outline-info">Proses Pesanan</a>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="summary">
                                            <div class="summary-item">
                                                <h6>Produk Pesanan </h6>
                                                <ul class="list-unstyled list-unstyled-border">
                                                    @foreach ($userOrders as $order)
                                                        <li class="media">
                                                            <div class="media-body">
                                                                <div class="media-title">
                                                                    {{ $order->detailProduct->product->title }}
                                                                </div>
                                                                <div class="text-muted text-small">
                                                                    {{ moneyFormat($order->detailProduct->sell_price_duz) }}/dus
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No orders found.</p>
                    @endif
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Create -->
    @include('pages.app.sales._modal_create')
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script>
        $("#table-1").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [1, 2, 3, 4, 5, 6, 7, 8]
            }],
            "iDisplayLength": 25,
            responsive: true,
            scrollX: true,
        });
    </script>

    <!-- Page Specific JS File -->
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
    </script> --}}
@endpush
