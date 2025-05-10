<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$del2 = mysqli_query($koneksi, "delete from buku_kas where id='" . $_POST['id_hapus'] . "'");
if ($del2) {
    echo "S";
} else {
    echo "F";
}
