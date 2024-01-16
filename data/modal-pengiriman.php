<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_pesan where id = ".$_GET['id'].""))
?>
<p align="justify">
    <?php
    echo "<b>Alamat Pengiriman :</b> <br/>" . $data['alamat_pengiriman']; ?>
    <hr />
    <?php echo "<b>Jalur Pengiriman :</b> <br/>" . $data['jalur_pengiriman']; ?>
    <hr />
    <?php echo "<b>Estimasi Pengiriman :</b> <br/>"; ?>
    <?php
    if ($data['estimasi_pengiriman'] != 0000 - 00 - 00) {
        echo date("d/m/Y", strtotime($data['estimasi_pengiriman']));
    } ?>
</p>