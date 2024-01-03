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
			$sql = "select *,barang_pinjam_kirim.id as idd from barang_pinjam_kirim,barang_pinjam_kirim_detail,barang_gudang,pembeli,barang_gudang_detail where barang_pinjam_kirim.id=barang_pinjam_kirim_detail.barang_pinjam_kirim_id and barang_gudang_detail.id=barang_pinjam_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and pembeli.id=barang_pinjam_kirim.pembeli_id and (no_pengiriman like '%$_GET[cari]%' or nama_paket like '%$_GET[cari]%' or keterangan like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%') and tgl_kirim between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_pinjam_kirim.id order by tgl_kirim DESC,barang_pinjam_kirim.id DESC LIMIT $start, $limit";
		} else {
			$sql = "select *,barang_pinjam_kirim.id as idd from barang_pinjam_kirim where tgl_kirim between '$_GET[tgl1]' and '$_GET[tgl2]' order by barang_pinjam_kirim.tgl_kirim DESC,barang_pinjam_kirim.id DESC LIMIT $start, $limit";
		}
	} else {
		if (isset($_GET['cari'])) {
			$sql = "select *,barang_pinjam_kirim.id as idd from barang_pinjam_kirim,barang_pinjam_kirim_detail,barang_gudang,pembeli,barang_gudang_detail where barang_pinjam_kirim.id=barang_pinjam_kirim_detail.barang_pinjam_kirim_id and barang_gudang_detail.id=barang_pinjam_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and pembeli.id=barang_pinjam_kirim.pembeli_id and (no_pengiriman like '%$_GET[cari]%' or nama_paket like '%$_GET[cari]%' or keterangan like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%') group by barang_pinjam_kirim.id order by tgl_kirim DESC,barang_pinjam_kirim.id DESC LIMIT $start, $limit";
		} else {
			$sql = "select *,barang_pinjam_kirim.id as idd from barang_pinjam_kirim order by barang_pinjam_kirim.tgl_kirim DESC,barang_pinjam_kirim.id DESC LIMIT $start, $limit";
		}
	}
} else {
	//untuk jumlah
	if ($_GET['tgl1'] && $_GET['tgl2']) {
		if (isset($_GET['cari'])) {
			$sql = "select *,barang_pinjam_kirim.id as idd from barang_pinjam_kirim,barang_pinjam_kirim_detail,barang_gudang,pembeli,barang_gudang_detail where barang_pinjam_kirim.id=barang_pinjam_kirim_detail.barang_pinjam_kirim_id and barang_gudang_detail.id=barang_pinjam_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and pembeli.id=barang_pinjam_kirim.pembeli_id and (no_pengiriman like '%$_GET[cari]%' or nama_paket like '%$_GET[cari]%' or keterangan like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%') and tgl_kirim between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_pinjam_kirim.id order by tgl_kirim DESC,barang_pinjam_kirim.id DESC";
		} else {
			$sql = "select *,barang_pinjam_kirim.id as idd from barang_pinjam_kirim where tgl_kirim between '$_GET[tgl1]' and '$_GET[tgl2]' order by barang_pinjam_kirim.tgl_kirim DESC,barang_pinjam_kirim.id DESC";
		}
	} else {
		if (isset($_GET['cari'])) {
			$sql = "select *,barang_pinjam_kirim.id as idd from barang_pinjam_kirim,barang_pinjam_kirim_detail,barang_gudang,pembeli,barang_gudang_detail where barang_pinjam_kirim.id=barang_pinjam_kirim_detail.barang_pinjam_kirim_id and barang_gudang_detail.id=barang_pinjam_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and pembeli.id=barang_pinjam_kirim.pembeli_id and (no_pengiriman like '%$_GET[cari]%' or nama_paket like '%$_GET[cari]%' or keterangan like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%') group by barang_pinjam_kirim.id order by tgl_kirim DESC,barang_pinjam_kirim.id DESC";
		} else {
			$sql = "select *,barang_pinjam_kirim.id as idd from barang_pinjam_kirim order by barang_pinjam_kirim.tgl_kirim DESC,barang_pinjam_kirim.id DESC";
		}
	}
}
//menampilkan data dari database, table tb_anggota
// if (isset($_GET['id'])) {
// 	if (isset($_GET['pilihan']) and isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
// 		$sql = "select *,barang_pinjam_kirim.id as idd from barang_pinjam_kirim,barang_pinjam_kirim_detail,barang_gudang,pembeli,barang_gudang_detail where barang_pinjam_kirim.id=barang_pinjam_kirim_detail.barang_pinjam_kirim_id and barang_gudang_detail.id=barang_pinjam_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and pembeli.id=barang_pinjam_kirim.pembeli_id and $_GET[pilihan] between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_pinjam_kirim.id order by tgl_kirim DESC,barang_pinjam_kirim.id DESC";
// 	} elseif (isset($_GET['kunci']) and isset($_GET['pilihan'])) {
// 		$sql = "select *,barang_pinjam_kirim.id as idd from barang_pinjam_kirim,barang_pinjam_kirim_detail,barang_gudang,pembeli,barang_gudang_detail where barang_pinjam_kirim.id=barang_pinjam_kirim_detail.barang_pinjam_kirim_id and barang_gudang_detail.id=barang_pinjam_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and pembeli.id=barang_pinjam_kirim.pembeli_id and $_GET[pilihan] like '%$_GET[kunci]%' group by barang_pinjam_kirim.id order by tgl_kirim DESC,barang_pinjam_kirim.id DESC";
// 	} else {
// 		$sql = "select *,barang_pinjam_kirim.id as idd from barang_pinjam_kirim where barang_pinjam_kirim.id=" . $_GET['id'] . " order by barang_pinjam_kirim.tgl_kirim DESC,barang_pinjam_kirim.id DESC LIMIT 100";
// 	}
// } else if (isset($_GET['id_riwayat'])) {
// 	if (isset($_GET['pilihan']) and isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
// 		$sql = "select *,barang_pinjam_kirim.id as idd from barang_pinjam_kirim,barang_pinjam_kirim_detail,barang_gudang,pembeli,barang_gudang_detail where barang_pinjam_kirim.id=barang_pinjam_kirim_detail.barang_pinjam_kirim_id and barang_gudang_detail.id=barang_pinjam_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and pembeli.id=barang_pinjam_kirim.pembeli_id and $_GET[pilihan] between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_pinjam_kirim.id order by tgl_kirim DESC,barang_pinjam_kirim.id DESC";
// 	} elseif (isset($_GET['kunci']) and isset($_GET['pilihan'])) {
// 		$sql = "select *,barang_pinjam_kirim.id as idd from barang_pinjam_kirim,barang_pinjam_kirim_detail,barang_gudang,pembeli,barang_gudang_detail where barang_pinjam_kirim.id=barang_pinjam_kirim_detail.barang_pinjam_kirim_id and barang_gudang_detail.id=barang_pinjam_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and pembeli.id=barang_pinjam_kirim.pembeli_id and $_GET[pilihan] like '%$_GET[kunci]%' group by barang_pinjam_kirim.id order by tgl_kirim DESC,barang_pinjam_kirim.id DESC";
// 	} else {
// 		$sql = "select *,barang_pinjam_kirim.id as idd from barang_pinjam_kirim where barang_pinjam_kirim.id=" . $_GET['id_riwayat'] . " order by tgl_kirim DESC,barang_pinjam_kirim.id DESC LIMIT 100";
// 	}
// } else {
// 	if (isset($_GET['pilihan']) and isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
// 		$sql = "select *,barang_pinjam_kirim.id as idd from barang_pinjam_kirim,barang_pinjam_kirim_detail,barang_gudang,pembeli,barang_gudang_detail where barang_pinjam_kirim.id=barang_pinjam_kirim_detail.barang_pinjam_kirim_id and barang_gudang_detail.id=barang_pinjam_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and pembeli.id=barang_pinjam_kirim.pembeli_id and $_GET[pilihan] between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_pinjam_kirim.id order by tgl_kirim DESC,barang_pinjam_kirim.id DESC";
// 	} elseif (isset($_GET['kunci']) and isset($_GET['pilihan'])) {
// 		$sql = "select *,barang_pinjam_kirim.id as idd from barang_pinjam_kirim,barang_pinjam_kirim_detail,barang_gudang,pembeli,barang_gudang_detail where barang_pinjam_kirim.id=barang_pinjam_kirim_detail.barang_pinjam_kirim_id and barang_gudang_detail.id=barang_pinjam_kirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and pembeli.id=barang_pinjam_kirim.pembeli_id and $_GET[pilihan] like '%$_GET[kunci]%' group by barang_pinjam_kirim.id order by tgl_kirim DESC,barang_pinjam_kirim.id DESC";
// 	} else {
// 		$sql = "select *,barang_pinjam_kirim.id as idd from barang_pinjam_kirim order by barang_pinjam_kirim.tgl_kirim DESC,barang_pinjam_kirim.id DESC LIMIT 100";
// 	}
// }
$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

//membuat array
while ($row = mysqli_fetch_assoc($result)) {
	$ArrAnggota[] = $row;
}

echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

//tutup koneksi ke database
mysqli_close($koneksi);
