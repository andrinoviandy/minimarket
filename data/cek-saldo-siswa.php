<?php
include("../config/koneksi_kantin.php");
include("../include/API.php");
session_start();
// error_reporting(0);
$sql = "select z.* from ((select a.id, a.kode,a.nama,a.whatsapp, a.foto, b.saldo, 'S' as kategori from siswa a inner join ortu b on a.id = b.id_siswa where a.kode = '" . $_GET['kode'] . "') union (select c.id, c.kode, c.nama, c.whatsapp, c.foto, c.saldo, 'G' as kategori from guru c where c.kode = '".$_GET['kode']."')) z  order by z.nama asc";

$result = mysqli_query($koneksi_kantin, $sql) or die("Error " . mysqli_error($koneksi_kantin));

//membuat array
$row = mysqli_fetch_assoc($result);

echo json_encode($row, JSON_PRETTY_PRINT);

//tutup koneksi_kantin ke database
mysqli_close($koneksi_kantin);
