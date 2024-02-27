<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$query = mysqli_query($koneksi, "select *,principle.id as id_principle from barang_pesan,principle where principle.id=barang_pesan.principle_id and barang_pesan.id='" . $_POST['id'] . "'");
$data = mysqli_fetch_array($query);
$s = mysqli_query($koneksi, "update utang_piutang set nominal=" . $_POST['dalam_rupiah'] . " where no_faktur_no_po='" . $data['no_po_pesan'] . "'");
$simpan = mysqli_query($koneksi, "update barang_pesan set total_price='" . $_POST['total_price'] . "', total_price_ppn='" . $_POST['total_price_ppn'] . "', cost_byair='" . $_POST['cost_byair'] . "', cost_cf='" . $_POST['cost_cf'] . "',nilai_tukar='" . $_POST['nilai_tukar'] . "' where id=$_POST[id]");
if ($simpan and $s) {
    echo "S";
} else {
    echo "F";
}
