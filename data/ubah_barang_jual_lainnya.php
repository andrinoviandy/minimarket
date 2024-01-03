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
if ($_POST['pph'] != '') {
    $pph = $_POST['pph'];
} else {
    $pph = 0;
}
if ($_POST['zakat'] != '') {
    $zakat = $_POST['zakat'];
} else {
    $zakat = 0;
}
if ($_POST['biaya_bank'] != '') {
    $biaya_bank = str_replace(".", "", $_POST['biaya_bank']);
} else {
    $biaya_bank = 0;
}

$jml = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty_jual*harga_jual_saat_itu) as total from barang_dijual_qty where barang_dijual_id=" . $_POST['idd'] . ""));
$dpp = ($jml['total'] + $ongkir) / 1.1;
$sm = mysqli_query($koneksi, "update barang_dijual set ongkir=$ongkir, diskon_jual=$diskon, total_harga=$jml[total], ppn_jual=$ppn, pph=$pph, zakat=$zakat, biaya_bank=$biaya_bank, neto='" . ($dpp - (($dpp * $ppn / 100) + ($dpp * $pph / 100) + ($dpp * $zakat / 100) + $biaya_bank)) . "' where id=" . $_POST['idd'] . "");
if ($sm) {
    $data = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dijual where id=" . $_POST['idd'] . ""));
    if ($data['status_deal'] == 1) {
        mysqli_query($koneksi, "update utang_piutang set nominal=" . ($dpp - (($dpp * $data['ppn_jual'] / 100) + ($dpp * $data['pph'] / 100) + ($dpp * $data['zakat'] / 100) + $data['biaya_bank'])) . " where no_faktur_no_po='" . $data['no_po_jual'] . "'");
    }
    echo "S";
} else {
    echo "F";
}
