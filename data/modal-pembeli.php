<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select nama_pembeli, jalan, kontak_rs, nama_provinsi, nama_kabupaten, nama_kecamatan from pembeli, alamat_provinsi, alamat_kabupaten, alamat_kecamatan where alamat_provinsi.id = pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id = pembeli.kecamatan_id and pembeli.id = ".$_GET['id'].""))
?>
<p align="justify">
    <?php
    echo "<b>Nama RS/Dinas/Klinik/Dll :</b> <br/>" . $data['nama_pembeli']; ?>
    <hr />
    <?php echo "<b>Provinsi :</b> <br/>" . ucwords(strtolower($data['nama_provinsi'])); ?>
    <hr />
    <?php echo "<b>Kabupaten :</b> <br/>" . ucwords(strtolower($data['nama_kabupaten'])); ?>
    <hr />
    <?php echo "<b>Kecamatan :</b> <br/>" . ucwords(strtolower($data['nama_kecamatan'])); ?>
    <hr />
    <?php echo "<b>Alamat :</b> <br/>" . str_replace("<br>", "", $data['jalan']); ?>
    <hr />
    <?php echo "<b>Kontak :</b> <br/>" . $data['kontak_rs']; ?>

</p>