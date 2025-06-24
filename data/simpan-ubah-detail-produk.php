<?php
include("../config/koneksi.php");
include("../include/API.php");
include("../include/helper.php");
session_start();
// error_reporting(0);
$stmt = $koneksi->prepare("update produk_detail set qrcode = ?, tgl_expired = ? where id = ?");
$params = [$_POST['qrcode'], $_POST['tgl_expired'], $_POST['id_ubah']];
$types = getBindTypes($params);
$stmt->bind_param($types, ...$params);
$update = $stmt->execute();
if ($update) {
    echo "S";
} else {
    echo "F";
}
