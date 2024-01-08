<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
$metode = $_POST['metode1'];
$data = $_POST['data'];
if ($metode == 'manual') {
    $cek = 0;
    for ($i = 0; $i < count($data); $i++) {
        $dt = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_dikirim_detail_hash where barang_gudang_detail_id = $data[$i]"));
        $cek = $cek + $dt['jml'];
    }
    if ($cek > 0) {
        echo 'SA';
    } else {
        for ($i = 0; $i < count($data); $i++) {
            $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]', '".count($data)."','Aksesoris','','','$_POST[id_gudang]','$data[$i]')");
        }
        echo 'S';
    }
} else {
    $cek = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and (tgl_expired = '0000-00-00' or TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0)"));
    if ($cek['jml'] >= $data) {
        $q = mysqli_query($koneksi, "
                        select count(*) as jml, '1' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' 
                        union
                        select count(*) as jml, '2' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180
                        union
                        select count(*) as jml, '3' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0");
        $jumlah = $data;
        while ($dt = mysqli_fetch_array($q)) {
            if ($jumlah > 0) {
                if ($dt['jml'] >= $jumlah) {
                    if ($dt['idd'] == '1') {
                        $q1 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id asc limit $jumlah");
                        while ($dt1 = mysqli_fetch_array($q1)) {
                            $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','$data','Aksesoris','','','$_POST[id_gudang]','$dt1[id]')");
                        }
                    }
                    if ($dt['idd'] == '2') {
                        $q1 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id asc limit $jumlah");
                        while ($dt1 = mysqli_fetch_array($q1)) {
                            $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','$data','Aksesoris','','','$_POST[id_gudang]','$dt1[id]')");
                        }
                    }
                    if ($dt['idd'] == '3') {
                        $q1 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id asc limit $jumlah");
                        while ($dt1 = mysqli_fetch_array($q1)) {
                            $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','$data','Aksesoris','','','$_POST[id_gudang]','$dt1[id]')");
                        }
                    }
                    $jumlah = 0;
                } else {
                    if ($dt['jml'] > 0) {
                        if ($dt['idd'] == '1') {
                            $q1 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id asc limit $dt[jml]");
                            while ($dt1 = mysqli_fetch_array($q1)) {
                                $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','$data','Aksesoris','','','$_POST[id_gudang]','$dt1[id]')");
                            }
                        }
                        if ($dt['idd'] == '2') {
                            $q1 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id asc limit $dt[jml]");
                            while ($dt1 = mysqli_fetch_array($q1)) {
                                $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','$data','Aksesoris','','','$_POST[id_gudang]','$dt1[id]')");
                            }
                        }
                        if ($dt['idd'] == '3') {
                            $q1 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id asc limit $dt[jml]");
                            while ($dt1 = mysqli_fetch_array($q1)) {
                                $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','$data','Aksesoris','','','$_POST[id_gudang]','$dt1[id]')");
                            }
                        }
                        $jumlah = $jumlah - $dt['jml'];
                    }
                }
            }
        }
        echo 'S';
    } else {
        echo "TC" . '&Stok Tersedia : ' . $cek['jml'] . '&Stok Akan Dikirim : ' . $data;
    }
}
