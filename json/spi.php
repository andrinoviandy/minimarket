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
			$sql = "select *,barang_teknisi.id as idd from barang_dikirim,barang_teknisi,barang_teknisi_detail,barang_dikirim_detail,barang_gudang,barang_gudang_detail,barang_dijual,barang_dijual_qty,pembeli where barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and (no_spk like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%' or barang_dijual.no_po_jual like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%') and tgl_spk between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_teknisi.id order by tgl_spk DESC,no_spk DESC LIMIT $start, $limit";
		} else {
			$sql = "select *,barang_teknisi.id as idd from barang_dikirim,barang_teknisi,barang_teknisi_detail,barang_dikirim_detail,barang_gudang,barang_gudang_detail,barang_dijual,barang_dijual_qty,pembeli where barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and tgl_spk between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_teknisi.id order by tgl_spk DESC,no_spk DESC LIMIT $start, $limit";
		}
	} else {
		if (isset($_GET['cari'])) {
			$sql = "select *,barang_teknisi.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,barang_dikirim,barang_gudang_detail,barang_dikirim_detail,barang_teknisi,barang_teknisi_detail where barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and (no_spk like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%' or barang_dijual.no_po_jual like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%') group by barang_teknisi.id order by tgl_spk DESC, no_spk DESC LIMIT $start, $limit";
		} else {
			$sql = "select *,barang_teknisi.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,barang_dikirim,barang_gudang_detail,barang_dikirim_detail,barang_teknisi,barang_teknisi_detail where barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id group by barang_teknisi.id order by tgl_spk DESC, no_spk DESC LIMIT $start, $limit";
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
			$sql = "select COUNT(DISTINCT barang_teknisi.id) as jml from barang_dikirim,barang_teknisi,barang_teknisi_detail,barang_dikirim_detail,barang_gudang,barang_gudang_detail,barang_dijual,barang_dijual_qty,pembeli where barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and (no_spk like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%' or barang_dijual.no_po_jual like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%') and tgl_spk between '$_GET[tgl1]' and '$_GET[tgl2]'";
		} else {
			$sql = "select COUNT(DISTINCT barang_teknisi.id) as jml from barang_dikirim,barang_teknisi,barang_teknisi_detail,barang_dikirim_detail,barang_gudang,barang_gudang_detail,barang_dijual,barang_dijual_qty,pembeli where barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and tgl_spk between '$_GET[tgl1]' and '$_GET[tgl2]'";
		}
	} else {
		if (isset($_GET['cari'])) {
			$sql = "select COUNT(DISTINCT barang_teknisi.id) as jml from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,barang_dikirim,barang_gudang_detail,barang_dikirim_detail,barang_teknisi,barang_teknisi_detail where barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and (no_spk like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%' or barang_dijual.no_po_jual like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%')";
		} else {
			$sql = "select COUNT(DISTINCT barang_teknisi.id) as jml from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,barang_dikirim,barang_gudang_detail,barang_dikirim_detail,barang_teknisi,barang_teknisi_detail where barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id";
		}
	}
	$result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
	echo $result['jml'];
	//tutup koneksi ke database
	mysqli_close($koneksi);
}

//batasssssssssssssss
