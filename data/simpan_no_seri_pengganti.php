<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
$cek_no_seri = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dikirim_detail_pengganti_hash where barang_dikirim_detail_id='" . $_POST['barang_dikirim_detail_id'] . "'"));
  if ($cek_no_seri == 0) {
    $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_pengganti_hash values('','" . $_SESSION['id'] . "','" . $_POST['barang_dikirim_detail_id'] . "','" . $_POST['jml_kirim'] . "','" . $_POST['kategori_brg'] . "','" . $_POST['barang_gudang_set_id'] . "','" . $_POST['barang_gudang_satuan_id'] . "','" . $_POST['barang_gudang_akse_id'] . "','" . $_POST['no_seri'] . "')");
    if ($simpan) {
      echo "S";
    } else {
        echo "F";
    }
  } else {
    $simpan = mysqli_query($koneksi, "update barang_dikirim_detail_pengganti_hash set akun_id='" . $_SESSION['id'] . "',barang_gudang_detail_id='" . $_POST['no_seri'] . "' where barang_dikirim_detail_id='" . $_POST['barang_dikirim_detail_id'] . "'");
    if ($simpan) {
      echo "S";
    } else {
        echo "F";
    }
  }
?>
