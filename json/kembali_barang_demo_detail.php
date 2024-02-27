<?php

header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");
error_reporting(0);

$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;
$start = mysqli_real_escape_string($koneksi, $_GET['start']);
//menampilkan data dari database, table tb_anggota

if (isset($_GET['start'])) {
    if (isset($_GET['cari'])) {
        $sql = "select *,barang_demo_kembali.id as idd from barang_gudang,barang_gudang_detail,barang_demo_kirim_detail,barang_demo_kembali,barang_demo_kirim where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_demo_kirim_detail.id=barang_demo_kembali.barang_demo_kirim_detail_id and barang_gudang.id=" . $_GET['id_gudang'] . " and (nama_brg like '%$_GET[cari]%' or nie_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%') LIMIT $start, $limit";
    } else {
        $sql = "select *,barang_demo_kembali.id as idd from barang_gudang,barang_gudang_detail,barang_demo_kirim_detail,barang_demo_kembali,barang_demo_kirim where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_demo_kirim_detail.id=barang_demo_kembali.barang_demo_kirim_detail_id and barang_gudang.id=" . $_GET['id_gudang'] . " LIMIT $start, $limit";
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
        $sql = "select COUNT(*) as jml from barang_gudang,barang_gudang_detail,barang_demo_kirim_detail,barang_demo_kembali,barang_demo_kirim where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_demo_kirim_detail.id=barang_demo_kembali.barang_demo_kirim_detail_id and barang_gudang.id=" . $_GET['id_gudang'] . " and (nama_brg like '%$_GET[cari]%' or nie_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%')";
    } else {
        $sql = "select COUNT(*) as jml from barang_gudang,barang_gudang_detail,barang_demo_kirim_detail,barang_demo_kembali,barang_demo_kirim where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_demo_kirim_detail.id=barang_demo_kembali.barang_demo_kirim_detail_id and barang_gudang.id=" . $_GET['id_gudang'] . "";
    }

    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}