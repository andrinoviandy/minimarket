<?php
//header("Content-type: application/vnd.ms-word");

$id = $_GET['id'];
require("config/koneksi.php");
$data = mysqli_fetch_array(mysqli_query($koneksi, "select *,barang_pesan.id as idd from barang_pesan,principle,mata_uang where principle.id=barang_pesan.principle_id and mata_uang.id=barang_pesan.mata_uang_id and barang_pesan.id=$id"));
?>
<html>

<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
    <title>Cetak PO</title>
    <style>
        .mytable {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }

        .mytable tr th,
        .mytable tr td {
            border: 1px solid black;
            padding: 3px 4px;
        }
    </style>
    <link href='logo.png' rel='icon'>
</head>

<body onLoad="window.print();">
    <center>
        <font size="+2" style="font-family:Arial, Helvetica, sans-serif"><b>PESANAN BARANG</b></font>
    </center><br>
    <table width="100%">
        <tr>
            <td width="56%" rowspan="3" valign="top"><b style="font-size:17px">PT. CIPTA VARIA KHARISMA UTAMA</b><br> Jl. Utan Kayu No.105A<br>
                Jakarta 13120 - INDONESIA<br>
                Telp : +62.21.8511 303</td>

        </tr>
        <tr>
            <td width="3%" rowspan="2">&nbsp;</td>
            <td width="13%" height="21" valign="top">
                <font>Nomor</font>
            </td>
            <td width="28%" valign="top"><?php echo " :  " . $data['no_po_pesan']; ?></td>
        </tr>
        <tr>
            <td valign="top">
                <font>Tanggal</font>
            </td>
            <td width="28%" valign="top"><?php echo " :  " . date("d M Y", strtotime($data['tgl_po_pesan'])); ?></td>
        </tr>
        <tr>
            <td valign="top">&nbsp;</td>
            <td colspan="3" valign="top" style="font-size:13px">Kepada Yth,<br>
                <b><?php echo $data['nama_principle']; ?></b><br>
                <?php echo $data['alamat_principle']; ?><br>
                <?php echo "Telp. : " . $data['telp_principle']; ?><br><?php echo "Fax. : " . $data['fax_principle']; ?>
            </td>
        </tr>
    </table>
    <font style="font-size:13px">Dengan hormat,<br>
        Bersama ini kami sampaikan <em><strong>Pesanan Barang</strong></em>, sebagai berikut :</font>
    <br><br>
    <table width="100%" class="mytable" style="padding-left:15px; font-size:13px">
        <tr>
            <td width="7%" align="center"><strong>No</strong></td>
            <td width="50%" align="center"><strong>Nama Barang</strong></td>
            <td width="13%" align="center"><strong>Type/Merk</strong></td>
            <td width="16%" align="center"><strong>Jml</strong></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $q = mysqli_query($koneksi, "select * from barang_pesan_detail where barang_pesan_id=$id");
        $n = 0;
        $total_akse2 = 0;
        while ($d = mysqli_fetch_array($q)) {
            $n++;
        ?>
            <tr>
                <td align="center"><strong><?php echo $n; ?></strong></td>
                <td><strong>
                        <?php
                        $brg = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_gudang where id=" . $d['barang_gudang_id'] . ""));
                        echo $brg['nama_brg']; ?>

                    </strong></td>
                <td align="center"><strong><?php echo $brg['tipe_brg']; ?></strong></td>
                <td align="center"><strong>
                        <?php
                        // echo $d['qty']." Units"; 
                        if ($brg['satuan_header'] != '') {
                            // echo $d['qty_jual'];
                            if ($d['qty'] % $brg['jumlah_rincian_to_satuan'] == 0) {
                                $qtyy = $d['qty'] / $brg['jumlah_rincian_to_satuan'];
                                echo $qtyy . " " . $brg['satuan_header'];
                            } else {
                                echo $d['qty'] . " " . $brg['satuan'];
                            }
                        } else {
                            echo $d['qty'] . " " . $brg['satuan'];
                        }
                        ?></strong></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        <?php } ?>
    </table>
    <br>
    <table style="font-size:13px">
        <tr>
            <td colspan="4" valign="top">
                Syarat-syarat :</td>
        </tr>
        <tr>
            <td valign="top">1&nbsp;&nbsp;</td>
            <td valign="top">Harga</td>
            <td valign="top">:</td>
            <td valign="top">Frandko Gudang Kharisma, sudah termasuk PPn 10%</td>
        </tr>
        <tr>
            <td valign="top">2&nbsp;&nbsp;</td>
            <td valign="top">Pembayaran</td>
            <td valign="top">:</td>
            <td valign="top">Sesuai Perjanjian</td>
        </tr>
        <tr>
            <td valign="top">3&nbsp;&nbsp;</td>
            <td valign="top">Faktur</td>
            <td valign="top">:</td>
            <td valign="top"><strong>PT. CIPTA VARIA KHARISMA UTAMA<br>
                    Jl. Utan Kayu Raya No. 105A, Utan Kayu Utara<br>
                    Matraman - Jakarta Timur 13120</strong></td>
        </tr>
        <tr>
            <td valign="top">4&nbsp;&nbsp;</td>
            <td valign="top">NPWP</td>
            <td valign="top">:</td>
            <td valign="top">01.321.289.9.007.000</td>
        </tr>
    </table>
    <font style="font-size:13px">Demikian surat pesanan ini kami sampaikan, atas perhatian dan kerjasamanya, kami ucapkan terima kasih.<br></font><br>
    <table width="100%" style="font-size:13px">
        <tr>
            <td width="53%">
                Hormat kami<br>
                <strong>PT. Cipta Varia Kharisma Utama</strong><br>
                <img src="img/ttd.png" alt="" width="180"><br>
                <strong><u>Banter Setyaki</u></strong><br>
                D i r e c t o r<br>
                <i><strong>af/bs</strong></i><br>
                <i><strong style="font-size:14px">Node : Mohon setelah tanda tangan di Email kembali</strong></i>
            </td>
            <td width="2%">&nbsp;</td>
            <td width="45%" valign="top">Disetujui Oleh,<br>
                <strong><?php echo $data['nama_principle']; ?></strong>,<br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                -------------------------
            </td>
        </tr>
    </table>
    <br><br>
    <div style="position:absolute; font-size:13px">1. Putih : Supplier, 2. Merah : Keuangan, 3. Kuning : Administrasi I, 4. Hijau : Administrasi II, 5. Biru : Gudang</div>
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
<?php
//header("Content-Disposition: attachment;Filename=Surat Jalan-".$data['nama_pembeli']."-".$data['nama_pemakai'].".doc");
?>