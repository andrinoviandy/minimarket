<?php
// error_reporting(0);
header("Access-Control-Allow-Origin: *");

// Izinkan metode HTTP yang diizinkan
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

// Izinkan header yang diizinkan
header("Access-Control-Allow-Headers: Content-Type");

// Izinkan pengiriman cookie pada permintaan lintas domain
header("Access-Control-Allow-Credentials: true");


//koneksi ke database
require("../config/koneksi.php");
$distinct = "CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END";
$filter = "";
if ($_GET['alkes'] && $_GET['alkes'] !== 'all') {
    $filter = $filter . " and barang_gudang_id = $_GET[alkes] ";
    // $distinct = "CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END";
}
if ($_GET['filter'] == 1) {
    $filter = $filter . " and pembeli.id = $_GET[pembeli] ";
} else if ($_GET['filter'] == 2) {
    if ($_GET['provinsi'] && $_GET['provinsi'] !== 'all') {
        $filter = $filter . " and provinsi_id = $_GET[provinsi] ";
        if ($_GET['kabupaten'] && $_GET['kabupaten'] !== 'all') {
            $filter = $filter . " and kabupaten_id = $_GET[kabupaten] ";
            if ($_GET['kecamatan'] && $_GET['kecamatan'] !== 'all') {
                $filter = $filter . " and kecamatan_id = $_GET[kecamatan] ";
            }
        }
    }
}

$sql = "select 
pembeli.id as pembeli_id,
barang_gudang.id as barang_id,
nama_pembeli,
nama_brg,
tipe_brg 
from barang_dijual left join pembeli on pembeli.id=barang_dijual.pembeli_id left join barang_dijual_qty on barang_dijual.id=barang_dijual_qty.barang_dijual_id left join barang_gudang on barang_gudang.id = barang_dijual_qty.barang_gudang_id where barang_dijual.status_deal=1 and year(barang_dijual.tgl_jual) = '$_GET[tahun]' $filter";  

// echo $sql; die();

$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

//membuat array
while ($row = mysqli_fetch_assoc($result)) {
    $ArrAnggota[] = $row;
}

echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

//tutup koneksi ke database
mysqli_close($koneksi);
