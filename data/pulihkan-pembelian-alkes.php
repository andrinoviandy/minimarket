<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$up = mysqli_query($koneksi, "update barang_pesan set status_po_batal=0,deskripsi_batal='' where id=" . $_POST['id_pulih'] . "");
if ($up) {
    echo "S";
} else {
    echo "F";
}
