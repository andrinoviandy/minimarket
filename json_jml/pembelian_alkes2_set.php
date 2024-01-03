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
 
//menampilkan data dari database, table tb_anggota
// if (isset($_GET['id_keuangan'])) {
// $sql = "select *,barang_pesan_set.id as idd from barang_pesan_set where jenis_po='Luar Negeri' and keuangan_id=$_GET[id_keuangan] order by tgl_po_pesan DESC, barang_pesan_set.id DESC";
// } else {
// $sql = "select *,barang_pesan_set.id as idd from barang_pesan_set where jenis_po='Luar Negeri' order by tgl_po_pesan DESC, barang_pesan_set.id DESC";
// }

if (isset($_GET['start'])) {
    if (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
        if (isset($_GET['cari'])) {
            $sql = "select *,barang_pesan_set.id as idd from barang_pesan_set where jenis_po='Luar Negeri' and (no_po_pesan like '%$_GET[cari]%' or nama_principle like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%') and tgl_po_pesan between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_pesan_set.id order by tgl_po_pesan DESC, barang_pesan_set.id DESC LIMIT $start, $limit";
        } else {
            $sql = "select *,barang_pesan_set.id as idd from barang_pesan_set where jenis_po='Luar Negeri' and tgl_po_pesan between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_pesan_set.id order by tgl_po_pesan DESC, barang_pesan_set.id DESC LIMIT $start, $limit";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select *,barang_pesan_set.id as idd from barang_pesan_set where jenis_po='Luar Negeri' and (no_po_pesan like '%$_GET[cari]%' or nama_principle like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%') group by barang_pesan_set.id order by tgl_po_pesan DESC, barang_pesan_set.id DESC LIMIT $start, $limit";
        } else {
            $sql = "select *,barang_pesan_set.id as idd from barang_pesan_set where jenis_po='Luar Negeri' order by tgl_po_pesan DESC, barang_pesan_set.id DESC LIMIT $start, $limit";
        }
    }
} else {
    //untuk jumlah
    if ($_GET['tgl1'] && $_GET['tgl2']) {
        if (isset($_GET['cari'])) {
            $sql = "select *,barang_pesan_set.id as idd from barang_pesan_set where jenis_po='Luar Negeri' and (no_po_pesan like '%$_GET[cari]%' or nama_principle like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%') and tgl_po_pesan between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_pesan_set.id order by tgl_po_pesan DESC, barang_pesan_set.id DESC";
        } else {
            $sql = "select *,barang_pesan_set.id as idd from barang_pesan_set where jenis_po='Luar Negeri' and tgl_po_pesan between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_pesan_set.id order by tgl_po_pesan DESC, barang_pesan_set.id DESC";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select *,barang_pesan_set.id as idd from barang_pesan_set where jenis_po='Luar Negeri' and (no_po_pesan like '%$_GET[cari]%' or nama_principle like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%') group by barang_pesan_set.id order by tgl_po_pesan DESC, barang_pesan_set.id DESC";
        } else {
            $sql = "select *,barang_pesan_set.id as idd from barang_pesan_set where jenis_po='Luar Negeri' order by tgl_po_pesan DESC, barang_pesan_set.id DESC";
        }
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
?>