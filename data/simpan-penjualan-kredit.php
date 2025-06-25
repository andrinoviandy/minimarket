<?php
include("../config/koneksi.php");
include("../include/API.php");
include("../include/helper.php");
session_start();
// error_reporting(0);
if (isset($_POST['id_pelanggan'])) {
    mysqli_begin_transaction($koneksi);
    $frm = explode("-", $_POST['id_pelanggan']);
    if ($frm[1] == 'pelanggan') {
        $id_pelanggan = intval($frm[0]);
        $pelanggan = $koneksi->prepare("insert into penjualan(tgl_jual, no_po_jual, id_pelanggan, diskon_jual, total_harga, tgl_jatuh_tempo, status_jual) values(current_timestamp(), ?, ?, ?, ?, ?, ?)");
        $params = [$_POST['no_nota'], $id_pelanggan, $_POST['diskon_jual'], $_POST['total_harga'], $_POST['tgl_jatuh_tempo'], $_POST['status']];
        $types = getBindTypes($params);
        $pelanggan->bind_param($types, ...$params);
        $simpan1 = $pelanggan->execute();
        if ($simpan1) {
            $id_penjualan = mysqli_insert_id($koneksi);
            $update1 = $koneksi->prepare("
                INSERT INTO penjualan_qty (penjualan_id, produk_id, harga_jual_saat_itu, qty_jual)
                SELECT ?, produk_id, harga_jual_saat_itu, qty_jual
                FROM penjualan_qty_temp
                WHERE akun_id = ? AND status = 0
            ");
            $update1->bind_param("ii", $id_penjualan, $_SESSION['id']);
            $detail1 = $update1->execute();
            if ($detail1) {
                $q_stok = $koneksi->prepare("select * from penjualan_qty_temp where akun_id = ? and status = 0");
                $q_stok->bind_param("i", $_SESSION['id']);
                $q_stok->execute();
                $result = $q_stok->get_result();
                while ($dt = $result->fetch_assoc()) {
                    mysqli_query($koneksi, "update produk set stok = stok - $dt[qty_jual] where id = $dt[produk_id]");
                }
                mysqli_query($koneksi, "delete from penjualan_qty_temp where akun_id = " . $_SESSION['id'] . " and status = 0");
                mysqli_commit($koneksi);
                die('S');
            } else {
                mysqli_rollback($koneksi);
                die('F');
            }
        } else {
            mysqli_rollback($koneksi);
            die('F');
        }
    } else if ($frm[1] == 'siswa') {
        $id_siswa = intval($frm[0]);
        $siswa = $koneksi->prepare("insert into penjualan(tgl_jual, no_po_jual, id_siswa, diskon_jual, total_harga, tgl_jatuh_tempo, status_jual) values(current_timestamp(), ?, ?, ?, ?, ?, ?)");
        $params2 = [$_POST['no_nota'], $id_siswa, $_POST['diskon_jual'], $_POST['total_harga'], $_POST['tgl_jatuh_tempo'], $_POST['status']];
        $types2 = getBindTypes($params2);
        $siswa->bind_param($types2, ...$params2);
        $simpan2 = $siswa->execute();
        if ($simpan2) {
            $id_penjualan = mysqli_insert_id($koneksi);
            $update2 = $koneksi->prepare("
                INSERT INTO penjualan_qty (penjualan_id, produk_id, harga_jual_saat_itu, qty_jual)
                SELECT ?, produk_id, harga_jual_saat_itu, qty_jual
                FROM penjualan_qty_temp
                WHERE akun_id = ? AND status = 0
            ");
            $update2->bind_param("ii", $id_penjualan, $_SESSION['id']);
            $detail2 = $update2->execute();
            if ($detail2) {
                $q_stok = $koneksi->prepare("select * from penjualan_qty_temp where akun_id = ? and status = 0");
                $q_stok->bind_param("i", $_SESSION['id']);
                $q_stok->execute();
                $result = $q_stok->get_result();
                while ($dt = $result->fetch_assoc()) {
                    mysqli_query($koneksi, "update produk set stok = stok - $dt[qty_jual] where id = $dt[produk_id]");
                }
                mysqli_query($koneksi, "delete from penjualan_qty_temp where akun_id = " . $_SESSION['id'] . " and status = 0");
                mysqli_commit($koneksi);
                die('S');
            } else {
                mysqli_rollback($koneksi);
                die('F');
            }
        } else {
            mysqli_rollback($koneksi);
            die('F');
        }
    } else if ($frm[1] == 'guru') {
        $id_guru = intval($frm[0]);
        $guru = $koneksi->prepare("insert into penjualan(tgl_jual, no_po_jual, id_guru, diskon_jual, total_harga, tgl_jatuh_tempo, status_jual) values(current_timestamp(), ?, ?, ?, ?, ?, ?)");
        $params3 = [$_POST['no_nota'], $id_guru, $_POST['diskon_jual'], $_POST['total_harga'], $_POST['tgl_jatuh_tempo'], $_POST['status']];
        $types3 = getBindTypes($params3);
        $guru->bind_param($types3, ...$params3);
        $simpan3 = $guru->execute();
        if ($simpan3) {
            $id_penjualan = mysqli_insert_id($koneksi);
            $update3 = $koneksi->prepare("
                INSERT INTO penjualan_qty (penjualan_id, produk_id, harga_jual_saat_itu, qty_jual)
                SELECT ?, produk_id, harga_jual_saat_itu, qty_jual
                FROM penjualan_qty_temp
                WHERE akun_id = ? AND status = 0
            ");
            $update3->bind_param("ii", $id_penjualan, $_SESSION['id']);
            $detail3 = $update3->execute();
            if ($detail3) {
                $q_stok = $koneksi->prepare("select * from penjualan_qty_temp where akun_id = ? and status = 0");
                $q_stok->bind_param("i", $_SESSION['id']);
                $q_stok->execute();
                $result = $q_stok->get_result();
                while ($dt = $result->fetch_assoc()) {
                    mysqli_query($koneksi, "update produk set stok = stok - $dt[qty_jual] where id = $dt[produk_id]");
                }
                mysqli_query($koneksi, "delete from penjualan_qty_temp where akun_id = " . $_SESSION['id'] . " and status = 0");
                mysqli_commit($koneksi);
                die('S');
            } else {
                mysqli_rollback($koneksi);
                die('F');
            }
        } else {
            mysqli_rollback($koneksi);
            die('F');
        }
    } else {
        mysqli_rollback($koneksi);
        die('F');
    }
} else {
    die('F');
}
