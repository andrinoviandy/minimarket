<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
$ce = mysqli_num_rows(mysqli_query($koneksi, "select * from pembelian_detail_temp where akun_id=" . $_SESSION['id'] . ""));
if ($ce != 0) {
    $id_supplier = $_SESSION['supplier_id'];
    $total = mysqli_fetch_array(mysqli_query($koneksi, "select sum(total_harga) as total from pembelian_detail_temp where akun_id = ".$_SESSION['id'].""));
    $simpan1 = mysqli_query($koneksi, "insert into pembelian values('','" . $_SESSION['tgl_po'] . "','" . $_SESSION['no_po'] . "','$id_supplier','" . $_SESSION['ppn'] . "','" . $_SESSION['cara_pembayaran'] . "','" . $_SESSION['catatan'] . "','0','" . $total['total'] . "','" . $total['total']+($total['total']*($_SESSION['ppn']/100)) . "','0','','$_SESSION[nama]')");
    $d1 = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_pesan from pembelian"));
    $id_pesan = $d1['id_pesan'];
    //simpan barang pesan detail
    $q2 = mysqli_query($koneksi, "select * from pembelian_detail_temp where akun_id=" . $_SESSION['id'] . "");
    while ($d2 = mysqli_fetch_array($q2)) {
        $simpan2 = mysqli_query($koneksi, "insert into pembelian_detail values('','$id_pesan','" . $d2['produk_id'] . "','" . $d2['qty'] . "','" . $d2['harga_beli'] . "','" . $d2['diskon'] . "','" . $d2['total_harga'] . "','0')");
    }

    if ($simpan1 and $simpan2) {
        // $Result = mysqli_query($koneksi, "insert into utang_piutang values('','Hutang','" . $_SESSION['no_po'] . "','" . $_POST['tgl_input'] . "','" . $_POST['jatuh_tempo'] . "','" . $_POST['nominal'] . "','" . $_POST['klien'] . "','" . $_POST['deskripsi'] . "','0')");
        mysqli_query($koneksi, "delete from pembelian_detail_temp where akun_id=" . $_SESSION['id'] . "");
        die("S");
    } else {
        die('F');
    }
} else {
    die("K");
}
