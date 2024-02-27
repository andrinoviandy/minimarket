<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
$simpan = mysqli_query($koneksi, "update barang_dijual_qty_hash set barang_dijual_qty_hash.qty = '" . $_POST['qty'] . "', barang_dijual_qty_hash.harga_jual_saat_itu = '" . str_replace(".","",$_POST['harga']) . "' where barang_dijual_qty_hash.id = $_POST[id]");
$simpan2 = mysqli_query($koneksi, "update barang_dijual_qty_detail_hash set barang_dijual_qty_detail_hash.jml_total = (barang_dijual_qty_detail_hash.jml_satuan*$_POST[qty]) where barang_dijual_qty_hash_id = $_POST[id]");
if ($simpan && $simpan2) {
    echo "S";
} else {
    echo "F";
}
