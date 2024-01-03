<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$del2 = mysqli_query($koneksi, "delete barang_dijual_qty_detail, barang_dijual_qty from barang_dijual_qty_detail JOIN barang_dijual_qty ON barang_dijual_qty.id = barang_dijual_qty_detail.barang_dijual_qty_id where barang_dijual_qty.barang_dijual_id=" . $_POST['id_hapus'] . "");
$del3 = mysqli_query($koneksi, "delete from barang_dijual where id=" . $_POST['id_hapus'] . "");
if ($del2 && $del3) {
    echo "S";
} else {
    echo "F";
}