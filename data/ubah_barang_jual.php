<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$simpan = mysqli_query($koneksi, "update barang_dijual_qty_hash JOIN barang_dijual_qty_detail_hash ON barang_dijual_qty_hash.id = barang_dijual_qty_detail_hash.barang_dijual_qty_hash_id set barang_dijual_qty_hash.qty = '" . $_POST['qty'] . "', barang_dijual_qty_hash.harga_jual_saat_itu = '" . str_replace(".","",$_POST['harga']) . "', barang_dijual_qty_detail_hash.jml_total = barang_dijual_qty_detail_hash.jml_satuan*$_POST[qty] where barang_dijual_qty_hash.id = $_POST[id]");
if ($simpan) {
    echo "S";
} else {
    echo "F";
}
