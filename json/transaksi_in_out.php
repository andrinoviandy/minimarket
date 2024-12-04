<?php
error_reporting(0);
header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");
$filter = "";
if ($_GET['alkes'] && $_GET['alkes'] !== 'all') {
    $filter = $filter . " and merk_brg = '" . $_GET['alkes'] . "' ";
    // $distinct = "CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END";
    if ($_GET['tipe'] && $_GET['tipe'] !== 'all') {
        $filter = $filter . " and tipe_brg = '" . $_GET['tipe'] . "' ";
    }
}

$sql = "select 
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '1' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as jan_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '2' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as feb_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '3' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as mar_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '4' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as apr_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '5' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as mei_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '6' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as jun_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '7' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as jul_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '8' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as agu_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '9' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as sep_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '10' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as okt_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '11' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as nov_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '12' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as des_in,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '1' and year(tgl_jual) = '$_GET[tahun]' $filter) as jan_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '2' and year(tgl_jual) = '$_GET[tahun]' $filter) as feb_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '3' and year(tgl_jual) = '$_GET[tahun]' $filter) as mar_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '4' and year(tgl_jual) = '$_GET[tahun]' $filter) as apr_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '5' and year(tgl_jual) = '$_GET[tahun]' $filter) as mei_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '6' and year(tgl_jual) = '$_GET[tahun]' $filter) as jun_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '7' and year(tgl_jual) = '$_GET[tahun]' $filter) as jul_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '8' and year(tgl_jual) = '$_GET[tahun]' $filter) as agu_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '9' and year(tgl_jual) = '$_GET[tahun]' $filter) as sep_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '10' and year(tgl_jual) = '$_GET[tahun]' $filter) as okt_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '11' and year(tgl_jual) = '$_GET[tahun]' $filter) as nov_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '12' and year(tgl_jual) = '$_GET[tahun]' $filter) as des_out 
from dual";

// echo $sql; die();

$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

//membuat array
while ($row = mysqli_fetch_assoc($result)) {
    $ArrAnggota[] = $row;
}

echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

//tutup koneksi ke database
mysqli_close($koneksi);
