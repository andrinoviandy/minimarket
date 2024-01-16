<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$u = mysqli_query($koneksi, "update barang_gudang_detail_rusak set teknisi_id='" . $_POST['id_teknisi'] . "' where id=$_POST[id]");
if ($u) {
    echo "S";
} else {
    echo "F";
}
