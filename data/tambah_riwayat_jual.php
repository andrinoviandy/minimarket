<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$sel = mysqli_query($koneksi, "select * from barang_dijual where id=" . $_POST['riwayat'] . "");
$dt_sel = mysqli_fetch_array($sel);
$simpan1 = mysqli_query($koneksi, "insert into barang_dijual values('','" . $dt_sel['tgl_jual'] . "','" . $dt_sel['no_po_jual'] . "','" . $dt_sel['no_kontrak'] . "','" . $dt_sel['pembeli_id'] . "','" . $dt_sel['pemakai_id'] . "','" . $dt_sel['marketing'] . "','" . $dt_sel['subdis'] . "','" . $dt_sel['ongkir'] . "','" . $dt_sel['diskon_jual'] . "','" . $dt_sel['total_harga'] . "','" . $dt_sel['ppn_jual'] . "','" . $dt_sel['pph'] . "','" . $dt_sel['zakat'] . "','" . $dt_sel['biaya_bank'] . "','" . $dt_sel['neto'] . "','0','0')");

$id_max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as idd from barang_dijual"));
$sel2 = mysqli_query($koneksi, "select * from barang_dijual_qty where barang_dijual_id=" . $_POST['riwayat'] . "");
while ($dt = mysqli_fetch_array($sel2)) {
    $simpan2 = mysqli_query($koneksi, "insert into barang_dijual_qty values('','" . $id_max['idd'] . "','" . $dt['barang_gudang_id'] . "','" . $dt['harga_jual_saat_itu'] . "','" . $dt['qty_jual'] . "','" . $dt['okr'] . "','0')");
}
if ($simpan1 and $simpan2) {
    echo "S";
} else {
    echo "F";
}
