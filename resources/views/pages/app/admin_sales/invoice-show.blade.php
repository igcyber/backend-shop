@extends('layouts.app')

@section('title', 'Order Invoice')

@push('style')
@endpush

@section('main')
    <div id="loading-container">
        <div id="loading-spinner"></div>
    </div>
    <div class="main-content" style="padding-left:28px; !important">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="invoice">
                            {{-- @dd($order) --}}
                            <div class="invoice-print">
                                <div class="row ml-2">
                                    <img src="{{ asset('front-end/img/loogoo (3).png') }}" alt="" width="16%;">
                                    <div class="col-md-5 my-5 mx-0">
                                        <h4 class="d-inline" style="font-weight: bolder">FAKTUR PENJUALAN</h4><br>
                                        <h5 class="" style="font-weight: bold">PT. UPINDO RAYA SEMESTA BORNEO</h5>
                                        <p style="font-size: 1.2em">
                                            JL.MUGIREJO RT.14 NO.2A <br>
                                            (0541)282657 / 7074778 <br>
                                            082158111409
                                        </p>
                                    </div>
                                    <div class="col-md-5 mt-5" style="padding-left: 5%">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="width:200px"></th>
                                                    <th scope="col" style="width:400px"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="font-size: 0.9rem">
                                                        No. Transaksi
                                                    </td>
                                                    <td style="font-weight: bolder;font-size: 0.9rem">
                                                        : {{ $order->transaction_id }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 0.9rem">
                                                        Tanggal
                                                    </td>
                                                    <td style="font-size: 0.9rem">
                                                        : {{ $order->formatted_created_at }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 0.9rem">Kode Sales</td>
                                                    <td style="font-size: 0.9rem">: {{ $order->sales->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 0.9rem">Pelanggan</td>
                                                    <td style="font-size: 0.9rem">:
                                                        {{ $order->customer_id }}-{{ $order->outlet->name }}{{ $order->customer_phone && $order->customer_phone !== '-' ? '-' . $order->customer_phone : '' }}
                                                    </td>
                                                </tr>
                                                <tr class="align-top">
                                                    <td style="font-size: 0.9rem">Alamat</td>
                                                    <td style="font-size: 0.9rem">: {!! $order->customer_address !!}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-md">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">Kode Item</th>
                                                        <th scope="col" style="width: 40%">Nama Item</th>
                                                        <th scope="col">Jumlah Satuan</th>
                                                        <th scope="col" style="width: 10%" class="text-center">Cek</th>
                                                        <th scope="col" style="width: 10%">Harga</th>
                                                        <th scope="col" style="width: 10%">Pot</th>
                                                        <th scope="col" style="width: 10%">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->orderDetails as $orderDetail)
                                                        <tr>
                                                            <td>{{ ++$loop->index }}</td>
                                                            <td>{{ $orderDetail->productDetail->product->serial_number }}
                                                            </td>
                                                            <td>{{ $orderDetail->productDetail->product->title }}
                                                            </td>
                                                            <td>
                                                                @if ($orderDetail->qty_duz > 0 || $orderDetail->qty_pak > 0 || $orderDetail->qty_pcs > 0)
                                                                    @if ($orderDetail->qty_duz > 0)
                                                                        {{ $orderDetail->qty_duz }} Dus
                                                                    @endif
                                                                    @if ($orderDetail->qty_pak > 0)
                                                                        {{ $orderDetail->qty_pak }} Pak
                                                                    @endif
                                                                    @if ($orderDetail->qty_pcs > 0)
                                                                        {{ $orderDetail->qty_pcs }} Pcs
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" checked class="form-control">
                                                            </td>
                                                            <td>
                                                                @if ($orderDetail->qty_duz > 0 || $orderDetail->qty_pak > 0 || $orderDetail->qty_pcs > 0)
                                                                    @if ($orderDetail->qty_duz > 0)
                                                                        {{ moneyFormat($orderDetail->productDetail->sell_price_duz) }}
                                                                    @endif
                                                                    @if ($orderDetail->qty_pak > 0)
                                                                        {{ moneyFormat($orderDetail->productDetail->sell_price_pak) }}
                                                                    @endif
                                                                    @if ($orderDetail->qty_pcs > 0)
                                                                        {{ moneyFormat($orderDetail->productDetail->sell_price_pcs) }}
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <!-- Tambahkan form input diskon per-item -->
                                                                <form
                                                                    action="{{ route('app.update-discount', ['orderDetailId' => $orderDetail->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <div class="form-row">
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                class="form-control col-md-12"
                                                                                id="disc_atas" placeholder="0%"
                                                                                name="disc_atas"
                                                                                value="{{ $orderDetail->disc_atas }}">
                                                                            <button type="submit"
                                                                                onclick="alert('Konfirmasi Nilai Diskon')"
                                                                                class="btn btn-sm btn-outline-primary">
                                                                                <i class="fas fa-calculator"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </td>
                                                            <td>
                                                                @if ($orderDetail->qty_duz > 0 || $orderDetail->qty_pak > 0 || $orderDetail->qty_pcs > 0)
                                                                    @if ($orderDetail->qty_duz > 0)
                                                                        {{ moneyFormat($orderDetail->price_duz * $orderDetail->qty_duz) }}
                                                                    @endif
                                                                    @if ($orderDetail->qty_pak > 0)
                                                                        {{ moneyFormat($orderDetail->price_pak * $orderDetail->qty_pak) }}
                                                                    @endif
                                                                    @if ($orderDetail->qty_pcs > 0)
                                                                        {{ moneyFormat($orderDetail->price_pcs * $orderDetail->qty_pcs) }}
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-3">
                                                <div style="font-size: 0.9rem">KETERANGAN : </div>
                                                <p class="section-lead text-center">TIDAK MENERIMA
                                                    KOMPLAIN SETELAH FAKTUR
                                                    DITANDA
                                                    TANGANI</p>
                                            </div>
                                            <div class="col-md-4 ml-auto" style="padding-left: 9%">
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" style="width:200px"></th>
                                                            <th scope="col" style="width:200px"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="font-size: 1.1rem">
                                                                Jumlah Item
                                                            </td>
                                                            <td style="font-weight: bolder;font-size: 1.1rem">
                                                                : {{ $order->orderDetails->count() }}
                                                            </td>
                                                        </tr>
                                                        <tr class="align-top">
                                                            <td style="font-size: 1.1rem">
                                                                Potongan
                                                            </td>
                                                            <td style="font-size: 1.1rem">
                                                                : <input type="text" name="disc_bawah" placeholder="0"
                                                                    style="width: 30px;border:none;" id="disc_bawah"> %
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 1.1rem">Pajak</td>
                                                            <td style="font-size: 1.1rem">:
                                                                <input type="text" style="width: 30px;border:none;"
                                                                    readonly
                                                                    value="{{ $taxTypesString === 'PPN' ? '11' : '0' }}"> %
                                                                @if ($taxTypesString === 'PPN')
                                                                    {{ number_format($total, 0, ',', '.') }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr class="align-top">
                                                            <td style="font-size: 1.1rem">Tanggal Tempo</td>
                                                            <td class="align-top" style="font-size: 1.1rem">
                                                                : <input type="date" style="border:none;"
                                                                    id="dateInput">
                                                                {{-- <span id="formattedDate"> --}}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-4" style="padding-left: 10%">
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" style="width:200px"></th>
                                                            <th scope="col" style="width:200px"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="font-size: 1.1rem">
                                                                Subtotal
                                                            </td>
                                                            <td style="font-weight: bolder;font-size: 1.1rem">
                                                                : {{ moneyFormat($order->total) }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 1.1rem">
                                                                Total Akhir
                                                            </td>
                                                            <td style="font-size: 1.1rem">:
                                                                <span
                                                                    id="totalAmount">{{ moneyFormat($order->total) }}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 1.1rem">DP PO</td>
                                                            <td style="font-size: 1.1rem">: 0</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 1.1rem">Tunai</td>
                                                            <td style="font-size: 1.1rem">: 0</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 1.1rem">Kredit</td>
                                                            <td style="font-weight: bolder;font-size: 1.1rem">:
                                                                <span
                                                                    id="kreditAmount">{{ moneyFormat($order->total) }}</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="text-md-right">
                                <a href="{{ route('app.admin') }}" class="btn btn-outline-primary btn-lg">
                                    <i class="fas fa-arrow-left"></i> KEMBALI
                                </a>
                                <div class="float-lg-left mb-lg-0 mb-3">

                                </div>
                                <button class="btn btn-outline-warning btn-lg"><i class="fas fa-print"></i>
                                    PRINT</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    {{-- <script>
        function showConfirmation(orderId) {
            // console.log(orderId);
            swal({
                title: "DISKON KONFIRMASI",
                text: "PASTIKAN NILAI DISKON SUDAH BENAR, DATA TIDAK BISA DIRUBAH",
                icon: "warning",
                buttons: [
                    'TIDAK',
                    'YA'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    // If the user clicks "Yes", submit the form
                    // document.getElementById('discountForm' + orderId).submit();
                    // If the user clicks "Yes", send an Ajax request
                    var form = document.getElementById('discountForm' + orderId);
                    var formData = new FormData(form);

                    // Validate and convert disc_atas to a numeric value
                    var discAtasValue = parseFloat(formData.get('disc_atas[' + orderId + ']'));
                    if (isNaN(discAtasValue)) {
                        console.error('Invalid disc_atas value');
                        return;
                    }

                    // Set the numeric disc_atas value back to the FormData object
                    formData.set('disc_atas[' + orderId + ']', discAtasValue);

                    // Add CSRF token to the formData
                    formData.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        url: form.action,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            // Handle success, if needed
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            // Handle error, if needed
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    return true;
                }
            });
        }
    </script> --}}
    <script>
        // Add an event listener to the disc_bawah input field
        document.getElementById('disc_bawah').addEventListener('input', function() {
            // Get the entered disc_bawah value
            var discBawah = parseFloat(this.value) || 0;

            // Get the initial total amount from the server-side rendered value
            var initialTotal = parseFloat('{{ $order->total }}');

            // Calculate the discounted total
            var discountedTotal = initialTotal - (initialTotal * (discBawah / 100));

            // Convert to integer to remove the decimal part
            var totalWithoutDecimal = Math.floor(discountedTotal);

            // Format the total without decimal using the moneyFormat helper function
            var formattedTotal = formatCurrency(totalWithoutDecimal);
            console.log(formattedTotal);

            // Update the 'Total Akhir' element
            document.getElementById('totalAmount').innerText = formattedTotal;

            // Update the 'Kredit' element
            document.getElementById('kreditAmount').innerText = formattedTotal;
        });

        // Helper function to format currency
        function formatCurrency(amount) {
            return 'Rp. ' + new Intl.NumberFormat('id-ID').format(amount);
        }
    </script>
    <script>
        // Function to format the date as DD/MM/YYYY
        function formatDate(inputDate) {
            const date = new Date(inputDate);
            const day = date.getDate().toString().padStart(2, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        // Event listener for the date input change
        document.getElementById('dateInput').addEventListener('input', function() {
            const inputValue = this.value; // Get the current value of the input
            const formattedDate = formatDate(inputValue); // Format the date
            // Update the content of the span with the formatted date
            document.getElementById('formattedDate').textContent = formattedDate;
        });
    </script>
@endpush
