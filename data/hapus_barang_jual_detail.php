<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$del = mysqli_query($koneksi, "delete from barang_dijual_qty_detail_hash where id=" . $_POST['id_hapus'] . "");
if ($del) {
    echo "S";
} else {
    echo "F";
}
