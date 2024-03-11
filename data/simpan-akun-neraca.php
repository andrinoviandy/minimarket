<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$query = mysqli_query($koneksi, "insert into coa_sub_akun values('','" . $_POST['coa_id'] . "','" . $_POST['nama_sub_grup'] . "')");
if ($query) {
    echo "S";
} else {
    echo "F";
}
