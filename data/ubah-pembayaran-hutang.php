<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select *,utang_piutang.id as idd from utang_piutang where utang_piutang.id=$_POST[id]"));
$da = mysqli_fetch_array(mysqli_query($koneksi, "select *,buku_kas.id as id_coa from utang_piutang_bayar,buku_kas where buku_kas.id=utang_piutang_bayar.buku_kas_id and utang_piutang_bayar.id=$_POST[id_ubah]"));
//$up=mysqli_query($koneksi, "update buku_kas set saldo=saldo-$da[nominal] where buku_kas.id=$da[id_coa]");
//if ($up) {
$nom = str_replace(".", "", $_POST['nominal2']);
//$up2=mysqli_query($koneksi, "update buku_kas set saldo=saldo+$nom where buku_kas.id=$_POST[akun2]");
$up3 = mysqli_query($koneksi, "update utang_piutang_bayar set tgl_bayar='" . $_POST['tgl_input2'] . "', nominal='" . str_replace(".", "", $_POST['nominal2']) . "', deskripsi='" . $_POST['deskripsi2'] . "', buku_kas_id=" . $_POST['akun2'] . " where id=$_POST[id_ubah]");
$up4 = mysqli_query($koneksi, "update keuangan set tgl_transaksi='" . $_POST['tgl_input2'] . "', deskripsi='" . $_POST['deskripsi2'] . "', saldo='" . str_replace(".", "", $_POST['nominal2']) . "' where id=$da[keuangan_id]");
if ($up3 and $up4) {
    $sel = mysqli_fetch_array(mysqli_query($koneksi, "select sum(nominal) as jumlah from utang_piutang_bayar where utang_piutang_id=$_POST[id]"));
    $sl = mysqli_fetch_array(mysqli_query($koneksi, "select no_faktur_no_po from utang_piutang where id=$_POST[id]"));
    if ($sel['jumlah'] >= $data['nominal']) {
        mysqli_query($koneksi, "update utang_piutang set status_lunas=1 where id=$_POST[id]");
        mysqli_query($koneksi, "update barang_pesan set status_lunas=1 where no_po_pesan='" . $sl['no_faktur_no_po'] . "'");
    } else {
        mysqli_query($koneksi, "update utang_piutang set status_lunas=0 where id=$_POST[id]");
        mysqli_query($koneksi, "update barang_pesan set status_lunas=0 where no_po_pesan='" . $sl['no_faktur_no_po'] . "'");
    }
    //}
    echo "S";
} else {
    echo "F";
}
