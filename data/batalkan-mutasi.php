<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$sel1 = mysqli_fetch_array(mysqli_query($koneksi, "select *,barang_pesan_detail.id as idd from barang_pesan,barang_pesan_detail,barang_gudang where barang_gudang.id=barang_pesan_detail.barang_gudang_id and barang_pesan.id=barang_pesan_detail.barang_pesan_id and barang_pesan_detail.id=" . $_GET['id_detail'] . ""));
if ($sel1['kategori_brg'] == 'Set') {
    $sel2 = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_gudang_po where no_po_gudang='" . $sel1['no_po_pesan'] . "' and barang_gudang_id=" . $_GET['id_gudang'] . " and stok=" . $_GET['stok'] . ""));
    $sel3 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where barang_gudang_po_id=" . $_GET['barang_gudang_po_id'] . " and status_kirim=1"));
    $sel5 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where barang_gudang_po_id=" . $_GET['barang_gudang_po_id'] . " and status_demo=1"));

    // window.location='index.php?page=detail_mutasi&id=$_GET[id]&id_gudang=$_GET[id_gudang]&id_detail=$_GET[id_detail]';
    $cek = 0;
    $detail = mysqli_query($koneksi, "select * from barang_gudang_detail_set where barang_gudang_set_id = $_GET[id_gudang]");
    while ($dt = mysqli_fetch_array($detail)) {
        $sel33 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where barang_gudang_po_id=" . $_GET['barang_gudang_po_id'] . " and barang_gudang_id = $dt[barang_gudang_id] and status_kirim=1"));
        if ($sel33 > 0) {
            $cek = $cek + 1;
        }
        $sel55 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where barang_gudang_po_id=" . $_GET['barang_gudang_po_id'] . " and barang_gudang_id = $dt[barang_gudang_id] and status_demo=1"));
        if ($sel55 > 0) {
            $cek = $cek + 1;
        }
    }
    if ($sel3 != 0 or $sel5 != 0) {
        echo "F";
    } else if ($cek > 0) {
        echo "F";
    } else {
        $sel4 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where barang_gudang_po_id=" . $_GET['barang_gudang_po_id'] . " and barang_gudang_id = $_GET[id_gudang]"));
        $del1 = mysqli_query($koneksi, "delete from barang_gudang_detail where barang_gudang_po_id=$_GET[barang_gudang_po_id]");
        $del2 = mysqli_query($koneksi, "delete from barang_gudang_po where id=$_GET[barang_gudang_po_id]");
        $del3 = mysqli_query($koneksi, "update barang_gudang set stok_total=stok_total-$sel4 where id=$_GET[id_gudang]");
        $detail2 = mysqli_query($koneksi, "select * from barang_pesan_detail_set where barang_pesan_detail_id = $_GET[id_detail]");
        while ($dt = mysqli_fetch_array($detail2)) {
            $del4 = mysqli_query($koneksi, "update barang_gudang set stok_total=stok_total-($dt[qty]*$_GET[stok]) where id=$dt[barang_gudang_id]");
        }
        if ($del1 and $del2 and $del3) {
            echo "S";
        }
    }
} else {
    // $sel2 = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_gudang_po where no_po_gudang='" . $sel1['no_po_pesan'] . "' and barang_gudang_id=" . $_GET['id_gudang'] . " and stok=" . $_GET['stok'] . ""));
    $sel3 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where barang_gudang_po_id=" . $_GET['barang_gudang_po_id'] . " and status_kirim=1"));
    $sel5 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where barang_gudang_po_id=" . $_GET['barang_gudang_po_id'] . " and status_demo=1"));
    if ($sel3 != 0 or $sel5 != 0) {
        echo "F";
    } else {
        $sel4 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where barang_gudang_po_id=" . $_GET['barang_gudang_po_id'] . ""));
        $del1 = mysqli_query($koneksi, "delete from barang_gudang_detail where barang_gudang_po_id=$_GET[barang_gudang_po_id]");
        $del2 = mysqli_query($koneksi, "delete from barang_gudang_po where id=$_GET[barang_gudang_po_id]");
        $del3 = mysqli_query($koneksi, "update barang_gudang set stok_total=stok_total-$sel4 where id=$_GET[id_gudang]");
        if ($del1 and $del2 and $del3) {
            echo "S";
        }
    }
}
