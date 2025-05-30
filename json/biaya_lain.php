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

if (isset($_GET['id_keuangan'])) {
	if (isset($_GET['start'])) {
		if (isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
			if (isset($_GET['id'])) {
				$sql = "select a.*,a.id as idd, b.nama_akun from biaya_lain a left join buku_kas b on b.id = a.buku_kas_id where a.buku_kas_id='" . $_GET['id'] . "' and a.keuangan_id=" . $_GET['id_keuangan'] . " and a.tgl between '$_GET[tgl1]' and '$_GET[tgl2]' order by a.tgl DESC, a.id DESC LIMIT $start, $limit";
			} else {
				$sql = "select a.*,a.id as idd, b.nama_akun from biaya_lain a left join buku_kas b on b.id = a.buku_kas_id where a.keuangan_id=" . $_GET['id_keuangan'] . " and a.tgl between '$_GET[tgl1]' and '$_GET[tgl2]' order by a.tgl DESC, a.id DESC LIMIT $start, $limit";
			}
		} else {
			if (isset($_GET['id'])) {
				$sql = "select a.*,a.id as idd, b.nama_akun from biaya_lain a left join buku_kas b on b.id = a.buku_kas_id where a.buku_kas_id='" . $_GET['id'] . "' and a.keuangan_id=" . $_GET['id_keuangan'] . " order by a.tgl DESC, a.id DESC LIMIT $start, $limit";
			} else {
				$sql = "select a.*,a.id as idd, b.nama_akun from biaya_lain a left join buku_kas b on b.id = a.buku_kas_id where a.keuangan_id=" . $_GET['id_keuangan'] . " order by a.tgl DESC, a.id DESC LIMIT $start, $limit";
			}
		}
		$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

		while ($row = mysqli_fetch_assoc($result)) {
			$ArrAnggota[] = $row;
		}

		echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

		//tutup koneksi ke database
		mysqli_close($koneksi);
	} else {
		// untuk jumlah
		if (isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
			if (isset($_GET['id'])) {
				$sql = "select count(*) as jml from biaya_lain where buku_kas_id=" . $_GET['id'] . " and keuangan_id=" . $_GET['id_keuangan'] . " and tgl between '$_GET[tgl1]' and '$_GET[tgl2]'";
			} else {
				$sql = "select count(*) as jml from biaya_lain where keuangan_id=" . $_GET['id_keuangan'] . " and tgl between '$_GET[tgl1]' and '$_GET[tgl2]'";
			}
		} else {
			if (isset($_GET['id'])) {
				$sql = "select count(*) as jml from biaya_lain where buku_kas_id=" . $_GET['id'] . " and keuangan_id=" . $_GET['id_keuangan'] . "";
			} else {
				$sql = "select count(*) as jml from biaya_lain where keuangan_id=" . $_GET['id_keuangan'] . "";
			}
		}
		$result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
		echo $result['jml'];
		//tutup koneksi ke database
		mysqli_close($koneksi);
	}
} else {
	if (isset($_GET['start'])) {
		if (isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
			if (isset($_GET['id'])) {
				if (isset($_GET['cari'])) {
					$sql = "select a.*,a.id as idd, b.nama_akun from biaya_lain a left join buku_kas b on b.id = a.buku_kas_id where a.buku_kas_id='$_GET[id]' and (a.jenis_transaksi like '%$_GET[cari]%' or a.penerima like '%$_GET[cari]%' or a.deskripsi like '%$_GET[cari]%') and a.tgl between '$_GET[tgl1]' and '$_GET[tgl2]' order by a.tgl DESC, a.id DESC LIMIT $start, $limit";
				} else {
					$sql = "select a.*,a.id as idd, b.nama_akun from biaya_lain a left join buku_kas b on b.id = a.buku_kas_id where a.buku_kas_id='$_GET[id]' and a.tgl between '$_GET[tgl1]' and '$_GET[tgl2]' order by a.tgl DESC, a.id DESC LIMIT $start, $limit";
				}
			} else {
				if (isset($_GET['cari'])) {
					$sql = "select a.*,a.id as idd, b.nama_akun from biaya_lain a left join buku_kas b on b.id = a.buku_kas_id where (a.jenis_transaksi like '%$_GET[cari]%' or a.penerima like '%$_GET[cari]%' or a.deskripsi like '%$_GET[cari]%') and a.tgl between '$_GET[tgl1]' and '$_GET[tgl2]' order by a.tgl DESC, a.id DESC LIMIT $start, $limit";
				} else {
					$sql = "select a.*,a.id as idd, b.nama_akun from biaya_lain a left join buku_kas b on b.id = a.buku_kas_id where a.tgl between '$_GET[tgl1]' and '$_GET[tgl2]' order by a.tgl DESC, a.id DESC LIMIT $start, $limit";
				}
			}
		} else {
			if (isset($_GET['id'])) {
				if (isset($_GET['cari'])) {
					$sql = "select *,a.id as idd from biaya_lain a left join buku_kas b on b.id = a.buku_kas_id where a.buku_kas_id='" . $_GET['id'] . "' and (a.jenis_transaksi like '%$_GET[cari]%' or a.penerima like '%$_GET[cari]%' or a.deskripsi like '%$_GET[cari]%') order by a.tgl DESC, a.id DESC LIMIT $start, $limit";
				} else {
					$sql = "select a.*,a.id as idd, b.nama_akun from biaya_lain a left join buku_kas b on b.id = a.buku_kas_id where a.buku_kas_id='" . $_GET['id'] . "' order by a.tgl DESC, a.id DESC LIMIT $start, $limit";
				}
			} else {
				if (isset($_GET['cari'])) {
					$sql = "select a.*,a.id as idd, b.nama_akun from biaya_lain a left join buku_kas b on b.id = a.buku_kas_id where (a.jenis_transaksi like '%$_GET[cari]%' or a.penerima like '%$_GET[cari]%' or a.deskripsi like '%$_GET[cari]%') order by a.tgl DESC, a.id DESC LIMIT $start, $limit";
				} else {
					$sql = "select a.*,a.id as idd, b.nama_akun from biaya_lain a left join buku_kas b on b.id = a.buku_kas_id order by a.tgl DESC, a.id DESC LIMIT $start, $limit";
				}
			}
		}
		$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

		while ($row = mysqli_fetch_assoc($result)) {
			$ArrAnggota[] = $row;
		}

		echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

		//tutup koneksi ke database
		mysqli_close($koneksi);
	} else {
		// untuk jumlah
		if (isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
			if (isset($_GET['id'])) {
				if (isset($_GET['cari'])) {
					$sql = "select COUNT(*) as jml from biaya_lain where buku_kas_id=$_GET[id] and tgl between '$_GET[tgl1]' and '$_GET[tgl2]'";
				} else {
					$sql = "select COUNT(*) as jml from biaya_lain where buku_kas_id=$_GET[id] and tgl between '$_GET[tgl1]' and '$_GET[tgl2]'";
				}
			} else {
				if (isset($_GET['cari'])) {
					$sql = "select COUNT(*) as jml from biaya_lain where tgl between '$_GET[tgl1]' and '$_GET[tgl2]'";
				} else {
					$sql = "select COUNT(*) as jml from biaya_lain where tgl between '$_GET[tgl1]' and '$_GET[tgl2]'";
				}
			}
		} else {
			if (isset($_GET['id'])) {
				if (isset($_GET['cari'])) {
					$sql = "select COUNT(*) as jml from biaya_lain where buku_kas_id=" . $_GET['id'] . "";
				} else {
					$sql = "select COUNT(*) as jml from biaya_lain where buku_kas_id=" . $_GET['id'] . "";
				}
			} else {
				if (isset($_GET['cari'])) {
					$sql = "select COUNT(*) as jml from biaya_lain";
				} else {
					$sql = "select COUNT(*) as jml from biaya_lain";
				}
			}
		}
		$result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
		echo $result['jml'];
		//tutup koneksi ke database
		mysqli_close($koneksi);
	}
}
