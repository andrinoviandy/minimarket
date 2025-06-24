<?php
include("../config/koneksi.php");
include("../include/API.php");
include("../include/helper.php");
session_start();
// error_reporting(0);
$stmt = $koneksi->prepare("update pembelian set status = ? where id = ?");
$params = [$_POST['status'], $_POST['id_ubah']];
$type = getBindTypes($params);
$stmt->bind_param($type, ...$params);
$update = $stmt->execute();

if ($update) {
    if ($_POST['status'] == 1) {
        $query = $koneksi->prepare("select * from pembelian_detail left join pembelian on pembelian.id = pembelian_detail.pembelian_id where pembelian_detail.pembelian_id = ?");
        $query->bind_param('i', $_POST['id_ubah']);
        $query->execute();
        $result = $query->get_result();
        while ($dt = $result->fetch_assoc()) {
            $update_produk = mysqli_query($koneksi, "update produk set stok = stok + $dt[qty] where id = $dt[produk_id]");
            $update_detail = mysqli_query($koneksi, "update pembelian_detail set status_ke_stok = 1 where id = $dt[id]");
            $queryProduk = $koneksi->prepare("insert into produk_detail(pembelian_id, no_po_pesan, deskripsi, produk_id, stok_masuk) values(?, ?, ?, ?, ?)");
            $paramsProduk = [$_POST['id_ubah'], $dt['no_po_pesan'], $_POST['deskripsi'], $dt['produk_id'], $dt['qty']];
            $typeProduk =getBindTypes($paramsProduk);
            $queryProduk->bind_param($typeProduk, ...$paramsProduk);
            $queryProduk->execute();
        }
    }

    echo "S";
} else {
    echo "F";
}
