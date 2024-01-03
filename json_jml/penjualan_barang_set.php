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

if (isset($_GET['start'])) {
	if (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
		if (isset($_GET['cari'])) {
			$sql = "select *,barang_dijual_set.id as idd from barang_dijual_set, pembeli where pembeli.id=barang_dijual_set.pembeli_id and (DATE_FORMAT(tgl_jual, '%d-%m-%Y') like '%$_GET[cari]%' or no_faktur_jual like '%$_GET[cari]%' or marketing like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%') and tgl_jual between '$_GET[tgl1]' and '$_GET[tgl2]' order by tgl_jual DESC, barang_dijual_set.id DESC LIMIT $start, $limit";
		} else {
			$sql = "select *,barang_dijual_set.id as idd from barang_dijual_set, pembeli where pembeli.id=barang_dijual_set.pembeli_id and tgl_jual between '$_GET[tgl1]' and '$_GET[tgl2]' order by tgl_jual DESC, barang_dijual_set.id DESC LIMIT $start, $limit";
		}
	} else {
		if (isset($_GET['cari'])) {
			$sql = "select *,barang_dijual_set.id as idd from barang_dijual_set, pembeli where pembeli.id=barang_dijual_set.pembeli_id and (DATE_FORMAT(tgl_jual, '%d-%m-%Y') like '%$_GET[cari]%' or no_faktur_jual like '%$_GET[cari]%' or marketing like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%') order by tgl_jual DESC, barang_dijual_set.id DESC LIMIT $start, $limit";
		} else {
			$sql = "select *,barang_dijual_set.id as idd from barang_dijual_set order by tgl_jual DESC, barang_dijual_set.id DESC LIMIT $start, $limit";
		}
	}
} else {
	//untuk jumlah
	if ($_GET['tgl1'] && $_GET['tgl2']) {
		if (isset($_GET['cari'])) {
			$sql = "select *,barang_dijual_set.id as idd from barang_dijual_set, pembeli where pembeli.id=barang_dijual_set.pembeli_id and (DATE_FORMAT(tgl_jual, '%d-%m-%Y') like '%$_GET[cari]%' or no_faktur_jual like '%$_GET[cari]%' or marketing like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%') and tgl_jual between '$_GET[tgl1]' and '$_GET[tgl2]' order by tgl_jual DESC, barang_dijual_set.id DESC";
		} else {
			$sql = "select *,barang_dijual_set.id as idd from barang_dijual_set, pembeli where pembeli.id=barang_dijual_set.pembeli_id and tgl_jual between '$_GET[tgl1]' and '$_GET[tgl2]' order by tgl_jual DESC, barang_dijual_set.id DESC";
		}
	} else {
		if (isset($_GET['cari'])) {
			$sql = "select *,barang_dijual_set.id as idd from barang_dijual_set, pembeli where pembeli.id=barang_dijual_set.pembeli_id and (DATE_FORMAT(tgl_jual, '%d-%m-%Y') like '%$_GET[cari]%' or no_faktur_jual like '%$_GET[cari]%' or marketing like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%') order by tgl_jual DESC, barang_dijual_set.id DESC";
		} else {
			$sql = "select *,barang_dijual_set.id as idd from barang_dijual_set order by tgl_jual DESC, barang_dijual_set.id DESC";
		}
	}
}
//menampilkan data dari database, table tb_anggota
// $sql = "select *,barang_dijual_set.id as idd from barang_dijual_set order by tgl_jual DESC, barang_dijual_set.id DESC";
$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));
 
//membuat array
while ($row = mysqli_fetch_assoc($result)) {
    $ArrAnggota[] = $row;
}
 
echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);
 
//tutup koneksi ke database
mysqli_close($koneksi);
?>