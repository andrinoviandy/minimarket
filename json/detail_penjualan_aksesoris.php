<?php
error_reporting(0);
header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");

$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;
$start = mysqli_real_escape_string($koneksi, $_GET['start']);

$sql = "select *, aksesoris_kirim.id as idd from aksesoris_kirim,aksesoris_jual,aksesoris_jual_qty,aksesoris_kirim_detail,aksesoris_detail,pembeli where aksesoris_kirim.id=aksesoris_kirim_detail.aksesoris_kirim_id and aksesoris_jual_qty.id=aksesoris_kirim_detail.aksesoris_jual_qty_id and aksesoris_jual.id=aksesoris_jual_qty.aksesoris_jual_id and aksesoris_detail.id=aksesoris_kirim_detail.aksesoris_detail_id and pembeli.id=aksesoris_jual.pembeli_id and aksesoris_jual_id=$_GET[id]";

$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

//membuat array
while ($row = mysqli_fetch_assoc($result)) {
    $ArrAnggota[] = $row;
}

echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

//tutup koneksi ke database
mysqli_close($koneksi);
