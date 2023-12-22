<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>PRINT ORDER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
        }

        .sheet {
            margin: 0;
            overflow: hidden;
            position: relative;
            box-sizing: border-box;
            page-break-after: always;
        }

        /** Paper sizes **/
        body.A3 .sheet {
            width: 297mm;
            height: 419mm;
        }

        body.A3.landscape .sheet {
            width: 420mm;
            height: 296mm;
        }

        body.A4 .sheet {
            width: 210mm;
            height: 296mm;
        }

        body.A4.landscape .sheet {
            width: 297mm;
            height: 209mm;
        }

        body.A5 .sheet {
            width: 148mm;
            height: 209mm;
        }

        body.A5.landscape .sheet {
            width: 210mm;
            height: 147mm;
        }

        body.continuous_form .sheet {
            width: 138mm;
            height: 218mm;
        }

        body.continuous_form.landscape .sheet {
            width: 218mm;
            height: 138mm;
        }

        /** Padding area **/
        .sheet.padding-5mm {
            padding: 5mm;
        }

        .sheet.padding-10mm {
            padding: 10mm;
        }

        .sheet.padding-15mm {
            padding: 15mm;
        }

        .sheet.padding-20mm {
            padding: 20mm;
        }

        .sheet.padding-25mm {
            padding: 25mm;
        }

        /** For screen preview **/
        @media screen {
            body {
                background: #e0e0e0;
            }

            .sheet {
                background: white;
                box-shadow: 0 0.5mm 2mm rgba(0, 0, 0, 0.3);
                margin: 5mm;
            }
        }

        /** Fix for Chrome issue #273306 **/
        @media print {
            body.A3.landscape {
                width: 420mm;
            }

            body.A3,
            body.A4.landscape {
                width: 297mm;
            }

            body.A4,
            body.A5.landscape {
                width: 210mm;
            }

            body.A5 {
                width: 148mm;
            }

            body.continuous_form {
                width: 138mm;
            }

            body.continuous_form.landscape {
                width: 218mm;
            }
        }

        @page {
            size: continuous_form;
        }

        table {
            border-collapse: collapse;
        }

        table,
        td,
        th {
            /* border: 1px solid black; */
            padding: 2px;
        }

        tr {
            height: 20px;
        }

        table {
            table-layout: fixed;
            font-size: 11px;
            font-family: monospace;
            /* font-family: monako; */
            /* font-family: arial; */
        }
    </style>
