<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
if ($_POST['ongkir'] != '') {
    $ongkir = str_replace(".", "", $_POST['ongkir']);
} else {
    $ongkir = 0;
}
if ($_POST['diskon'] != '') {
    $diskon = $_POST['diskon'];
} else {
    $diskon = 0;
}
if ($_POST['ppn'] != '') {
    $ppn = $_POST['ppn'];
} else {
    $ppn = 0;
}

$jml = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty_jual*harga_jual_saat_itu) as total from barang_dijual_qty where barang_dijual_id=" . $_POST['idd'] . ""));
$dpp = ($jml['total'] + $ongkir);
$neto = ($dpp - ($dpp * $diskon / 100) + ($dpp * $ppn / 100));
$sm = mysqli_query($koneksi, "update barang_dijual set ongkir=$ongkir, diskon_jual=$diskon, total_harga=$jml[total], ppn_jual=$ppn, neto='" . $neto . "' where id=" . $_POST['idd'] . "");
if ($sm) {
    $data = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dijual where id=" . $_POST['idd'] . ""));
    if ($data['status_deal'] == 1) {
        mysqli_query($koneksi, "update utang_piutang set nominal=" . $neto . " where no_faktur_no_po='" . $data['no_po_jual'] . "'");
    }
    echo "S";
} else {
    echo "F";
}
