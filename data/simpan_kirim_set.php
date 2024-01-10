<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
$metode2 = $_POST['metode2'];
$data = $_POST['data'];

$q1 = mysqli_query($koneksi, "select barang_gudang_id, (jml_satuan*$data) as jumlah from barang_dijual_qty_detail where barang_dijual_qty_id = $_POST[id_qty] order by id asc");
while ($dt1 = mysqli_fetch_array($q1)) {
    $cek = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml, (select nama_brg from barang_gudang where id = $dt1[barang_gudang_id]) as nm_brg from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and (tgl_expired = '0000-00-00' or TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0)"));

    if ($cek['jml'] >= $dt1['jumlah']) {
        // $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL order by barang_gudang_detail.id $metode2 limit $dt1[jumlah]");
        $q = mysqli_query($koneksi, "
        select count(*) as jml, '1' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' 
        union
        select count(*) as jml, '2' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180
        union
        select count(*) as jml, '3' as idd from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0");
        $jumlah = $dt1['jumlah'];
        while ($dt = mysqli_fetch_array($q)) {
            if ($jumlah > 0) {
                if ($dt['jml'] >= $jumlah) {
                    if ($dt['idd'] == '1') {
                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id $metode2 limit $jumlah");
                        while ($dt2 =  mysqli_fetch_array(($q2))) {
                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','$data','Set','$_POST[id_gudang]','$dt1[barang_gudang_id]','','$dt2[id]')");
                        }
                    }
                    if ($dt['idd'] == '2') {
                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id $metode2 limit $jumlah");
                        while ($dt2 =  mysqli_fetch_array(($q2))) {
                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','$data','Set','$_POST[id_gudang]','$dt1[barang_gudang_id]','','$dt2[id]')");
                        }
                    }
                    if ($dt['idd'] == '3') {
                        $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id $metode2 limit $jumlah");
                        while ($dt2 =  mysqli_fetch_array(($q2))) {
                            $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','$data','Set','$_POST[id_gudang]','$dt1[barang_gudang_id]','','$dt2[id]')");
                        }
                    }
                    $jumlah = 0;
                } else {
                    if ($dt['jml'] > 0) {
                        if ($dt['idd'] == '1') {
                            $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and tgl_expired = '0000-00-00' order by barang_gudang_detail.id $metode2 limit $dt[jml]");
                            while ($dt2 =  mysqli_fetch_array(($q2))) {
                                $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','$data','Set','$_POST[id_gudang]','$dt1[barang_gudang_id]','','$dt2[id]')");
                            }
                        }
                        if ($dt['idd'] == '2') {
                            $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180 order by barang_gudang_detail.id $metode2 limit $dt[jml]");
                            while ($dt2 =  mysqli_fetch_array(($q2))) {
                                $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','$data','Set','$_POST[id_gudang]','$dt1[barang_gudang_id]','','$dt2[id]')");
                            }
                        }
                        if ($dt['idd'] == '3') {
                            $q2 = mysqli_query($koneksi, "select barang_gudang_detail.id from barang_gudang_detail left join barang_dikirim_detail_hash on barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id where barang_gudang_id = $dt1[barang_gudang_id] and status_kirim=0 and status_kerusakan=0 and status_demo=0 and akun_id IS NULL and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 order by barang_gudang_detail.id $metode2 limit $dt[jml]");
                            while ($dt2 =  mysqli_fetch_array(($q2))) {
                                $simpan2 = mysqli_query($koneksi, "insert into barang_dikirim_detail_hash values('','$_SESSION[id]','$_POST[id_qty]','$data','Set','$_POST[id_gudang]','$dt1[barang_gudang_id]','','$dt2[id]')");
                            }
                        }
                        $jumlah = $jumlah - $dt['jml'];
                    }
                }
            }
        }
    } else {
        mysqli_query($koneksi, "delete from barang_dikirim_detail_hash where akun_id = $_SESSION[id] and barang_dijual_qty_id = $_POST[id_qty]");
        die('DEL&' . $cek['nm_brg'] . '&Tersedia : ' . $cek['jml'] . '&Akan Dikirim : ' . $dt1['jumlah']);
    }
}
echo "S";