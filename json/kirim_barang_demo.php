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
			$sql = "select barang_demo_kirim.*,barang_demo_kirim.id as idd from barang_demo_kirim,barang_demo_kirim_detail,barang_gudang,pembeli,barang_gudang_detail,barang_demo,barang_demo_qty where barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_demo.id=barang_demo_qty.barang_demo_id and barang_demo_qty.id=barang_demo_kirim_detail.barang_demo_qty_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and (nama_paket like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%' or ekspedisi like '%$_GET[cari]%' or keterangan like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or supplier like '%$_GET[cari]%' or deskripsi_kegiatan like '%$_GET[cari]%') and tgl_kirim between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_demo_kirim.id order by tgl_kirim DESC, barang_demo_kirim.id DESC LIMIT $start, $limit";
		} else {
			$sql = "select barang_demo_kirim.*,barang_demo_kirim.id as idd from barang_demo_kirim,barang_demo_kirim_detail,barang_gudang,pembeli,barang_gudang_detail,barang_demo,barang_demo_qty where barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_demo.id=barang_demo_qty.barang_demo_id and barang_demo_qty.id=barang_demo_kirim_detail.barang_demo_qty_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and tgl_kirim between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_demo_kirim.id order by tgl_kirim DESC, barang_demo_kirim.id DESC LIMIT $start, $limit";
		}
	} else {
		if (isset($_GET['cari'])) {
			$sql = "select barang_demo_kirim.*,barang_demo_kirim.id as idd from barang_demo_kirim,barang_demo_kirim_detail,barang_gudang,pembeli,barang_gudang_detail,barang_demo,barang_demo_qty where barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_demo.id=barang_demo_qty.barang_demo_id and barang_demo_qty.id=barang_demo_kirim_detail.barang_demo_qty_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and (nama_paket like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%' or ekspedisi like '%$_GET[cari]%' or keterangan like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or supplier like '%$_GET[cari]%' or deskripsi_kegiatan like '%$_GET[cari]%') group by barang_demo_kirim.id order by tgl_kirim DESC, barang_demo_kirim.id DESC LIMIT $start, $limit";
		} else {
			$sql = "select barang_demo_kirim.*,barang_demo_kirim.id as idd from barang_demo_kirim,barang_demo_kirim_detail,barang_gudang,pembeli,barang_gudang_detail,barang_demo,barang_demo_qty where barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_demo.id=barang_demo_qty.barang_demo_id and barang_demo_qty.id=barang_demo_kirim_detail.barang_demo_qty_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id group by barang_demo_kirim.id order by tgl_kirim DESC, barang_demo_kirim.id DESC LIMIT $start, $limit";
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
			$sql = "select COUNT(DISTINCT barang_demo_kirim.id) as jml from barang_demo_kirim,barang_demo_kirim_detail,barang_gudang,pembeli,barang_gudang_detail,barang_demo,barang_demo_qty where barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_demo.id=barang_demo_qty.barang_demo_id and barang_demo_qty.id=barang_demo_kirim_detail.barang_demo_qty_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and (nama_paket like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%' or ekspedisi like '%$_GET[cari]%' or keterangan like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or supplier like '%$_GET[cari]%' or deskripsi_kegiatan like '%$_GET[cari]%') and tgl_kirim between '$_GET[tgl1]' and '$_GET[tgl2]'";
		} else {
			$sql = "select COUNT(DISTINCT barang_demo_kirim.id) as jml from barang_demo_kirim,barang_demo_kirim_detail,barang_gudang,pembeli,barang_gudang_detail,barang_demo,barang_demo_qty where barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_demo.id=barang_demo_qty.barang_demo_id and barang_demo_qty.id=barang_demo_kirim_detail.barang_demo_qty_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and tgl_kirim between '$_GET[tgl1]' and '$_GET[tgl2]'";
		}
	} else {
		if (isset($_GET['cari'])) {
			$sql = "select COUNT(DISTINCT barang_demo_kirim.id) as jml from barang_demo_kirim,barang_demo_kirim_detail,barang_gudang,pembeli,barang_gudang_detail,barang_demo,barang_demo_qty where barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_demo.id=barang_demo_qty.barang_demo_id and barang_demo_qty.id=barang_demo_kirim_detail.barang_demo_qty_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and (nama_paket like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%' or ekspedisi like '%$_GET[cari]%' or keterangan like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or supplier like '%$_GET[cari]%' or deskripsi_kegiatan like '%$_GET[cari]%')";
		} else {
			$sql = "select COUNT(DISTINCT barang_demo_kirim.id) as jml from barang_demo_kirim,barang_demo_kirim_detail,barang_gudang,pembeli,barang_gudang_detail,barang_demo,barang_demo_qty where barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_demo.id=barang_demo_qty.barang_demo_id and barang_demo_qty.id=barang_demo_kirim_detail.barang_demo_qty_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id";
		}
	}
	$result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
	echo $result['jml'];
	//tutup koneksi ke database
	mysqli_close($koneksi);
}
//menampilkan data dari database, table tb_anggota
// if (isset($_GET['id'])) {
// 	if (isset($_GET['pilihan']) and isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
// 		$sql = "select *,barang_demo_kirim.id as idd from barang_demo_kirim,barang_demo_kirim_detail,barang_gudang,pembeli,barang_gudang_detail,barang_demo,barang_demo_qty where barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_demo.id=barang_demo_qty.barang_demo_id and barang_demo_qty.id=barang_demo_kirim_detail.barang_demo_qty_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and $_GET[pilihan] between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_demo_kirim.id order by tgl_kirim DESC, barang_demo_kirim.id DESC";
// 	} elseif (isset($_GET['kunci']) and isset($_GET['pilihan'])) {
// 		$sql = "select *,barang_demo_kirim.id as idd from barang_demo_kirim,barang_demo_kirim_detail,barang_gudang,pembeli,barang_gudang_detail,barang_demo,barang_demo_qty where barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_demo.id=barang_demo_qty.barang_demo_id and barang_demo_qty.id=barang_demo_kirim_detail.barang_demo_qty_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and $_GET[pilihan] like '%$_GET[kunci]%' group by barang_demo_kirim.id order by tgl_kirim DESC, barang_demo_kirim.id DESC";
// 	} else {
// 		$sql = "select *,barang_demo_kirim.id as idd from barang_demo_kirim where barang_demo_kirim.id=" . $_GET['id'] . " order by barang_demo_kirim.tgl_kirim DESC, barang_demo_kirim.id DESC LIMIT 100";
// 	}
// } else if (isset($_GET['id_riwayat'])) {
// 	if (isset($_GET['pilihan']) and isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
// 		$sql = "select *,barang_demo_kirim.id as idd from barang_demo_kirim,barang_demo_kirim_detail,barang_gudang,pembeli,barang_gudang_detail,barang_demo,barang_demo_qty where barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_demo.id=barang_demo_qty.barang_demo_id and barang_demo_qty.id=barang_demo_kirim_detail.barang_demo_qty_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and $_GET[pilihan] between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_demo_kirim.id order by tgl_kirim DESC, barang_demo_kirim.id DESC";
// 	} elseif (isset($_GET['kunci']) and isset($_GET['pilihan'])) {
// 		$sql = "select *,barang_demo_kirim.id as idd from barang_demo_kirim,barang_demo_kirim_detail,barang_gudang,pembeli,barang_gudang_detail,barang_demo,barang_demo_qty where barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_demo.id=barang_demo_qty.barang_demo_id and barang_demo_qty.id=barang_demo_kirim_detail.barang_demo_qty_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and $_GET[pilihan] like '%$_GET[kunci]%' group by barang_demo_kirim.id order by tgl_kirim DESC, barang_demo_kirim.id DESC";
// 	} else {
// 		$sql = "select *,barang_demo_kirim.id as idd from barang_demo_kirim where barang_demo_kirim.id=" . $_GET['id_riwayat'] . " order by tgl_kirim DESC, barang_demo_kirim.id DESC LIMIT 100";
// 	}
// } else {
// 	if (isset($_GET['pilihan']) and isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
// 		$sql = "select *,barang_demo_kirim.id as idd from barang_demo_kirim,barang_demo_kirim_detail,barang_gudang,pembeli,barang_gudang_detail,barang_demo,barang_demo_qty where barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_demo.id=barang_demo_qty.barang_demo_id and barang_demo_qty.id=barang_demo_kirim_detail.barang_demo_qty_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and $_GET[pilihan] between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_demo_kirim.id order by tgl_kirim DESC, barang_demo_kirim.id DESC";
// 	} elseif (isset($_GET['kunci']) and isset($_GET['pilihan'])) {
// 		$sql = "select *,barang_demo_kirim.id as idd from barang_demo_kirim,barang_demo_kirim_detail,barang_gudang,pembeli,barang_gudang_detail,barang_demo,barang_demo_qty where barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_demo.id=barang_demo_qty.barang_demo_id and barang_demo_qty.id=barang_demo_kirim_detail.barang_demo_qty_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and $_GET[pilihan] like '%$_GET[kunci]%' group by barang_demo_kirim.id order by tgl_kirim DESC, barang_demo_kirim.id DESC";
// 	} else {
// 		$sql = "select *,barang_demo_kirim.id as idd from barang_demo_kirim order by barang_demo_kirim.tgl_kirim DESC, barang_demo_kirim.id DESC LIMIT 100";
// 	}
// }
