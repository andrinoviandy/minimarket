<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();

// error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select *,utang_piutang.id as idd from utang_piutang where utang_piutang.id=$_POST[id]"));
$sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from utang_piutang_bayar where id=$_POST[id_hapus]"));
//$up = mysqli_query($koneksi, "update utang_piutang_bayar,buku_kas,utang_piutang set saldo=saldo-$sel[nominal] where utang_piutang.id=utang_piutang_bayar.utang_piutang_id and buku_kas.id=utang_piutang_bayar.buku_kas_id and utang_piutang_bayar.buku_kas_id=".$sel['buku_kas_id']."");
//if ($up) { 
$de = mysqli_query($koneksi, "delete from utang_piutang_bayar where id=$_POST[id_hapus]");
$de2 = mysqli_query($koneksi, "delete from keuangan_detail where keuangan_id=$sel[keuangan_id]");
$de3 = mysqli_query($koneksi, "delete from keuangan where id=$sel[keuangan_id]");
if ($de and $de2 and $de3) {
    $c = mysqli_fetch_array(mysqli_query($koneksi, "select sum(nominal) as jumlah from utang_piutang_bayar where utang_piutang_id=$_POST[id]"));
    if ($c['jumlah'] < $data['nominal']) {
        mysqli_query($koneksi, "update utang_piutang set status_lunas=0 where id=$_POST[id]");
    }
    echo "S";
} else {
    echo "F";
}
//}
