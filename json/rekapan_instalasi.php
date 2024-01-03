<?php
error_reporting(0);
header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");
mysqli_set_charset($koneksi, 'utf8');

$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;
$start = mysqli_real_escape_string($koneksi, $_GET['start']);

//menampilkan data dari database, table tb_anggota
if (isset($_GET['start'])) {
	if (isset($_GET['merk'])) {
		if ($_GET['merk'] == 'all') {
			if (isset($_GET['cari'])) {
				$sql = "select *,barang_teknisi_detail.id as idd from barang_teknisi,barang_teknisi_detail, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and tgl_spk between '$_GET[tgl1]' and '$_GET[tgl2]' and (no_spk like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or jalan like '%$_GET[cari]%') group by no_seri_brg order by tgl_spk DESC, no_spk DESC LIMIT $start, $limit";
			} else {
				$sql = "select *,barang_teknisi_detail.id as idd from barang_teknisi,barang_teknisi_detail, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and tgl_spk between '$_GET[tgl1]' and '$_GET[tgl2]' group by no_seri_brg order by tgl_spk DESC, no_spk DESC LIMIT $start, $limit";
			}
		} else {
			if (isset($_GET['cari'])) {
				$sql = "select *,barang_teknisi_detail.id as idd from barang_teknisi,barang_teknisi_detail, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and tgl_spk between '$_GET[tgl1]' and '$_GET[tgl2]' and (no_spk like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or jalan like '%$_GET[cari]%') and barang_gudang.merk_brg='" . $_GET['merk'] . "' group by no_seri_brg order by tgl_spk DESC, no_spk DESC LIMIT $start, $limit";
			} else {
				$sql = "select *,barang_teknisi_detail.id as idd from barang_teknisi,barang_teknisi_detail, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and tgl_spk between '$_GET[tgl1]' and '$_GET[tgl2]' and barang_gudang.merk_brg='" . $_GET['merk'] . "' group by no_seri_brg order by tgl_spk DESC, no_spk DESC LIMIT $start, $limit";
			}
		}
	} else {
		if (isset($_GET['cari'])) {
			$sql = "select *,barang_teknisi_detail.id as idd from barang_teknisi,barang_teknisi_detail, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and (no_spk like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or jalan like '%$_GET[cari]%') group by no_seri_brg order by tgl_spk DESC, no_spk DESC LIMIT $start, $limit";
		} else {
			$sql = "select *,barang_teknisi_detail.id as idd from barang_teknisi,barang_teknisi_detail, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id group by no_seri_brg order by tgl_spk DESC, no_spk DESC LIMIT $start, $limit";
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
	// untuk jumlah
	if (isset($_GET['merk'])) {
		if ($_GET['merk'] == 'all') {
			if (isset($_GET['cari'])) {
				$sql = "select COUNT(DISTINCT no_seri_brg) as jml from barang_teknisi,barang_teknisi_detail, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and tgl_spk between '$_GET[tgl1]' and '$_GET[tgl2]' and (no_spk like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or jalan like '%$_GET[cari]%')";
			} else {
				$sql = "select COUNT(DISTINCT no_seri_brg) as jml from barang_teknisi,barang_teknisi_detail, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and tgl_spk between '$_GET[tgl1]' and '$_GET[tgl2]'";
			}
		} else {
			if (isset($_GET['cari'])) {
				$sql = "select COUNT(DISTINCT no_seri_brg) as jml from barang_teknisi,barang_teknisi_detail, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and tgl_spk between '$_GET[tgl1]' and '$_GET[tgl2]' and (no_spk like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or jalan like '%$_GET[cari]%') and barang_gudang.merk_brg='" . $_GET['merk'] . "'";
			} else {
				$sql = "select COUNT(DISTINCT no_seri_brg) as jml from barang_teknisi,barang_teknisi_detail, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and tgl_spk between '$_GET[tgl1]' and '$_GET[tgl2]' and barang_gudang.merk_brg='" . $_GET['merk'] . "'";
			}
		}
	} else {
		if (isset($_GET['cari'])) {
			$sql = "select COUNT(DISTINCT no_seri_brg) as jml from barang_teknisi,barang_teknisi_detail, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and (no_spk like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or jalan like '%$_GET[cari]%')";
		} else {
			$sql = "select COUNT(DISTINCT no_seri_brg) as jml from barang_teknisi,barang_teknisi_detail, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id";
		}
	}
	$result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
	echo $result['jml'];
	//tutup koneksi ke database
	mysqli_close($koneksi);
}