</head>
<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="continuous_form landscape">
    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-5mm">
        <!-- Write HTML just like a web page -->
        <!-- <article>This is an Continuous Form document.</article> -->
        <?php $cols = [35, 180, 200, 70, 70, 100, 110]; ?>

        <table style="table-layout: fixed;" border="0">
            <colgroup>
                <col style="<?= 'width: ' . $cols[0] . 'px' ?>">
                <col style="<?= 'width: ' . $cols[1] . 'px' ?>">
                <col style="<?= 'width: ' . $cols[2] . 'px' ?>">
                <col style="<?= 'width: ' . $cols[3] . 'px' ?>">
                <col style="<?= 'width: ' . $cols[4] . 'px' ?>">
                <col style="<?= 'width: ' . $cols[5] . 'px' ?>">
                <col style="<?= 'width: ' . $cols[6] . 'px' ?>">
            </colgroup>
            <thead>
                <tr>
                    <td>

                    </td>
                    <td style="padding-left:0px; margin-right:0px;">
                        <img src="{{ asset('front-end/img/loogoo (3).png') }}" alt="site icon" />
                    </td>
                    <td style="padding-bottom:20px;">
                        <p style="font-weight: bolder;font-size:1.1rem;margin-bottom:0px;">FAKTUR PENJUALAN</p>
                        <p style="font-weight: bold; margin-top:0px;margin-bottom:5px;">PT. UPINDO RAYA SEMESTA BORNEO
                        </p>
                        <p style="font-size: 0.9em;margin-top:0px;">
                            JL.MUGIREJO RT.14 NO.2A <br>
                            (0541)282657 / 7074778 <br>
                            082158111409 <br>
                            @if ($taxTypesString === 'PPN')
                                NPWP : 080.905.149.3-722.000
                            @endif
                        </p>
                    </td>
                    <td colspan="2" style="font-size: 0.9em;text-align:initial;padding-bottom:5%;">
                        No. Transaksi <br>
                        Tanggal <br>
                        Kode Sales <br>
                        Alamat
                    </td>
                    <td style="font-weight: bolder;font-size: 0.9em;padding-bottom:5%;padding-top:3%;" colspan="3">
                        : {{ $order->transaction_id }} <br>
                        : {{ $order->formatted_printed_at }} <br>
                        : {{ $order->sales->name }} <br>
                        : {!! $order->customer_address !!}</td>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr style="text-align: center;font-weight:bold;">
                    <td style="border: 1px solid black; text-align: left; width:2%;">No</td>
                    <td style="border: 1px solid black; text-align: left;width:10%;">Kode Item</td>
                    <td style="border: 1px solid black; text-align: left;width:32%;">Nama Item</td>
                    <td style="border: 1px solid black; text-align: center;width:7%">Jml Satuan</td>
                    <td style="border: 1px solid black; text-align: center;width:12%">Cek</td>
                    <td style="border: 1px solid black; text-align: left;">Harga</td>
                    <td style="border: 1px solid black; text-align: left;width:5%">Pot</td>
                    <td style="border: 1px solid black; text-align: left;" colspan="5">Total</td>
                </tr>
                @foreach ($order->orderDetails as $orderDetail)
                    <tr>
                        <td style="border: 1px solid black; text-align: center;">
                            {{ ++$loop->index }}
                        </td>
                        <td style="border: 1px solid black; text-align: left;">
                            {{ $orderDetail->productDetail->product->serial_number }}</td>
                        <td style="border: 1px solid black; text-align: left;">
                            {{ $orderDetail->productDetail->product->title }}</td>
                        <td style="border: 1px solid black; text-align: center;">
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
                        <td style="border: 1px solid black; text-align: center; ">
                            <input type="checkbox" style="width: 30px;  height: 15px;">
                        </td>
                        <td style="border: 1px solid black; text-align: left;">
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
                        <td style="border: 1px solid black; text-align: center;">
                            {{ number_format($orderDetail->disc_atas, 0, ',', '.') }} %
                        </td>
                        <td colspan="5" style="border: 1px solid black; text-align: left;">
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
            <tr>
                <td colspan="3">
                    <table>
                        <?php $footer = [150, 25, 200, 35, 150]; ?>
                        <colgroup>
                            <col style="<?= 'width: ' . $footer[0] . 'px' ?>">
                            <col style="<?= 'width: ' . $footer[1] . 'px' ?>">
                            <col style="<?= 'width: ' . $footer[2] . 'px' ?>">
                            <col style="<?= 'width: ' . $footer[3] . 'px' ?>">
                            <col style="<?= 'width: ' . $footer[4] . 'px' ?>">
                        </colgroup>
                        <thead>
                            <tr>
                                <p style="margin-top: 0px;margin-bottom:0px;">Keterangan :</p>
                                <p style="text-align: center;margin-bottom:0px;margin-top:0px;">TIDAK MENERIMA
                                    KOMPLAIN
                                    SETELAH FAKTUR
                                    DITANDA TANGANI</p>
                            </tr>
                            <tr>
                                <th style="padding-top: 0px;">Hormat Kami</th>
                                <td></td>
                                <td></td>
                                <th style="padding-top: 0px;">Penerima</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding-top:40px;">(......................)</td>
                                <td></td>
                                <td></td>
                                <td style="padding-top:40px;">(......................)</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <p style="font-size:0.5rem;text-align: left;" id="hasilTerbilang">Terbilang :</p>
                                </td>
                            </tr>
                            <tr></tr>
                            <tr></tr>
                        </tbody>
                    </table>
                </td>
                <td colspan="2">
                    <table>
                        <?php $footer = [150, 25, 200, 35, 150]; ?>
                        <colgroup>
                            <col style="<?= 'width: ' . $footer[0] . 'px' ?>">
                            <col style="<?= 'width: ' . $footer[1] . 'px' ?>">
                            <col style="<?= 'width: ' . $footer[2] . 'px' ?>">
                            <col style="<?= 'width: ' . $footer[3] . 'px' ?>">
                            <col style="<?= 'width: ' . $footer[4] . 'px' ?>">
                        </colgroup>
                        <thead>
                            <tr>
                                <p style="font-size:0.6rem;text-align: left;margin-bottom:10px;margin-top:0px;">Jml
                                    Item
                                    <span>: {{ $order->orderDetails->count() }}</span>
                                </p>
                                <p style="font-size:0.6rem;text-align: left;margin-bottom:10px;margin-top:0px;">Potongan
                                    <span>: {{ number_format($order->disc_bawah, 0, ',', '.') }}%</span>
                                </p>
                                <p style="font-size:0.6rem;text-align: left;margin-bottom:10px;margin-top:0px;">Pajak

                                    <span style="margin-left:16.6px;">:
                                        {{ $taxTypesString === 'PPN' ? '11' : '0' }} %
                                        @if ($taxTypesString === 'PPN')
                                            {{ number_format($total, 0, ',', '.') }}
                                        @endif
                                    </span>
                                </p>
                                <p style="font-size:0.6rem;text-align: left;margin-bottom:10px;margin-top:0px;">Tgl.
                                    JT <span style="margin-left:6px;">: {{ $order->formatted_exp_date }} <br></span>
                                </p>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            </tr>
                            <tr>
                            </tr>
                            <tr></tr>
                            <tr></tr>
                        </tbody>
                    </table>
                </td>
                <td colspan="5">
                    <table>
                        <?php $footer = [150, 25, 200, 35, 150]; ?>
                        <colgroup>
                            <col style="<?= 'width: ' . $footer[0] . 'px' ?>">
                            <col style="<?= 'width: ' . $footer[1] . 'px' ?>">
                            <col style="<?= 'width: ' . $footer[2] . 'px' ?>">
                            <col style="<?= 'width: ' . $footer[3] . 'px' ?>">
                            <col style="<?= 'width: ' . $footer[4] . 'px' ?>">
                        </colgroup>
                        <thead>
                            <tr>
                                <p style="font-size:0.6rem;text-align: left;margin-bottom:10px;margin-top:0px;">Sub
                                    Total
                                    <span style="margin-left:75.6px;">: {{ moneyFormat($order->total) }}</span>
                                </p>
                                <p style="font-size:0.6rem;text-align: left;margin-bottom:10px;margin-top:0px;">Total
                                    Akhir
                                    <span style="margin-left:64.8px;">: {{ moneyFormat($order->total) }}</span>
                                </p>
                                <p style="font-size:0.6rem;text-align: left;margin-bottom:10px;margin-top:0px;">DP PO
                                    <span style="margin-left:98.4px;">: 0</span>
                                </p>
                                <p style="font-size:0.6rem;text-align: left;margin-bottom:10px;margin-top:0px;">Tunai
                                    <span style="margin-left:98.4px;">: 0</span>
                                </p>
                                <p id="nilaiKredit"
                                    style="font-size:0.6rem;text-align: left;margin-bottom:10px;margin-top:0px;">Kredit
                                    <span style="margin-left:92.4px;">: {{ moneyFormat($order->total) }}</span>
                                </p>
                            </tr>
                        </thead>
                        <tbody>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </section>
