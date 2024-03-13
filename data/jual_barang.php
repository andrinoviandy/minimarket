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
                    <th align="center">No</th>
                    <th align="center"><strong>Tanggal Jual</strong></th>
                    <th align="center">No PO</th>
                    <th align="center">Barang</th>
                    <th align="center">Sisa Kirim</th>
                    <th align="center"><strong>Dinas/RS/Puskemas/Klinik</strong></th>
                    <th align="center">Marketing</th>
                    <th align="center">SubDis</th>
                    <th align="center"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <?php
            for ($i = 0; $i < $jml; $i++) {
                //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
                //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
            ?>
                <tr>
                    <td align="center"><?php echo $start += 1 ?></td>
                    <td>
                        <?php if ($json[$i]['tgl_jual'] != '0000-00-00') {
                            echo date("d/M/Y", strtotime($json[$i]['tgl_jual']));
                        }
                        ?>
                    </td>
                    <td><?php echo $json[$i]['no_po_jual'];
                        ?></td>
                    <td>
                        <?php /* if ($_GET['tampil'] == 1) { ?>
                            <?php
                            $q23 = mysqli_query($koneksi, "select ,barang_dijual_qty.id as id_det_jual from barang_dijual_qty,barang_dijual,barang_gudang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual_qty.barang_dijual_id=" . $json[$i]['idd'] . "");
                            $n2 = 0;
                            while ($d1 = mysqli_fetch_array($q23)) {
                                $n2++;
                            ?>
                                <?php if ($d1['status_kembali_ke_gudang'] == 1) { ?>
                                    <font class="pull pull-right" size="1px" color="#FF0000">(Kembali Ke Gudang)</font>
                                <?php } ?>
                                <?php echo $n2 . ".[" . $d1['nama_brg'] . "]-[" . $d1['tipe_brg'] . "]-[" . $d1['qty_jual'] . "]"; ?>
                                <hr style="margin:0px; border-top:1px double; width:100%" />
                            <?php } ?>
                        <?php } else { */ ?>
                            <a href="javascript:void()" onclick="modalDetailBarang('<?php echo $json[$i]['idd']; ?>'); return false;"><small data-toggle="tooltip" title="Detail Barang" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a>
                        <?php //} ?>
                    </td>
                    <td>
                        <?php /* if ($_GET['tampil'] == 1) { ?>
                            <?php
                            $q24 = mysqli_query($koneksi, "select status_kembali_ke_gudang, qty_jual, nama_brg,barang_dijual_qty.id as id_det_jual from barang_dijual_qty,barang_dijual,barang_gudang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual_qty.barang_dijual_id=" . $json[$i]['idd'] . "");
                            $nn2 = 0;
                            while ($d1 = mysqli_fetch_array($q24)) {
                                $nn2++;
                                $q4 = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_dikirim_detail where barang_dijual_qty_id=" . $d1['id_det_jual'] . ""));
                            ?>
                                <?php if ($d1['status_kembali_ke_gudang'] == 1) { ?>
                                    <font class="pull pull-right" size="1px" color="#FF0000">(Kembali Ke Gudang)</font>
                                <?php } ?>
                                <font class="pull pull-right" size="2px">
                                    <?php
                                    if ($d1['qty_jual'] - $q4['jml'] == 0) {
                                        echo "<span class='fa fa-check'></span>";
                                    } ?>
                                </font>
                                <?php if ($d1['qty_jual'] - $q4['jml'] != 0) {
                                    echo "<div class='btn-danger'>";
                                } ?>
                                <?php echo $nn2 . ".[" . $d1['nama_brg'] . "]-["; ?>
                                <?php echo $d1['qty_jual'] - $q4['jml'] . "]"; ?>
                                <?php if ($d1['qty_jual'] - $q4['jml'] != 0) {
                                    echo "</div>";
                                } ?>
                                <hr style="margin:0px; border-top:1px double" />
                            <?php } ?>
                        <?php } else { */ ?>
                            <a href="javascript:void()" onclick="modalSisaKirim('<?php echo $json[$i]['idd']; ?>')"><small data-toggle="tooltip" title="Detail Barang" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a>
                        <?php //} ?>
                    </td>
                    <td>
                        <a href="javascript:void()" onclick="modalPembeli('<?php echo $json[$i]['pembeli_id']; ?>')" style="color:#060" title="Klik Untuk Lebih Lengkap">
                            <?php
                            $data_pem = mysqli_fetch_array(mysqli_query($koneksi, "select nama_pembeli from pembeli where id=" . $json[$i]['pembeli_id'] . ""));
                            echo $data_pem['nama_pembeli'];
                            ?>
                        </a>
                    </td>
                    <td><?php echo $json[$i]['marketing'];
                        ?></td>
                    <td><?php echo $json[$i]['subdis'];
                        ?></td>

                    <td align="center">

                        <?php
                        if (!isset($_SESSION['user_admin_keuangan'])) { ?>
                            <!--<a href="index.php?page=jual_barang&id=<?php echo $json[$i]['idd']; ?>#openKirim"><small data-toggle="tooltip" title="Kirim Alkes" class="label bg-blue">Kirim</small></a>-->
                            <!-- <a href="#" data-toggle="modal" data-target="#modal-kirim<?php echo $json[$i]['idd']; ?>"> -->
                            <?php
                            $q_cek = mysqli_query($koneksi, "select qty_jual,barang_dijual_qty.id as id_det_jual from barang_dijual_qty,barang_dijual,barang_gudang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual_qty.barang_dijual_id=" . $json[$i]['idd'] . "");
                            $jml_cek = 0;

                            while ($d1 = mysqli_fetch_array($q_cek)) {
                                $q4 = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_dikirim_detail where barang_dijual_qty_id=" . $d1['id_det_jual'] . ""));
                            ?>
                                <?php
                                if ($d1['qty_jual'] - $q4['jml'] != 0) {
                                    $jml_cek += 1;
                                }
                                ?>
                            <?php } ?>
                            <?php if ($jml_cek != 0) { ?>
                                <a href="?page=kirim_data&id=<?php echo $json[$i]['idd']; ?>">
                                    <small data-toggle="tooltip" title="Kirim Alkes" class="label bg-blue">Kirim</small>
                                </a>
                                <br />
                            <?php } ?>
                            <a href="index.php?page=detail_jual_barang&id=<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Detail Kirim" class="label bg-yellow">Detail</small></a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>