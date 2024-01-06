<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);

$tglSekarang = date('Y-m-d');

function selisihEnamBulan($tanggalA, $tanggalB) {
    // Membuat objek DateTime untuk kedua tanggal
    $dateTimeA = new DateTime($tanggalA);
    $dateTimeB = new DateTime($tanggalB);

    // Menghitung selisih bulan antara dua tanggal
    $selisih_bulan = $dateTimeA->diff($dateTimeB)->m;

    // Memeriksa apakah selisih bulan adalah 6
    if ($selisih_bulan >= 6) {
        return true;
    } else {
        return false;
    }
}

$data = mysqli_fetch_array(mysqli_query($koneksi, "select TIMESTAMPDIFF(DAY, NOW(), tgl_expired) as selisih_hari from barang_gudang_detail where id = '$_GET[id]'"));
if ($data['selisih_hari'] > 0 && $data['selisih_hari'] <= 180) {
    echo 'Y';
} else {
    echo 'T';
}
