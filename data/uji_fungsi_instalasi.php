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
        <table width="100%" id="example1" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th align="center">No</th>
                    <th>Nama RS/Dinas/Pusk./dll</th>
                    <td align="center" valign="bottom"><strong>Alamat</strong></td>
                    <td align="center"><strong>Kontak RS/Dinas/Dll</strong></td>
                    <td align="center"><strong>Aksi</strong></td>
                </tr>
            </thead>
            <?php
            // if (isset($_SESSION['id_b'])) {
            //     $query = mysqli_query($koneksi, "select *,alat_uji_detail.id as idd,pembeli.id as id_rumkit from alat_uji_detail,barang_teknisi_detail,barang_dikirim_detail,barang_dikirim,barang_dijual,pembeli,tb_teknisi,barang_teknisi_detail_teknisi where pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and tb_teknisi.id=$_SESSION[id_b] group by pembeli.id order by nama_pembeli ASC");
            // } else {
            //     $query = mysqli_query($koneksi, "select *,alat_uji_detail.id as idd,pembeli.id as id_rumkit from alat_uji_detail,barang_teknisi_detail,barang_dikirim_detail,barang_dikirim,barang_dijual,pembeli where pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id group by pembeli.id order by nama_pembeli ASC");
            // }
            // $no = 0;
            // while ($json[$i] = mysqli_fetch_assoc($query)) {
            //     $no++;
            for ($i = 0; $i < $jml; $i++) {
            ?>
                <tr>
                    <td align="center"><?php echo $start += 1; ?></td>
                    <td><?php echo $json[$i]['nama_pembeli']; ?></td>
                    <td align="center"><?php echo $json[$i]['jalan'] . ", Kelurahan " . $json[$i]['kelurahan_id']; ?></td>
                    <td align="center"><?php echo $json[$i]['kontak_rs']; ?></td>
                    <td align="center">
                        <!--<?php if (!isset($_SESSION['id_b'])) { ?>
                                <a href="pages/delete_uji.php?id_hapus=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"><span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a> &nbsp;
                    <?php } ?>-->
                        <a href="index.php?page=ubah_uji&id_rumkit=<?php echo $json[$i]['id_rumkit']; ?>">
                            <button class="btn btn-xs btn-info">
                                <span data-toggle="tooltip" title="Detail" class="fa fa-caret-square-o-right"></span>
                            </button>
                        </a>
                        <br />
                        <!--<?php if (!isset($_SESSION['id_b'])) { ?>
                      <a href="cetak_surat_perintah_instalasi.php?id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Cetak Surat Perintah Instalasi" class="fa fa-print"></span></a>&nbsp;&nbsp; <a target="_blank" href="cetak_laporan_instalasi.php?id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Download Report" class="glyphicon glyphicon-print"></span></a><br />
                        <?php } ?>-->
                        <!--
                      <?php

                        if ($tt == 0) { ?>
                        <a href="index.php?page=tambah_pelatihan&id=<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Pelatihan Alat" class="label bg-blue">Pelatihan</small></a>
                      <?php } ?>
                      -->
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>