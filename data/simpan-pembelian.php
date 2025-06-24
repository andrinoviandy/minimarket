<?php
include("../config/koneksi.php");
include("../include/helper.php");
session_start();
// error_reporting(0);
// $ce = mysqli_num_rows(mysqli_query($koneksi, "select * from pembelian_detail_temp where akun_id=" . $_SESSION['id'] . ""));
// if ($ce != 0) {
//     $id_supplier = $_SESSION['supplier_id'];
//     $total = mysqli_fetch_array(mysqli_query($koneksi, "select sum(total_harga) as total from pembelian_detail_temp where akun_id = " . $_SESSION['id'] . ""));
//     mysqli_begin_transaction($koneksi);
//     $simpan1 = mysqli_query($koneksi, "insert into pembelian values('','" . $_SESSION['tgl_po'] . "','" . $_SESSION['no_po'] . "','$id_supplier','" . $_SESSION['ppn'] . "','" . $_SESSION['cara_pembayaran'] . "','" . $_SESSION['catatan'] . "','0','" . $total['total'] . "','" . $total['total'] + ($total['total'] * ($_SESSION['ppn'] / 100)) . "','0','','$_SESSION[nama]', '0')");
//     mysqli_commit($koneksi);
//     $d1 = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_pesan from pembelian"));
//     $id_pesan = $d1['id_pesan'];
//     //simpan barang pesan detail
//     $q2 = mysqli_query($koneksi, "select * from pembelian_detail_temp where akun_id=" . $_SESSION['id'] . "");
//     while ($d2 = mysqli_fetch_array($q2)) {
//         $simpan2 = mysqli_query($koneksi, "insert into pembelian_detail values('','$id_pesan','" . $d2['produk_id'] . "','" . $d2['qty'] . "','" . $d2['harga_beli'] . "','" . $d2['diskon'] . "','" . $d2['total_harga'] . "','0')");
//     }

//     if ($simpan1 and $simpan2) {
//         // $Result = mysqli_query($koneksi, "insert into utang_piutang values('','Hutang','" . $_SESSION['no_po'] . "','" . $_POST['tgl_input'] . "','" . $_POST['jatuh_tempo'] . "','" . $_POST['nominal'] . "','" . $_POST['klien'] . "','" . $_POST['deskripsi'] . "','0')");
//         mysqli_query($koneksi, "delete from pembelian_detail_temp where akun_id=" . $_SESSION['id'] . "");
//         die("S");
//     } else {
//         die('F');
//     }
// } else {
//     die("K");
// }

$ce = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pembelian_detail_temp WHERE akun_id=" . $_SESSION['id']));
if ($ce != 0) {
    $id_supplier = $_SESSION['supplier_id'];
    $total = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(total_harga) AS total FROM pembelian_detail_temp WHERE akun_id = " . $_SESSION['id']));

    mysqli_begin_transaction($koneksi);

    try {
        // Simpan ke pembelian (header)
        $stmt = $koneksi->prepare("
        INSERT INTO pembelian (
            tgl_po_pesan, no_po_pesan, supplier_id, ppn, cara_pembayaran,
            catatan, total_harga, total_harga_ppn,
            operator
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $params = [$_SESSION['tgl_po'], $_SESSION['no_po'], $id_supplier, $_SESSION['ppn'], $_SESSION['cara_pembayaran'], $_SESSION['catatan'], $total['total'], ($total['total'] + ($total['total'] * ($_SESSION['ppn'] / 100))), $_SESSION['nama']];
        $types = getBindTypes($params);
        $stmt->bind_param($types, ...$params);
        $simpan1 = $stmt->execute();

        // $simpan1 = mysqli_query($koneksi, "INSERT INTO pembelian 
        //     VALUES (
        //         '', 
        //         '" . $_SESSION['tgl_po'] . "', 
        //         '" . $_SESSION['no_po'] . "', 
        //         '$id_supplier', 
        //         '" . $_SESSION['ppn'] . "', 
        //         '" . $_SESSION['cara_pembayaran'] . "', 
        //         '" . $_SESSION['catatan'] . "', 
        //         '0', 
        //         '" . $total['total'] . "', 
        //         '" . ($total['total'] + ($total['total'] * ($_SESSION['ppn'] / 100))) . "', 
        //         '0', 
        //         '', 
        //         '" . $_SESSION['nama'] . "', 
        //         '0'
        //     )");

        if (!$simpan1) {
            // throw new Exception("Gagal insert pembelian");
            die('F');
        }

        // Dapatkan ID pembelian terakhir
        $id_pesan = mysqli_insert_id($koneksi);

        // Ambil semua detail sementara
        $q2 = mysqli_query($koneksi, "SELECT * FROM pembelian_detail_temp WHERE akun_id=" . $_SESSION['id']);
        while ($d2 = mysqli_fetch_array($q2)) {
            $simpan2 = mysqli_query($koneksi, "INSERT INTO pembelian_detail 
                VALUES (
                    '', 
                    '$id_pesan', 
                    '" . $d2['produk_id'] . "', 
                    '" . $d2['qty'] . "', 
                    '" . $d2['harga_beli'] . "', 
                    '" . $d2['diskon'] . "', 
                    '" . $d2['total_harga'] . "', 
                    '0'
                )");

            if (!$simpan2) {
                throw new Exception("Gagal insert detail pembelian");
            }
        }

        // (Optional) Simpan utang/piutang — pastikan semua data valid
        // $result = mysqli_query(...);
        // if (!$result) throw new Exception("Gagal insert utang");

        // Bersihkan data temp
        mysqli_query($koneksi, "DELETE FROM pembelian_detail_temp WHERE akun_id=" . $_SESSION['id']);

        // Jika semua berhasil, commit transaksi
        mysqli_commit($koneksi);
        die("S");
    } catch (Exception $e) {
        // Ada kesalahan, rollback semua
        mysqli_rollback($koneksi);
        die("F"); // Atau cukup die("F");
    }
} else {
    die("K");
}
