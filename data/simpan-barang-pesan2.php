<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$ce = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_pesan_hash where akun_id=" . $_SESSION['id'] . ""));
if ($ce != 0) {
    $max_id_princ = $_SESSION['id_princ'];
    $almat_peng = str_replace("\n", "<br>", $_SESSION['alamat_pengiriman']);
    $simpan1 = mysqli_query($koneksi, "insert into barang_pesan values('','" . $_SESSION['tgl_po'] . "','" . $_SESSION['no_po'] . "','Luar Negeri','$max_id_princ','" . $_SESSION['ppn'] . "','" . $_SESSION['cara_pembayaran'] . "','" . $_SESSION['mata_uang'] . "','" . $almat_peng . "','" . $_SESSION['jalur_pengiriman'] . "','" . $_SESSION['estimasi_pengiriman'] . "','" . $_SESSION['catatan'] . "','0','','" . $_POST['total_price'] . "','" . $_POST['total_price_ppn'] . "','" . $_POST['cost_byair'] . "','" . $_POST['cost_cf'] . "','','','')");
    $d1 = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_pesan from barang_pesan"));
    $id_pesan = $d1['id_pesan'];
    //simpan barang pesan detail
    $q2 = mysqli_query($koneksi, "select * from barang_pesan_hash where akun_id=" . $_SESSION['id'] . "");
    while ($d2 = mysqli_fetch_array($q2)) {

        $simpan2 = mysqli_query($koneksi, "insert into barang_pesan_detail values('','$id_pesan','" . $d2['barang_gudang_id'] . "','" . $d2['qty'] . "','" . $d2['mata_uang_id'] . "','" . $d2['harga_perunit'] . "','" . $d2['diskon'] . "','" . $d2['harga_total'] . "','" . $d2['catatan_spek'] . "','0')");
    }

    if ($simpan1 and $simpan2) {
        $Result = mysqli_query($koneksi, "insert into utang_piutang values('','Hutang','" . $_SESSION['no_po'] . "','" . $_POST['tgl_input'] . "','" . $_POST['jatuh_tempo'] . "','" . $_POST['nominal'] . "','" . $_POST['klien'] . "','" . $_POST['deskripsi'] . "','0')");
        mysqli_query($koneksi, "delete from barang_pesan_hash where akun_id=" . $_SESSION['id'] . "");
        echo "S";
    }
} else {
    echo "F";
}
