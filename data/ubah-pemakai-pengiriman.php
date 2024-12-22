<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
$up = mysqli_query($koneksi, "update pemakai set nama_pemakai='" . $_POST['nama_pemakai'] . "', kontak1_pemakai='" . $_POST['kontak1'] . "', kontak2_pemakai='" . $_POST['kontak2'] . "', email_pemakai='" . $_POST['email_pemakai'] . "' where id=" . $_POST['id'] . "");
if ($up) {
    echo "S";
} else {
    echo "F";
}
