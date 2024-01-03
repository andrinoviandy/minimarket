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
                    <th valign="top">Tgl Jual</th>
                    <th valign="top">No PO</th>


                    <th valign="top"><strong>Nama Aksesoris</strong><span class="pull pull-right">Qty</span></th>
                    <th align="center" valign="top">Sisa Belum Dikirim</th>

                    <th align="center" valign="top"><strong>Dinas/RS/Puskemas/Klinik</strong></th>
                    <th align="center" valign="top"><strong>Kontak RS/Dinas/Dll</strong></th>
                    <th align="center" valign="top">Diskon</th>
                    <th align="center" valign="top">PPN</th>
                    <th align="center" valign="top">Marketing</th>
                    <th align="center" valign="top">Subdis</th>

                    <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator']) or isset($_SESSION['user_admin_gudang']) && isset($_SESSION['pass_admin_gudang'])) { ?>
                        <th align="center" valign="top"><strong>Aksi</strong></th>
                    <?php } ?>
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
                    <td align="center"><?php
                                        $start += 1;
                                        ?></td>
                    <td><?php echo date("d-m-Y", strtotime($json[$i]['tgl_jual_akse'])); ?></td>
                    <td><?php echo $json[$i]['no_po_jual_akse']; ?></td>

                    <td>
                        <table width="100%" border="0">
                            <?php
                            $q2 = mysqli_query($koneksi, "select *,aksesoris_jual_qty.id as id_qty from aksesoris_jual_qty,aksesoris where aksesoris.id=aksesoris_jual_qty.aksesoris_id and aksesoris_jual_qty.aksesoris_jual_id=" . $json[$i]['idd'] . "");
                            $n = 0;
                            while ($d1 = mysqli_fetch_array($q2)) {
                                $n++;
                                if ($n % 2 == 0) {
                                    $col = "#CCCCCC";
                                } else {
                                    $col = "#999999";
                                }
                            ?>
                                <tr bgcolor="<?php echo $col; ?>">
                                    <td style="padding-left:2px" align="left"><?php echo $d1['nama_akse'] ?></td>
                                    <td style="padding-right:2px" align="right"><?php echo $d1['qty_jual_akse']; ?>
                                        <?php
                                        $q4 = mysqli_num_rows(mysqli_query($koneksi, "select * from aksesoris_kirim_detail where aksesoris_jual_qty_id=" . $d1['id_qty'] . ""));
                                        if ($q4 != 0) {
                                        ?>
                                            &nbsp;&nbsp;<span class="fa fa-plane"></span>&nbsp;
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                    <td align="">
                        <table width="100%" border="0">
                            <?php
                            $q2 = mysqli_query($koneksi, "select *,aksesoris_jual_qty.id as id_det_jual from aksesoris_jual_qty,aksesoris where aksesoris.id=aksesoris_jual_qty.aksesoris_id and aksesoris_jual_qty.aksesoris_jual_id=" . $json[$i]['idd'] . "");
                            $n = 0;
                            while ($d1 = mysqli_fetch_array($q2)) {
                                $n++;
                                if ($n % 2 == 0) {
                                    $col = "#CCCCCC";
                                } else {
                                    $col = "#999999";
                                }
                            ?>
                                <tr bgcolor="<?php echo $col; ?>">
                                    <td style="padding-left:2px" align="left"><?php echo $d1['nama_akse'] ?></td>
                                    <td style="padding-right:2px" align="right"><?php
                                                                                $q4 = mysqli_num_rows(mysqli_query($koneksi, "select * from aksesoris_kirim_detail where aksesoris_jual_qty_id=" . $d1['id_det_jual'] . ""));
                                                                                echo $d1['qty_jual_akse'] - $q4;
                                                                                if ($d1['qty_jual_akse'] - $q4 == 0) {
                                                                                    echo "<span class='fa fa-check'></span>";
                                                                                }
                                                                                ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>

                    <td align=""><?php echo $json[$i]['nama_pembeli']; ?></td>
                    <td align="" style="background-color:<?php echo $color; ?>"><?php echo $json[$i]['kontak_rs']; ?></td>
                    <td align="" style="background-color:<?php echo $color; ?>"><?php echo $json[$i]['diskon_akse']; ?></td>
                    <td align="" style="background-color:<?php echo $color; ?>"><?php echo $json[$i]['ppn_akse']; ?></td>
                    <td align="" style="background-color:<?php echo $color; ?>"><?php echo $json[$i]['marketing_akse']; ?></td>
                    <td align="" style="background-color:<?php echo $color; ?>"><?php echo $json[$i]['subdis_akse']; ?></td>

                    <td align="">
                        <input type="hidden" name="id" value="<?php echo $json[$i]['idd']; ?>" />
                        <!-- <a href="#" data-toggle="modal" data-target="#modal-kirim<?php echo $json[$i]['idd']; ?>"> -->
                        <a href="#" onclick="modalKirim(<?php echo $json[$i]['idd']; ?>, '<?php echo $json[$i]['no_po_jual_akse']; ?>')">
                            <small data-toggle="tooltip" title="Kirim Aksesoris" class="label bg-blue">Kirim</small>
                        </a>
                        <br>
                        <a href="index.php?page=detail_penjualan_aksesoris&id=<?php echo $json[$i]['idd']; ?>">
                            <small data-toggle="tooltip" title="Detail Kirim" class="label bg-yellow">Lihat</small>
                        </a>
                    </td>

                </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>