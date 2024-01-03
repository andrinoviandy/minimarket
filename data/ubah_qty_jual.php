<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);

$upt = mysqli_query($koneksi, "update barang_dijual_qty set qty_jual=" . $_POST['qty'] . " where id=" . $_POST['id_ubahitem'] . "");
$upt2 = mysqli_query($koneksi, "update barang_dijual_qty_detail set barang_dijual_qty_detail.jml_total = barang_dijual_qty_detail.jml_satuan*$_POST[qty] where barang_dijual_qty_id=" . $_POST['id_ubahitem'] . "");
if ($upt && $upt2) {
    $jml = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty_jual*harga_jual_saat_itu) as total from barang_dijual_qty where barang_dijual_id=" . $_POST['id_barang_jual'] . ""));
    $data = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dijual where id=" . $_POST['id_barang_jual'] . ""));
    $dpp = ($jml['total'] + $data['ongkir']) / 1.1;
    mysqli_query($koneksi, "update barang_dijual set total_harga=" . $jml['total'] . ", neto='" . ($dpp - ($jml['total'] * $data['diskon_jual'] / 100) - (($dpp * $data['ppn_jual'] / 100) + ($dpp * $data['pph'] / 100) + $data['zakat'] + $data['biaya_bank'])) . "' where id=" . $_POST['id_barang_jual'] . "");

    //neto='".($dpp-(($dpp*$ppn/100)+($dpp*$pph/100)+($dpp*$zakat/100)+$biaya_bank))."'
    if ($data['status_deal'] == 1) {
        mysqli_query($koneksi, "update utang_piutang set nominal=" . ($dpp - ($jml['total'] * $data['diskon_jual'] / 100) - ($dpp * $data['ppn_jual'] / 100) - ($dpp * $data['pph'] / 100) - $data['zakat'] - $data['biaya_bank']) . " where no_faktur_no_po='" . $data['no_po_jual'] . "'");
    }
    echo "S";
} else {
    echo "F";
}
