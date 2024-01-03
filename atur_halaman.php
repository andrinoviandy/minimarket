<?php
require_once('config/koneksi.php');
if (isset($_POST['jumlah_limit'])) {
  $up = mysqli_query($koneksi, "update limiter set jumlah_limit=" . $_POST['jumlah_limit'] . "");
  if ($up) {
    echo "S";
  } else {
    echo "F";
  }
}
