<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $start = $_GET['start'];

    if (isset($_GET['cari'])) {
        $search = str_replace(" ", "%20", $_GET['cari']);
        if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "");
        } else {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
        }
    } else {
        if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php");
        } else {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
        }
    }
    $json = json_decode($file, true);
    $jml = count($json);
    $jml2 = $file2;

    ?>
    <div>
        <em><?php echo "Jumlah Data Yang Ditemukan : " . $jml2 ?></em>
    </div>
    <div class="table-responsive p-0">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="vertical-align: middle;" align="center" valign="top">#</th>
                    <th style="vertical-align: middle;"><strong>Tanggal_Lapor</strong></th>
                    <th style="vertical-align: middle;"><strong>Penelepon</strong></th>
                    <th style="vertical-align: middle;"><strong>Kontak_Penelepon</strong></th>
                    <th style="vertical-align: middle;"><strong>Keluhan</strong></th>
                    <th style="vertical-align: middle;"><strong>Instansi</strong></th>
                    <th style="vertical-align: middle;"><strong>Alamat_Instansi</strong></th>
                    <th style="vertical-align: middle;"><strong>Kontak_Instansi</strong></th>
                    <th style="vertical-align: middle;"><strong>No_PO</strong></th>
                    <th style="vertical-align: middle;"><strong>No_SJ</strong></th>
                    <th style="vertical-align: middle;"><strong>No_SPI</strong></th>
                    <th style="vertical-align: middle;"><strong>Nama_Alkes</strong></th>
                    <th style="vertical-align: middle;"><strong>Tipe</strong></th>
                    <th style="vertical-align: middle;"><strong>No_Seri</strong></th>
                    <th style="vertical-align: middle;"><strong>Garansi_Habis</strong></th>
                    <th style="vertical-align: middle;"><strong>Kategori_Kerusakan</strong></th>
                    <th style="vertical-align: middle;"><strong>Detail_Permasalahan</strong></th>
                    <th style="vertical-align: middle;"><strong>Teknisi_Yang_Menangani</strong></th>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < $jml; $i++) {
                ?>
                    <tr>
                        <td align="center"><?php echo $start += 1; ?></td>
                        <td><?php echo date("d-m-Y H:i:s A", strtotime($json[$i]['tgl_lapor'])); ?></td>
                        <td><?php echo $json[$i]['nama_penelepon']; ?></td>
                        <td><?php echo $json[$i]['kontak_penelepon']; ?></td>
                        <td><?php echo $json[$i]['keluhan']; ?></td>
                        <td><?php echo $json[$i]['nama_pembeli']; ?></td>
                        <td><?php echo $json[$i]['alamat_instansi']; ?></td>
                        <td><?php echo $json[$i]['kontak_instansi']; ?></td>
                        <td><?php echo $json[$i]['no_po']; ?></td>
                        <td><?php echo $json[$i]['no_pengiriman']; ?></td>
                        <td><?php echo $json[$i]['no_spk']; ?></td>
                        <td><?php echo $json[$i]['nama_brg']; ?></td>
                        <td><?php echo $json[$i]['tipe_brg']; ?></td>
                        <td><?php echo $json[$i]['no_seri_brg']; ?></td>
                        <td><?php
                            if ($json[$i]['tgl_garansi_habis'] != '' || $json[$i]['tgl_garansi_habis'] != '0000-00-00') {
                                echo date("d/m/Y", strtotime($json[$i]['tgl_garansi_habis']));
                            }
                            ?></td>
                        <td><?php echo $json[$i]['kategori_kerusakan']; ?></td>
                        <td><?php echo $json[$i]['detail_permasalahan']; ?></td>
                        <td><?php echo $json[$i]['nama_teknisi']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>

</html>