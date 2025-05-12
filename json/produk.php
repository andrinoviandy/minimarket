<?php
// error_reporting(0);
header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");

$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;
//menampilkan data dari database, table tb_anggota
if (isset($_GET['start'])) {
    $start = mysqli_real_escape_string($koneksi, $_GET['start']);
	if (isset($_GET['cari'])) {
		$sql = "select a.*, a.id as idd, COALESCE(b.stok_produk, 0) as stok_produk, c.kategori from produk a left join (select produk_id, count(*) as stok_produk from produk_detail b group by b.produk_id) b on a.id = b.produk_id left join kategori_produk c on c.id = a.kategori_produk_id where (a.nama_produk like '%$_GET[cari]%' or c.kategori like '%$_GET[cari]%') order by a.nama_produk ASC LIMIT $start, $limit";
	} else {
		$sql = "select a.*, a.id as idd, COALESCE(b.stok_produk, 0) as stok_produk, c.kategori from produk a left join (select produk_id, count(*) as stok_produk from produk_detail b group by b.produk_id) b on a.id = b.produk_id left join kategori_produk c on c.id = a.kategori_produk_id order by a.nama_produk ASC LIMIT $start, $limit";
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
		$sql = "select COUNT(a.id) as jml from produk a left join (select produk_id, count(*) as stok_produk from produk_detail b group by b.produk_id) b on a.id = b.produk_id left join kategori_produk c on c.id = a.kategori_produk_id where (a.nama_produk like '%$_GET[cari]%' or c.kategori like '%$_GET[cari]%')";
	} else {
		$sql = "select COUNT(a.id) as jml from produk a";
	}
	$result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
	echo $result['jml'];
	//tutup koneksi ke database
	mysqli_close($koneksi);
}
