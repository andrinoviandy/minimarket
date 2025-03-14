<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
$sel = mysqli_query($koneksi, "select * from barang_kembali,barang_kembali_detail where barang_kembali.id=barang_kembali_detail.barang_kembali_id and barang_kembali.id=" . $_POST['id_hapus'] . "");
while ($up = mysqli_fetch_array($sel)) {
    $update = mysqli_query($koneksi, "update barang_dikirim_detail,barang_gudang_detail set status_kirim=1, status_kerusakan=0, status_kembali_ke_gudang=0, status_batal=0 where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_gudang_detail_id=" . $up['barang_gudang_detail_id'] . "");
}
if ($update) {
    $del = mysqli_query($koneksi, "delete from barang_kembali_detail where barang_kembali_id=" . $_POST['id_hapus'] . "");
    $del2 = mysqli_query($koneksi, "delete from barang_kembali where id=" . $_POST['id_hapus'] . "");
    //mysqli_query($koneksi, "update barang_dikirim set status_barang_kembali=0 where id=".$sel['barang_dikirim_id']."");
    echo "S";
} else {
    echo "F";
}
