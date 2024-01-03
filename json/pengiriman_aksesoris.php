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
			$sql = "select *,aksesoris_kirim.id as idd from aksesoris_kirim,aksesoris_jual,aksesoris_jual_qty,aksesoris_kirim_detail,aksesoris_detail,pembeli where aksesoris_kirim.id=aksesoris_kirim_detail.aksesoris_kirim_id and aksesoris_jual_qty.id=aksesoris_kirim_detail.aksesoris_jual_qty_id and aksesoris_jual.id=aksesoris_jual_qty.aksesoris_jual_id and aksesoris_detail.id=aksesoris_kirim_detail.aksesoris_detail_id and pembeli.id=aksesoris_jual.pembeli_id and (date_format(tgl_kirim_akse, '%d-%m-%Y') like '%$_GET[cari]%' or no_po_jual_akse like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or marketing_akse like '%$_GET[cari]%' or subdis_akse like '%$_GET[cari]%' or po_no_akse like '%$_GET[cari]%' or no_pengiriman_akse like '%$_GET[cari]%' or nama_paket_akse like '%$_GET[cari]%') and tgl_kirim_akse between '$_GET[tgl1]' and '$_GET[tgl2]' group by aksesoris_kirim.id order by tgl_kirim_akse DESC, aksesoris_kirim.id DESC LIMIT $start, $limit";
		} else {
			$sql = "select *,aksesoris_kirim.id as idd from aksesoris_kirim and tgl_kirim_akse between '$_GET[tgl1]' and '$_GET[tgl2]' order by aksesoris_kirim.tgl_kirim_akse DESC, aksesoris_kirim.id DESC LIMIT $start, $limit";
		}
	} else {
		if (isset($_GET['cari'])) {
			$sql = "select *,aksesoris_kirim.id as idd from aksesoris_kirim,aksesoris_jual,aksesoris_jual_qty,aksesoris_kirim_detail,aksesoris_detail,pembeli where aksesoris_kirim.id=aksesoris_kirim_detail.aksesoris_kirim_id and aksesoris_jual_qty.id=aksesoris_kirim_detail.aksesoris_jual_qty_id and aksesoris_jual.id=aksesoris_jual_qty.aksesoris_jual_id and aksesoris_detail.id=aksesoris_kirim_detail.aksesoris_detail_id and pembeli.id=aksesoris_jual.pembeli_id and (date_format(tgl_kirim_akse, '%d-%m-%Y') like '%$_GET[cari]%' or no_po_jual_akse like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or marketing_akse like '%$_GET[cari]%' or subdis_akse like '%$_GET[cari]%' or po_no_akse like '%$_GET[cari]%' or no_pengiriman_akse like '%$_GET[cari]%' or nama_paket_akse like '%$_GET[cari]%') group by aksesoris_kirim.id order by tgl_kirim_akse DESC, aksesoris_kirim.id DESC LIMIT $start, $limit";
		} else {
			$sql = "select *,aksesoris_kirim.id as idd from aksesoris_kirim order by aksesoris_kirim.tgl_kirim_akse DESC, aksesoris_kirim.id DESC LIMIT $start, $limit";
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
	if ($_GET['tgl1'] && $_GET['tgl2']) {
		if (isset($_GET['cari'])) {
			$sql = "select COUNT(DISTINCT aksesoris_kirim.id) as jml from aksesoris_kirim,aksesoris_jual,aksesoris_jual_qty,aksesoris_kirim_detail,aksesoris_detail,pembeli where aksesoris_kirim.id=aksesoris_kirim_detail.aksesoris_kirim_id and aksesoris_jual_qty.id=aksesoris_kirim_detail.aksesoris_jual_qty_id and aksesoris_jual.id=aksesoris_jual_qty.aksesoris_jual_id and aksesoris_detail.id=aksesoris_kirim_detail.aksesoris_detail_id and pembeli.id=aksesoris_jual.pembeli_id and (date_format(tgl_kirim_akse, '%d-%m-%Y') like '%$_GET[cari]%' or no_po_jual_akse like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or marketing_akse like '%$_GET[cari]%' or subdis_akse like '%$_GET[cari]%' or po_no_akse like '%$_GET[cari]%' or no_pengiriman_akse like '%$_GET[cari]%' or nama_paket_akse like '%$_GET[cari]%') and tgl_kirim_akse between '$_GET[tgl1]' and '$_GET[tgl2]'";
		} else {
			$sql = "select COUNT(DISTINCT aksesoris_kirim.id) as jml from aksesoris_kirim and tgl_kirim_akse between '$_GET[tgl1]' and '$_GET[tgl2]'";
		}
	} else {
		if (isset($_GET['cari'])) {
			$sql = "select COUNT(DISTINCT aksesoris_kirim.id) as jml from aksesoris_kirim,aksesoris_jual,aksesoris_jual_qty,aksesoris_kirim_detail,aksesoris_detail,pembeli where aksesoris_kirim.id=aksesoris_kirim_detail.aksesoris_kirim_id and aksesoris_jual_qty.id=aksesoris_kirim_detail.aksesoris_jual_qty_id and aksesoris_jual.id=aksesoris_jual_qty.aksesoris_jual_id and aksesoris_detail.id=aksesoris_kirim_detail.aksesoris_detail_id and pembeli.id=aksesoris_jual.pembeli_id and (date_format(tgl_kirim_akse, '%d-%m-%Y') like '%$_GET[cari]%' or no_po_jual_akse like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or marketing_akse like '%$_GET[cari]%' or subdis_akse like '%$_GET[cari]%' or po_no_akse like '%$_GET[cari]%' or no_pengiriman_akse like '%$_GET[cari]%' or nama_paket_akse like '%$_GET[cari]%')";
		} else {
			$sql = "select COUNT(DISTINCT aksesoris_kirim.id) as jml from aksesoris_kirim";
		}
	}
	$result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
	echo $result['jml'];
	//tutup koneksi ke database
	mysqli_close($koneksi);
}
//menampilkan data dari database, table tb_anggota
// if (isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
// $sql = "select *,aksesoris_kirim.id as idd from aksesoris_kirim,aksesoris_jual,aksesoris_jual_qty,aksesoris_kirim_detail where aksesoris_kirim.id=aksesoris_kirim_detail.aksesoris_kirim_id and aksesoris_jual_qty.id=aksesoris_kirim_detail.aksesoris_jual_qty_id and aksesoris_jual.id=aksesoris_jual_qty.aksesoris_jual_id and tgl_kirim_akse between '$_GET[tgl1]' and '$_GET[tgl2]' group by aksesoris_kirim.id order by tgl_kirim_akse DESC, aksesoris_kirim.id DESC LIMIT $curr, $limit";
// }
// elseif (isset($_GET['kunci']) and isset($_GET['pilihan'])) {
// $sql = "select *,aksesoris_kirim.id as idd from aksesoris_kirim,aksesoris_jual,aksesoris_jual_qty,aksesoris_kirim_detail,aksesoris_detail,pembeli where aksesoris_kirim.id=aksesoris_kirim_detail.aksesoris_kirim_id and aksesoris_jual_qty.id=aksesoris_kirim_detail.aksesoris_jual_qty_id and aksesoris_jual.id=aksesoris_jual_qty.aksesoris_jual_id and aksesoris_detail.id=aksesoris_kirim_detail.aksesoris_detail_id and pembeli.id=aksesoris_jual.pembeli_id and $_GET[pilihan] like '%$_GET[kunci]%' group by aksesoris_kirim.id order by tgl_kirim_akse DESC, aksesoris_kirim.id DESC LIMIT $curr, $limit";
// } else {
// $sql = "select *,aksesoris_kirim.id as idd from aksesoris_kirim order by aksesoris_kirim.tgl_kirim_akse DESC, aksesoris_kirim.id DESC LIMIT $curr, $limit";
// }
