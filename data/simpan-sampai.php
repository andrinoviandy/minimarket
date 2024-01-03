<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$tgl_k = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dikirim where id=" . $_POST['id'] . ""));
  if ($_POST['tgl_sampai'] >= $tgl_k['tgl_kirim']) {
    $que = mysqli_query($koneksi, "update barang_dikirim set tgl_sampai='" . $_POST['tgl_sampai'] . "' where id=" . $_POST['id'] . "");
    if ($que) {
      //mysqli_query($koneksi, "insert into uji_f_i values('','".$_GET['id']."','0','0','')");
      echo "S";
    }
  } else {
    echo "F";
  }