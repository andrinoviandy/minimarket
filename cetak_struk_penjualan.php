<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Struk Penjualan</title>
    <style>
        @media print {
            @page {
                size: 80mm;
                margin: 0;
            }

            body {
                width: 80mm;
                margin: 0;
                padding: 5mm;
                font-family: Arial, sans-serif;
                font-size: 11px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                padding: 3px 0;
            }

            .no-break {
                page-break-inside: avoid;
                break-inside: avoid;
            }
        }

        body {
            width: 80mm;
            margin: 0 auto;
            padding: 5mm;
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
        }

        th,
        td {
            text-align: left;
            padding: 3px 0;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .center {
            text-align: center;
        }

        .no-print {
            display: none;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="center">
        <strong>STRUK PENJUALAN</strong><br>
        <small>SMK Negeri 1 Mempawah Hilir</small><br>
        <small><?php echo $_GET['trx']; ?></small><br>
        <hr>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th align="center">Qty</th>
                <th style="text-align: right;">Harga</th>
            </tr>
        </thead>
        <tbody>
            <!-- Repeat baris item di bawah ini sesuai kebutuhan -->
            <!-- BEGIN: Repeat -->
            <?php
            require("config/koneksi.php");
            $query = mysqli_query($koneksi, "select b.nama_produk, a.qty_jual, a.harga_jual_saat_itu as harga_satuan from penjualan_qty a left join produk b on b.id = a.produk_id where a.penjualan_id = " . $_GET['id'] . " order by a.id asc");
            while ($data = mysqli_fetch_array($query)) {
            ?>
                <tr class="no-break">
                    <td><?php echo $data['nama_produk']; ?></td>
                    <td align="center"><?php echo $data['qty_jual']; ?></td>
                    <td style="text-align: right;"><?php echo number_format($data['harga_satuan'],0,',','.') ?></td>
                </tr>
            <?php } ?>
            <!-- Ulangi blok <tr> ini sesuai jumlah barang -->
            <!-- END: Repeat -->
        </tbody>
    </table>

    <hr>

    <div style="text-align: right;">
        <strong>Total : Rp130.000</strong>
    </div>

    <div class="center">
        <p>Terima kasih!</p>
    </div>
    <script type="text/javascript">
        function PrintPage() {
            window.print();
        }
        window.addEventListener('DOMContentLoaded', (event) => {
            PrintPage()
            setTimeout(function() {
                window.close()
            }, 750)
        });
    </script>
</body>

</html>