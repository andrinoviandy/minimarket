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
        $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "&id=$_GET[id]");
        $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&id=$_GET[id]");
    } else {
        $file = file_get_contents($API . "json/$_GET[page].php?start=$start&id=$_GET[id]");
        $file2 = file_get_contents($API . "json/$_GET[page].php?id=$_GET[id]");
    }
    $json = json_decode($file, true);
    $jml = count($json);

    $jml2 = $file2;

    ?>
    <div>
        <em><?php echo "Jumlah Data Yang Ditemukan : " . $jml2 ?></em>
    </div>
    <div class="table-responsive">
        <table width="100%" id="example1" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th align="center">#</th>
                    <th><strong>Tanggal Lapor</strong></th>
                    <th><strong>Nama Penelepon</strong></th>
                    <th><strong>Kontak Penelepon</strong></th>
                    <th><strong>Keluhan</strong></th>
                    <th><strong>
                            <font>Nama Alkes</font>
                            <font class="pull-right">Jumlah Barang</font>
                        </strong></th>
                    <th align="center"><strong>Detail</strong></th>
                    <th align="center"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <?php

            // membuka file JSON
            //   if (isset($_SESSION['id_b'])) {
            //     $file = file_get_contents("http://localhost/ALKES/json/barang_rusak.php?id_gudang=$_GET[id_gudang]&id_b=$_SESSION[id_b]");
            //   } else {
            //     $file = file_get_contents("http://localhost/ALKES/json/barang_rusak.php?id_gudang=$_GET[id_gudang]");
            //   }
            //   $json = json_decode($file, true);
            //   $jml = count($json);
            for ($i = 0; $i < $jml; $i++) {
                //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
                //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
            ?>
                <tr>
                    <td align="center"><?php echo $i + 1; ?></td>
                    <td>
                        <font><?php echo date("d-m-Y H:i:s A", strtotime($json[$i]['tgl_lapor'])); ?></font>
                    </td>
                    <td><?php echo $json[$i]['nama_penelepon']; ?></td>
                    <td><?php echo $json[$i]['kontak_penelepon']; ?></td>
                    <td><?php echo $json[$i]['keluhan']; ?></td>
                    <td>
                        <table width="100%" border="0" style="line-height:30px;">
                            <?php
                            $q2 = mysqli_query($koneksi, "select * from tb_laporan_kerusakan_cs,tb_laporan_kerusakan_cs_detail,barang_gudang,pembeli where pembeli.id=tb_laporan_kerusakan_cs.pembeli_id and tb_laporan_kerusakan_cs.id=tb_laporan_kerusakan_cs_detail.tb_laporan_kerusakan_cs_id and barang_gudang.id=tb_laporan_kerusakan_cs_detail.barang_gudang_id and tb_laporan_kerusakan_cs.id=" . $json[$i]['idd'] . " and pembeli.id=$_GET[id]");
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
                                    <td align="left" style="padding-left:10px"><?php echo $n . ". " . $d1['nama_brg'] ?></td>
                                    <td align=""></td>
                                    <td align="right" style="padding-right:10px"><?php
                                                                                    $jm_brg = mysqli_num_rows(mysqli_query($koneksi, "select * from tb_laporan_kerusakan_cs,tb_laporan_kerusakan_detail,tb_laporan_kerusakan_cs_detail,barang_gudang,pembeli where pembeli.id=tb_laporan_kerusakan_cs.pembeli_id and tb_laporan_kerusakan_cs.id=tb_laporan_kerusakan_cs_detail.tb_laporan_kerusakan_cs_id and barang_gudang.id=tb_laporan_kerusakan_cs_detail.barang_gudang_id and tb_laporan_kerusakan_cs_detail.id=tb_laporan_kerusakan_detail.tb_laporan_kerusakan_cs_detail_id and tb_laporan_kerusakan_cs.id=" . $json[$i]['idd'] . " and barang_gudang.id=" . $d1['barang_gudang_id'] . " and pembeli.id=" . $_GET['id'] . ""));
                                                                                    echo "<font size='+1'>" . $jm_brg . "</font>"; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                    <td align="center">
                        <button class="btn btn-sm btn-primary" onclick="showDetail();">
                            <span class="fa fa-eye"></span>
                        </button>
                    </td>
                    <td align="center">
                        <!--
                          <a href="pages/delete_laporan.php?id_hapus=<?php echo $json[$i]['idd']; ?>&id=<?php echo $_GET['id']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"><span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a> &nbsp;&nbsp;
                          
                          <a href="index.php?page=detail_laporan_kerusakan_lama&id_detail=<?php echo $json[$i]['idd']; ?>&id=<?php echo $_GET['id']; ?>"><span data-toggle="tooltip" title="Detail Kerusakan" class="fa fa-caret-square-o-right"></span></a> &nbsp;&nbsp; 
                          -->
                        <?php if (isset($_SESSION['user_administrator']) or isset($_SESSION['user_admin_teknisi'])) { ?>
                            <!-- <a href="index.php?page=pilih_no_seri_teknisi&id=<?php echo $_GET['id'] ?>&id_laporan=<?php echo $json[$i]['idd']; ?>"> -->
                            <button onclick="showModal('<?php echo $json[$i]['idd']; ?>');" title="Tambah No Seri & Teknisi" class="btn btn-sm btn-success"><span class="fa fa-plus"></span> &nbsp;Pilih No Seri & Teknisi</button>
                            <!-- </a> -->
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>