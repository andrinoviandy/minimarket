<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$del = mysqli_query($koneksi, "delete from barang_dijual_qty_detail_hash where barang_dijual_qty_hash_id=" . $_POST['id_hapus'] . "");
$del2 = mysqli_query($koneksi, "delete from barang_dijual_qty_hash where id=" . $_POST['id_hapus'] . "");
$tot = mysqli_fetch_array(mysqli_query($koneksi, "select sum(okr) as tot_okr from barang_dijual_qty_hash where akun_id=" . $_SESSION['id'] . ""));
$_SESSION['ongkir'] = $tot['tot_okr'];
if ($del && $del2) {
    echo "S";
} else {
    echo "F";
}
