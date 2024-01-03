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
if (isset($_GET['start'])) {
    if (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
        if (isset($_GET['cari'])) {
            $sql = "select *,barang_pesan.id as idd from barang_pesan,barang_pesan_detail,barang_gudang,principle where barang_pesan.id=barang_pesan_detail.barang_pesan_id and barang_gudang.id=barang_pesan_detail.barang_gudang_id and principle.id=barang_pesan.principle_id and barang_pesan.jenis_po='Luar Negeri' and (no_po_pesan like '%$_GET[cari]%' or nama_principle like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%') and tgl_po_pesan between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_pesan.id order by tgl_po_pesan DESC, barang_pesan.id DESC LIMIT $start, $limit";
        } else {
            $sql = "select *,barang_pesan.id as idd from barang_pesan,barang_pesan_detail,barang_gudang,principle where barang_pesan.id=barang_pesan_detail.barang_pesan_id and barang_gudang.id=barang_pesan_detail.barang_gudang_id and principle.id=barang_pesan.principle_id and barang_pesan.jenis_po='Luar Negeri' and tgl_po_pesan between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_pesan.id order by tgl_po_pesan DESC, barang_pesan.id DESC LIMIT $start, $limit";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select *,barang_pesan.id as idd from barang_pesan,barang_pesan_detail,barang_gudang,principle where barang_pesan.id=barang_pesan_detail.barang_pesan_id and barang_gudang.id=barang_pesan_detail.barang_gudang_id and principle.id=barang_pesan.principle_id and barang_pesan.jenis_po='Luar Negeri' and (no_po_pesan like '%$_GET[cari]%' or nama_principle like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%') group by barang_pesan.id order by tgl_po_pesan DESC, barang_pesan.id DESC LIMIT $start, $limit";
        } else {
            $sql = "select *,barang_pesan.id as idd from barang_pesan,barang_pesan_detail,barang_gudang,principle where barang_pesan.id=barang_pesan_detail.barang_pesan_id and barang_gudang.id=barang_pesan_detail.barang_gudang_id and principle.id=barang_pesan.principle_id and barang_pesan.jenis_po='Luar Negeri' group by barang_pesan.id order by tgl_po_pesan DESC, barang_pesan.id DESC LIMIT $start, $limit";
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
            $sql = "select COUNT(DISTINCT barang_pesan.id) as jml from barang_pesan,barang_pesan_detail,barang_gudang,principle where barang_pesan.id=barang_pesan_detail.barang_pesan_id and barang_gudang.id=barang_pesan_detail.barang_gudang_id and principle.id=barang_pesan.principle_id and barang_pesan.jenis_po='Luar Negeri' and (no_po_pesan like '%$_GET[cari]%' or nama_principle like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%') and tgl_po_pesan between '$_GET[tgl1]' and '$_GET[tgl2]'";
        } else {
            $sql = "select COUNT(DISTINCT barang_pesan.id) as jml from barang_pesan,barang_pesan_detail,barang_gudang,principle where barang_pesan.id=barang_pesan_detail.barang_pesan_id and barang_gudang.id=barang_pesan_detail.barang_gudang_id and principle.id=barang_pesan.principle_id and barang_pesan.jenis_po='Luar Negeri' and tgl_po_pesan between '$_GET[tgl1]' and '$_GET[tgl2]'";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select COUNT(DISTINCT barang_pesan.id) as jml from barang_pesan,barang_pesan_detail,barang_gudang,principle where barang_pesan.id=barang_pesan_detail.barang_pesan_id and barang_gudang.id=barang_pesan_detail.barang_gudang_id and principle.id=barang_pesan.principle_id and barang_pesan.jenis_po='Luar Negeri' and (no_po_pesan like '%$_GET[cari]%' or nama_principle like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%')";
        } else {
            $sql = "select COUNT(DISTINCT barang_pesan.id) as jml from barang_pesan,barang_pesan_detail,barang_gudang,principle where barang_pesan.id=barang_pesan_detail.barang_pesan_id and barang_gudang.id=barang_pesan_detail.barang_gudang_id and principle.id=barang_pesan.principle_id and barang_pesan.jenis_po='Luar Negeri'";
        }
    }
    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
//batasssssssssssssss
