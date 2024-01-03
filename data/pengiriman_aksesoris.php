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
                    <th align="center">#</th>

                    <th bgcolor="#99FFCC">Tanggal Kirim</th>
                    <th>Nama Paket</th>
                    <th>No Pengiriman</th>
                    <th>No PO</th>
                    <th><strong>Detail Alkes</strong></th>
                    <th><strong>Tempat Tujuan</strong></th>
                    <th bgcolor="#99FFCC"><strong>Tanggal Sampai</strong></th>
                    <th align="center"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <?php

            // membuka file JSON
            // if (isset($_GET['pilihan']) and isset($_GET['kunci'])) {
            //     $file = file_get_contents("http://localhost/ALKES/json/$_GET[page].php?paging=$_GET[paging]&pilihan=$_GET[pilihan]&kunci=" . str_replace(" ", "%20", $_GET['kunci']) . "");
            // } elseif (isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
            //     $file = file_get_contents("http://localhost/ALKES/json/$_GET[page].php?paging=$_GET[paging]&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
            // } else {
            //     $file = file_get_contents("http://localhost/ALKES/json/$_GET[page].php?paging=$_GET[paging]");
            // }
            // $json = json_decode($file, true);
            // $jml = count($json);
            for ($i = 0; $i < $jml; $i++) {
                //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
                //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
            ?>
                <tr>
                    <td align="center"><?php echo $start += 1; ?></td>
                    <td bgcolor="#99FFCC"><?php echo date("d M Y", strtotime($json[$i]['tgl_kirim_akse'])); ?></td>
                    <td><?php echo $json[$i]['nama_paket_akse']; ?></td>

                    <td><?php echo $json[$i]['no_pengiriman_akse']; ?></td>
                    <td><?php echo $json[$i]['po_no_akse']; ?></td>
                    <td>
                        <table width="100%" border="0">
                            <?php
                            $q = mysqli_query($koneksi, "select *,aksesoris_kirim.id as idd from aksesoris,aksesoris_detail,aksesoris_kirim,aksesoris_kirim_detail where aksesoris.id=aksesoris_detail.aksesoris_id and aksesoris_detail.id=aksesoris_kirim_detail.aksesoris_detail_id and aksesoris_kirim.id=aksesoris_kirim_detail.aksesoris_kirim_id and aksesoris_kirim.id=" . $json[$i]['idd'] . "");
                            $n = 0;
                            while ($d1 = mysqli_fetch_array($q)) {
                                $n++;
                                if ($n % 2 == 0) {
                                    $col = "#CCCCCC";
                                } else {
                                    $col = "#999999";
                                }
                            ?>
                                <tr bgcolor="<?php echo $col; ?>">
                                    <td align="left"><?php echo $d1['nama_akse'] . "|"; ?></td>
                                    <td align="right"><?php echo $d1['no_seri_akse'] . " " . $d1['nama_set_akse']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                    <td><?php
                        $data3 = mysqli_fetch_array(mysqli_query($koneksi, "select nama_pembeli,aksesoris_kirim.id as idd from aksesoris,aksesoris_detail,aksesoris_jual,aksesoris_jual_qty,pembeli,aksesoris_kirim,aksesoris_kirim_detail where aksesoris.id=aksesoris_detail.aksesoris_id and aksesoris_detail.id=aksesoris_kirim_detail.aksesoris_detail_id and aksesoris_jual.id=aksesoris_jual_qty.aksesoris_jual_id and aksesoris_jual_qty.id=aksesoris_kirim_detail.aksesoris_jual_qty_id and pembeli.id=aksesoris_jual.pembeli_id and aksesoris_kirim.id=aksesoris_kirim_detail.aksesoris_kirim_id and aksesoris_kirim.id=" . $json[$i]['idd'] . ""));
                        echo $data3['nama_pembeli']; ?></td>

                    <?php
                    if ($json[$i]['tgl_sampai_akse'] != 0000 - 00 - 00) {
                        $bg = "#99FFCC";
                    } else {
                        $bg = "red";
                    }
                    ?>
                    <td bgcolor=<?php echo $bg; ?>>
                        <?php
                        if ($json[$i]['tgl_sampai_akse'] != 0000 - 00 - 00) {
                            echo date("d M Y", strtotime($json[$i]['tgl_sampai_akse']));
                        } else {
                            echo "-";
                        } ?>
                    </td>
                    <td align="center">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" style="z-index:000">Aksi
                                <span class="fa fa-caret-down"></span></button>
                            <ul class="dropdown-menu">
                                <?php if (!isset($_SESSION['user_cs'])) { ?>
                                    <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator']) or isset($_SESSION['user_admin_gudang'])) { ?>
                                        <li>
                                            <!-- <a href="index.php?page=kirim_barang&id_hapus=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"> -->
                                            <a href="#" onclick="hapus(<?php echo $json[$i]['idd'] ?>)">
                                                <span data-toggle="tooltip" title="Hapus" class="fa fa-trash"></span> Hapus
                                            </a>
                                        </li>
                                        <!-- <li>
                                            <a href="index.php?page=riwayat_panggilan&id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Riwayat Panggilan CS" class="fa fa-phone-square"></span> Riw. Pangg. CS</a>
                                        </li> -->
                                    <?php } ?>
                                    <li>
                                        <a href="index.php?page=ubah_pengiriman_aksesoris&id=<?php echo $json[$i]['idd']; ?>">
                                            <span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span> Ubah
                                        </a>
                                    </li>
                                    <!--<a target="blank" href="cetak_surat_perintah_instalasi.php?id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Cetak Surat Perintah Instalasi" class="glyphicon glyphicon-print"></span></a><a href="cetak_surat_perintah_instalasi.php?id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Buat Surat Perintah Instalasi" class="fa fa-file-pdf-o"></span></a>-->
                                    <li>
                                        <a href="#" onclick="sudahSampai(<?php echo $json[$i]['idd']; ?>, '<?php echo $json[$i]['tgl_sampai_akse']; ?>')">
                                            <span data-toggle="tooltip" title="Status : Sudah Sampai" class="fa fa-calendar-check-o"></span> Status : Sudah Sampai</a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="belumSampai(<?php echo $json[$i]['idd']; ?>)">
                                            <span data-toggle="tooltip" title="Status : Belum Sampai" class="fa fa-calendar-times-o"></span> Status : Belum Sampai</a>
                                    </li>
                                    <li><a href="cetak_surat_jalan_aksesoris.php?id=<?php echo $json[$i]['idd']; ?>" target="_blank"><span data-toggle="tooltip" title="Cetak Surat Jalan" class="fa fa-print"></span> Cet. Surat Jalan</a>
                                    </li>
                                <?php } ?>


                            </ul>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>