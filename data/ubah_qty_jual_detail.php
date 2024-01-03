<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
// if ($_POST['satuan'] == 'satuan') {
//     $up = mysqli_query($koneksi, "update barang_gudang_detail_akse set qty='" . $_POST['qty'] . "' where id=" . $_POST['id'] . "");
// } else {
//     $up = mysqli_query($koneksi, "update barang_gudang_detail_set set qty='" . $_POST['qty'] . "' where id=" . $_POST['id'] . "");
// }
$up = mysqli_query($koneksi, "update barang_dijual_qty_detail JOIN barang_dijual_qty ON barang_dijual_qty.id = barang_dijual_qty_detail.barang_dijual_qty_id set barang_dijual_qty_detail.jml_satuan='" . $_POST['qty'] . "', barang_dijual_qty_detail.jml_total = barang_dijual_qty.qty_jual*$_POST[qty] where barang_dijual_qty_detail.id=" . $_POST['id'] . "");
if ($up) {
    echo "S";
} else {
    echo "F";
}
