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
        $sql = "select a.*,a.id as idd, b.nama_supplier, b.alamat_supplier from pembelian a left join supplier b on b.id = a.supplier_id where (a.no_po_pesan like '%$_GET[cari]%' or b.nama_supplier like '%$_GET[cari]%' or a.catatan like '%$_GET[cari]%' or a.deskripsi_batal like '%$_GET[cari]%') and a.tgl_po_pesan between '$_GET[tglPembelian1]' and '$_GET[tglPembelian2]' order by a.tgl_po_pesan DESC, a.no_po_pesan DESC LIMIT $start, $limit";
    } else {
        $sql = "select a.*,a.id as idd, b.nama_supplier, b.alamat_supplier from pembelian a left join supplier b on b.id = a.supplier_id where a.tgl_po_pesan between '$_GET[tglPembelian1]' and '$_GET[tglPembelian2]' order by a.tgl_po_pesan DESC, a.no_po_pesan DESC LIMIT $start, $limit";
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
        $sql = "select count(a.id) as jml from pembelian a left join supplier b on b.id = a.supplier_id where (a.no_po_pesan like '%$_GET[cari]%' or b.nama_supplier like '%$_GET[cari]%' or a.catatan like '%$_GET[cari]%' or a.deskripsi_batal like '%$_GET[cari]%') and a.tgl_po_pesan between '$_GET[tglPembelian1]' and '$_GET[tglPembelian2]'";
    } else {
        $sql = "select count(a.id) as jml from pembelian a left join supplier b on b.id = a.supplier_id where a.tgl_po_pesan between '$_GET[tglPembelian1]' and '$_GET[tglPembelian2]'";
    }


    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
