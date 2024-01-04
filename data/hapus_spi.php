<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$up = mysqli_query($koneksi, "update barang_dikirim_detail,barang_teknisi_detail set status_spi=0 where barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi_id=" . $_GET['id_hapus'] . "");
$hapus2 = mysqli_query($koneksi, "delete from barang_teknisi_detail where barang_teknisi_id=" . $_GET['id_hapus'] . "");
$hapus = mysqli_query($koneksi, "delete from barang_teknisi where id=" . $_GET['id_hapus'] . "");
if ($up and $hapus2 and $hapus) {
    echo "S";
} else {
    echo "F";
}
