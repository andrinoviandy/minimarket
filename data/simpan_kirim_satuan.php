<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$metode1 = $_POST['metode1'];
$metode2 = $_POST['metode2'];
$data = $_POST['data'];
if ($metode1 == 'manual') {
    $cek = 0;
    for ($i = 0; $i < count($data); $i++) {
        $dt = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_dikirim_detail_hash where barang_gudang_detail_id = $data[$i]"));
        $cek = $cek + $dt['jml'];
    }
    if ($cek > 0) {
        echo 'SA';
    } else {
        for ($i = 0; $i < count($data); $i++) {
            $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Satuan','','$_POST[id_gudang]','','$data[$i]')");
            if ($_POST['jml_aksesoris'] > 0) {
                $q = mysqli_query($koneksi, "select barang_gudang_id, jml_satuan from barang_dijual_qty_detail where barang_dijual_qty_id = $_POST[id_qty] order by id asc");
                while ($dt = mysqli_fetch_array($q)) {
                    $cek = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml, (select nama_brg from barang_gudang where id = $dt[barang_gudang_id]) as nm_brg from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL"));
                    if ($cek['jml'] >= $dt['jml_satuan']) {
                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL order by barang_gudang_detail.id $metode2 limit $dt[jml_satuan]");
                        while ($dt2 = mysqli_fetch_array($q2)) {
                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt[barang_gudang_id]','$dt2[id]')");
                        }
                    } else {
                        mysqli_query($koneksi, "delete from barang_dikirim_detail_hash where akun_id = $_SESSION[id] and barang_dijual_qty_id = $_POST[id_qty]");
                        die('DEL&' . $cek['nm_brg'].'&Tersedia : '.$cek['jml'].'&Akan Dikirim : '.$dt['jml_satuan']);
                    }
                }
            }
        }
        echo 'S';
    }
} else {
    $q = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL order by barang_gudang_detail.id asc limit $data");
    while ($dt = mysqli_fetch_array($q)) {
        $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Satuan','','$_POST[id_gudang]','','$dt[id]')");
        if ($_POST['jml_aksesoris'] > 0) {
            $q1 = mysqli_query($koneksi, "select barang_gudang_id, jml_satuan from barang_dijual_qty_detail where barang_dijual_qty_id = $_POST[id_qty] order by id asc");
            while ($dt1 = mysqli_fetch_array($q1)) {
                $cek = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml, (select nama_brg from barang_gudang where id = $dt1[barang_gudang_id]) as nm_brg from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL"));
                if ($cek['jml'] >= $dt1['jml_satuan']) {
                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL order by barang_gudang_detail.id $metode2 limit $dt1[jml_satuan]");
                    while ($dt2 = mysqli_fetch_array($q2)) {
                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt2[id]')");
                    }
                } else {
                    mysqli_query($koneksi, "delete from barang_dikirim_detail_hash where akun_id = $_SESSION[id] and barang_dijual_qty_id = $_POST[id_qty]");
                    die('DEL&' . $cek['nm_brg'].'&Tersedia : '.$cek['jml'].'&Akan Dikirim : '.$dt1['jml_satuan']);
                }
            }
        }
    }
    echo 'S';
}
