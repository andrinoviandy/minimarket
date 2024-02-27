<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$s = mysqli_query($koneksi, "update barang_teknisi set keterangan_spk='" . str_replace("\r\n", "<br>", $_POST['keterangan_spk']) . "' where id=" . $_POST['id_spk'] . "");
if ($s) {
    echo "S";
} else {
    echo "F";
}
