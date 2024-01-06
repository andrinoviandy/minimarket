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
        die('SA');
    } else {
        for ($i = 0; $i < count($data); $i++) {
            $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Satuan','','$_POST[id_gudang]','','$data[$i]')");
            if ($_POST['jml_aksesoris'] > 0) {
                $q = mysqli_query($koneksi, "select barang_gudang_id, jml_satuan from barang_dijual_qty_detail where barang_dijual_qty_id = $_POST[id_qty] order by id asc");
                while ($dt = mysqli_fetch_array($q)) {
                    $cek = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml, (select nama_brg from barang_gudang where id = $dt[barang_gudang_id]) as nm_brg from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL"));
                    if ($cek['jml'] >= $dt['jml_satuan']) {
                        $q2 = mysqli_query($koneksi, "
                        select count(*) as jml, '1' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' 
                        union
                        select count(*) as jml, '2' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180
                        union
                        select count(*) as jml, '3' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0");
                        $jumlah = $dt['jumlah_satuan'];
                        while ($dt1 = mysqli_fetch_array($q2)) {
                            if ($dt1['jml'] >= $jumlah) {
                                if ($dt1['idd'] == '1') {
                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id $metode2 limit $jumlah");
                                    while ($dt2 = mysqli_fetch_array($q2)) {
                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt[barang_gudang_id]','$dt2[id]')");
                                    }
                                }
                                if ($dt1['idd'] == '2') {
                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id $metode2 limit $jumlah");
                                    while ($dt2 = mysqli_fetch_array($q2)) {
                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt[barang_gudang_id]','$dt2[id]')");
                                    }
                                }
                                if ($dt1['idd'] == '3') {
                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id $metode2 limit $jumlah");
                                    while ($dt2 = mysqli_fetch_array($q2)) {
                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt[barang_gudang_id]','$dt2[id]')");
                                    }
                                }
                            } else {
                                if ($dt1['jml'] > 0) {
                                    if ($dt1['idd'] == '1') {
                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id $metode2 limit $dt1[jml]");
                                        while ($dt2 = mysqli_fetch_array($q2)) {
                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt[barang_gudang_id]','$dt2[id]')");
                                        }
                                    }
                                    if ($dt1['idd'] == '2') {
                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id $metode2 limit $dt1[jml]");
                                        while ($dt2 = mysqli_fetch_array($q2)) {
                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt[barang_gudang_id]','$dt2[id]')");
                                        }
                                    }
                                    if ($dt1['idd'] == '3') {
                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id $metode2 limit $dt1[jml]");
                                        while ($dt2 = mysqli_fetch_array($q2)) {
                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt[barang_gudang_id]','$dt2[id]')");
                                        }
                                    }
                                    $jumlah = $jumlah - $dt1['jml'];
                                }
                            }
                        }
                    } else {
                        mysqli_query($koneksi, "delete from barang_dikirim_detail_hash where akun_id = $_SESSION[id] and barang_dijual_qty_id = $_POST[id_qty]");
                        die('DEL&' . $cek['nm_brg'] . '&Tersedia : ' . $cek['jml'] . '&Akan Dikirim : ' . $dt['jml_satuan']);
                    }
                }
            }
        }
        echo 'S';
    }
} else {
    $cek1 = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml, (select nama_brg from barang_gudang where id = $_POST[id_gudang]) as nm_brg from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and (tgl_expired = '0000-00-00' or TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0)"));
    if ($cek1['jml'] >= $data) {
        $qq = mysqli_query($koneksi, "
                        select count(*) as jml, '1' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' 
                        union
                        select count(*) as jml, '2' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180
                        union
                        select count(*) as jml, '3' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0");
        $jumlahh = $data;
        while ($dtt = mysqli_fetch_array($qq)) {
            if ($jumlahh > 0) {
                if ($dtt['jml'] >= $jumlahh) {
                    if ($dtt['idd'] == '1') {
                        $q = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id asc limit $data");
                        while ($dt = mysqli_fetch_array($q)) {
                            $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Satuan','','$_POST[id_gudang]','','$dt[id]')");
                            if ($_POST['jml_aksesoris'] > 0) {
                                $q1 = mysqli_query($koneksi, "select barang_gudang_id, jml_satuan from barang_dijual_qty_detail where barang_dijual_qty_id = $_POST[id_qty] order by id asc");
                                while ($dt1 = mysqli_fetch_array($q1)) {
                                    $cek = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml, (select nama_brg from barang_gudang where id = $dt1[barang_gudang_id]) as nm_brg from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL"));
                                    if ($cek['jml'] >= $dt1['jml_satuan']) {
                                        $q22 = mysqli_query($koneksi, "
                                        select count(*) as jml, '1' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' 
                                        union
                                        select count(*) as jml, '2' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180
                                        union
                                        select count(*) as jml, '3' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0");
                                        $jumlah = $dt1['jumlah_satuan'];
                                        while ($dt2 = mysqli_fetch_array($q22)) {
                                            if ($dt2['jml'] >= $jumlah) {
                                                if ($dt2['idd'] == '1') {
                                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id $metode2 limit $jumlah");
                                                    while ($dt3 = mysqli_fetch_array($q2)) {
                                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                    }
                                                }
                                                if ($dt2['idd'] == '2') {
                                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id $metode2 limit $jumlah");
                                                    while ($dt3 = mysqli_fetch_array($q2)) {
                                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                    }
                                                }
                                                if ($dt2['idd'] == '3') {
                                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id $metode2 limit $jumlah");
                                                    while ($dt3 = mysqli_fetch_array($q2)) {
                                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                    }
                                                }
                                            } else {
                                                if ($dt2['jml'] > 0) {
                                                    if ($dt2['idd'] == '1') {
                                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id $metode2 limit $dt2[jml]");
                                                        while ($dt3 = mysqli_fetch_array($q2)) {
                                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                        }
                                                    }
                                                    if ($dt2['idd'] == '2') {
                                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id $metode2 limit $dt2[jml]");
                                                        while ($dt3 = mysqli_fetch_array($q2)) {
                                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                        }
                                                    }
                                                    if ($dt2['idd'] == '3') {
                                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id $metode2 limit $dt2[jml]");
                                                        while ($dt3 = mysqli_fetch_array($q2)) {
                                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                        }
                                                    }
                                                    $jumlah = $jumlah - $dt2['jml'];
                                                }
                                            }
                                        }
                                    } else {
                                        mysqli_query($koneksi, "delete from barang_dikirim_detail_hash where akun_id = $_SESSION[id] and barang_dijual_qty_id = $_POST[id_qty]");
                                        die('DEL&' . $cek['nm_brg'] . '&Tersedia : ' . $cek['jml'] . '&Akan Dikirim : ' . $dt1['jml_satuan']);
                                    }
                                }
                            }
                        }
                    }
                    if ($dtt['idd'] == '2') {
                        $q = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id asc limit $data");
                        while ($dt = mysqli_fetch_array($q)) {
                            $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Satuan','','$_POST[id_gudang]','','$dt[id]')");
                            if ($_POST['jml_aksesoris'] > 0) {
                                $q1 = mysqli_query($koneksi, "select barang_gudang_id, jml_satuan from barang_dijual_qty_detail where barang_dijual_qty_id = $_POST[id_qty] order by id asc");
                                while ($dt1 = mysqli_fetch_array($q1)) {
                                    $cek = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml, (select nama_brg from barang_gudang where id = $dt1[barang_gudang_id]) as nm_brg from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL"));
                                    if ($cek['jml'] >= $dt1['jml_satuan']) {
                                        $q22 = mysqli_query($koneksi, "
                                    select count(*) as jml, '1' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' 
                                    union
                                    select count(*) as jml, '2' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180
                                    union
                                    select count(*) as jml, '3' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0");
                                        $jumlah = $dt1['jumlah_satuan'];
                                        while ($dt2 = mysqli_fetch_array($q22)) {
                                            if ($dt2['jml'] >= $jumlah) {
                                                if ($dt2['idd'] == '1') {
                                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id $metode2 limit $jumlah");
                                                    while ($dt3 = mysqli_fetch_array($q2)) {
                                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                    }
                                                }
                                                if ($dt2['idd'] == '2') {
                                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id $metode2 limit $jumlah");
                                                    while ($dt3 = mysqli_fetch_array($q2)) {
                                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                    }
                                                }
                                                if ($dt2['idd'] == '3') {
                                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id $metode2 limit $jumlah");
                                                    while ($dt3 = mysqli_fetch_array($q2)) {
                                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                    }
                                                }
                                            } else {
                                                if ($dt2['jml'] > 0) {
                                                    if ($dt2['idd'] == '1') {
                                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id $metode2 limit $dt2[jml]");
                                                        while ($dt3 = mysqli_fetch_array($q2)) {
                                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                        }
                                                    }
                                                    if ($dt2['idd'] == '2') {
                                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id $metode2 limit $dt2[jml]");
                                                        while ($dt3 = mysqli_fetch_array($q2)) {
                                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                        }
                                                    }
                                                    if ($dt2['idd'] == '3') {
                                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id $metode2 limit $dt2[jml]");
                                                        while ($dt3 = mysqli_fetch_array($q2)) {
                                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                        }
                                                    }
                                                    $jumlah = $jumlah - $dt2['jml'];
                                                }
                                            }
                                        }
                                    } else {
                                        mysqli_query($koneksi, "delete from barang_dikirim_detail_hash where akun_id = $_SESSION[id] and barang_dijual_qty_id = $_POST[id_qty]");
                                        die('DEL&' . $cek['nm_brg'] . '&Tersedia : ' . $cek['jml'] . '&Akan Dikirim : ' . $dt1['jml_satuan']);
                                    }
                                }
                            }
                        }
                    }
                    if ($dtt['idd'] == '3') {
                        $q = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id asc limit $data");
                        while ($dt = mysqli_fetch_array($q)) {
                            $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Satuan','','$_POST[id_gudang]','','$dt[id]')");
                            if ($_POST['jml_aksesoris'] > 0) {
                                $q1 = mysqli_query($koneksi, "select barang_gudang_id, jml_satuan from barang_dijual_qty_detail where barang_dijual_qty_id = $_POST[id_qty] order by id asc");
                                while ($dt1 = mysqli_fetch_array($q1)) {
                                    $cek = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml, (select nama_brg from barang_gudang where id = $dt1[barang_gudang_id]) as nm_brg from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL"));
                                    if ($cek['jml'] >= $dt1['jml_satuan']) {
                                        $q22 = mysqli_query($koneksi, "
                                        select count(*) as jml, '1' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' 
                                        union
                                        select count(*) as jml, '2' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180
                                        union
                                        select count(*) as jml, '3' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0");
                                        $jumlah = $dt1['jumlah_satuan'];
                                        while ($dt2 = mysqli_fetch_array($q22)) {
                                            if ($dt2['jml'] >= $jumlah) {
                                                if ($dt2['idd'] == '1') {
                                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id $metode2 limit $jumlah");
                                                    while ($dt3 = mysqli_fetch_array($q2)) {
                                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                    }
                                                }
                                                if ($dt2['idd'] == '2') {
                                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id $metode2 limit $jumlah");
                                                    while ($dt3 = mysqli_fetch_array($q2)) {
                                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                    }
                                                }
                                                if ($dt2['idd'] == '3') {
                                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id $metode2 limit $jumlah");
                                                    while ($dt3 = mysqli_fetch_array($q2)) {
                                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                    }
                                                }
                                            } else {
                                                if ($dt2['jml'] > 0) {
                                                    if ($dt2['idd'] == '1') {
                                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id $metode2 limit $dt2[jml]");
                                                        while ($dt3 = mysqli_fetch_array($q2)) {
                                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                        }
                                                    }
                                                    if ($dt2['idd'] == '2') {
                                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id $metode2 limit $dt2[jml]");
                                                        while ($dt3 = mysqli_fetch_array($q2)) {
                                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                        }
                                                    }
                                                    if ($dt2['idd'] == '3') {
                                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id $metode2 limit $dt2[jml]");
                                                        while ($dt3 = mysqli_fetch_array($q2)) {
                                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                        }
                                                    }
                                                    $jumlah = $jumlah - $dt2['jml'];
                                                }
                                            }
                                        }
                                    } else {
                                        mysqli_query($koneksi, "delete from barang_dikirim_detail_hash where akun_id = $_SESSION[id] and barang_dijual_qty_id = $_POST[id_qty]");
                                        die('DEL&' . $cek['nm_brg'] . '&Tersedia : ' . $cek['jml'] . '&Akan Dikirim : ' . $dt1['jml_satuan']);
                                    }
                                }
                            }
                        }
                    }
                    $jumlahh = 0;
                } else {
                    if ($dtt['idd'] == '1') {
                        $q = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id asc limit $dtt[jml]");
                        while ($dt = mysqli_fetch_array($q)) {
                            $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Satuan','','$_POST[id_gudang]','','$dt[id]')");
                            if ($_POST['jml_aksesoris'] > 0) {
                                $q1 = mysqli_query($koneksi, "select barang_gudang_id, jml_satuan from barang_dijual_qty_detail where barang_dijual_qty_id = $_POST[id_qty] order by id asc");
                                while ($dt1 = mysqli_fetch_array($q1)) {
                                    $cek = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml, (select nama_brg from barang_gudang where id = $dt1[barang_gudang_id]) as nm_brg from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL"));
                                    if ($cek['jml'] >= $dt1['jml_satuan']) {
                                        $q22 = mysqli_query($koneksi, "
                            select count(*) as jml, '1' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' 
                            union
                            select count(*) as jml, '2' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180
                            union
                            select count(*) as jml, '3' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0");
                                        $jumlah = $dt1['jumlah_satuan'];
                                        while ($dt2 = mysqli_fetch_array($q22)) {
                                            if ($dt2['jml'] >= $jumlah) {
                                                if ($dt2['idd'] == '1') {
                                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id $metode2 limit $jumlah");
                                                    while ($dt3 = mysqli_fetch_array($q2)) {
                                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                    }
                                                }
                                                if ($dt2['idd'] == '2') {
                                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id $metode2 limit $jumlah");
                                                    while ($dt3 = mysqli_fetch_array($q2)) {
                                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                    }
                                                }
                                                if ($dt2['idd'] == '3') {
                                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id $metode2 limit $jumlah");
                                                    while ($dt3 = mysqli_fetch_array($q2)) {
                                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                    }
                                                }
                                            } else {
                                                if ($dt2['jml'] > 0) {
                                                    if ($dt2['idd'] == '1') {
                                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id $metode2 limit $dt2[jml]");
                                                        while ($dt3 = mysqli_fetch_array($q2)) {
                                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                        }
                                                    }
                                                    if ($dt2['idd'] == '2') {
                                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id $metode2 limit $dt2[jml]");
                                                        while ($dt3 = mysqli_fetch_array($q2)) {
                                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                        }
                                                    }
                                                    if ($dt2['idd'] == '3') {
                                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id $metode2 limit $dt2[jml]");
                                                        while ($dt3 = mysqli_fetch_array($q2)) {
                                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                        }
                                                    }
                                                    $jumlah = $jumlah - $dt2['jml'];
                                                }
                                            }
                                        }
                                    } else {
                                        mysqli_query($koneksi, "delete from barang_dikirim_detail_hash where akun_id = $_SESSION[id] and barang_dijual_qty_id = $_POST[id_qty]");
                                        die('DEL&' . $cek['nm_brg'] . '&Tersedia : ' . $cek['jml'] . '&Akan Dikirim : ' . $dt1['jml_satuan']);
                                    }
                                }
                            }
                        }
                    }
                    if ($dtt['idd'] == '2') {
                        $q = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id asc limit $dtt[jml]");
                        while ($dt = mysqli_fetch_array($q)) {
                            $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Satuan','','$_POST[id_gudang]','','$dt[id]')");
                            if ($_POST['jml_aksesoris'] > 0) {
                                $q1 = mysqli_query($koneksi, "select barang_gudang_id, jml_satuan from barang_dijual_qty_detail where barang_dijual_qty_id = $_POST[id_qty] order by id asc");
                                while ($dt1 = mysqli_fetch_array($q1)) {
                                    $cek = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml, (select nama_brg from barang_gudang where id = $dt1[barang_gudang_id]) as nm_brg from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL"));
                                    if ($cek['jml'] >= $dt1['jml_satuan']) {
                                        $q22 = mysqli_query($koneksi, "
                                    select count(*) as jml, '1' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' 
                                    union
                                    select count(*) as jml, '2' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180
                                    union
                                    select count(*) as jml, '3' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0");
                                        $jumlah = $dt1['jumlah_satuan'];
                                        while ($dt2 = mysqli_fetch_array($q22)) {
                                            if ($dt2['jml'] >= $jumlah) {
                                                if ($dt2['idd'] == '1') {
                                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id $metode2 limit $jumlah");
                                                    while ($dt3 = mysqli_fetch_array($q2)) {
                                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                    }
                                                }
                                                if ($dt2['idd'] == '2') {
                                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id $metode2 limit $jumlah");
                                                    while ($dt3 = mysqli_fetch_array($q2)) {
                                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                    }
                                                }
                                                if ($dt2['idd'] == '3') {
                                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id $metode2 limit $jumlah");
                                                    while ($dt3 = mysqli_fetch_array($q2)) {
                                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                    }
                                                }
                                            } else {
                                                if ($dt2['jml'] > 0) {
                                                    if ($dt2['idd'] == '1') {
                                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id $metode2 limit $dt2[jml]");
                                                        while ($dt3 = mysqli_fetch_array($q2)) {
                                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                        }
                                                    }
                                                    if ($dt2['idd'] == '2') {
                                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id $metode2 limit $dt2[jml]");
                                                        while ($dt3 = mysqli_fetch_array($q2)) {
                                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                        }
                                                    }
                                                    if ($dt2['idd'] == '3') {
                                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id $metode2 limit $dt2[jml]");
                                                        while ($dt3 = mysqli_fetch_array($q2)) {
                                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                        }
                                                    }
                                                    $jumlah = $jumlah - $dt2['jml'];
                                                }
                                            }
                                        }
                                    } else {
                                        mysqli_query($koneksi, "delete from barang_dikirim_detail_hash where akun_id = $_SESSION[id] and barang_dijual_qty_id = $_POST[id_qty]");
                                        die('DEL&' . $cek['nm_brg'] . '&Tersedia : ' . $cek['jml'] . '&Akan Dikirim : ' . $dt1['jml_satuan']);
                                    }
                                }
                            }
                        }
                    }
                    if ($dtt['idd'] == '3') {
                        $q = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $_POST[id_gudang] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id asc limit $dtt[jml]");
                        while ($dt = mysqli_fetch_array($q)) {
                            $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Satuan','','$_POST[id_gudang]','','$dt[id]')");
                            if ($_POST['jml_aksesoris'] > 0) {
                                $q1 = mysqli_query($koneksi, "select barang_gudang_id, jml_satuan from barang_dijual_qty_detail where barang_dijual_qty_id = $_POST[id_qty] order by id asc");
                                while ($dt1 = mysqli_fetch_array($q1)) {
                                    $cek = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml, (select nama_brg from barang_gudang where id = $dt1[barang_gudang_id]) as nm_brg from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL"));
                                    if ($cek['jml'] >= $dt1['jml_satuan']) {
                                        $q22 = mysqli_query($koneksi, "
                            select count(*) as jml, '1' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' 
                            union
                            select count(*) as jml, '2' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180
                            union
                            select count(*) as jml, '3' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0");
                                        $jumlah = $dt1['jumlah_satuan'];
                                        while ($dt2 = mysqli_fetch_array($q22)) {
                                            if ($dt2['jml'] >= $jumlah) {
                                                if ($dt2['idd'] == '1') {
                                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id $metode2 limit $jumlah");
                                                    while ($dt3 = mysqli_fetch_array($q2)) {
                                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                    }
                                                }
                                                if ($dt2['idd'] == '2') {
                                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id $metode2 limit $jumlah");
                                                    while ($dt3 = mysqli_fetch_array($q2)) {
                                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                    }
                                                }
                                                if ($dt2['idd'] == '3') {
                                                    $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id $metode2 limit $jumlah");
                                                    while ($dt3 = mysqli_fetch_array($q2)) {
                                                        $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                    }
                                                }
                                            } else {
                                                if ($dt2['jml'] > 0) {
                                                    if ($dt2['idd'] == '1') {
                                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id $metode2 limit $dt2[jml]");
                                                        while ($dt3 = mysqli_fetch_array($q2)) {
                                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                        }
                                                    }
                                                    if ($dt2['idd'] == '2') {
                                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id $metode2 limit $dt2[jml]");
                                                        while ($dt3 = mysqli_fetch_array($q2)) {
                                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                        }
                                                    }
                                                    if ($dt2['idd'] == '3') {
                                                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id $metode2 limit $dt2[jml]");
                                                        while ($dt3 = mysqli_fetch_array($q2)) {
                                                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','Aksesoris','','$_POST[id_gudang]','$dt1[barang_gudang_id]','$dt3[id]')");
                                                        }
                                                    }
                                                    $jumlah = $jumlah - $dt2['jml'];
                                                }
                                            }
                                        }
                                    } else {
                                        mysqli_query($koneksi, "delete from barang_dikirim_detail_hash where akun_id = $_SESSION[id] and barang_dijual_qty_id = $_POST[id_qty]");
                                        die('DEL&' . $cek['nm_brg'] . '&Tersedia : ' . $cek['jml'] . '&Akan Dikirim : ' . $dt1['jml_satuan']);
                                    }
                                }
                            }
                        }
                    }
                    $jumlahh = $jumlahh - $dtt['jml'];
                }
            }
        }
    } else {
        die('DEL2&' . $cek1['nm_brg'] . '&Tersedia : ' . $cek1['jml'] . '&Akan Dikirim : ' . $data);
    }
    echo 'S';
}