</body>
<script>
    function terbilangRupiah(nominal) {
        const bilangan = [
            "", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan"
        ];

        const ribuan = ["", "Ribu", "Juta", "Miliar", "Triliun"];

        function terbilangSatuan(n) {
            return bilangan[n];
        }

        function terbilangPuluhan(n) {
            if (n < 10) {
                return terbilangSatuan(n);
            } else if (n >= 10 && n <= 19) {
                const belasan = ["Sepuluh", "Sebelas", "Dua Belas", "Tiga Belas", "Empat Belas", "Lima Belas",
                    "Enam Belas", "Tujuh Belas", "Delapan Belas", "Sembilan Belas"
                ];
                return belasan[n - 10];
            } else {
                const puluhan = Math.floor(n / 10);
                const satuan = n % 10;
                return bilangan[puluhan] + " Puluh " + terbilangSatuan(satuan);
            }
        }

        function terbilangRatusan(n) {
            const ratusan = Math.floor(n / 100);
            const sisasatuan = n % 100;
            if (ratusan === 1) {
                return "Seratus " + terbilangPuluhan(sisasatuan);
            } else if (ratusan > 1) {
                return bilangan[ratusan] + " Ratus " + terbilangPuluhan(sisasatuan);
            } else {
                return terbilangPuluhan(sisasatuan);
            }
        }

        function terbilangRibuan(n) {
            const ribuan = Math.floor(n / 1000);
            const sisaratusan = n % 1000;
            if (ribuan > 1) {
                return terbilangRatusan(ribuan) + " Ribu " + terbilangRatusan(sisaratusan);
            } else {
                return terbilangRatusan(sisaratusan);
            }
        }

        const nominalStr = String(nominal).replace(/[^\d]/g, "");
        const panjang = nominalStr.length;

        if (nominal <= 0 || panjang > 15) {
            return "Input tidak valid";
        }

        let terbilang = "";
        let angka = nominal;

        for (let i = 0; i < ribuan.length && angka > 0; i++) {
            const segment = angka % 1000;
            if (segment > 0) {
                terbilang = terbilangRibuan(segment) + " " + ribuan[i] + " " + terbilang;
            }
            angka = Math.floor(angka / 1000);
        }

        return terbilang.trim() + " Rupiah";
    }

    // Mendapatkan elemen berdasarkan ID
    const elemenKredit = document.getElementById("nilaiKredit");
    const elemenHasilTerbilang = document.getElementById("hasilTerbilang");

    // Mendapatkan teks dari elemen
    const teksElemen = elemenKredit.innerText;

    // Menggunakan ekspresi reguler untuk mengekstrak nilai uang
    const nilaiUangMatch = teksElemen.match(/Rp\. (\d+(\.\d{3})*)/);

    // Menampilkan nilai uang
    const nilaiUang = nilaiUangMatch ? parseFloat(nilaiUangMatch[1].replace(/\./g, '').replace(',', '.')) : null;
    // console.log("Nilai Uang:", nilaiUang);

    // Menggunakan fungsi terbilangRupiah
    const terbilangNilai = terbilangRupiah(nilaiUang);
    // console.log("Terbilang:", terbilangNilai);

    // Menampilkan hasil terbilang pada elemen HTML
    elemenHasilTerbilang.innerText = "Terbilang : " + "# " + terbilangNilai + " #";
</script>

</html>
