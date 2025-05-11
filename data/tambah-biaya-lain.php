<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
$cek_saldo = mysqli_fetch_array(mysqli_query($koneksi, "select * from buku_kas where id='" . $_POST['buku_kas_id'] . "'"));

if ($_POST['jenis_transaksi'] == 'Pembayaran') {
    $nom = str_replace(".", "", $_POST['harga']);
    if ($cek_saldo['saldo'] < $nom) {
        die("K");
    } else {
        $simpan_keuangan = mysqli_query($koneksi, "insert into keuangan values('','" . $_POST['tanggal'] . "','" . $_POST['jenis_transaksi'] . "','" . $_POST['deskripsi'] . "','" . $nom . "')");
        $max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_max from keuangan"));
        //$coa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT *,coa_sub_akun.id as idd FROM coa,coa_sub,coa_sub_akun where coa.id=coa_sub.coa_id and coa_sub.id=coa_sub_akun.coa_sub_id and coa_sub_akun.id=$_POST[coa_id]"));
        if ($_POST['coa_id'] == 1) {
            $simpan_keuangan_detail = mysqli_query($koneksi, "insert into keuangan_detail values('','$max[id_max]','" . $_POST['coa_id'] . "','" . $_POST['coa_sub_id'] . "','" . $_POST['coa_sub_akun_id'] . "','db')");
        } else {
            $simpan_keuangan_detail = mysqli_query($koneksi, "insert into keuangan_detail values('','$max[id_max]','" . $_POST['coa_id'] . "','" . $_POST['coa_sub_id'] . "','" . $_POST['coa_sub_akun_id'] . "','cr')");
        }
        if ($_POST['coa_id'] == 5) {
            $simpan_keuangan_detail2 = mysqli_query($koneksi, "insert into keuangan_detail values('','$max[id_max]','3','32','','cr')");
        }
        $Result = mysqli_query($koneksi, "insert into biaya_lain values('','$max[id_max]','" . $_POST['buku_kas_id'] . "','" . $_POST['jenis_transaksi'] . "','" . $_POST['tanggal'] . "','" . $_POST['penerima'] . "','" . $_POST['deskripsi'] . "','" . $nom . "')");
        if ($simpan_keuangan and $Result and $simpan_keuangan_detail) {
            $saldo_kurang = $cek_saldo['saldo'] - $nom;
            $up = mysqli_query($koneksi, "update buku_kas set saldo='" . $saldo_kurang . "' where id=$_POST[buku_kas_id]");
            echo "S";
        } else {
            echo "F";
        }
    }
} else {
    $nom = str_replace(".", "", $_POST['harga']);
    $simpan_keuangan = mysqli_query($koneksi, "insert into keuangan values('','" . $_POST['tanggal'] . "','" . $_POST['jenis_transaksi'] . "','" . $_POST['deskripsi'] . "','" . $nom . "')");
    $max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_max from keuangan"));
    //$coa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT *,coa_sub_akun.id as idd FROM coa,coa_sub,coa_sub_akun where coa.id=coa_sub.coa_id and coa_sub.id=coa_sub_akun.coa_sub_id and coa_sub_akun.id=$_POST[coa_id]"));
    if ($_POST['coa_id'] == 1) {
        $simpan_keuangan_detail = mysqli_query($koneksi, "insert into keuangan_detail values('','$max[id_max]','" . $_POST['coa_id'] . "','" . $_POST['coa_sub_id'] . "','" . $_POST['coa_sub_akun_id'] . "','cr')");
    } else {
        $simpan_keuangan_detail = mysqli_query($koneksi, "insert into keuangan_detail values('','$max[id_max]','" . $_POST['coa_id'] . "','" . $_POST['coa_sub_id'] . "','" . $_POST['coa_sub_akun_id'] . "','db')");
    }
    if ($_POST['coa_id'] == 4) {
        $simpan_keuangan_detail2 = mysqli_query($koneksi, "insert into keuangan_detail values('','$max[id_max]','3','32','','db')");
    }
    $Result = mysqli_query($koneksi, "insert into biaya_lain values('','$max[id_max]','" . $_POST['buku_kas_id'] . "','" . $_POST['jenis_transaksi'] . "','" . $_POST['tanggal'] . "','" . $_POST['penerima'] . "','" . $_POST['deskripsi'] . "','" . $nom . "')");
    if ($simpan_keuangan and $Result and $simpan_keuangan_detail) {
        $saldo_kurang = $cek_saldo['saldo'] + $nom;
        $up = mysqli_query($koneksi, "update buku_kas set saldo='" . $saldo_kurang . "' where id=$_POST[buku_kas_id]");
        echo "S";
    } else {
        echo "F";
    }
}
