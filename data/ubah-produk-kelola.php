<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$total_harga = ($_POST['qty2'] * str_replace('.', '', $_POST['harga_perunit2'])) - ($_POST['diskon2'] / 100 * ($_POST['qty2'] * str_replace('.', '', $_POST['harga_perunit2'])));
$Result = mysqli_query($koneksi, "update pembelian_detail set qty=" . $_POST['qty2'] . ", harga_beli=" . str_replace('.', '', $_POST['harga_perunit2']) . ", diskon=" . $_POST['diskon2'] . ", total_harga=" . $total_harga . " where id=" . $_POST['id_ubah'] . "");
if ($Result) {
    $detail = mysqli_fetch_array(mysqli_query($koneksi, "select sum(total_harga) as total from pembelian_detail where pembelian_id='" . $_POST['id'] . "'"));
    $data = mysqli_fetch_array(mysqli_query($koneksi, "select * from pembelian where id='" . $_POST['id'] . "'"));

    $simpan = mysqli_query($koneksi, "update pembelian set total_harga='" . $detail['total'] . "', total_harga_ppn='" . ($detail['total'] + ($data['ppn'] / 100 * $detail['total'])) . "' where id= " . $_POST['id'] . "");
    // $s = mysqli_query($koneksi, "update utang_piutang set nominal=" . (($detail['total'] + ($data['ppn'] / 100 * $detail['total'])) + $data['cost_byair']) * $data['nilai_tukar'] . " where no_faktur_no_po='" . $data['no_po_pesan'] . "'");
    echo "S";
} else {
    echo "F";
}
