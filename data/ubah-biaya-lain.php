<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);

$data = mysqli_fetch_array(mysqli_query($koneksi, "select * from biaya_lain,buku_kas,keuangan,keuangan_detail where buku_kas.id=biaya_lain.buku_kas_id and keuangan.id=biaya_lain.keuangan_id and keuangan.id=keuangan_detail.keuangan_id and biaya_lain.id=" . $_POST['id_ubah'] . ""));

$cek_saldo = mysqli_fetch_array(mysqli_query($koneksi, "select * from buku_kas where id='" . $_POST['buku_kas_id'] . "'"));
$nom = str_replace(".", "", $_POST['harga']);
if ($_POST['jenis_transaksi'] == 'Pembayaran') {
    if ($cek_saldo['saldo'] < $nom) {
        die("K");
    } else {
        $coa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT *,coa_sub_akun.id as idd FROM coa,coa_sub,coa_sub_akun where coa.id=coa_sub.coa_id and coa_sub.id=coa_sub_akun.coa_sub_id and coa_sub_akun.id=$_POST[coa_id]"));

        $Result1 = mysqli_query($koneksi, "update biaya_lain,keuangan,buku_kas set biaya_lain.buku_kas_id='" . $_POST['buku_kas_id'] . "', biaya_lain.jenis_transaksi='" . $_POST['jenis_transaksi'] . "',biaya_lain.tgl='" . $_POST['tanggal'] . "',biaya_lain.penerima='" . $_POST['penerima'] . "',biaya_lain.deskripsi='" . $_POST['deskripsi'] . "',biaya_lain.harga='" . $nom . "',keuangan.tgl_transaksi='" . $_POST['tanggal'] . "',keuangan.deskripsi='" . $_POST['deskripsi'] . "',keuangan.saldo='" . $nom . "',buku_kas.saldo=buku_kas.saldo+$data[harga] where keuangan.id=biaya_lain.keuangan_id and buku_kas.id=biaya_lain.buku_kas_id and biaya_lain.id=$_POST[id_ubah]");
        $del_keuangan = mysqli_query($koneksi, "delete from keuangan_detail where keuangan_id=" . $data['keuangan_id'] . "");
        //$Result = mysqli_query($koneksi, "update biaya_lain,keuangan,keuangan_detail,buku_kas set biaya_lain.buku_kas_id='".$_POST['buku_kas_id']."',biaya_lain.jenis_transaksi='".$_POST['jenis_transaksi']."',biaya_lain.tgl='".$_POST['tanggal']."',biaya_lain.penerima='".$_POST['penerima']."',biaya_lain.deskripsi='".$_POST['deskripsi']."',biaya_lain.harga='".$nom."',keuangan_detail.coa_id='".$_POST['coa_id']."',keuangan_detail.coa_sub_id='".$_POST['coa_sub_id']."',keuangan_detail.coa_sub_akun_id='".$_POST['coa_sub_akun_id']."',keuangan.tgl_transaksi='".$_POST['tanggal']."',keuangan.deskripsi='".$_POST['deskripsi']."',keuangan.saldo='".$nom."',buku_kas.saldo=buku_kas.saldo+$data[harga] where keuangan.id=biaya_lain.keuangan_id and buku_kas.id=biaya_lain.buku_kas_id and keuangan.id=keuangan_detail.keuangan_id and biaya_lain.id=$_POST[id_ubah]");
        if ($Result1) {
            if ($_POST['coa_id'] == 1) {
                $simpan_keuangan_detail = mysqli_query($koneksi, "insert into keuangan_detail values('','$data[keuangan_id]','" . $_POST['coa_id'] . "','" . $_POST['coa_sub_id'] . "','" . $_POST['coa_sub_akun_id'] . "','db')");
            } else {
                $simpan_keuangan_detail = mysqli_query($koneksi, "insert into keuangan_detail values('','$data[keuangan_id]','" . $_POST['coa_id'] . "','" . $_POST['coa_sub_id'] . "','" . $_POST['coa_sub_akun_id'] . "','cr')");
            }

            if ($_POST['coa_id'] == 5) {
                $simpan_keuangan_detail2 = mysqli_query($koneksi, "insert into keuangan_detail values('','$data[keuangan_id]','3','32','','cr')");
            }
            $cek_saldo2 = mysqli_fetch_array(mysqli_query($koneksi, "select * from buku_kas where id='" . $_POST['buku_kas_id'] . "'"));
            $saldo_kurang = $cek_saldo2['saldo'] - $nom;
            $up = mysqli_query($koneksi, "update buku_kas set saldo='" . $saldo_kurang . "' where id='$_POST[buku_kas_id]'");
            echo "S";
        } else {
            echo "HAA";
        }
    }
} else {
    //$coa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT *,coa_sub_akun.id as idd FROM coa,coa_sub,coa_sub_akun where coa.id=coa_sub.coa_id and coa_sub.id=coa_sub_akun.coa_sub_id and coa_sub_akun.id=$_POST[coa_id]"));

    $Result1 = mysqli_query($koneksi, "update biaya_lain,keuangan,buku_kas set biaya_lain.buku_kas_id='" . $_POST['buku_kas_id'] . "', biaya_lain.jenis_transaksi='" . $_POST['jenis_transaksi'] . "',biaya_lain.tgl='" . $_POST['tanggal'] . "',biaya_lain.penerima='" . $_POST['penerima'] . "',biaya_lain.deskripsi='" . $_POST['deskripsi'] . "',biaya_lain.harga='" . $nom . "',keuangan.tgl_transaksi='" . $_POST['tanggal'] . "',keuangan.deskripsi='" . $_POST['deskripsi'] . "',keuangan.saldo='" . $nom . "',buku_kas.saldo=buku_kas.saldo-$data[harga] where keuangan.id=biaya_lain.keuangan_id and buku_kas.id=biaya_lain.buku_kas_id and biaya_lain.id=$_POST[id_ubah]");
    $del_keuangan = mysqli_query($koneksi, "delete from keuangan_detail where keuangan_id=" . $data['keuangan_id'] . "");

    //mysqli_query($koneksi, "update biaya_lain,keuangan,keuangan_detail,buku_kas set biaya_lain.buku_kas_id='".$_POST['buku_kas_id']."',biaya_lain.jenis_transaksi='".$_POST['jenis_transaksi']."',biaya_lain.tgl='".$_POST['tanggal']."',biaya_lain.penerima='".$_POST['penerima']."',biaya_lain.deskripsi='".$_POST['deskripsi']."',biaya_lain.harga='".$nom."',keuangan_detail.coa_id='".$_POST['coa_id']."',keuangan_detail.coa_sub_id='".$_POST['coa_sub_id']."',keuangan_detail.coa_sub_akun_id='".$_POST['coa_sub_akun_id']."',keuangan.tgl_transaksi='".$_POST['tanggal']."',keuangan.deskripsi='".$_POST['deskripsi']."',keuangan.saldo='".$nom."',buku_kas.saldo=buku_kas.saldo-$data[harga] where keuangan.id=biaya_lain.keuangan_id and buku_kas.id=biaya_lain.buku_kas_id and keuangan.id=keuangan_detail.keuangan_id and biaya_lain.id=$_POST[id_ubah]");
    if ($Result1) {
        if ($_POST['coa_id'] == 1) {
            $simpan_keuangan_detail = mysqli_query($koneksi, "insert into keuangan_detail values('','$data[keuangan_id]','" . $_POST['coa_id'] . "','" . $_POST['coa_sub_id'] . "','" . $_POST['coa_sub_akun_id'] . "','cr')");
        } else {
            $simpan_keuangan_detail = mysqli_query($koneksi, "insert into keuangan_detail values('','$data[keuangan_id]','" . $_POST['coa_id'] . "','" . $_POST['coa_sub_id'] . "','" . $_POST['coa_sub_akun_id'] . "','db')");
        }

        if ($_POST['coa_id'] == 4) {
            $simpan_keuangan_detail2 = mysqli_query($koneksi, "insert into keuangan_detail values('','$data[keuangan_id]','3','32','','db')");
        }
        $cek_saldo2 = mysqli_fetch_array(mysqli_query($koneksi, "select * from buku_kas where id='" . $_POST['buku_kas_id'] . "'"));
        $saldo_kurang = $cek_saldo2['saldo'] + $nom;
        $up = mysqli_query($koneksi, "update buku_kas set saldo='" . $saldo_kurang . "' where id='$_POST[buku_kas_id]'");
        echo "S";
    } else {
        echo "HUU";
    }
}
