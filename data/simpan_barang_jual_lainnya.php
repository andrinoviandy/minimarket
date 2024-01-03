<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$_SESSION['ongkir'] = str_replace(".", "", $_POST['ongkir']);
$_SESSION['diskon'] = $_POST['diskon'];
$_SESSION['ppn'] = $_POST['ppn'];
$_SESSION['pph'] = $_POST['pph'];
$_SESSION['zakat'] = $_POST['zakat'];
$_SESSION['biaya_bank'] = str_replace(".", "", $_POST['biaya_bank']);
