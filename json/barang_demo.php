<?php
error_reporting(0);
header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");

$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;
$start = mysqli_real_escape_string($koneksi, $_GET['start']);

if (isset($_GET['start'])) {
    if (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
        if (isset($_GET['cari'])) {
            $sql = "select distinct barang_demo.*,barang_demo.id as idd, pembeli.nama_pembeli from barang_demo,pembeli,barang_demo_qty,barang_gudang where barang_gudang.id=barang_demo_qty.barang_gudang_id and barang_demo.id=barang_demo_qty.barang_demo_id and pembeli.id=barang_demo.pembeli_id and (supplier like '%$_GET[cari]%' or deskripsi_kegiatan like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or pic like '%$_GET[cari]%' or subdis like '%$_GET[cari]%') and tgl_pinjam between '$_GET[tgl1]' and '$_GET[tgl2]' order by tgl_pinjam DESC, barang_demo.id DESC LIMIT $start, $limit";
        } else {
            $sql = "select distinct barang_demo.*,barang_demo.id as idd, pembeli.nama_pembeli from barang_demo,pembeli,barang_demo_qty,barang_gudang where barang_gudang.id=barang_demo_qty.barang_gudang_id and barang_demo.id=barang_demo_qty.barang_demo_id and pembeli.id=barang_demo.pembeli_id and tgl_pinjam between '$_GET[tgl1]' and '$_GET[tgl2]' order by tgl_pinjam DESC, barang_demo.id DESC LIMIT $start, $limit";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select distinct barang_demo.*,barang_demo.id as idd, pembeli.nama_pembeli from barang_demo,pembeli,barang_demo_qty,barang_gudang where barang_gudang.id=barang_demo_qty.barang_gudang_id and barang_demo.id=barang_demo_qty.barang_demo_id and pembeli.id=barang_demo.pembeli_id and (supplier like '%$_GET[cari]%' or deskripsi_kegiatan like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or pic like '%$_GET[cari]%' or subdis like '%$_GET[cari]%') order by tgl_pinjam DESC, barang_demo.id DESC LIMIT $start, $limit";
        } else {
            $sql = "select distinct barang_demo.*,barang_demo.id as idd, pembeli.nama_pembeli from barang_demo,pembeli,barang_demo_qty,barang_gudang where barang_gudang.id=barang_demo_qty.barang_gudang_id and barang_demo.id=barang_demo_qty.barang_demo_id and pembeli.id=barang_demo.pembeli_id order by tgl_pinjam DESC, barang_demo.id DESC LIMIT $start, $limit";
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
    if ($_GET['tgl1'] && $_GET['tgl2']) {
        if (isset($_GET['cari'])) {
            $sql = "select COUNT(DISTINCT barang_demo.id) as jml from barang_demo,pembeli,barang_demo_qty,barang_gudang where barang_gudang.id=barang_demo_qty.barang_gudang_id and barang_demo.id=barang_demo_qty.barang_demo_id and pembeli.id=barang_demo.pembeli_id and (supplier like '%$_GET[cari]%' or deskripsi_kegiatan like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or pic like '%$_GET[cari]%' or subdis like '%$_GET[cari]%') and tgl_pinjam between '$_GET[tgl1]' and '$_GET[tgl2]'";
        } else {
            $sql = "select COUNT(DISTINCT barang_demo.id) as jml from barang_demo,pembeli,barang_demo_qty,barang_gudang where barang_gudang.id=barang_demo_qty.barang_gudang_id and barang_demo.id=barang_demo_qty.barang_demo_id and pembeli.id=barang_demo.pembeli_id and tgl_pinjam between '$_GET[tgl1]' and '$_GET[tgl2]'";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select COUNT(DISTINCT barang_demo.id) as jml from barang_demo,pembeli,barang_demo_qty,barang_gudang where barang_gudang.id=barang_demo_qty.barang_gudang_id and barang_demo.id=barang_demo_qty.barang_demo_id and pembeli.id=barang_demo.pembeli_id and (supplier like '%$_GET[cari]%' or deskripsi_kegiatan like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or pic like '%$_GET[cari]%' or subdis like '%$_GET[cari]%')";
        } else {
            $sql = "select COUNT(DISTINCT barang_demo.id) as jml from barang_demo,pembeli,barang_demo_qty,barang_gudang where barang_gudang.id=barang_demo_qty.barang_gudang_id and barang_demo.id=barang_demo_qty.barang_demo_id and pembeli.id=barang_demo.pembeli_id";
        }
    }
    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
//menampilkan data dari database, table tb_anggota
// if (isset($_GET['tgl_awal']) and isset($_GET['tgl_akhir'])) {
// $sql = "select *,barang_demo.id as idd from barang_demo,pembeli where pembeli.id=barang_demo.pembeli_id and tgl_pinjam between '$_GET[tgl_awal]' and '$_GET[tgl_akhir]' order by tgl_pinjam DESC, barang_demo.id DESC";
// }
// elseif (isset($_GET['cari']) and isset($_GET['pilihan'])) {
// $sql = "select *,barang_demo.id as idd from barang_demo,pembeli,barang_demo_qty,barang_gudang where barang_gudang.id=barang_demo_qty.barang_gudang_id and barang_demo.id=barang_demo_qty.barang_demo_id and pembeli.id=barang_demo.pembeli_id and $_GET[pilihan] like '%$_GET[cari]%' order by tgl_pinjam DESC, barang_demo.id DESC";
// }
//  else {
// $sql = "select *,barang_demo.id as idd from barang_demo,pembeli where pembeli.id=barang_demo.pembeli_id order by tgl_pinjam DESC, barang_demo.id DESC LIMIT 100";
// }