<?php
// error_reporting(0);
header("Content-type:application/json");
session_start();
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
        $sql = "select p.tgl_jual, p.no_po_jual, a.*, a.id as idd, c.kategori, (select sum(qty_jual) from penjualan_qty aa where aa.penjualan_id = p.id) as stok_terjual from produk a left join kategori_produk c on c.id = a.kategori_produk_id join penjualan_qty pq on pq.produk_id = a.id left join penjualan p on p.id = pq.penjualan_id where (p.no_po_jual like '%$_GET[cari]%' or a.nama_produk like '%$_GET[cari]%') and p.tgl_jual between '$_GET[tglLaris1] 00:00:00' and '$_GET[tglLaris2] 23:59:59' order by (select sum(qty_jual) from penjualan_qty aa where aa.penjualan_id = p.id) DESC LIMIT $start, $limit";
    } else {
        $sql = "select p.tgl_jual, p.no_po_jual, a.*, a.id as idd, c.kategori, (select sum(qty_jual) from penjualan_qty aa where aa.penjualan_id = p.id) as stok_terjual from produk a left join kategori_produk c on c.id = a.kategori_produk_id join penjualan_qty pq on pq.produk_id = a.id left join penjualan p on p.id = pq.penjualan_id where p.tgl_jual between '$_GET[tglLaris1] 00:00:00' and '$_GET[tglLaris2] 23:59:59' order by (select sum(qty_jual) from penjualan_qty aa where aa.penjualan_id = p.id) DESC LIMIT $start, $limit";
    }


    $result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

    while ($row = mysqli_fetch_assoc($result)) {
        $ArrAnggota[] = $row;
    }

    echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

    //tutup koneksi ke database
    mysqli_close($koneksi);
} else {
    // untuk jumlah
    if (isset($_GET['cari'])) {
        $sql = "select count(a.id) as jml from produk a left join kategori_produk c on c.id = a.kategori_produk_id join penjualan_qty pq on pq.produk_id = a.id left join penjualan p on p.id = pq.penjualan_id where (p.no_po_jual like '%$_GET[cari]%' or a.nama_produk like '%$_GET[cari]%') and p.tgl_jual between '$_GET[tglLaris1] 00:00:00' and '$_GET[tglLaris2] 23:59:59' order by a.nama_produk ASC";
    } else {
        $sql = "select count(a.id) as jml from produk a left join kategori_produk c on c.id = a.kategori_produk_id join penjualan_qty pq on pq.produk_id = a.id left join penjualan p on p.id = pq.penjualan_id where p.tgl_jual between '$_GET[tglLaris1] 00:00:00' and '$_GET[tglLaris2] 23:59:59' order by a.nama_produk";
    }


    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
