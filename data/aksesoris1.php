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
                    <th valign="top">Tgl PO</th>
                    <th valign="top">No PO</th>
                    <th valign="top">Jenis PO</th>
                    <th valign="top">Nama Principle</th>
                    <th valign="top">
                        <table width="100%">
                            <tr>
                                <td>Nama Aksesoris</td>
                                <td>Tipe Aksesoris</td>
                                <td>Qty</td>
                            </tr>
                        </table>
                    </th>
                    <?php if (!isset($_SESSION['user_admin_gudang'])) { ?>

                        <th align="center" valign="top"><strong>PPN</strong></th>
                        <th align="center" valign="top"><strong>Total Price</strong> </th>
                        <th align="center" valign="top">Total Keseluruhan</th>
                    <?php } ?>
                    <th align="center" valign="top">Estimasi Pengiriman</th>
                    <th align="center" valign="top">Tgl Masuk</th>
                    <th align="center" valign="top"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <?php

            // membuka file JSON
            // if (isset($_GET['pilihan']) and isset($_GET['kunci'])) {
            //     $file = file_get_contents("http://localhost/ALKES/json/$_GET[page].php?paging=$_GET[paging]&pilihan=$_GET[pilihan]&kunci=" . str_replace(" ", "%20", $_GET['kunci']) . "");
            // } elseif (isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
            //     $file = file_get_contents("http://localhost/ALKES/json/$_GET[page].php?paging=$_GET[paging]&tgl_awal=" . $_GET['tgl1'] . "&tgl_akhir=" . $_GET['tgl2'] . "");
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
                    <td align="center"><?php echo $start += 1 ?></td>
                    <td><?php echo date("d-m-Y", strtotime($json[$i]['tgl_po_pesan'])); ?></td>
                    <td><?php echo $json[$i]['no_po_pesan']; ?></td>
                    <td><?php echo $json[$i]['jenis_po']; ?></td>
                    <td><?php echo $json[$i]['nama_principle']; ?></td>

                    <td>
                        <table width="100%" border="0">
                            <?php
                            $q = mysqli_query($koneksi, "select * from barang_pesan_akse_detail,aksesoris where aksesoris.id=barang_pesan_akse_detail.aksesoris_id and barang_pesan_akse_detail.barang_pesan_akse_id=" . $json[$i]['idd'] . "");
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
                                    <td style="padding-left:5px"><?php echo $d1['nama_akse'] ?>&nbsp;&nbsp;</td>
                                    <td style="padding-left:5px"><?php echo $d1['tipe_akse'] ?>&nbsp;&nbsp;</td>
                                    <td style="padding-left:1px; padding-right:1px" align="right"><?php echo $d1['qty']; ?>
                                        <?php if ($d1['status_ke_stok'] == 1) { ?>
                                            <span class="fa fa-share"></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                    <?php if (!isset($_SESSION['user_admin_gudang'])) { ?>

                        <td><?php echo $json[$i]['ppn'] . "%"; ?></td>
                        <td><?php
                            echo $json[$i]['simbol'] . " " . number_format($json[$i]['total_price'], 0, ',', ',') . ".00";
                            ?></td>
                        <td><?php echo $json[$i]['simbol'] . " " . number_format($json[$i]['cost_cf'], 0, ',', ',') . ".00"; ?></td>
                    <?php } ?>
                    <td>
                        <?php if ($json[$i]['estimasi_pengiriman'] == 0000 - 00 - 00) {
                            echo "-";
                        } else {
                            echo date("d/m/Y", strtotime($json[$i]['estimasi_pengiriman']));
                        } ?>
                    </td>
                    <td><?php if ($json[$i]['tgl_masuk_gudang'] == 0000 - 00 - 00) {
                            echo "-";
                        } else {
                            echo date("d/m/Y", strtotime($json[$i]['tgl_masuk_gudang']));
                        } ?></td>
                    <td align="center">
                        <?php if (isset($_SESSION['user_administrator']) or isset($_SESSION['user_admin_gudang'])) { ?>
                            <!-- <a href="index.php?page=aksesoris1&id=<?php //echo $json[$i]['idd']; ?>#openLunas"> -->
                            <a href="#" onclick="masukGudang(<?php echo $json[$i]['idd'] ?>, '<?php echo $json[$i]['tgl_masuk_gudang'] ?>')">
                                <small data-toggle="tooltip" title="Tgl Masuk Gudang" class="label bg-green">Tgl Masuk Gudang</small>
                            </a>
                            <br />
                            <?php if ($json[$i]['status_lunas'] == 1 or $json[$i]['tgl_masuk_gudang'] != '0000-00-00') { ?>
                                <a href="index.php?page=mutasi_akse&id=<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Mutasi" class="label bg-yellow">Mutasi</small></a><br /><?php }
                                                                                                                                                                                            } ?>
                        <a href="index.php?page=ubah_pembelian_akse&id=<?php echo $json[$i]['idd']; ?>">
                            <button class="btn btn-xs btn-info">
                                <span data-toggle="tooltip" title="Detail" class="fa fa-caret-square-o-right"></span>
                            </button>
                        </a>
                        <?php /*if (isset($_SESSION['user_admin_keuangan']) or isset($_SESSION['user_administrator'])) { ?>
                <a href="index.php?page=barang_gudang1&id=<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Pelunasan" class="label bg-red">Pelunasan</small></a>
                  <?php }*/ ?>
                        <!--<a href="cetak_invoice.php?id=<?php echo $data['idd']; ?>" target="_blank"><span data-toggle="tooltip" title="Cetak Invoice" class="fa fa-print"></span></a>-->
                    <?php } ?>
                    </td>
                </tr>
        </table>
    </div>

</body>

</html>