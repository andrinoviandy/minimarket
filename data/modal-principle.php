<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
// $data = mysqli_fetch_array(mysqli_query($koneksi, "select nama_pembeli, jalan, kontak_rs from pembeli where id = ".$_GET['id'].""))
?>
<p align="justify">
    <?php
    $sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from principle where id=" . $_GET['id'] . ""));
    echo "<b>Nama Principle :</b> <br/>" . $sel['nama_principle']; ?>
    <hr />
    <?php echo "<b>Alamat Principle :</b> <br/>" . $sel['alamat_principle']; ?>
    <hr />
    <?php echo "<b>Telepon Principle :</b> <br/>" . $sel['telp_principle']; ?>
    <hr />
    <?php echo "<b>Fax Principle :</b> <br/>" . $sel['fax_principle']; ?>
    <hr />
    <?php echo "<b>Attn Principle :</b> <br/>" . $sel['attn_principle']; ?>
</p>