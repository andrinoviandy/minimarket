<?php
// error_reporting(0);
header("Content-type:application/json");
session_start();
//koneksi ke database
require("../config/koneksi.php");
//menampilkan data dari database, table tb_anggota

$sql = "select a.*,a.id as idd, b.nama_supplier, b.alamat_supplier from pembelian a left join supplier b on b.id = a.supplier_id where a.tgl_po_pesan between '$_GET[tglPembelian1]' and '$_GET[tglPembelian2]' order by a.tgl_po_pesan DESC, a.no_po_pesan DESC";

$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

while ($row = mysqli_fetch_assoc($result)) {
    $ArrAnggota[] = $row;
}

echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

//tutup koneksi ke database
mysqli_close($koneksi);
