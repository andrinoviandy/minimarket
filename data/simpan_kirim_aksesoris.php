<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$metode = $_POST['metode1'];
$data = $_POST['data'];
if ($metode == 'manual') {
    $cek = 0;
    for ($i = 0; $i < count($data); $i++) {
        $dt = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_dikirim_detail_hash where barang_gudang_detail_id = $data[$i]"));
        $cek = $cek + $dt['jml'];
    }
    if ($cek > 0) {
        echo 'SA';
    } else {
        for ($i = 0; $i < count($data); $i++) {
            $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','','$_POST[id_gudang]','$data[$i]')");
        }
        echo 'S';
    }
} else {
    $cek = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL"));
    if ($cek['jml'] >= $data) {
        $q = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL order by barang_gudang_detail.id asc limit $data");
        while ($dt = mysqli_fetch_array($q)) {
            $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','','$_POST[id_gudang]','$dt[id]')");
        }
        echo 'S';
    } else {
        echo "TC".'&Stok Tersedia : '.$cek['jml'].'&Stok Akan Dikirim : '.$data;
    }
}
