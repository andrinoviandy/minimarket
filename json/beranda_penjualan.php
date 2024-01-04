<?php
error_reporting(0);
header("Access-Control-Allow-Origin: *");

// Izinkan metode HTTP yang diizinkan
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

// Izinkan header yang diizinkan
header("Access-Control-Allow-Headers: Content-Type");

// Izinkan pengiriman cookie pada permintaan lintas domain
header("Access-Control-Allow-Credentials: true");


//koneksi ke database
require("../config/koneksi.php");

$sql = "select DISTINCT 
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual where month(tgl_jual) = '1' and year(tgl_jual) = '$_GET[tahun]') as jan,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual where month(tgl_jual) = '2' and year(tgl_jual) = '$_GET[tahun]') as feb,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual where month(tgl_jual) = '3' and year(tgl_jual) = '$_GET[tahun]') as mar,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual where month(tgl_jual) = '4' and year(tgl_jual) = '$_GET[tahun]') as apr,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual where month(tgl_jual) = '5' and year(tgl_jual) = '$_GET[tahun]') as mei,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual where month(tgl_jual) = '6' and year(tgl_jual) = '$_GET[tahun]') as jun,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual where month(tgl_jual) = '7' and year(tgl_jual) = '$_GET[tahun]') as jul,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual where month(tgl_jual) = '8' and year(tgl_jual) = '$_GET[tahun]') as agu,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual where month(tgl_jual) = '9' and year(tgl_jual) = '$_GET[tahun]') as sep,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual where month(tgl_jual) = '10' and year(tgl_jual) = '$_GET[tahun]') as okt,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual where month(tgl_jual) = '11' and year(tgl_jual) = '$_GET[tahun]') as nov,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual where month(tgl_jual) = '12' and year(tgl_jual) = '$_GET[tahun]') as des 
from barang_dijual where status_deal=1";

$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));
$row = mysqli_fetch_array($result);
// $ArrAnggota = array();
for ($i=0; $i<=11; $i++) {
    $ArrAnggota[] = $row[$i];
}
echo str_replace('"', '', json_encode($ArrAnggota));

//tutup koneksi ke database
mysqli_close($koneksi);
