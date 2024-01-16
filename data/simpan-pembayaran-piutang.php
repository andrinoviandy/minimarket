<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select *,utang_piutang.id as idd from utang_piutang where utang_piutang.id=$_POST[id]"));
$simpan1 = mysqli_query($koneksi, "insert into keuangan values('','" . $_POST['tgl_input'] . "','Pembayaran Piutang Alkes Ber No Seri','" . $_POST['deskripsi'] . "','" . str_replace(".", "", $_POST['nominal']) . "')");
$max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_max from keuangan"));
$Result = mysqli_query($koneksi, "insert into utang_piutang_bayar values('','$max[id_max]','Piutang','$_POST[id]','" . $_POST['tgl_input'] . "','" . str_replace(".", "", $_POST['nominal']) . "','" . $_POST['deskripsi'] . "','" . $_POST['akun'] . "')");
$simpan2 = mysqli_query($koneksi, "insert into keuangan_detail values('','$max[id_max]','4','19','8','db')");
$simpan3 = mysqli_query($koneksi, "insert into keuangan_detail values('','$max[id_max]','1','2','22','db')");
$simpan4 = mysqli_query($koneksi, "insert into keuangan_detail values('','$max[id_max]','3','32','','db')");
if ($Result) {
    $sel = mysqli_fetch_array(mysqli_query($koneksi, "select sum(nominal) as jumlah from utang_piutang_bayar where utang_piutang_id=$_POST[id]"));
    $nom = str_replace(".", "", $_POST['nominal']);
    //$up=mysqli_query($koneksi, "update buku_kas set saldo=saldo+$nom where buku_kas.id=$_POST[akun]");
    if ($sel['jumlah'] >= $data['nominal']) {
        // mysqli_query($koneksi, "update utang_piutang,barang_dijual set utang_piutang.status_lunas=1,barang_dijual.status_lunas=1 where barang_dijual.no_po_jual=utang_piutang.no_faktur_no_po and utang_piutang.id=" . $_POST['id'] . "");
        mysqli_query($koneksi, "update utang_piutang set status_lunas=1 where id=$_POST[id]");
    }
    echo "S";
} else {
    echo "F";
}
