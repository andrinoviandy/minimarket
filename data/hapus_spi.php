<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$up = mysqli_query($koneksi, "update barang_dikirim_detail,barang_teknisi_detail set status_spi=0 where barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi_id=" . $_GET['id_hapus'] . "");
$sel = mysqli_query($koneksi, "select * from barang_teknisi_detail barang_teknisi_id=" . $_GET['id_hapus'] . "");
while ($dt = mysqli_fetch_array($sel)) {
    $sel2 = mysqli_fetch_array(mysqli_query($koneksi, "select id from alat_uji_detail where barang_teknisi_detail_id = " . $dt['id'] . ""));
    mysqli_query($koneksi, "delete from alat_pelatihan where alat_uji_detail_id = " . $sel2['id'] . "");
    mysqli_query($koneksi, "delete from alat_uji_detail where id = " . $sel2['id'] . "");
}
$hapus2 = mysqli_query($koneksi, "delete from barang_teknisi_detail where barang_teknisi_id=" . $_GET['id_hapus'] . "");
$hapus = mysqli_query($koneksi, "delete from barang_teknisi where id=" . $_GET['id_hapus'] . "");
if ($up and $hapus2 and $hapus) {
    echo "S";
} else {
    echo "F";
}
