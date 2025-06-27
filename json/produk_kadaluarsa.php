<?php
// error_reporting(0);
header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");

$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;
//menampilkan data dari database, table tb_anggota
if (isset($_GET['start'])) {
    $start = mysqli_real_escape_string($koneksi, $_GET['start']);
    if (isset($_GET['cari'])) {
        if (isset($_GET['expired_to'])) {
            $sql = "select a.*, a.id as idd, c.kategori, b.*, DATEDIFF(a.tgl_expired, CURDATE()) AS sisa_hari from produk_detail a left join produk b on b.id = a.produk_id left join kategori_produk c on c.id = b.kategori_produk_id where (a.qrcode like '%$_GET[cari]%' or b.nama_produk like '%$_GET[cari]%' or c.kategori like '%$_GET[cari]%') and a.tgl_expired BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL " . $_GET['expired_to'] . " DAY) order by b.nama_produk ASC LIMIT $start, $limit";
        } else {
            $sql = "select a.*, a.id as idd, c.kategori, b.*, DATEDIFF(a.tgl_expired, CURDATE()) AS sisa_hari from produk_detail a left join produk b on b.id = a.produk_id left join kategori_produk c on c.id = b.kategori_produk_id where (a.qrcode like '%$_GET[cari]%' or b.nama_produk like '%$_GET[cari]%' or c.kategori like '%$_GET[cari]%') order by b.nama_produk ASC LIMIT $start, $limit";
        }
    } else {
        if (isset($_GET['expired_to'])) {
            $sql = "select a.*, a.id as idd, c.kategori, b.*, DATEDIFF(a.tgl_expired, CURDATE()) AS sisa_hari from produk_detail a left join produk b on b.id = a.produk_id left join kategori_produk c on c.id = b.kategori_produk_id where a.tgl_expired BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL " . $_GET['expired_to'] . " DAY) order by b.nama_produk ASC LIMIT $start, $limit";
        } else {
            $sql = "select a.*, a.id as idd, c.kategori, b.*, DATEDIFF(a.tgl_expired, CURDATE()) AS sisa_hari from produk_detail a left join produk b on b.id = a.produk_id left join kategori_produk c on c.id = b.kategori_produk_id order by b.nama_produk ASC LIMIT $start, $limit";
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
    if (isset($_GET['cari'])) {
        if (isset($_GET['expired_to'])) {
            $sql = "select COUNT(a.id) as jml from produk_detail a left join produk b on b.id = a.produk_id left join kategori_produk c on c.id = b.kategori_produk_id where (a.qrcode like '%$_GET[cari]%' or b.nama_produk like '%$_GET[cari]%' or c.kategori like '%$_GET[cari]%') and a.tgl_expired BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL " . $_GET['expired_to'] . " DAY)";
        } else {
            $sql = "select COUNT(a.id) as jml from produk_detail a left join produk b on b.id = a.produk_id left join kategori_produk c on c.id = b.kategori_produk_id where (a.qrcode like '%$_GET[cari]%' or b.nama_produk like '%$_GET[cari]%' or c.kategori like '%$_GET[cari]%')";
        }
    } else {
        if (isset($_GET['expired_to'])) {
            $sql = "select COUNT(a.id) as jml from produk_detail a left join produk b on b.id = a.produk_id left join kategori_produk c on c.id = b.kategori_produk_id where a.tgl_expired BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL " . $_GET['expired_to'] . " DAY)";
        } else {
            $sql = "select COUNT(a.id) as jml from produk_detail a left join produk b on b.id = a.produk_id left join kategori_produk c on c.id = b.kategori_produk_id";
        }
    }
    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
