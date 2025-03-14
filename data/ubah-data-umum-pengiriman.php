<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
$Result = mysqli_query($koneksi, "update barang_dikirim set nama_paket='" . $_POST['nama_paket'] . "', no_pengiriman='" . $_POST['no_pengiriman'] . "', tgl_kirim='" . $_POST['tgl_kirim'] . "', ekspedisi='" . $_POST['ekspedisi'] . "', via_pengiriman='" . $_POST['via_kirim'] . "', estimasi_barang_sampai='" . $_POST['estimasi'] . "', biaya_pengiriman='" . $_POST['biaya_jasa'] . "', tgl_sampai='" . $_POST['tgl_sampai'] . "', keterangan = '" . $_POST['keterangan'] . "' where id=" . $_POST['id'] . "");
if ($Result) {
    echo "S";
} else {
    echo "F";
}
