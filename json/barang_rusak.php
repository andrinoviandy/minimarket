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
if (isset($_SESSION['id_b'])) {
	if (isset($_GET['start'])) {
		if (isset($_GET['cari'])) {
			$sql = "select *,barang_gudang.id as id_gudang from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and teknisi_id=$_SESSION[id_b] and (nama_brg like '%$_GET[cari]%' or nie_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or negara_asal like '%$_GET[cari]%') group by nama_brg order by nama_brg ASC LIMIT $start, $limit";
		} else {
			$sql = "select *,barang_gudang.id as id_gudang from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and teknisi_id=$_SESSION[id_b] group by nama_brg order by nama_brg ASC LIMIT $start, $limit";
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
			$sql = "select COUNT(DISTINCT barang_gudang.id) as jml from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and teknisi_id=$_SESSION[id_b] and (nama_brg like '%$_GET[cari]%' or nie_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or negara_asal like '%$_GET[cari]%')";
		} else {
			$sql = "select COUNT(DISTINCT barang_gudang.id) as jml from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and teknisi_id=$_SESSION[id_b]";
		}
		$result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
		echo $result['jml'];
		//tutup koneksi ke database
		mysqli_close($koneksi);
	}
} else {
	if (isset($_GET['start'])) {
		if (isset($_GET['cari'])) {
			$sql = "select *,barang_gudang.id as id_gudang from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and (nama_brg like '%$_GET[cari]%' or nie_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or negara_asal like '%$_GET[cari]%') group by nama_brg order by nama_brg ASC LIMIT $start, $limit";
		} else {
			$sql = "select *,barang_gudang.id as id_gudang from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id group by nama_brg order by nama_brg ASC LIMIT $start, $limit";
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
			$sql = "select COUNT(DISTINCT barang_gudang.id) as jml from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and (nama_brg nie_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or negara_asal like '%$_GET[cari]%')";
		} else {
			$sql = "select COUNT(DISTINCT barang_gudang.id) as jml from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id";
		}
		$result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
		echo $result['jml'];
		//tutup koneksi ke database
		mysqli_close($koneksi);
	}
}
//menampilkan data dari database, table tb_anggota

// if (isset($_SESSION['id_b'])) {
// 	if (isset($_POST['button_lihat'])) {
// 		if ($_POST['merk'] == 'all') {
// 			$query = mysqli_query($koneksi, "select *,barang_gudang.id as id_gudang from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and teknisi_id=$_SESSION[id_b] group by nama_brg order by nama_brg ASC");
// 		} else {
// 			$query = mysqli_query($koneksi, "select *,barang_gudang.id as id_gudang from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and merk_brg='" . $_POST['merk'] . "' and teknisi_id=$_SESSION[id_b] group by nama_brg order by nama_brg ASC");
// 		}
// 	} else {
// 		$query = mysqli_query($koneksi, "select *,barang_gudang.id as id_gudang from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and teknisi_id=$_SESSION[id_b] group by nama_brg order by nama_brg ASC");
// 	}
// } else {
// 	if (isset($_POST['button_lihat'])) {
// 		if ($_POST['merk'] == 'all') {
// 			$query = mysqli_query($koneksi, "select *,barang_gudang.id as id_gudang from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id group by nama_brg order by nama_brg ASC");
// 		} else {
// 			$query = mysqli_query($koneksi, "select *,barang_gudang.id as id_gudang from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and merk_brg='" . $_POST['merk'] . "' group by nama_brg order by nama_brg ASC");
// 		}
// 	} else {
// 		$query = mysqli_query($koneksi, "select *,barang_gudang.id as id_gudang from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id group by nama_brg order by nama_brg ASC");
// 	}
// 	//$query = mysqli_query($koneksi, "select *,barang_gudang.id as idd from barang_gudang order by id ".$limiter['urut']." LIMIT ".$limiter['limiter']."");
// }
//dnaksndknaskdansds
// if (isset($_GET['id_b'])) {
// 	$sql = "select *,barang_gudang_detail_rusak.id as idd, barang_gudang_detail.id as id_gudang_detail from barang_gudang,barang_gudang_po,barang_gudang_detail,barang_gudang_detail_rusak,tb_teknisi where barang_gudang.id=barang_gudang_po.barang_gudang_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and barang_gudang.id=$_GET[id_gudang] and tb_teknisi.id=barang_gudang_detail_rusak.teknisi_id and teknisi_id=$_GET[id_b] group by barang_gudang_detail_rusak.id order by tgl_po_gudang DESC, barang_gudang_detail_rusak.id DESC";
// } else {
// 	$sql = "select *,barang_gudang_detail_rusak.id as idd, barang_gudang_detail.id as id_gudang_detail from barang_gudang,barang_gudang_po,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_po.barang_gudang_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and barang_gudang.id=$_GET[id_gudang] group by barang_gudang_detail_rusak.id order by tgl_po_gudang DESC, barang_gudang_detail_rusak.id DESC";
// }
