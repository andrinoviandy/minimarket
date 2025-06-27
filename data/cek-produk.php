<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
$sql = "select a.qrcode, b.id as produk_id, b.nama_produk, b.harga_beli from produk_detail a inner join produk b on b.id = a.produk_id where a.qrcode = '" . $_GET['qrcode'] . "' and b.stok != 0 order by b.nama_produk asc";

$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

//membuat array
while ($row = mysqli_fetch_assoc($result)) {
    $ArrAnggota[] = $row;
}

echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

//tutup koneksi ke database
mysqli_close($koneksi);
