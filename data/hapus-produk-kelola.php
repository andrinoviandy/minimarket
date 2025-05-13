<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$del = mysqli_query($koneksi, "delete from pembelian_detail where id=" . $_POST['id_hapus'] . "");
if ($del) {
    // mysqli_query($koneksi, "update barang_pesan set cost_byair=0, cost_cf=0 where id=$_POST[id]");
    $detail = mysqli_fetch_array(mysqli_query($koneksi, "select sum(total_harga) as total from pembelian_detail where pembelian_id='" . $_POST['id'] . "'"));
    $data = mysqli_fetch_array(mysqli_query($koneksi, "select * from pembelian where id='" . $_POST['id'] . "'"));

    $simpan = mysqli_query($koneksi, "update pembelian set total_harga='" . $detail['total'] . "', total_harga_ppn='" . ($detail['total'] + ($data['ppn'] / 100 * $detail['total'])) . "' where id= " . $_POST['id'] . "");
    // $s = mysqli_query($koneksi, "update utang_piutang set nominal=" . (($detail['total'] + ($data['ppn'] / 100 * $detail['total'])) + $data['cost_byair']) * $data['nilai_tukar'] . " where no_faktur_no_po='" . $data['no_po_pesan'] . "'");
    echo "S";
} else {
    echo "F";
}
