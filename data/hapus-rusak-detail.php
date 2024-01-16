<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$se = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_gudang_detail_rusak where id=$_POST[id_hapus]"));
$up = mysqli_query($koneksi, "update barang_gudang_detail set status_kerusakan=0 where id=" . $se['barang_gudang_detail_id'] . "");
$up2 = mysqli_query($koneksi, "update barang_gudang_detail,barang_gudang set barang_gudang.stok_total=barang_gudang.stok_total+1 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=" . $se['barang_gudang_detail_id'] . "");
$h = mysqli_query($koneksi, "delete from barang_gudang_detail_rusak where id=$_POST[id_hapus]");
if ($up and $up2 and $h) {
    echo "S";
} else {
    echo "F";
}
