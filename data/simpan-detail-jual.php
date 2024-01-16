<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);

// $up = mysqli_query($koneksi, "update barang_dijual_qty_detail JOIN barang_dijual_qty ON barang_dijual_qty.id = barang_dijual_qty_detail.barang_dijual_qty_id set barang_dijual_qty_detail.barang_gudang_id = '".$_POST['id_gudang']."', barang_dijual_qty_detail.jml_satuan='" . $_POST['qty'] . "', barang_dijual_qty_detail.jml_total = barang_dijual_qty.qty_jual*$_POST[qty] where barang_dijual_qty_detail.id=" . $_POST['id'] . "");
$sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_gudang where id = '$_POST[id_gudang]'"));
$sel2 = mysqli_fetch_array(mysqli_query($koneksi, "select qty_jual from barang_dijual_qty where id = '$_POST[id_jual]'"));
$up = mysqli_query($koneksi, "insert into barang_dijual_qty_detail values('','$_POST[id_jual]','$_POST[id_gudang]','$sel[harga_satuan]','$_POST[qty]','".($sel2['qty_jual']*$_POST['qty'])."')");
if ($up) {
    echo "S";
} else {
    echo "F";
}
