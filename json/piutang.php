<?php

header("Content-type:application/json");

//koneksi ke database
error_reporting(0);
//koneksi ke database
require("../config/koneksi.php");

$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;
$start = mysqli_real_escape_string($koneksi, $_GET['start']);

//menampilkan data dari database, table tb_anggota
if (isset($_GET['start'])) {
    if (isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
        if (isset($_GET['cari'])) {
            // $sql = "select utang_piutang.*,utang_piutang.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,utang_piutang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.no_po_jual=utang_piutang.no_faktur_no_po and u_p='Piutang' and status_deal=1 and tgl_input between '$_GET[tgl1]' and '$_GET[tgl2]' and (no_faktur_no_po like '%$_GET[cari]%' or klien like '%$_GET[cari]%' or deskripsi like '%$_GET[cari]%') group by utang_piutang.id order by tgl_input DESC, utang_piutang.id DESC LIMIT $start, $limit";
            $sql = "select *,utang_piutang.id as idd from utang_piutang where u_p='Piutang' and tgl_input between '$_GET[tgl1]' and '$_GET[tgl2]' and (no_faktur_no_po like '%$_GET[cari]%' or klien like '%$_GET[cari]%' or deskripsi like '%$_GET[cari]%') group by utang_piutang.id order by tgl_input DESC, utang_piutang.id DESC LIMIT $start, $limit";
        } else {
            // $sql = "select utang_piutang.*,utang_piutang.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,utang_piutang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.no_po_jual=utang_piutang.no_faktur_no_po and u_p='Piutang' and status_deal=1 and tgl_input between '$_GET[tgl1]' and '$_GET[tgl2]' group by utang_piutang.id order by tgl_input DESC, utang_piutang.id DESC LIMIT $start, $limit";
            $sql = "select *,utang_piutang.id as idd from utang_piutang where u_p='Piutang' and tgl_input between '$_GET[tgl1]' and '$_GET[tgl2]' group by utang_piutang.id order by tgl_input DESC, utang_piutang.id DESC LIMIT $start, $limit";
        }
    } else {
        if (isset($_GET['cari'])) {
            // $sql = "select utang_piutang.*,utang_piutang.id as idd from utang_piutang,barang_dijual where barang_dijual.no_po_jual=utang_piutang.no_faktur_no_po and u_p='Piutang' and status_deal=1 and (no_faktur_no_po like '%$_GET[cari]%' or klien like '%$_GET[cari]%' or deskripsi like '%$_GET[cari]%') order by tgl_input DESC, utang_piutang.id DESC LIMIT $start, $limit";
            $sql = "select *,utang_piutang.id as idd from utang_piutang where u_p='Piutang' and (no_faktur_no_po like '%$_GET[cari]%' or klien like '%$_GET[cari]%' or deskripsi like '%$_GET[cari]%') order by tgl_input DESC, utang_piutang.id DESC LIMIT $start, $limit";
        } else {
            // $sql = "select utang_piutang.*,utang_piutang.id as idd from utang_piutang,barang_dijual where barang_dijual.no_po_jual=utang_piutang.no_faktur_no_po and u_p='Piutang' and status_deal=1 order by tgl_input DESC, utang_piutang.id DESC LIMIT $start, $limit";
            $sql = "select *,utang_piutang.id as idd from utang_piutang where u_p='Piutang' order by tgl_input DESC, utang_piutang.id DESC LIMIT $start, $limit";
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
    if (isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
        if (isset($_GET['cari'])) {
            // $sql = "select COUNT(DISTINCT utang_piutang.id) as jml from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,utang_piutang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.no_po_jual=utang_piutang.no_faktur_no_po and u_p='Piutang' and status_deal=1 and tgl_input between '$_GET[tgl1]' and '$_GET[tgl2]' and (no_faktur_no_po like '%$_GET[cari]%' or klien like '%$_GET[cari]%' or deskripsi like '%$_GET[cari]%')";
            $sql = "select COUNT(DISTINCT utang_piutang.id) as jml from utang_piutang where u_p='Piutang' and tgl_input between '$_GET[tgl1]' and '$_GET[tgl2]' and (no_faktur_no_po like '%$_GET[cari]%' or klien like '%$_GET[cari]%' or deskripsi like '%$_GET[cari]%')";
        } else {
            // $sql = "select COUNT(DISTINCT utang_piutang.id) as jml from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,utang_piutang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.no_po_jual=utang_piutang.no_faktur_no_po and u_p='Piutang' and status_deal=1 and tgl_input between '$_GET[tgl1]' and '$_GET[tgl2]'";
            $sql = "select COUNT(DISTINCT utang_piutang.id) as jml from utang_piutang where u_p='Piutang' and tgl_input between '$_GET[tgl1]' and '$_GET[tgl2]'";
        }
    } else {
        if (isset($_GET['cari'])) {
            // $sql = "select COUNT(DISTINCT utang_piutang.id) as jml from utang_piutang,barang_dijual where barang_dijual.no_po_jual=utang_piutang.no_faktur_no_po and u_p='Piutang' and status_deal=1 and (no_faktur_no_po like '%$_GET[cari]%' or klien like '%$_GET[cari]%' or deskripsi like '%$_GET[cari]%')";
            $sql = "select COUNT(DISTINCT utang_piutang.id) as jml from utang_piutang where u_p='Piutang' and (no_faktur_no_po like '%$_GET[cari]%' or klien like '%$_GET[cari]%' or deskripsi like '%$_GET[cari]%')";
        } else {
            // $sql = "select COUNT(DISTINCT utang_piutang.id) as jml from utang_piutang,barang_dijual where barang_dijual.no_po_jual=utang_piutang.no_faktur_no_po and u_p='Piutang' and status_deal=1";
            $sql = "select COUNT(DISTINCT utang_piutang.id) as jml from utang_piutang where u_p='Piutang'";
        }
    }
    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
