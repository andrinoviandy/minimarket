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
            $sql = "select barang_gudang_detail_rusak.*,barang_gudang_detail_rusak.id as idd, barang_gudang_detail.no_seri_brg, barang_gudang_po.tgl_po_gudang, tb_teknisi.nama_teknisi, barang_gudang_detail.status_kerusakan, barang_gudang_detail.id as id_gudang_detail from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak,tb_teknisi, barang_gudang_po where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and tb_teknisi.id=barang_gudang_detail_rusak.teknisi_id and barang_gudang_po.id = barang_gudang_detail.barang_gudang_po_id and teknisi.id=$_SESSION[id_b] and (nama_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%') order by tgl_input DESC LIMIT $start, $limit";
        } else {
            $sql = "select barang_gudang_detail_rusak.*,barang_gudang_detail_rusak.id as idd, barang_gudang_detail.no_seri_brg, barang_gudang_po.tgl_po_gudang, tb_teknisi.nama_teknisi, barang_gudang_detail.status_kerusakan, barang_gudang_detail.id as id_gudang_detail from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak,tb_teknisi, barang_gudang_po where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and tb_teknisi.id=barang_gudang_detail_rusak.teknisi_id and barang_gudang_po.id = barang_gudang_detail.barang_gudang_po_id and (nama_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%') order by tgl_input DESC LIMIT $start, $limit";
        }
    } else {
        if (isset($_SESSION['id_b'])) {
            $sql = "select barang_gudang_detail_rusak.*,barang_gudang_detail_rusak.id as idd, barang_gudang_detail.no_seri_brg, barang_gudang_po.tgl_po_gudang, tb_teknisi.nama_teknisi, barang_gudang_detail.status_kerusakan, barang_gudang_detail.id as id_gudang_detail from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak,tb_teknisi, barang_gudang_po where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and tb_teknisi.id=barang_gudang_detail_rusak.teknisi_id and barang_gudang_po.id = barang_gudang_detail.barang_gudang_po_id and teknisi.id=$_SESSION[id_b] order by tgl_input DESC LIMIT $start, $limit";
        } else {
            $sql = "select barang_gudang_detail_rusak.*,barang_gudang_detail_rusak.id as idd, barang_gudang_detail.no_seri_brg, barang_gudang_po.tgl_po_gudang, tb_teknisi.nama_teknisi, barang_gudang_detail.status_kerusakan, barang_gudang_detail.id as id_gudang_detail from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak,tb_teknisi, barang_gudang_po where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and tb_teknisi.id=barang_gudang_detail_rusak.teknisi_id and barang_gudang_po.id = barang_gudang_detail.barang_gudang_po_id order by tgl_input DESC LIMIT $start, $limit";
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
            $sql = "select COUNT(DISTINCT barang_gudang_detail_rusak.id) as jml from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak,tb_teknisi, barang_gudang_po where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and tb_teknisi.id=barang_gudang_detail_rusak.teknisi_id and barang_gudang_po.id = barang_gudang_detail.barang_gudang_po_id and teknisi.id=$_SESSION[id_b] and (nama_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%')";
        } else {
            $sql = "select COUNT(DISTINCT barang_gudang_detail_rusak.id) as jml from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak,tb_teknisi, barang_gudang_po where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and tb_teknisi.id=barang_gudang_detail_rusak.teknisi_id and barang_gudang_po.id = barang_gudang_detail.barang_gudang_po_id and (nama_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%')";
        }
    } else {
        if (isset($_SESSION['id_b'])) {
            $sql = "select COUNT(DISTINCT barang_gudang_detail_rusak.id) as jml from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak,tb_teknisi, barang_gudang_po where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and tb_teknisi.id=barang_gudang_detail_rusak.teknisi_id and barang_gudang_po.id = barang_gudang_detail.barang_gudang_po_id and teknisi.id=$_SESSION[id_b]";
        } else {
            $sql = "select COUNT(DISTINCT barang_gudang_detail_rusak.id) as jml from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak,tb_teknisi, barang_gudang_po where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and tb_teknisi.id=barang_gudang_detail_rusak.teknisi_id and barang_gudang_po.id = barang_gudang_detail.barang_gudang_po_id";
        }
    }
    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
//batasssssssssssssss
