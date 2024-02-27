<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$total_harga = ($_POST['qty']*intval(str_replace(".","",$_POST['harga_perunit']))) - ($_POST['diskon'] / 100 * ($_POST['qty']*intval(str_replace(".","",$_POST['harga_perunit']))));
$simpan = mysqli_query($koneksi, "insert into barang_pesan_detail values('','" . $_POST['id'] . "','" . $_POST['id_akse'] . "','" . $_POST['qty'] . "','" . $_POST['mata_uang_id'] . "','" . str_replace(".","",$_POST['harga_perunit']) . "','" . $_POST['diskon'] . "','" . $total_harga . "','" . $_POST['catatan_spek'] . "','')");
// mysqli_query($koneksi, "update barang_pesan set cost_byair=0, cost_cf=0 where id=$_POST[id]");
if ($simpan) {
    $detail = mysqli_fetch_array(mysqli_query($koneksi, "select sum(harga_total) as total from barang_pesan_detail where barang_pesan_id='" . $_POST['id'] . "'"));
    $data = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_pesan where id='" . $_POST['id'] . "'"));

    $simpan = mysqli_query($koneksi, "update barang_pesan set total_price='" . $detail['total'] . "', total_price_ppn='" . ($detail['total'] + ($data['ppn'] / 100 * $detail['total'])) . "', cost_cf='".(($detail['total'] + ($data['ppn'] / 100 * $detail['total'])) + $data['cost_byair'])."' where id= " . $_POST['id'] . "");
    $s = mysqli_query($koneksi, "update utang_piutang set nominal=" . (($detail['total'] + ($data['ppn'] / 100 * $detail['total'])) + $data['cost_byair']) * $data['nilai_tukar'] . " where no_faktur_no_po='" . $data['no_po_pesan'] . "'");
    echo "S";
} else {
    echo "F";
}
