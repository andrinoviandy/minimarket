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
    if (isset($_GET['cari'])) {
        $sql = "select *,barang_kembali_tidak_rusak.id as idd from barang_kembali_tidak_rusak, barang_kembali_tidak_rusak_detail, barang_gudang_detail, barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_kembali_tidak_rusak_detail.barang_gudang_detail_id and barang_kembali_tidak_rusak.id=barang_kembali_tidak_rusak_detail.barang_kembali_tidak_rusak_id and (nama_brg like '%$_GET[cari]%' or nie_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or negara_asal like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or no_po_id like '%$_GET[cari]%') order by tgl_retur DESC, barang_kembali_tidak_rusak.id DESC LIMIT $start, $limit";
    } else {
        $sql = "select *,barang_kembali_tidak_rusak.id as idd from barang_kembali_tidak_rusak order by tgl_retur DESC, barang_kembali_tidak_rusak.id DESC LIMIT $start, $limit";
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
        $sql = "select COUNT(DISTINCT barang_kembali_tidak_rusak.id) as jml from barang_kembali_tidak_rusak, barang_kembali_tidak_rusak_detail, barang_gudang_detail, barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_kembali_tidak_rusak_detail.barang_gudang_detail_id and barang_kembali_tidak_rusak.id=barang_kembali_tidak_rusak_detail.barang_kembali_tidak_rusak_id and (nama_brg like '%$_GET[cari]%' or nie_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or negara_asal like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or no_po_id like '%$_GET[cari]%')";
    } else {
        $sql = "select COUNT(*) as jml from barang_kembali_tidak_rusak";
    }
    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
//menampilkan data dari database, table tb_anggota
// $sql = "select *,barang_kembali_tidak_rusak.id as idd from barang_kembali_tidak_rusak order by tgl_retur DESC, barang_kembali_tidak_rusak.id DESC";
