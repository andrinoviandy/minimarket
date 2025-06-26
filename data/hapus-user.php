<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
$stmt = $koneksi->prepare("delete from admin where id = ?");
$stmt->bind_param("i", $_POST['id_hapus']);
$simpan1 = $stmt->execute();
if ($simpan1) {
    die("S");
} else {
    die('F');
}
