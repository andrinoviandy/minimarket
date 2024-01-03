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

if (isset($_SESSION['id_b'])) {
	if (isset($_GET['start'])) {
		if (isset($_GET['cari'])) {
			$sql = "select *,barang_gudang_detail_rusak.id as idd, barang_gudang_detail.id as id_gudang_detail from barang_gudang,barang_gudang_po,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_po.barang_gudang_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and barang_gudang.id=$_GET[id_gudang] and teknisi_id=$_SESSION[id_b] and (no_seri_brg like '%$_GET[cari]%' or kerusakan_alat like '%$_GET[cari]%' or date_format(tgl_input, '%d-%m-%Y') like '%$_GET[cari]%') group by barang_gudang_detail_rusak.id order by tgl_po_gudang DESC, barang_gudang_detail_rusak.id DESC LIMIT $start, $limit";
		} else {
			$sql = "select *,barang_gudang_detail_rusak.id as idd, barang_gudang_detail.id as id_gudang_detail from barang_gudang,barang_gudang_po,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_po.barang_gudang_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and barang_gudang.id=$_GET[id_gudang] and teknisi_id=$_SESSION[id_b] group by barang_gudang_detail_rusak.id order by tgl_po_gudang DESC, barang_gudang_detail_rusak.id DESC LIMIT $start, $limit";
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
			$sql = "select COUNT(DISTINCT barang_gudang_detail_rusak.id) as jml from barang_gudang,barang_gudang_po,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_po.barang_gudang_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and barang_gudang.id=$_GET[id_gudang] and teknisi_id=$_SESSION[id_b] and (no_seri_brg like '%$_GET[cari]%' or kerusakan_alat like '%$_GET[cari]%' or date_format(tgl_input, '%d-%m-%Y') like '%$_GET[cari]%')";
		} else {
			$sql = "select COUNT(DISTINCT barang_gudang_detail_rusak.id) as jml from barang_gudang,barang_gudang_po,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_po.barang_gudang_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and barang_gudang.id=$_GET[id_gudang] and teknisi_id=$_SESSION[id_b]";
		}
		$result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
		echo $result['jml'];
		//tutup koneksi ke database
		mysqli_close($koneksi);
	}
} else {
	if (isset($_GET['start'])) {
		if (isset($_GET['cari'])) {
			$sql = "select *,barang_gudang_detail_rusak.id as idd, barang_gudang_detail.id as id_gudang_detail from barang_gudang,barang_gudang_po,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_po.barang_gudang_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and barang_gudang.id=$_GET[id_gudang] and (no_seri_brg like '%$_GET[cari]%' or kerusakan_alat like '%$_GET[cari]%' or DATE_FORMAT(tgl_input, '%d-%m-%Y') like '%$_GET[cari]%') group by barang_gudang_detail_rusak.id order by tgl_po_gudang DESC, barang_gudang_detail_rusak.id DESC LIMIT $start, $limit";
		} else {
			$sql = "select *,barang_gudang_detail_rusak.id as idd, barang_gudang_detail.id as id_gudang_detail from barang_gudang,barang_gudang_po,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_po.barang_gudang_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and barang_gudang.id=$_GET[id_gudang] group by barang_gudang_detail_rusak.id order by tgl_po_gudang DESC, barang_gudang_detail_rusak.id DESC LIMIT $start, $limit";
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
			$sql = "select COUNT(DISTINCT barang_gudang_detail_rusak.id) as jml from barang_gudang,barang_gudang_po,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_po.barang_gudang_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and barang_gudang.id=$_GET[id_gudang] and (no_seri_brg like '%$_GET[cari]%' or kerusakan_alat like '%$_GET[cari]%' or DATE_FORMAT(tgl_input, '%d-%m-%Y') like '%$_GET[cari]%')";
		} else {
			$sql = "select COUNT(DISTINCT barang_gudang_detail_rusak.id) as jml from barang_gudang,barang_gudang_po,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_po.barang_gudang_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and barang_gudang.id=$_GET[id_gudang]";
		}
	}
	$result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
	echo $result['jml'];
	//tutup koneksi ke database
	mysqli_close($koneksi);
}
