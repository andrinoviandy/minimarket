<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$sel = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dikirim_detail where barang_gudang_detail_id=" . $_POST['id_hapus'] . ""));
if ($sel == 0) {
    $up = mysqli_query($koneksi, "update barang_gudang set stok_total=stok_total-1 where id=" . $_POST['id'] . "");

    $lihat_stok = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_gudang_po where id=" . $_POST['id_po'] . ""));
    if ($lihat_stok['stok'] < 2) {
        $upd = mysqli_query($koneksi, "delete from barang_gudang_po where id=" . $_POST['id_po'] . "");
    } else {
        $upd = mysqli_query($koneksi, "update barang_gudang_po set stok=stok-1 where id=" . $_POST['id_po'] . "");
    }
    if ($up or $upd) {
        $del = mysqli_query($koneksi, "delete from barang_gudang_detail where id=" . $_POST['id_hapus'] . "");
        echo "S";
    } else {
        echo "F";
    }
} else {
    echo "L";
}
