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

    $json2 = json_decode($file2, true);
    $jml2 = count($json2);

    ?>
    <div>
        <em><?php echo "Jumlah Data Yang Ditemukan : " . $jml2 ?></em>
    </div>
    <div class="table-responsive">
        <table width="100%" id="example1" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th align="center">#</th>
                    <th valign="top">Tgl PO</th>
                    <th valign="top">No PO</th>
                    <th valign="top">Jenis PO</th>
                    <th valign="top">
                        <table width="100%">
                            <tr>
                                <td>Nama Barang</td>
                                <td>Qty</td>
                            </tr>
                        </table>
                    </th>
                    <?php if (!isset($_SESSION['user_admin_gudang'])) { ?>

                        <th align="center" valign="top"><strong>PPN</strong></th>
                        <th align="center" valign="top"><strong>Total Price</strong> </th>
                        <th align="center" valign="top">Total Keseluruhan</th>
                        <th align="center" valign="top">Status Lunas</th>
                    <?php } ?>
                    <th align="center" valign="top">Tgl Masuk</th>
                    <th align="center" valign="top"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <?php

            // membuka file JSON
            // $file = file_get_contents("http://localhost/ALKES/json/barang_gudang1_set.php");
            // $json = json_decode($file, true);
            // $jml = count($json);
            for ($i = 0; $i < $jml; $i++) {
                //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
                //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
            ?>
                <tr>
                    <td align="center"><?php echo $i + 1; ?></td>
                    <td><?php echo date("d-m-Y", strtotime($json[$i]['tgl_po_pesan'])); ?></td>
                    <td><?php echo $json[$i]['no_po_pesan']; ?></td>
                    <td><?php echo $json[$i]['jenis_po']; ?></td>

                    <td>
                        <table width="100%" border="0">
                            <?php
                            $q = mysqli_query($koneksi, "select * from barang_pesan_set_detail,barang_gudang_set where barang_gudang_set.id=barang_pesan_set_detail.barang_gudang_set_id and barang_pesan_set_detail.barang_pesan_set_id=" . $json[$i]['idd'] . "");
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
                                    <td style="padding-left:5px"><?php echo $d1['nama_brg'] ?></td>
                                    <td style="padding-left:1px; padding-right:1px"><?php echo $d1['qty']; ?>
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
                            /*$q = mysqli_query($koneksi, "select * from barang_pesan_detail where barang_pesan_id=".$data['idd']."");
                          $n=0;
                          $total_akse2=0;
                          while ($d = mysqli_fetch_array($q)) {
                            $q_akse = mysqli_query($koneksi, "select * from aksesoris_alkes,aksesoris where aksesoris.id=aksesoris_alkes.aksesoris_id and aksesoris_alkes.barang_gudang_id=".$d['barang_gudang_id']."");
                          $no=0;
                          $total_akse=0;
                            while ($d_akse = mysqli_fetch_array($q_akse)) {
                            $total_akse = $total_akse+($d_akse['qty']*$d_akse['harga_akse'])-(($d_akse['qty']*$d_akse['harga_akse'])*$d['diskon']/100); 
                            }
                          $total_akse2 = $total_akse2 + $total_akse;
                          }
                          $total = mysqli_fetch_array(mysqli_query($koneksi, "select sum(harga_total) as total from barang_pesan_detail where barang_pesan_id=".$data['idd'].""));*/
                            echo $json[$i]['simbol'] . " " . number_format($json[$i]['total_price'], 0, ',', ',') . ".00";
                            ?></td>
                        <td><?php echo $json[$i]['simbol'] . " " . number_format($json[$i]['cost_cf'], 0, ',', ',') . ".00"; ?></td>
                        <td><?php if ($json[$i]['status_lunas'] == 0) {
                                echo "Belum";
                            } else {
                                echo "Sudah";
                            } ?></td>
                    <?php } ?>
                    <td><?php if ($json[$i]['tgl_masuk_gudang'] == 0000 - 00 - 00) {
                            echo "-";
                        } else {
                            echo date("d/m/Y", strtotime($json[$i]['tgl_masuk_gudang']));
                        } ?></td>
                    <td align="center">
                        <?php if ($json[$i]['status_po_batal'] == 0) { ?>
                            <!-- <a href="index.php?page=barang_set1&id=<?php echo $json[$i]['idd']; ?>#openLunas"> -->
                            <a href="#" onclick="simpanTgl(<?php echo $json[$i]['idd']; ?>, '<?php echo $json[$i]['tgl_masuk_gudang']; ?>')">
                                <small data-toggle="tooltip" title="Tgl Masuk Gudang" class="label bg-green">Tgl Masuk Gudang</small>
                            </a>
                            <br />
                            <?php if ($json[$i]['status_lunas'] == 1 or $json[$i]['tgl_masuk_gudang'] != '0000-00-00') { ?>
                                <a href="index.php?page=mutasi_set&id=<?php echo $json[$i]['idd']; ?>">
                                    <small data-toggle="tooltip" title="Mutasi Ke Gudang" class="label bg-yellow">Mutasi</small>
                                </a>
                            <?php } ?>
                            <?php /*if (isset($_SESSION['user_admin_keuangan']) or isset($_SESSION['user_administrator'])) { ?>
                          <a href="index.php?page=barang_gudang1&id=<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Pelunasan" class="label bg-red">Pelunasan</small></a>
                            <?php }*/ ?>
                            <!--<a href="cetak_invoice.php?id=<?php echo $data['idd']; ?>" target="_blank"><span data-toggle="tooltip" title="Cetak Invoice" class="fa fa-print"></span></a>-->
                    <?php } else {
                            echo "DIBATALKAN";
                        }
                    } ?>
                    </td>
                </tr>
        </table>
    </div>

</body>

</html>