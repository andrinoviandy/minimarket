<?php
include("../config/koneksi.php");
include("../include/helper.php");
session_start();

mysqli_begin_transaction($koneksi);
try {
    // Simpan ke pembelian (header)
    $stmt = $koneksi->prepare("
        INSERT INTO biaya_lain (
            jenis_transaksi, kategori_biaya_id, tgl, nomor, deskripsi, nominal
        )
        VALUES (?, ?, ?, ?, ?, ?)
        ");
    $params = [$_POST['jenis_transaksi'], $_POST['kategori_biaya_id'], $_POST['tgl'], $_POST['nomor'], $_POST['deskripsi'], str_replace(".", "", $_POST['nominal'])];
    $types = getBindTypes($params);
    $stmt->bind_param($types, ...$params);
    $simpan1 = $stmt->execute();

    if ($simpan1) {
        mysqli_commit($koneksi);
        die('S');
    } else {
        mysqli_rollback($koneksi);
        die("F");
    }
} catch (Exception $e) {
    // Ada kesalahan, rollback semua
    mysqli_rollback($koneksi);
    die("F"); // Atau cukup die("F");
}
