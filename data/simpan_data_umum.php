<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$up = mysqli_query($koneksi, "update pemakai set nama_pemakai='" . $_POST['nama_pemakai'] . "', kontak1_pemakai='" . $_POST['kontak1'] . "', kontak2_pemakai='" . $_POST['kontak2'] . "', email_pemakai='" . $_POST['email_pemakai'] . "' where id=" . $_POST['pemakai_id'] . "");
$up2 = mysqli_query($koneksi, "update barang_dijual set tgl_jual='" . $_POST['tgl_jual'] . "', no_po_jual='" . $_POST['no_po'] . "', no_kontrak='" . $_POST['no_kontrak'] . "', pembeli_id='" . $_POST['pembeli'] . "',marketing='" . $_POST['marketing'] . "',subdis='" . $_POST['subdis'] . "' where id=" . $_POST['id'] . "");
if ($_POST['status_deal'] == 0) {
    $up3 = mysqli_query($koneksi, "update barang_dijual set status_deal=0 where no_po_jual='" . $_POST['no_po_jual'] . "'");
    mysqli_query($koneksi, "update utang_piutang set nominal=0 where no_faktur_no_po='" . $_POST['no_po_jual'] . "'");
} else {
    $upp = mysqli_query($koneksi, "update barang_dijual set status_deal=0 where no_po_jual='" . $_POST['no_po_jual'] . "'");
    $up3 = mysqli_query($koneksi, "update barang_dijual set status_deal=1 where id='" . $_POST['status_deal'] . "'");
    $data = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dijual where id=" . $_POST['status_deal'] . ""));
    $jml = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty_jual*harga_jual_saat_itu) as total from barang_dijual_qty where barang_dijual_id=" . $_POST['status_deal'] . ""));
    $dpp = ($jml['total'] + $_POST['ongkir']) / 1.1;
    mysqli_query($koneksi, "update utang_piutang set nominal=" . ($dpp - (($dpp * $_POST['ppn_jual'] / 100) + ($dpp * $_POST['pph'] / 100) + ($dpp * $_POST['zakat'] / 100) + $_POST['biaya_bank'])) . " where no_faktur_no_po='" . $_POST['no_po_jual'] . "'");
}
if ($up and $up2) {
    // echo "<script>window.location='index.php?page=ubah_jual_barang_uang&id=$_GET[id]'</script>";
    echo "S";
} else {
    echo "F";
}
