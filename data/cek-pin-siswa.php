<?php
include("../config/koneksi_kantin.php");
include("../include/API.php");
session_start();
// error_reporting(0);
if (isset($_GET['kategori']) && $_GET['kategori'] == 'S') {
    $siswa = mysqli_fetch_array(mysqli_query($koneksi_kantin, "select pin from siswa where id = ".$_GET['id_siswa'].""));
    $hashed_pin = hash('sha256', $siswa['pin']);
    if ($hashed_pin === $_GET['pin']) {
        die('S');
    } else {
        die('F');
    }
} else {
    $guru = mysqli_fetch_array(mysqli_query($koneksi_kantin, "select pin from guru where id = ".$_GET['id_siswa'].""));
    $hashed_pin = hash('sha256', $guru['pin']);
    if ($hashed_pin === $_GET['pin']) {
        die('S');
    } else {
        die('F');
    }
}