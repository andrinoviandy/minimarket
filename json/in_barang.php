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
// $distinct = "COUNT(DISTINCT barang_dijual.no_po_jual)";
$distinct = "CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END";
$filter = "";
if ($_GET['alkes'] && $_GET['alkes'] !== 'all') {
    $filter = $filter . " and merk_brg = '" . $_GET['alkes'] . "' ";
    // $distinct = "CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END";
    if ($_GET['tipe'] && $_GET['tipe'] !== 'all') {
        $filter = $filter . " and tipe_brg = '" . $_GET['tipe'] . "' ";
    }
}

$sql = "select DISTINCT 
(SELECT $distinct from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '1' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as jan,
(SELECT $distinct from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '2' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as feb,
(SELECT $distinct from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '3' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as mar,
(SELECT $distinct from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '4' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as apr,
(SELECT $distinct from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '5' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as mei,
(SELECT $distinct from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '6' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as jun,
(SELECT $distinct from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '7' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as jul,
(SELECT $distinct from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '8' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as agu,
(SELECT $distinct from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '9' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as sep,
(SELECT $distinct from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '10' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as okt,
(SELECT $distinct from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '11' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as nov,
(SELECT $distinct from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '12' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as des 
from dual";

// echo $sql; die();

$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));
$row = mysqli_fetch_array($result);
// $ArrAnggota = array();
for ($i = 0; $i <= 11; $i++) {
    $ArrAnggota[] = $row[$i];
}
echo str_replace('"', '', json_encode($ArrAnggota));

//tutup koneksi ke database
mysqli_close($koneksi);
