<?php
include("../config/koneksi.php");
include("../config/koneksi_kantin.php");
include("../include/API.php");
session_start();
// error_reporting(0);
if (isset($_POST['kategori']) && $_POST['kategori'] == 'S') {
    $id_siswa = $_POST['id_siswa'];
    $id_guru = NULL;
} else {
    $id_siswa = NULL;
    $id_guru = $_POST['id_siswa'];
}

$simpan1 = mysqli_query($koneksi, "insert into penjualan(tgl_jual, no_po_jual, id_siswa, id_guru, diskon_jual, total_harga, status_jual) values(current_timestamp(), '" . $_POST['no_nota'] . "', '$id_siswa', '$id_guru','$_POST[diskon_jual]','$_POST[total_harga]','$_POST[status]')");

if ($simpan1) {
    $id_penjualan = mysqli_insert_id($koneksi);
    if (isset($_POST['status']) && $_POST['status'] == '1') {
        $detail = mysqli_query($koneksi, "update penjualan_qty_temp set penjualan_id = $id_penjualan, status = 1 where akun_id = " . $_SESSION['id'] . " and status = 0");
        if ($detail) {
            die('S');
        } else {
            die('F');
        }
    } else {
        $detail2 = mysqli_query($koneksi, "insert into penjualan_qty(penjualan_id, produk_id, harga_jual_saat_itu, qty_jual) select $id_penjualan as penjualan_id, produk_id, harga_jual_saat_itu, qty_jual from penjualan_qty_temp where akun_id = " . $_SESSION['id'] . " and status = 0");
        if ($detail2) {
            $tglNow = date("Y-m-d H:i:s");
            $pesan = "Saldo kamu di kurangi sebesar Rp. {$_POST['total_harga']} untuk pembelian di milu mart pada $tglNow";
            if (isset($_POST['kategori']) && $_POST['kategori'] == 'S') {
                mysqli_query($koneksi_kantin, "update ortu set saldo = saldo-$_POST[total_harga] where id_siswa = " . $id_siswa . "");
                mysqli_query($koneksi_kantin, "insert into notifikasi(id_siswa, id_ortu, pesan, jenis, created_at, updated_at) values ('$id_siswa', (SELECT id from ortu where id_siswa = '$id_siswa'), '$pesan', 'out', current_timestamp(), current_timestamp())");
            } else {
                mysqli_query($koneksi_kantin, "update guru set saldo = saldo-$_POST[total_harga] where id = " . $id_guru . "");
                mysqli_query($koneksi_kantin, "insert into notifikasi(id_guru, pesan, jenis, created_at, updated_at) values ('$id_guru', '$pesan', 'out', current_timestamp(), current_timestamp())");
            }
            mysqli_query($koneksi, "delete from penjualan_qty_temp where akun_id = " . $_SESSION['id'] . " and status = 0");
            die('S');
        } else {
            die('F');
        }
    }
} else {
    die('F');
}
