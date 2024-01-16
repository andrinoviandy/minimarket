<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
$update = mysqli_query($koneksi, "update barang_dikirim_detail_hash set barang_gudang_detail_id = '$_POST[no_seri]' where id = '$_POST[id]'");
if ($update) {
    echo "S";
} else {
    echo "S";
}
