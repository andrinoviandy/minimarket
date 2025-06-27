<?php
include("../config/koneksi.php");
include("../include/API.php");
include("../include/helper.php");
session_start();
// error_reporting(0);
mysqli_begin_transaction($koneksi);

try {
    $queryProduk = $koneksi->prepare("insert into produk_detail(no_po_pesan, deskripsi, produk_id, tgl_masuk, stok_masuk, tgl_expired, qrcode) values(?, ?, ?, ?, ?, ?, ?)");
    $paramsProduk = [$_POST['no_po_pesan'], $_POST['deskripsi'], $_POST['produk_id'], $_POST['tgl_masuk'], $_POST['stok_masuk'], $_POST['tgl_expired'], $_POST['qrcode']];
    $typeProduk = getBindTypes($paramsProduk);
    $queryProduk->bind_param($typeProduk, ...$paramsProduk);
    $update = $queryProduk->execute();

    if ($update) {
        $upStok = $koneksi->prepare("update produk set stok = stok + ? where id = ?");
        $paramStok = [$_POST['stok_masuk'], $_POST['produk_id']];
        $typeStok = getBindTypes($paramStok);
        $upStok->bind_param($typeStok, ...$paramStok);
        $update2 = $upStok->execute();
        if ($update2) {
            mysqli_commit($koneksi);
            echo "S";
        } else {
            mysqli_rollback($koneksi);
            die("F");
        }
    } else {
        echo "F";
    }
} catch (\Throwable $th) {
    mysqli_rollback($koneksi);
    die("F");
}
