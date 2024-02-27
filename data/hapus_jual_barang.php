<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dijual where id=" . $_POST['id_barang_jual'] . ""));
$sel1 = mysqli_fetch_array(mysqli_query($koneksi, "select okr from barang_dijual_qty where id=" . $_POST['id_hapus'] . ""));
$okr = $data['ongkir'] - $sel1['okr'];
mysqli_query($koneksi, "update barang_dijual set ongkir=$okr where id=" . $_POST['id_barang_jual'] . "");
// $del = mysqli_query($koneksi, "delete barang_dijual_qty, barang_dijual_qty_detail from barang_dijual_qty JOIN barang_dijual_qty_detail ON barang_dijual_qty.id = barang_dijual_qty_detail.barang_dijual_qty_id where barang_dijual_qty.id=" . $_POST['id_hapus'] . "");
$del = mysqli_query($koneksi, "delete from barang_dijual_qty_detail where barang_dijual_qty_id=" . $_POST['id_hapus'] . "");
$del2 = mysqli_query($koneksi, "delete from barang_dijual_qty where id=" . $_POST['id_hapus'] . "");
$jml = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty_jual*harga_jual_saat_itu) as total from barang_dijual_qty where barang_dijual_id=" . $_POST['id_barang_jual'] . ""));
if ($del) {
    // echo "S";
    // $dpp = ($jml['total'] + $data['ongkir']) / 1.1;
    $dpp = $_POST['dpp'] == 1 ? (($jml['total'] + $data['ongkir']) / 1.1) : ($jml['total'] + $data['ongkir']);
    $diskon = $dpp * $data['diskon_jual'] / 100;
    $ppn = $dpp * $data['ppn_jual'] / 100;
    $pph = $dpp * $data['pph'] / 100;
    $zakat = $dpp * $data['zakat'] / 100;
    $biaya_bank = $data['biaya_bank'];
    $neto = $_POST['dpp'] == 1 ? ($dpp - ($ppn + $pph + $zakat + $biaya_bank)) : ($dpp - $diskon + $ppn);

    // mysqli_query($koneksi, "update barang_dijual set total_harga=$jml[total], neto='" . ($dpp - ($jml['total'] * $data['diskon_jual'] / 100) - ($dpp * $data['ppn_jual'] / 100) - ($dpp * $data['pph'] / 100) - $data['zakat'] - $data['biaya_bank']) . "' where id=" . $_POST['id_barang_jual'] . "");
    mysqli_query($koneksi, "update barang_dijual set total_harga=$jml[total], neto='" . $neto . "' where id=" . $_POST['id_barang_jual'] . "");

    if ($data['status_deal'] == 1) {
        // mysqli_query($koneksi, "update utang_piutang set nominal=" . ($dpp - ($jml['total'] * $data['diskon_jual'] / 100) - ($dpp * $data['ppn_jual'] / 100) - ($dpp * $data['pph'] / 100) - $data['zakat'] - $data['biaya_bank']) . " where no_faktur_no_po='" . $data['no_po_jual'] . "'");
        mysqli_query($koneksi, "update utang_piutang set nominal=" . $neto . " where no_faktur_no_po='" . $data['no_po_jual'] . "'");
    }
    // echo "<script>sbah_jual_barang_uang&id=$_POST[id]'</script>";
} else {
    echo "F";
}
