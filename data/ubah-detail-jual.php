<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);

$up = mysqli_query($koneksi, "update barang_dijual_qty_detail JOIN barang_dijual_qty ON barang_dijual_qty.id = barang_dijual_qty_detail.barang_dijual_qty_id set barang_dijual_qty_detail.barang_gudang_id = '".$_POST['id_gudang']."', barang_dijual_qty_detail.jml_satuan='" . $_POST['qty'] . "', barang_dijual_qty_detail.jml_total = barang_dijual_qty.qty_jual*$_POST[qty] where barang_dijual_qty_detail.id=" . $_POST['id'] . "");
if ($up) {
    echo "S";
} else {
    echo "F";
}
