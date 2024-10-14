<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$cek = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as total from barang_teknisi_hash where akun_id=" . $_POST['id'] . ""));
$data = $_POST['no_seri'];
if ($cek['total'] == 0) {
    if ($_POST['metode'] == 'all') {
        mysqli_query($koneksi, "delete from barang_teknisi_hash where akun_id = " . $_POST['id'] . "");
        $que = mysqli_query($koneksi, "select * from barang_dikirim_detail where barang_dikirim_id=" . $_POST['id_kirim'] . "");
        while ($data_que = mysqli_fetch_array($que)) {
            $simpan = mysqli_query($koneksi, "insert into barang_teknisi_hash values('','" . $_POST['id'] . "','" . $data_que['id'] . "','0')");
        }
        die("S");
    } else {
        if ($data == '' || count($data) == 0) {
            die("KOSONG");
        } else {
            for ($i = 0; $i < count($data); $i++) {
                $simpan = mysqli_query($koneksi, "insert into barang_teknisi_hash values('','" . $_POST['id'] . "','" . $data[$i] . "','0')");
            }
            die("S");
        }
    }
} else {
    $data2 = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_teknisi_hash where akun_id=" . $_POST['id'] . ""));
    // die($data2['barang_dikirim_detail_id']);
    $cek2 = mysqli_fetch_array(mysqli_query($koneksi, "select no_po_jual from barang_dikirim,barang_dikirim_detail where barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=" . $data2['barang_dikirim_detail_id'] . ""));
    //$cek2['po_no'];
    $cek3 = mysqli_fetch_array(mysqli_query($koneksi, "select no_po_jual from barang_dikirim where id=" . $_POST['id_kirim'] . ""));
    if ($cek2['no_po_jual'] == $cek3['no_po_jual']) {
        //batas
        if ($_POST['metode'] == 'all') {
            mysqli_query($koneksi, "delete from barang_teknisi_hash where akun_id = " . $_POST['id'] . "");
            $que = mysqli_query($koneksi, "select * from barang_dikirim_detail where barang_dikirim_id=" . $_POST['id_kirim'] . "");
            while ($data_que = mysqli_fetch_array($que)) {
                $simpan = mysqli_query($koneksi, "insert into barang_teknisi_hash values('','" . $_POST['id'] . "','" . $data_que['id'] . "','0')");
            }
            die("S");
        } else {
            if ($data == '' || count($data) == 0) {
                die("KOSONG");
            } else {
                for ($i = 0; $i < count($data); $i++) {
                    $simpan = mysqli_query($koneksi, "insert into barang_teknisi_hash values('','" . $_POST['id'] . "','" . $data[$i] . "','0')");
                }
                die("S");
            }
        }
        //batas
    } else {
        die("BEDA_PO");
    }
}
