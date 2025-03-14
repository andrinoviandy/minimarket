<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$nopo = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dikirim where id=" . $_SESSION['no_po'] . ""));
$cek4 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dikirim_detail_pengganti_hash where akun_id=" . $_SESSION['id'] . ""));
if ($cek4 != 0) {
    $s1 = mysqli_query($koneksi, "insert into barang_dikirim values('','" . $nopo['barang_dijual_id'] . "','" . $_SESSION['nama_paket'] . "','" . $_SESSION['no_pengiriman'] . "','" . $_SESSION['tgl_pengiriman'] . "','" . $nopo['no_po_jual'] . "','" . $_SESSION['ekspedisi'] . "','" . $_SESSION['via_pengiriman'] . "','" . $_SESSION['estimasi'] . "','" . $_SESSION['biaya_pengiriman'] . "','','','1','" . $_SESSION['keterangan'] . "')");
    if ($s1) {
        $max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_max from barang_dikirim"));
        $q = mysqli_query($koneksi, "select * from barang_dikirim_detail_pengganti_hash where akun_id=" . $_SESSION['id'] . "");
        while ($d = mysqli_fetch_array($q)) {
            $dd = mysqli_fetch_array(mysqli_query($koneksi, "select barang_dijual_qty_id from barang_dikirim_detail where id = " . $d['barang_dikirim_detail_id'] . ""));
            $s = mysqli_query($koneksi, "insert into barang_dikirim_detail values('','" . $max['id_max'] . "','" . $dd['barang_dijual_qty_id'] . "','" . $d['jml_kirim'] . "', '" . $d['kategori_brg'] . "','" . $d['barang_gudang_set_id'] . "', '" . $d['barang_gudang_satuan_id'] . "', '" . $d['barang_gudang_akse_id'] . "','" . $d['barang_gudang_detail_id'] . "','0','0')");
            $up_stok = mysqli_query($koneksi, "update barang_gudang,barang_gudang_detail set stok_total=stok_total-1 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=" . $d['barang_gudang_detail_id'] . "");
            $up_status = mysqli_query($koneksi, "update barang_gudang_detail set status_kirim=1 where id=" . $d['barang_gudang_detail_id'] . "");
        }
        if ($s1 && $s && $up_stok && $up_status) {
            //$Result = mysqli_query($koneksi, "insert into utang_piutang values('','Hutang','".$_SESSION['no_po']."','".$_POST['tgl_input']."','".$_POST['jatuh_tempo']."','".$_POST['nominal']."','".$_POST['klien']."','".$_POST['deskripsi']."','0')");
            mysqli_query($koneksi, "delete from barang_dikirim_detail_pengganti_hash where akun_id=" . $_SESSION['id'] . "");
        }
        die("S");
    } else {
        die("F");
    }
} else {
    die("KOSONG");
}
