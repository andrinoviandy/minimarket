<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
// if ($_POST['setor_ambil'] == 1) {
$s1 = mysqli_query($koneksi, "insert into pinjaman_bayar(id, pinjaman_id, tgl_transaksi, angsuran, persen_bunga, bunga, nominal_bayar, keterangan, operator) values(UUID(),'" . $_POST['pinjaman_id'] . "','" . $_POST['tgl_transaksi'] . "', '" . str_replace(".", "", $_POST['angsuran']) . "','" . $_POST['persen_bunga'] . "', '" . str_replace(".", "", $_POST['bunga']) . "', '" . str_replace(".", "", $_POST['nominal_bayar']) . "', '" . $_POST['keterangan'] . "', '" . $_SESSION['nama'] . "')");
if ($s1) {
    echo "S";
} else {
    echo "F";
}
// } else {
//     $setor = mysqli_fetch_array(mysqli_query($koneksi, "select sum(a.nominal) as total from tabungan_setor_ambil a where a.setor_ambil = 1 and a.tabungan_id = '" . $_POST['tabungan_id'] . "'"));
//     $ambil = mysqli_fetch_array(mysqli_query($koneksi, "select sum(a.nominal) as total from tabungan_setor_ambil a where a.setor_ambil = 2 and a.tabungan_id = '" . $_POST['tabungan_id'] . "'"));
//     if (intval($ambil['total']) + intval(str_replace(".", "", $_POST['nominal'])) <= $setor['total']) {
//         $s1 = mysqli_query($koneksi, "insert into tabungan_setor_ambil values(UUID(),'" . $_POST['tabungan_id'] . "','" . $_POST['tgl_transaksi'] . "'," . $_POST['setor_ambil'] . ", '" . str_replace(".", "", $_POST['nominal']) . "', '" . $_POST['keterangan'] . "')");
//         if ($s1) {
//             die("S");
//         } else {
//             die("F");
//         }
//     } else {
//         $kurang = number_format((intval($ambil['total']) + intval(str_replace(".", "", $_POST['nominal'])) - $setor['total']), 0, ',', '.');
//         die("L&" . $kurang);
//     }
// }
