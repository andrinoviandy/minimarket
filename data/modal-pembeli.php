<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select nama_pembeli, jalan, kontak_rs from pembeli where id = ".$_GET['id'].""))
?>
<p align="justify">
    <?php
    echo "<b>Nama RS/Dinas/Klinik/Dll :</b> <br/>" . $data['nama_pembeli']; ?>
    <hr />
    <?php echo "<b>Alamat :</b> <br/>" . str_replace("<br>", "", $data['jalan']); ?>
    <hr />
    <?php echo "<b>Kontak :</b> <br/>" . $data['kontak_rs']; ?>

</p>