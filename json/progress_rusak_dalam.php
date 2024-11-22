<?php
error_reporting(0);
header("Content-type:application/json");
session_start();

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
    if (isset($_GET['cari'])) {
        if (isset($_SESSION['id_b'])) {
            $sql = "select *,barang_gudang.id as id_gudang from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak,tb_teknisi where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and tb_teknisi.id=barang_gudang_detail_rusak.teknisi_id and tb_teknisi.id=$_SESSION[id_b] and (nama_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' tipe_brg like '%$_GET[cari]%' negara_asal like '%$_GET[cari]%') group by nama_brg order by nama_brg ASC LIMIT $start, $limit";
        } else {
            $sql = "select *,barang_gudang.id as id_gudang from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak,tb_teknisi where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and tb_teknisi.id=barang_gudang_detail_rusak.teknisi_id and (nama_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' tipe_brg like '%$_GET[cari]%' negara_asal like '%$_GET[cari]%') group by nama_brg order by nama_brg ASC LIMIT $start, $limit";
        }
    } else {
        if (isset($_SESSION['id_b'])) {
            $sql = "select *,barang_gudang.id as id_gudang from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak,tb_teknisi where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and tb_teknisi.id=barang_gudang_detail_rusak.teknisi_id and tb_teknisi.id=$_SESSION[id_b] group by nama_brg order by nama_brg ASC LIMIT $start, $limit";
        } else {
            $sql = "select *,barang_gudang.id as id_gudang from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak,tb_teknisi where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and tb_teknisi.id=barang_gudang_detail_rusak.teknisi_id group by nama_brg order by nama_brg ASC LIMIT $start, $limit";
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
    if (isset($_GET['cari'])) {
        if (isset($_SESSION['id_b'])) {
            $sql = "select COUNT(DISTINCT barang_gudang.id) as jml from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak,tb_teknisi where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and tb_teknisi.id=barang_gudang_detail_rusak.teknisi_id and tb_teknisi.id=$_SESSION[id_b] and (nama_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' tipe_brg like '%$_GET[cari]%' negara_asal like '%$_GET[cari]%')";
        } else {
            $sql = "select COUNT(DISTINCT barang_gudang.id) as jml from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak,tb_teknisi where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and tb_teknisi.id=barang_gudang_detail_rusak.teknisi_id and (nama_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' tipe_brg like '%$_GET[cari]%' negara_asal like '%$_GET[cari]%')";
        }
    } else {
        if (isset($_SESSION['id_b'])) {
            $sql = "select COUNT(DISTINCT barang_gudang.id) as jml from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak,tb_teknisi where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and tb_teknisi.id=barang_gudang_detail_rusak.teknisi_id and tb_teknisi.id=$_SESSION[id_b]";
        } else {
            $sql = "select COUNT(DISTINCT barang_gudang.id) as jml from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak,tb_teknisi where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and tb_teknisi.id=barang_gudang_detail_rusak.teknisi_id";
        }
    }
    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
//batasssssssssssssss
