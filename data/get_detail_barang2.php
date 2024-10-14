<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);

$data = mysqli_fetch_assoc(mysqli_query($koneksi, "select * from barang_gudang where id = " . $_GET['id'] . ""));
$stok_total = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_gudang_detail where status_kirim=0 and status_kerusakan=0 and status_kembali_ke_gudang=0 and barang_gudang_id=" . $_GET['id'] . ""));

$stok_po1 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty_jual) as stok_po from barang_dijual_qty where barang_gudang_id=" . $_GET['id'] . ""));
$stok_po2 = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_dijual_qty.barang_gudang_id=" . $_GET['id'] . ""));

$result = array(
        "tipe_brg" => $data['tipe_brg'],
        "kategori_brg" => $data['kategori_brg'],
        "merk_brg" => $data['merk_brg'],
        "stok_total" => $stok_total['jml'] - ($stok_po1['stok_po'] - $stok_po2['jml']),
        "harga" => number_format($d['harga_satuan'], 2, ',', '.')
);
echo json_encode($result);
