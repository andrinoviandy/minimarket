<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$del2 = mysqli_query($koneksi, "delete from nasabah where id='" . $_POST['id'] . "'");
if ($del2) {
    echo "S";
} else {
    echo "F";
}
