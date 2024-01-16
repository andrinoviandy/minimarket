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
$filter = "";
if ($_GET['provinsi'] == 'all') {
    $filter = "";
} else if ($_GET['kabupaten'] == 'all') {
    $filter = "and provinsi_id = $_GET[provinsi]";
} else if ($_GET['kecamatan'] == 'all') {
    $filter = "and provinsi_id = $_GET[provinsi] and kabupaten_id = $_GET[kabupaten]";
} else if ($_GET['kecamatan'] != 'all') {
    $filter = "and provinsi_id = $_GET[provinsi] and kabupaten_id = $_GET[kabupaten] and kecamatan_id = $_GET[kecamatan]";
}

$sql = "select DISTINCT 
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual, pembeli where pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '1' and year(tgl_jual) = '$_GET[tahun]' $filter) as jan,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual, pembeli where pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '2' and year(tgl_jual) = '$_GET[tahun]' $filter) as feb,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual, pembeli where pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '3' and year(tgl_jual) = '$_GET[tahun]' $filter) as mar,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual, pembeli where pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '4' and year(tgl_jual) = '$_GET[tahun]' $filter) as apr,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual, pembeli where pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '5' and year(tgl_jual) = '$_GET[tahun]' $filter) as mei,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual, pembeli where pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '6' and year(tgl_jual) = '$_GET[tahun]' $filter) as jun,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual, pembeli where pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '7' and year(tgl_jual) = '$_GET[tahun]' $filter) as jul,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual, pembeli where pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '8' and year(tgl_jual) = '$_GET[tahun]' $filter) as agu,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual, pembeli where pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '9' and year(tgl_jual) = '$_GET[tahun]' $filter) as sep,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual, pembeli where pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '10' and year(tgl_jual) = '$_GET[tahun]' $filter) as okt,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual, pembeli where pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '11' and year(tgl_jual) = '$_GET[tahun]' $filter) as nov,
(SELECT COUNT(DISTINCT no_po_jual) from barang_dijual, pembeli where pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '12' and year(tgl_jual) = '$_GET[tahun]' $filter) as des 
from barang_dijual, pembeli where pembeli.id = barang_dijual.pembeli_id and status_deal=1";



$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));
$row = mysqli_fetch_array($result);
// $ArrAnggota = array();
for ($i = 0; $i <= 11; $i++) {
    $ArrAnggota[] = $row[$i];
}
echo str_replace('"', '', json_encode($ArrAnggota));

//tutup koneksi ke database
mysqli_close($koneksi);
