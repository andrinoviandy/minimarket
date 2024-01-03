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
    <title></title>

</head>

<body>
    <?php
    $start = $_GET['start'];
    $merk = $_GET['merk'];
    if (isset($merk)) {
        if (isset($_GET['cari'])) {
            $search = str_replace(" ", "%20", $_GET['cari']);
            // if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
            //     $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "");
            //     $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "");
            // } else {
                $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&merk=$merk");
                $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&merk=$merk");
            // }
        } else {
            // if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
            //     $file = file_get_contents($API . "json/$_GET[page].php?start=$start");
            //     $file2 = file_get_contents($API . "json/$_GET[page].php");
            // } else {
                $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&merk=$merk");
                $file2 = file_get_contents($API . "json/$_GET[page].php?tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&merk=$merk");
            // }
        }
    } else {
        if (isset($_GET['cari'])) {
            $search = str_replace(" ", "%20", $_GET['cari']);
            if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
                $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "");
                $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "");
            } else {
                $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
                $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
            }
        } else {
            if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
                $file = file_get_contents($API . "json/$_GET[page].php?start=$start");
                $file2 = file_get_contents($API . "json/$_GET[page].php");
            } else {
                $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
                $file2 = file_get_contents($API . "json/$_GET[page].php?tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
            }
        }
    }
    $json = json_decode($file, true);
    $jml = count($json);

    $jml2 = $file2;

    ?>
    <div>
        <em><?php echo "Jumlah Data Yang Ditemukan : " . $jml2 ?></em>
    </div>
    <div class="table-responsive">
        <table width="100%" id="" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th valign="bottom">No</th>
                    <th valign="bottom"><strong>Tgl SPI</strong></th>
                    <th valign="bottom">No SPI</th>
                    <th valign="bottom">Merk</th>
                    <th valign="bottom">Tipe</th>
                    <th valign="bottom">No Seri</th>
                    <th valign="bottom">Software Vers.</th>
                    <th valign="bottom">Tgl Garansi Habis</th>
                    <th valign="bottom">Tgl Instalasi</th>
                    <th valign="bottom">Lampiran Instalasi</th>
                    <th valign="bottom">Tgl Uji Fungsi</th>
                    <th valign="bottom">Lampiran U. Fungsi</th>
                    <th valign="bottom"><strong>Teknisi</strong></th>
                    <th valign="bottom">Kontak Teknisi</th>
                    <th valign="bottom">Keterangan</th>
                    <th valign="bottom">Nama RS/Dinas/Klinik/Dll</th>
                    <th valign="bottom">Alamat</th>
                    <th valign="bottom">Kontak</th>
                </tr>
            </thead>
            <?php

            // membuka file JSON
            // if (isset($_GET['kunci'])) {
            //     $file = file_get_contents("http://localhost/ALKES/json/$_GET[page].php?paging=$_GET[paging]&kunci=" . str_replace(" ", "%20", $_GET['kunci']) . "");
            // } elseif (isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
            //     $file = file_get_contents("http://localhost/ALKES/json/$_GET[page].php?paging=$_GET[paging]&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
            // } else {
            //     $file = file_get_contents("http://localhost/ALKES/json/$_GET[page].php?paging=$_GET[paging]");
            // }

            // $json = json_decode($file, true);
            // $jml = count($json);
            for ($i = 0; $i < $jml; $i++) {

            ?>
                <tr>
                    <td><?php
                        echo $start += 1;
                        ?></td>
                    <td><?php echo date("d/m/Y", strtotime($json[$i]['tgl_spk'])); ?></td>
                    <td><?php echo $json[$i]['no_spk']; ?></td>
                    <td><?php echo $json[$i]['merk_brg']; ?></td>
                    <td><?php echo $json[$i]['tipe_brg']; ?></td>
                    <td><?php echo $json[$i]['no_seri_brg'] . " " . $json[$i]['nama_set']; ?></td>
                    <td><?php
                        $q3 = mysqli_query($koneksi, "select *,alat_uji_detail.id as idd from alat_uji_detail where barang_teknisi_detail_id=" . $json[$i]['idd'] . "");
                        $d3 = mysqli_fetch_array($q3);
                        echo $d3['soft_version']; ?></td>
                    <td><?php
                        if ($d3['tgl_garansi_habis'] != 0000 - 00 - 00) {
                            echo date("d/m/Y", strtotime($d3['tgl_garansi_habis']));
                        } ?></td>
                    <td><?php
                        if ($d3['tgl_i'] != 0000 - 00 - 00) {
                            echo date("d/m/Y", strtotime($d3['tgl_i']));
                        } ?></td>
                    <td><?php if ($d3['lampiran_i'] != '') { ?>
                            <a href="#" data-toggle="modal" data-target="#modal-instalasi<?php echo $json[$i]['idd']; ?>"><img src="gambar_fi/instalasi/<?php echo $d3['lampiran_i']; ?>" width="50px" /></a>
                        <?php } ?>
                    </td>
                    <td><?php
                        if ($d3['tgl_f'] != 0000 - 00 - 00) {
                            echo date("d/m/Y", strtotime($d3['tgl_f']));
                        } ?></td>
                    <td><?php if ($d3['lampiran_f'] != '') { ?>
                            <a href="#" data-toggle="modal" data-target="#modal-ujifungsi<?php echo $json[$i]['idd']; ?>"><img src="gambar_fi/fungsi/<?php echo $d3['lampiran_f']; ?>" width="50px" /></a>
                        <?php } ?>
                    </td>
                    <td><?php
                        $q4 = mysqli_query($koneksi, "select *,barang_teknisi_detail_teknisi.id as idd from barang_teknisi_detail_teknisi,tb_teknisi where tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and barang_teknisi_detail_id=" . $json[$i]['idd'] . "");
                        $d4 = mysqli_fetch_array($q4);
                        echo $d4['nama_teknisi']; ?></td>
                    <td><?php echo $d4['no_hp']; ?></td>
                    <td><?php echo $d3['keterangan']; ?></td>
                    <td><?php echo $json[$i]['nama_pembeli']; ?></td>
                    <td><?php echo $json[$i]['jalan']; ?></td>
                    <td><?php echo $json[$i]['kontak_rs']; ?></td>
                </tr>
            <?php } ?>
            <?php if ($jml2 == 0) { ?>
                <tr>
                    <td colspan="17" align="center">Belum Ada Data</td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>