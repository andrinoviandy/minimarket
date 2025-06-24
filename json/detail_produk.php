<?php
error_reporting(0);
header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");

$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;


if (isset($_GET['start'])) {
    $start = mysqli_real_escape_string($koneksi, $_GET['start']);
    if ($_GET['status'] == 'ada_qrcode') {
        if (isset($_GET['cari'])) {
            $sql = "select a.*, a.id as idd from produk_detail a where a.qrcode is not null and a.tgl_expired is not null and (TIMESTAMPDIFF(DAY, NOW(), a.tgl_expired) >= 0) and a.produk_id=" . $_GET['id'] . " and (a.qrcode like '%$_GET[cari]%' or DATE_FORMAT(a.tgl_expired, '%d-%m-%Y') like '%$_GET[cari]%') order by a.created_at DESC LIMIT $start, $limit";
        } else {
            $sql = "select a.*, a.id as idd from produk_detail a where a.qrcode is not null and a.tgl_expired is not null and (TIMESTAMPDIFF(DAY, NOW(), a.tgl_expired) >= 0) and a.produk_id=" . $_GET['id'] . " order by a.created_at DESC LIMIT $start, $limit";
        }
    } else if ($_GET['status'] == 'belum_qrcode') {
        if (isset($_GET['cari'])) {
            $sql = "select a.*, a.id as idd from produk_detail a where (a.qrcode is null or a.tgl_expired is null) and a.produk_id=" . $_GET['id'] . " and (a.qrcode like '%$_GET[cari]%' or DATE_FORMAT(a.tgl_expired, '%d-%m-%Y') like '%$_GET[cari]%') order by a.created_at DESC LIMIT $start, $limit";
        } else {
            $sql = "select a.*, a.id as idd from produk_detail a where (a.qrcode is null or a.tgl_expired is null) and a.produk_id=" . $_GET['id'] . " order by a.created_at DESC LIMIT $start, $limit";
        }
    } else if ($_GET['status'] == 'kadaluarsa') {
        if (isset($_GET['cari'])) {
            $sql = "select a.*, a.id as idd from produk_detail a where (TIMESTAMPDIFF(DAY, NOW(), a.tgl_expired) < 0) and a.tgl_expired is not null and a.produk_id=" . $_GET['id'] . " and (a.qrcode like '%$_GET[cari]%' or DATE_FORMAT(a.tgl_expired, '%d-%m-%Y') like '%$_GET[cari]%') order by a.created_at DESC LIMIT $start, $limit";
        } else {
            $sql = "select a.*, a.id as idd from produk_detail a where (TIMESTAMPDIFF(DAY, NOW(), a.tgl_expired) < 0) and a.tgl_expired is not null and a.produk_id=" . $_GET['id'] . " order by a.created_at DESC LIMIT $start, $limit";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select a.*, a.id as idd from produk_detail a where a.qrcode is not null and a.tgl_expired is not null and (TIMESTAMPDIFF(DAY, NOW(), a.tgl_expired) >= 0) and a.produk_id=" . $_GET['id'] . " and (a.qrcode like '%$_GET[cari]%' or DATE_FORMAT(a.tgl_expired, '%d-%m-%Y') like '%$_GET[cari]%') order by a.created_at DESC LIMIT $start, $limit";
        } else {
            $sql = "select a.*, a.id as idd from produk_detail a where a.qrcode is not null and a.tgl_expired is not null and (TIMESTAMPDIFF(DAY, NOW(), a.tgl_expired) >= 0) and a.produk_id=" . $_GET['id'] . " order by a.created_at DESC LIMIT $start, $limit";
        }
    }
    $result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

    //membuat array
    while ($row = mysqli_fetch_assoc($result)) {
        $ArrAnggota[] = $row;
    }

    echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

    //tutup koneksi ke database
    mysqli_close($koneksi);
} else {
    //untuk jumlah
    if ($_GET['status'] == 'ada_qrcode') {
        if (isset($_GET['cari'])) {
            $sql = "select count(a.id) as jml from produk_detail a where a.qrcode is not null and a.tgl_expired is not null and (TIMESTAMPDIFF(DAY, NOW(), a.tgl_expired) > 0) and a.produk_id=" . $_GET['id'] . " and (a.qrcode like '%$_GET[cari]%' or DATE_FORMAT(a.tgl_expired, '%d-%m-%Y') like '%$_GET[cari]%')";
        } else {
            $sql = "select count(a.id) as jml from produk_detail a where a.qrcode is not null and a.tgl_expired is not null and (TIMESTAMPDIFF(DAY, NOW(), a.tgl_expired) > 0) and a.produk_id=" . $_GET['id'] . "";
        }
    } else if ($_GET['status'] == 'belum_qrcode') {
        if (isset($_GET['cari'])) {
            $sql = "select count(a.id) as jml from produk_detail a where (a.qrcode is null or a.tgl_expired is null) and a.produk_id=" . $_GET['id'] . " and (a.qrcode like '%$_GET[cari]%' or DATE_FORMAT(a.tgl_expired, '%d-%m-%Y') like '%$_GET[cari]%')";
        } else {
            $sql = "select count(a.id) as jml from produk_detail a where (a.qrcode is null or a.tgl_expired is null) and a.produk_id=" . $_GET['id'] . "";
        }
    } else if ($_GET['status'] == 'kadaluarsa') {
        if (isset($_GET['cari'])) {
            $sql = "select count(a.id) as jml from produk_detail a where (TIMESTAMPDIFF(DAY, NOW(), a.tgl_expired) < 0) and a.tgl_expired is not null and a.produk_id=" . $_GET['id'] . " and (a.qrcode like '%$_GET[cari]%' or DATE_FORMAT(a.tgl_expired, '%d-%m-%Y') like '%$_GET[cari]%')";
        } else {
            $sql = "select count(a.id) as jml from produk_detail a where (TIMESTAMPDIFF(DAY, NOW(), a.tgl_expired) < 0) and a.tgl_expired is not null and a.produk_id=" . $_GET['id'] . "";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select count(a.id) as jml from produk_detail a where a.qrcode is not null and a.tgl_expired is not null and (TIMESTAMPDIFF(DAY, NOW(), a.tgl_expired) > 0) and a.produk_id=" . $_GET['id'] . " and (a.qrcode like '%$_GET[cari]%' or DATE_FORMAT(a.tgl_expired, '%d-%m-%Y') like '%$_GET[cari]%')";
        } else {
            $sql = "select count(a.id) as jml from produk_detail a where a.qrcode is not null and a.tgl_expired is not null and (TIMESTAMPDIFF(DAY, NOW(), a.tgl_expired) > 0) and a.produk_id=" . $_GET['id'] . "";
        }
    }
    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
//menampilkan data dari database, table tb_anggota
// if (isset($_GET['kunci']) and isset($_GET['pilihan'])) {
// $sql = "select *,barang_gudang_detail.id as idd,barang_gudang_po.id as id_po,barang_gudang_po.stok as stok_masuk from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kirim=0 and status_kerusakan=0 and barang_gudang_detail.barang_gudang_id=".$_GET['id']." and $_GET[pilihan] like '%$_GET[kunci]%' order by no_po_gudang DESC LIMIT $curr, $limit";
// }
// else {
// $sql = "select *,barang_gudang_detail.id as idd,barang_gudang_po.id as id_po,barang_gudang_po.stok as stok_masuk from barang_gudang_detail,barang_gudang_po,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_po.id=barang_gudang_detail.barang_gudang_po_id and status_kirim=0 and status_kerusakan=0 and barang_gudang_detail.barang_gudang_id=".$_GET['id']." order by no_po_gudang DESC LIMIT $curr, $limit";
// }
