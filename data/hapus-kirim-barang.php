<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$cek = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dikirim,barang_dikirim_detail,barang_teknisi_detail where barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_dikirim.id=" . $_POST['id_hapus'] . ""));
if ($cek == 0) {
    $up = mysqli_query($koneksi, "update barang_gudang_detail,barang_dikirim_detail set barang_gudang_detail.status_kirim=0 where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_id=" . $_POST['id_hapus'] . "");
    $jml_sel = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dikirim_detail where barang_dikirim_id=" . $_POST['id_hapus'] . ""));
    $up2 = mysqli_query($koneksi, "update barang_gudang,barang_gudang_detail,barang_dikirim_detail set stok_total=stok_total+$jml_sel where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_id=" . $_POST['id_hapus'] . "");
    $del1 = mysqli_query($koneksi, "delete from barang_dikirim_detail where barang_dikirim_id=" . $_POST['id_hapus'] . "");
    $count = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_dikirim_detail where barang_dikirim_id = " . $_POST['id_hapus'] . ""));
    if ($count <= 0) {
        $del2 = mysqli_query($koneksi, "delete from barang_dikirim where id=" . $_POST['id_hapus'] . "");
    }
    if ($up && $up2 && $del1) {
        echo "S";
    } else {
        echo "F";
    }
} else {
    echo "SD";
}
