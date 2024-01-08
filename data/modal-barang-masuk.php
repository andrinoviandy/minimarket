<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_gudang where id = " . $_GET['id'] . ""))
?>
<p align="justify">
    <?php
    // $nm_brg = mysqli_fetch_array(mysqli_query($koneksi, "select nama_brg from barang_gudang where id=".$data['idd'].""));
    echo "<b>Nama Barang :</b> <br/>" . $data['nama_brg']; ?>
    <hr />
    <?php echo "<b>NIE Barang :</b> <br/>" . $data['nie_brg']; ?>
    <hr />

    <?php echo "<b>Negara Asal :</b> <br/>" . $data['negara_asal']; ?>
    <hr />
    <?php
    if ($data['jenis_barang'] == 1) {
        $jb = "E-Katalog";
    } else {
        $jb = "Bukan E-Katalog";
    }
    echo "<b>Jenis Barang :</b> <br/>" . $jb; ?>
    <hr />
    <?php echo "<b>Deskripsi Alkes :</b> <br/>" . $data['deskripsi_alat']; ?>
</p>