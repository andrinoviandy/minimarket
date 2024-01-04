<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
$q = mysqli_query($koneksi, "update barang_teknisi set tgl_spk='" . $_POST['tgl_spk'] . "', no_spk='" . $_POST['no_spk'] . "', keterangan_spk='" . $_POST['keterangan_spk'] . "' where id=" . $_POST['id_spk'] . "");
if ($q) {
    echo "S";
} else {
    echo "F";
}
