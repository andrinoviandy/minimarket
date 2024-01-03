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
        $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "&id_gudang=$_GET[id_gudang]");
        $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&id_gudang=$_GET[id_gudang]");
    } else {
        $file = file_get_contents($API . "json/$_GET[page].php?start=$start&id_gudang=$_GET[id_gudang]");
        $file2 = file_get_contents($API . "json/$_GET[page].php?id_gudang=$_GET[id_gudang]");
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
                    <th>No</th>
                    <th valign="bottom">Tgl Input</th>
                    <th valign="bottom"><strong>Tgl Masuk Gudang</strong></th>
                    <th valign="bottom">No Seri</th>
                    <th valign="bottom">Kerusakan</th>
                    <th valign="bottom">Status Barang</th>
                    <?php if (isset($_SESSION['user_admin_teknisi']) or isset($_SESSION['user_administrator'])) { ?>
                        <th valign="bottom">Teknisi</th>
                    <?php } ?>
                    <th valign="bottom">Aksi</th>
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
                    <td><?php echo $start += 1; ?></td>
                    <td><?php echo date("d-m-Y", strtotime($json[$i]['tgl_input'])); ?></td>
                    <td><?php echo date("d-m-Y", strtotime($json[$i]['tgl_po_gudang'])); ?></td>
                    <td><?php echo $json[$i]['no_seri_brg']; ?></td>
                    <td><?php echo $json[$i]['kerusakan_alat']; ?></td>
                    <td><?php if ($json[$i]['status_barang'] == 1) {
                            echo "Sudah Selesai Di Perbaiki & Sudah Masuk Gudang";
                        } else if ($json[$i]['status_barang'] == 2) {
                            echo "Di Kembalikan";
                        } else {
                            echo "Sedang Di Perbaiki";
                        } ?></td>
                    <td><?php $tek = mysqli_fetch_array(mysqli_query($koneksi, "select * from tb_teknisi where id=" . $json[$i]['teknisi_id'] . ""));
                        echo $tek['nama_teknisi']; ?></td>
                    <td align="center">
                        <!-- <a href="#" data-toggle="modal" data-target="#modal-teknisi<?php echo $json[$i]['idd']; ?>"> -->
                        <a href="#" onclick="pilihTeknisi(<?php echo $json[$i]['idd']; ?>, <?php echo $tek['id']; ?>)">
                            <small data-toggle="tooltip" title="Pilih Teknisi" class="label bg-green"> Pilih Teknisi</small>
                        </a>
                        <br />
                        <!-- <a href="index.php?page=barang_rusak_detail&id_hapus=<?php echo $json[$i]['idd']; ?>&id_gudang=<?php echo $_GET['id_gudang']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ? Aksi Ini Akan Membuat History Kerusakan Alkes Akan Terhapus Dan Status Alkes Menjadi Layak Untuk Dijual !')"> -->
                        <a href="#" onclick="hapus(<?php echo $_GET['id_gudang']; ?>, <?php echo $json[$i]['idd']; ?>)">
                            <button class="btn btn-xs btn-danger">
                                <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                            </button>
                        </a>
                        <!--&nbsp;&nbsp;<a target="blank" href="cetak_surat_perintah_instalasi.php?id=<?php echo $dataa['idd']; ?>"><span data-toggle="tooltip" title="Cetak Surat Perintah Instalasi" class="fa fa-print"></span></a>&nbsp;&nbsp;<a href="index.php?page=ubah_barang_rusak&id_gudang_detail=<?php echo $json[$i]['id_gudang_detail']; ?>&id_ubah=<?php echo $json[$i]['idd']; ?>&id_gudang=<?php echo $_GET['id_gudang']; ?>"><span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span></a><!--&nbsp;&nbsp;<a target="_blank" href="cetak_laporan_instalasi.php?id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Download Report" class="glyphicon glyphicon-print"></span></a><br />-->
                        <?php /*if ($json[$i]['status_dikembalikan']==1) { ?>
                      <a href="index.php?page=tambah_pelatihan&id=<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Kembalikan Ke Stok Gudang" class="label bg-blue"><span class="fa fa-share"></span> Stok</small></a> <?php }*/ ?>

                    </td>
                </tr>

            <?php } ?>
        </table>
    </div>

</body>

</html>