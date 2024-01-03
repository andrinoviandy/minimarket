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
(SELECT COUNT(*) from barang_pesan where month(tgl_po_pesan) = '1' and year(tgl_po_pesan) = '$_GET[tahun]') as jan,
(SELECT COUNT(*) from barang_pesan where month(tgl_po_pesan) = '2' and year(tgl_po_pesan) = '$_GET[tahun]') as feb,
(SELECT COUNT(*) from barang_pesan where month(tgl_po_pesan) = '3' and year(tgl_po_pesan) = '$_GET[tahun]') as mar,
(SELECT COUNT(*) from barang_pesan where month(tgl_po_pesan) = '4' and year(tgl_po_pesan) = '$_GET[tahun]') as apr,
(SELECT COUNT(*) from barang_pesan where month(tgl_po_pesan) = '5' and year(tgl_po_pesan) = '$_GET[tahun]') as mei,
(SELECT COUNT(*) from barang_pesan where month(tgl_po_pesan) = '6' and year(tgl_po_pesan) = '$_GET[tahun]') as jun,
(SELECT COUNT(*) from barang_pesan where month(tgl_po_pesan) = '7' and year(tgl_po_pesan) = '$_GET[tahun]') as jul,
(SELECT COUNT(*) from barang_pesan where month(tgl_po_pesan) = '8' and year(tgl_po_pesan) = '$_GET[tahun]') as agu,
(SELECT COUNT(*) from barang_pesan where month(tgl_po_pesan) = '9' and year(tgl_po_pesan) = '$_GET[tahun]') as sep,
(SELECT COUNT(*) from barang_pesan where month(tgl_po_pesan) = '10' and year(tgl_po_pesan) = '$_GET[tahun]') as okt,
(SELECT COUNT(*) from barang_pesan where month(tgl_po_pesan) = '11' and year(tgl_po_pesan) = '$_GET[tahun]') as nov,
(SELECT COUNT(*) from barang_pesan where month(tgl_po_pesan) = '12' and year(tgl_po_pesan) = '$_GET[tahun]') as des 
from barang_pesan where status_po_batal=0";

$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));
$row = mysqli_fetch_array($result);
// $ArrAnggota = array();
for ($i=0; $i<=11; $i++) {
    $ArrAnggota[] = $row[$i];
}
echo str_replace('"', '', json_encode($ArrAnggota));

//tutup koneksi ke database
mysqli_close($koneksi);
