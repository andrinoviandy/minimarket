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
//menampilkan data dari database, table tb_anggota
if (isset($_GET['start'])) {
	if (isset($_GET['cari'])) {
		$sql = "select barang_gudang.*, barang_gudang.id as idd, barang_gudang_detail.no_seri_brg, barang_gudang_detail.no_bath, barang_gudang_detail.no_lot, barang_gudang_detail.qrcode from barang_gudang LEFT JOIN barang_gudang_detail ON barang_gudang.id=barang_gudang_detail.barang_gudang_id where (nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' or nie_brg like '%$_GET[cari]%' or negara_asal like '%$_GET[cari]%' or qrcode like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%') group by barang_gudang.id order by nama_brg ASC LIMIT $start, $limit";
	} else {
		$sql = "select *,barang_gudang.id as idd from barang_gudang group by barang_gudang.id order by nama_brg ASC LIMIT $start, $limit";
	}
	$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

	//membuat array
	while ($row = mysqli_fetch_assoc($result)) {
		$ArrAnggota[] = $row;
	}

	echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

	//tutup koneksi ke database
	mysqli_close($koneksi);
} else {
	//untuk jumlah
	if (isset($_GET['cari'])) {
		$sql = "select COUNT(DISTINCT barang_gudang.id) as jml from barang_gudang LEFT JOIN barang_gudang_detail ON barang_gudang.id=barang_gudang_detail.barang_gudang_id where (nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' or nie_brg like '%$_GET[cari]%' or negara_asal like '%$_GET[cari]%' or qrcode like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%')";
	} else {
		$sql = "select COUNT(*) as jml from barang_gudang";
	}
	$result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
	echo $result['jml'];
	//tutup koneksi ke database
	mysqli_close($koneksi);
}
