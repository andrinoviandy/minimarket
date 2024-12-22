<?php
/*
header("Content-type:application/json");
 
//koneksi ke database
require("../config/koneksi.php");
 
//menampilkan data dari database, table tb_anggota
$sql = "select *,tb_laporan_kerusakan.id as idd from tb_laporan_kerusakan where pembeli_id=$_GET[id] order by tgl_lapor DESC, tb_laporan_kerusakan.id DESC";
$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));
 
//membuat array
while ($row = mysqli_fetch_assoc($result)) {
    $ArrAnggota[] = $row;
}
 
echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);
 
//tutup koneksi ke database
mysqli_close($koneksi);*/
?>
<?php
// error_reporting(0);
header("Content-type:application/json");
session_start();
error_reporting(0);
//koneksi ke database
require("../config/koneksi.php");

$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;
$start = mysqli_real_escape_string($koneksi, $_GET['start']);

if (isset($_GET['start'])) {
	if (isset($_GET['cari'])) {
		$sql = "select *,tb_laporan_kerusakan_cs.id as idd from tb_laporan_kerusakan_cs, tb_laporan_kerusakan_cs_detail,barang_gudang where barang_gudang.id = tb_laporan_kerusakan_cs_detail.barang_gudang_id and tb_laporan_kerusakan_cs.id = tb_laporan_kerusakan_cs_detail.tb_laporan_kerusakan_cs_id and tb_laporan_kerusakan_cs.pembeli_id=$_GET[id] and (nama_penelepon like '%$_GET[cari]%' or kontak_penelepon like '%$_GET[cari]%' or keluhan like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or DATE_FORMAT(tgl_lapor, '%d-%m-%Y') like '%$_GET[cari]%') group by tb_laporan_kerusakan_cs.id order by tgl_lapor DESC, tb_laporan_kerusakan_cs.id DESC LIMIT $start, $limit";
	} else {
		$sql = "select *,tb_laporan_kerusakan_cs.id as idd from tb_laporan_kerusakan_cs where pembeli_id=$_GET[id] order by tgl_lapor DESC, tb_laporan_kerusakan_cs.id DESC LIMIT $start, $limit";
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
		$sql = "select COUNT(DISTINCT tb_laporan_kerusakan_cs.id) as jml from tb_laporan_kerusakan_cs, tb_laporan_kerusakan_cs_detail,barang_gudang where barang_gudang.id = tb_laporan_kerusakan_cs_detail.barang_gudang_id and tb_laporan_kerusakan_cs.id = tb_laporan_kerusakan_cs_detail.tb_laporan_kerusakan_cs_id and tb_laporan_kerusakan_cs.pembeli_id=$_GET[id] and (nama_penelepon like '%$_GET[cari]%' or kontak_penelepon like '%$_GET[cari]%' or keluhan like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or DATE_FORMAT(tgl_lapor, '%d-%m-%Y') like '%$_GET[cari]%')";
	} else {
		$sql = "select COUNT(DISTINCT tb_laporan_kerusakan_cs.id) as jml from tb_laporan_kerusakan_cs where pembeli_id=$_GET[id]";
	}
}
$result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
echo $result['jml'];
//tutup koneksi ke database
mysqli_close($koneksi);
