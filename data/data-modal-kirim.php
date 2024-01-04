<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dikirim where id = " . $_GET['id'] . ""))
?>
<p align="justify">
    <?php
    echo "<b>Ekspedisi :</b> <br/>" . $data['ekspedisi']; ?>
    <hr />
    <?php echo "<b>Pengiriman Via :</b> <br/>" . $data['via_pengiriman']; ?>
    <hr />
    <?php echo "<b>Estimasi Barang Sampai :</b> <br/>"; ?>
    <?php
    if ($data['estimasi_barang_sampai'] != 0000 - 00 - 00) {
        echo date("d/m/Y", strtotime($data['estimasi_barang_sampai']));
    } ?>
    <hr />
    <?php echo "<b>Biaya Jasa Pengiriman :</b> <br/>" . number_format($data['biaya_pengiriman'], 0, ',', '.'); ?>
</p>