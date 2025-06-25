<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
// $sel = mysqli_fetch_array(mysqli_query($koneksi, "select no_po_pesan from barang_pesan where id=" . $_POST['id_hapus'] . ""));
// $del0 = mysqli_query($koneksi, "delete from utang_piutang where no_faktur_no_po='" . $sel['no_po_pesan'] . "'");
// $del2 = mysqli_query($koneksi, "delete from pembelian_detail where pembelian_id=" . $_POST['id_hapus'] . "");
$stmt = $koneksi->prepare("update penjualan set status_jual = 0 where id = ?");
$stmt->bind_param("i", $_POST['id_hapus']);
$del = $stmt->execute();
if ($del) {
    echo "S";
} else {
    echo "F";
}
