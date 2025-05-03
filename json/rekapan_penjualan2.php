<?php
error_reporting(0);
header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");
$str = explode("-", $_GET['month']);
$tahunJual = intval($str[0]);
$bulanJual = intval($str[1]);
$sql = "select *,barang_dijual.id as idd from barang_dijual left join pembeli on pembeli.id = barang_dijual.pembeli_id where barang_dijual.status_deal=1 and YEAR(tgl_jual) = '$tahunJual' AND MONTH(tgl_jual) = '$bulanJual' group by no_po_jual order by tgl_jual DESC, barang_dijual.id DESC";

$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));
//membuat array
while ($row = mysqli_fetch_assoc($result)) {
    $ArrAnggota[] = $row;
}

echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

//tutup koneksi ke database
mysqli_close($koneksi);
