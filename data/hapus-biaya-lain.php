<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from biaya_lain where id=$_POST[id_hapus]"));
if ($sel['jenis_transaksi'] == 'Pembayaran') {
    $up = mysqli_query($koneksi, "update biaya_lain,buku_kas set saldo=saldo+$sel[harga] where buku_kas.id=biaya_lain.buku_kas_id and biaya_lain.buku_kas_id='" . $sel['buku_kas_id'] . "'");
} else {
    $up = mysqli_query($koneksi, "update biaya_lain,buku_kas set saldo=saldo-$sel[harga] where buku_kas.id=biaya_lain.buku_kas_id and biaya_lain.buku_kas_id='" . $sel['buku_kas_id'] . "'");
}
if ($up) {
    $de = mysqli_query($koneksi, "delete from biaya_lain where id=$_POST[id_hapus]");
    $de2 = mysqli_query($koneksi, "delete from keuangan_detail where keuangan_id=$sel[keuangan_id]");
    $de3 = mysqli_query($koneksi, "delete from keuangan where id=$sel[keuangan_id]");
    if ($de) {
        echo "S";
    } else {
        echo "F";
    }
}
