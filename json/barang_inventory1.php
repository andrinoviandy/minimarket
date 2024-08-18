<?php
// error_reporting(0);
header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");

$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;
$start = mysqli_real_escape_string($koneksi, $_GET['start']);

//menampilkan data dari database, table tb_anggota
if (isset($_GET['start'])) {
    if (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
        if (isset($_GET['cari'])) {
            $sql = "select *,barang_pesan_inventory.id as idd from barang_pesan_inventory,mata_uang,principle where mata_uang.id=barang_pesan_inventory.mata_uang_id and principle.id=barang_pesan_inventory.principle_id and (no_po_pesan like '%$_GET[cari]%' or jenis_po like '%$_GET[cari]%' or nama_principle like '%$_GET[cari]%' or alamat_pengiriman like '%$_GET[cari]%') and tgl_po_pesan between '$_GET[tgl1]' and '$_GET[tgl2]' order by tgl_po_pesan DESC, barang_pesan_inventory.id DESC LIMIT $start, $limit";
        } else {
            $sql = "select *,barang_pesan_inventory.id as idd from barang_pesan_inventory,mata_uang,principle where mata_uang.id=barang_pesan_inventory.mata_uang_id and principle.id=barang_pesan_inventory.principle_id and tgl_po_pesan between '$_GET[tgl1]' and '$_GET[tgl2]' order by tgl_po_pesan DESC, barang_pesan_inventory.id DESC LIMIT $start, $limit";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select *,barang_pesan_inventory.id as idd from barang_pesan_inventory,mata_uang,principle where mata_uang.id=barang_pesan_inventory.mata_uang_id and principle.id=barang_pesan_inventory.principle_id and (no_po_pesan like '%$_GET[cari]%' or jenis_po like '%$_GET[cari]%' or nama_principle like '%$_GET[cari]%' or alamat_pengiriman like '%$_GET[cari]%') order by tgl_po_pesan DESC, barang_pesan_inventory.id DESC LIMIT $start, $limit";
        } else {
            $sql = "select *,barang_pesan_inventory.id as idd from barang_pesan_inventory,principle where principle.id=barang_pesan_inventory.principle_id order by tgl_po_pesan DESC, barang_pesan_inventory.id DESC LIMIT $start, $limit";
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
    // untuk jumlah
    if (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
        if (isset($_GET['cari'])) {
            $sql = "select COUNT(*) as jml from barang_pesan_inventory,mata_uang,principle where mata_uang.id=barang_pesan_inventory.mata_uang_id and principle.id=barang_pesan_inventory.principle_id and (no_po_pesan like '%$_GET[cari]%' or jenis_po like '%$_GET[cari]%' or nama_principle like '%$_GET[cari]%' or alamat_pengiriman like '%$_GET[cari]%') and tgl_po_pesan between '$_GET[tgl1]' and '$_GET[tgl2]'";
        } else {
            $sql = "select COUNT(*) as jml from barang_pesan_inventory,mata_uang,principle where mata_uang.id=barang_pesan_inventory.mata_uang_id and principle.id=barang_pesan_inventory.principle_id and tgl_po_pesan between '$_GET[tgl1]' and '$_GET[tgl2]'";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select COUNT(*) as jml from barang_pesan_inventory,mata_uang,principle where mata_uang.id=barang_pesan_inventory.mata_uang_id and principle.id=barang_pesan_inventory.principle_id and (no_po_pesan like '%$_GET[cari]%' or jenis_po like '%$_GET[cari]%' or nama_principle like '%$_GET[cari]%' or alamat_pengiriman like '%$_GET[cari]%')";
        } else {
            $sql = "select COUNT(*) as jml from barang_pesan_inventory,mata_uang,principle where mata_uang.id=barang_pesan_inventory.mata_uang_id and principle.id=barang_pesan_inventory.principle_id";
        }
    }
    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
