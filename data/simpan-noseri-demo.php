<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$cek = mysqli_fetch_array(mysqli_query($koneksi, "select qty from barang_demo_qty where id=" . $_POST['merk_akse'] . ""));
$cek2 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_demo_kirim_detail where barang_demo_qty_id=" . $_POST['merk_akse'] . ""));
$cek3 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_demo_kirim_detail_hash where barang_demo_qty_id=" . $_POST['merk_akse'] . " and akun_id=" . $_SESSION['id'] . ""));
$nil1 = $cek['qty'] - $cek2;
if ($nil1 > $cek3) {
    $simpan = mysqli_query($koneksi, "insert into barang_demo_kirim_detail_hash values('','" . $_SESSION['id'] . "','" . $_POST['merk_akse'] . "','" . $_POST['no_seri'] . "')");
    if ($simpan) {
        echo "S";
    } else {
        echo "F";
    }
} else {
    echo "G";
    // echo "<script>
	// 	alert('Gagal ! Sudah Mencukupi Kuantitas');
	// 	window.location='index.php?page=pilih_no_seri_demo&id=$_GET[id]'</script>";
}
