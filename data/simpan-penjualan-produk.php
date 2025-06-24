<?php
include("../config/koneksi.php");
include("../config/koneksi_kantin.php");
include("../include/API.php");
include("../include/helper.php");
session_start();
// error_reporting(0);
if (isset($_POST['kategori']) && $_POST['kategori'] == 'S') {
    $id_siswa = $_POST['id_siswa'];
    $id_guru = NULL;
} else {
    $id_siswa = NULL;
    $id_guru = $_POST['id_siswa'];
}
mysqli_begin_transaction($koneksi);
$stmt = $koneksi->prepare("insert into penjualan(tgl_jual, no_po_jual, id_siswa, id_guru, diskon_jual, total_harga, status_jual) values(current_timestamp(), ?, ?, ?, ?, ?, ?)");
$params = [$_POST['no_nota'], $id_siswa, $id_guru, $_POST['diskon_jual'], $_POST['total_harga'], $_POST['status']];
$types = getBindTypes($params);
$stmt->bind_param($types, ...$params);
$simpan1 = $stmt->execute();
if ($simpan1) {
    $id_penjualan = mysqli_insert_id($koneksi);
    if (isset($_POST['status']) && $_POST['status'] == '1') {
        $update1 = $koneksi->prepare("update penjualan_qty_temp set penjualan_id = ?, status = 1 where akun_id = ? and status = 0");
        $params1 = [$id_penjualan, $_SESSION['id']];
        $types1 = getBindTypes($params1);
        $update1->bind_param($types1, ...$params1);
        $detail = $update1->execute();
        if ($detail) {
            mysqli_commit($koneksi);
            die('S');
        } else {
            mysqli_rollback($koneksi);
            die('F');
        }
    } else {
        $update2 = $koneksi->prepare("
            INSERT INTO penjualan_qty (penjualan_id, produk_id, harga_jual_saat_itu, qty_jual)
            SELECT ?, produk_id, harga_jual_saat_itu, qty_jual
            FROM penjualan_qty_temp
            WHERE akun_id = ? AND status = 0
        ");
        $update2->bind_param("ii", $id_penjualan, $_SESSION['id']);
        $detail2 = $update2->execute();
        if ($detail2) {
            $tglNow = date("Y-m-d H:i:s");
            $pesan = "Saldo kamu di kurangi sebesar Rp. {$_POST['total_harga']} untuk pembelian di milu mart pada $tglNow";
            if (isset($_POST['kategori']) && $_POST['kategori'] == 'S') {
                $up = $koneksi_kantin->prepare("update ortu set saldo = saldo - ? where id_siswa = ?");
                $up->bind_param("ii", $_POST['total_harga'], $id_siswa);
                $up->execute();
                $up2 = $koneksi_kantin->prepare("insert into notifikasi(id_siswa, id_ortu, pesan, jenis, created_at, updated_at) values (?, (SELECT id from ortu where id_siswa = ?), ?, 'out', current_timestamp(), current_timestamp())");
                $up2->bind_param("iis", $id_siswa, $id_siswa, $pesan);
                $up2->execute();
            } else {
                $up = $koneksi_kantin->prepare("update guru set saldo = saldo - ? where id = ?");
                $up->bind_param("ii", $_POST['total_harga'], $id_guru);
                $up->execute();
                $up2 = $koneksi_kantin->prepare("insert into notifikasi(id_guru, pesan, jenis, created_at, updated_at) values (?, ?, 'out', current_timestamp(), current_timestamp())");
                $up2->bind_param("is", $id_guru, $pesan);
                $up2->execute();
            }
            mysqli_query($koneksi, "delete from penjualan_qty_temp where akun_id = " . $_SESSION['id'] . " and status = 0");

            mysqli_commit($koneksi);
            die('S');
        } else {
            mysqli_rollback($koneksi);
            die('F');
        }
    }
} else {
    mysqli_rollback($koneksi);
    die('F');
}
