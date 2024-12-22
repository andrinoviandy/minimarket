<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
$q3 = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_gudang_detail where id=" . $_POST['id_gudang_detail'] . ""));
if ($q3['status_kerusakan'] == 0) {
    $up3 = mysqli_query($koneksi, "update barang_gudang_detail,barang_gudang set status_kerusakan=" . $_POST['status'] . ",stok_total=stok_total-1 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=" . $_POST['id_gudang_detail'] . "");
}
if ($q3['status_kerusakan'] == 1) {
    if ($_POST['status'] == 0) {
        $up3 = mysqli_query($koneksi, "update barang_gudang_detail,barang_gudang set status_kerusakan=" . $_POST['status'] . ",stok_total=stok_total+1 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=" . $_POST['id_gudang_detail'] . "");
    } else {
        $up3 = mysqli_query($koneksi, "update barang_gudang_detail,barang_gudang set status_kerusakan=" . $_POST['status'] . " where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=" . $_POST['id_gudang_detail'] . "");
    }
}
if ($q3['status_kerusakan'] == 2) {
    if ($_POST['status'] == 0) {
        $up3 = mysqli_query($koneksi, "update barang_gudang_detail,barang_gudang set status_kerusakan=" . $_POST['status'] . ",stok_total=stok_total+1 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=" . $_POST['id_gudang_detail'] . "");
    } else {
        $up3 = mysqli_query($koneksi, "update barang_gudang_detail,barang_gudang set status_kerusakan=" . $_POST['status'] . " where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=" . $_POST['id_gudang_detail'] . "");
    }
}
if ($up3) {
    echo "S";
} else {
    echo "F";
}
