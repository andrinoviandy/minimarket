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
	if ($_GET['status'] == 'Tersedia') {
		if (isset($_GET['cari'])) {
			$sql = "select *,barang_gudang_detail.id as idd,barang_gudang_po.id as id_po,barang_gudang_po.stok as stok_masuk from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kirim=0 and status_kerusakan=0 and (TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 or tgl_expired = '0000-00-00') and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . " and (no_po_gudang like '%$_GET[cari]%' or no_lot like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or DATE_FORMAT(tgl_po_gudang, '%d-%m-%Y') like '%$_GET[cari]%' or qrcode like '%$_GET[cari]%') order by no_po_gudang DESC LIMIT $start, $limit";
		} else {
			$sql = "select *,barang_gudang_detail.id as idd,barang_gudang_po.id as id_po,barang_gudang_po.stok as stok_masuk from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kirim=0 and status_kerusakan=0 and (TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 or tgl_expired = '0000-00-00') and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . " order by no_po_gudang DESC LIMIT $start, $limit";
		}
	} else if ($_GET['status'] == 'Terjual') {
		if (isset($_GET['cari'])) {
			$sql = "select *,barang_gudang_detail.id as idd,barang_gudang_po.id as id_po,barang_gudang_po.stok as stok_masuk from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kirim!=0 and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . " and (no_po_gudang like '%$_GET[cari]%' or no_lot like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or DATE_FORMAT(tgl_po_gudang, '%d-%m-%Y') like '%$_GET[cari]%' or qrcode like '%$_GET[cari]%') order by tgl_po_gudang DESC LIMIT $start, $limit";
		} else {
			$sql = "select *,barang_gudang_detail.id as idd,barang_gudang_po.id as id_po,barang_gudang_po.stok as stok_masuk from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kirim!=0 and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . " order by tgl_po_gudang DESC LIMIT $start, $limit";
		}
	} else if ($_GET['status'] == 'Rusak') {
		if (isset($_GET['cari'])) {
			$sql = "select *,barang_gudang_detail.id as idd,barang_gudang_po.id as id_po,barang_gudang_po.stok as stok_masuk from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kerusakan=1 and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . " and (no_po_gudang like '%$_GET[cari]%' or no_lot like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or DATE_FORMAT(tgl_po_gudang, '%d-%m-%Y') like '%$_GET[cari]%' or qrcode like '%$_GET[cari]%') order by no_po_gudang DESC LIMIT $start, $limit";
		} else {
			$sql = "select *,barang_gudang_detail.id as idd,barang_gudang_po.id as id_po,barang_gudang_po.stok as stok_masuk from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kerusakan=1 and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . " order by no_po_gudang DESC LIMIT $start, $limit";
		}
	} else if ($_GET['status'] == 'Tidak_Layak') {
		if (isset($_GET['cari'])) {
			$sql = "select *,barang_gudang_detail.id as idd,barang_gudang_po.id as id_po,barang_gudang_po.stok as stok_masuk from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and (status_kerusakan=2 or (TIMESTAMPDIFF(DAY, NOW(), tgl_expired) < 0 and status_kirim = 0)) and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . " and (no_po_gudang like '%$_GET[cari]%' or no_lot like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or DATE_FORMAT(tgl_po_gudang, '%d-%m-%Y') like '%$_GET[cari]%' or qrcode like '%$_GET[cari]%') order by no_po_gudang DESC LIMIT $start, $limit";
		} else {
			$sql = "select *,barang_gudang_detail.id as idd,barang_gudang_po.id as id_po,barang_gudang_po.stok as stok_masuk from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and (status_kerusakan=2 or (TIMESTAMPDIFF(DAY, NOW(), tgl_expired) < 0 and status_kirim = 0)) and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . " order by no_po_gudang DESC LIMIT $start, $limit";
		}
	} else {
		// if (isset($_GET['cari'])) {
		// 	$sql = "select *,barang_gudang_detail.id as idd,barang_gudang_po.id as id_po,barang_gudang_po.stok as stok_masuk from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kirim=0 and status_kerusakan=0 and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . " and (no_po_gudang like '%$_GET[cari]%' or no_lot like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or tgl_po_gudang like '%$_GET[cari]%' or qrcode like '%$_GET[cari]%') order by no_po_gudang DESC LIMIT $start, $limit";
		// } else {
		// 	$sql = "select *,barang_gudang_detail.id as idd,barang_gudang_po.id as id_po,barang_gudang_po.stok as stok_masuk from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kirim=0 and status_kerusakan=0 and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . " order by no_po_gudang DESC LIMIT $start, $limit";
		// }
		if (isset($_GET['cari'])) {
			$sql = "select *,barang_gudang_detail.id as idd,barang_gudang_po.id as id_po,barang_gudang_po.stok as stok_masuk from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kirim=0 and status_kerusakan=0 and (TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 or tgl_expired = '0000-00-00') and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . " and (no_po_gudang like '%$_GET[cari]%' or no_lot like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or DATE_FORMAT(tgl_po_gudang, '%d-%m-%Y') like '%$_GET[cari]%' or qrcode like '%$_GET[cari]%') order by no_po_gudang DESC LIMIT $start, $limit";
		} else {
			$sql = "select *,barang_gudang_detail.id as idd,barang_gudang_po.id as id_po,barang_gudang_po.stok as stok_masuk from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kirim=0 and status_kerusakan=0 and (TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 or tgl_expired = '0000-00-00') and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . " order by no_po_gudang DESC LIMIT $start, $limit";
		}
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
	if ($_GET['status'] == 'Tersedia') {
		if (isset($_GET['cari'])) {
			$sql = "select COUNT(DISTINCT barang_gudang_detail.id) as jml from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kirim=0 and status_kerusakan=0 and (TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 or tgl_expired = '0000-00-00') and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . " and (no_po_gudang like '%$_GET[cari]%' or no_lot like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or DATE_FORMAT(tgl_po_gudang, '%d-%m-%Y') like '%$_GET[cari]%' or qrcode like '%$_GET[cari]%')";
		} else {
			$sql = "select COUNT(DISTINCT barang_gudang_detail.id) as jml from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kirim=0 and status_kerusakan=0 and (TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 or tgl_expired = '0000-00-00') and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . "";
		}
	} else if ($_GET['status'] == 'Terjual') {
		if (isset($_GET['cari'])) {
			$sql = "select COUNT(DISTINCT barang_gudang_detail.id) as jml from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kirim!=0 and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . " and (no_po_gudang like '%$_GET[cari]%' or no_lot like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or DATE_FORMAT(tgl_po_gudang, '%d-%m-%Y') like '%$_GET[cari]%' or qrcode like '%$_GET[cari]%')";
		} else {
			$sql = "select COUNT(DISTINCT barang_gudang_detail.id) as jml from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kirim!=0 and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . "";
		}
	} else if ($_GET['status'] == 'Rusak') {
		if (isset($_GET['cari'])) {
			$sql = "select COUNT(DISTINCT barang_gudang_detail.id) as jml from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kerusakan=1 and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . " and (no_po_gudang like '%$_GET[cari]%' or no_lot like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or DATE_FORMAT(tgl_po_gudang, '%d-%m-%Y') like '%$_GET[cari]%' or qrcode like '%$_GET[cari]%')";
		} else {
			$sql = "select COUNT(DISTINCT barang_gudang_detail.id) as jml from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kerusakan=1 and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . "";
		}
	} else if ($_GET['status'] == 'Tidak_Layak') {
		if (isset($_GET['cari'])) {
			$sql = "select COUNT(DISTINCT barang_gudang_detail.id) as jml from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and (status_kerusakan=2 or (TIMESTAMPDIFF(DAY, NOW(), tgl_expired) < 0 and status_kirim = 0)) and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . " and (no_po_gudang like '%$_GET[cari]%' or no_lot like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or DATE_FORMAT(tgl_po_gudang, '%d-%m-%Y') like '%$_GET[cari]%' or qrcode like '%$_GET[cari]%')";
		} else {
			$sql = "select COUNT(DISTINCT barang_gudang_detail.id) as jml from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and (status_kerusakan=2 or (TIMESTAMPDIFF(DAY, NOW(), tgl_expired) < 0 and status_kirim = 0)) and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . "";
		}
	} else {
		if (isset($_GET['cari'])) {
			$sql = "select COUNT(DISTINCT barang_gudang_detail.id) as jml from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kirim=0 and status_kerusakan=0 and (TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 or tgl_expired = '0000-00-00') and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . " and (no_po_gudang like '%$_GET[cari]%' or no_lot like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or DATE_FORMAT(tgl_po_gudang, '%d-%m-%Y') like '%$_GET[cari]%' or qrcode like '%$_GET[cari]%')";
		} else {
			$sql = "select COUNT(DISTINCT barang_gudang_detail.id) as jml from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kirim=0 and status_kerusakan=0 and (TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 or tgl_expired = '0000-00-00') and barang_gudang_detail.barang_gudang_id=" . $_GET['id'] . "";
		}
	}
	$result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
	echo $result['jml'];
	//tutup koneksi ke database
	mysqli_close($koneksi);
}
//menampilkan data dari database, table tb_anggota
// if (isset($_GET['kunci']) and isset($_GET['pilihan'])) {
// $sql = "select *,barang_gudang_detail.id as idd,barang_gudang_po.id as id_po,barang_gudang_po.stok as stok_masuk from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kirim=0 and status_kerusakan=0 and barang_gudang_detail.barang_gudang_id=".$_GET['id']." and $_GET[pilihan] like '%$_GET[kunci]%' order by no_po_gudang DESC LIMIT $curr, $limit";
// }
// else {
// $sql = "select *,barang_gudang_detail.id as idd,barang_gudang_po.id as id_po,barang_gudang_po.stok as stok_masuk from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kirim=0 and status_kerusakan=0 and barang_gudang_detail.barang_gudang_id=".$_GET['id']." order by no_po_gudang DESC LIMIT $curr, $limit";
// }
