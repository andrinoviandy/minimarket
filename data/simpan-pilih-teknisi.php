<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
if ($_POST['id_brg'] == 'all') {
    $que = mysqli_query($koneksi, "select * from barang_teknisi_detail where barang_teknisi_id=" . $_POST['id'] . "");
    while ($data_que = mysqli_fetch_array($que)) {
        $simpan = mysqli_query($koneksi, "insert into barang_teknisi_detail_teknisi values('','" . $_POST['id'] . "','" . $data_que['id'] . "','" . $_POST['id_teknisi'] . "','" . $_POST['estimasi'] . "','" . $_POST['tgl_berangkat'] . "','" . $_POST['deskripsi'] . "')");
        mysqli_query($koneksi, "update barang_teknisi_detail set status_teknisi=1 where id=" . $data_que['id'] . "");
    }
    if ($simpan) {
        echo "S";
    } else {
        echo "F";
    }
} else {
    $que = mysqli_query($koneksi, "select *,barang_teknisi_detail.id as idd from barang_gudang,barang_gudang_detail,barang_dijual,barang_dikirim,barang_dikirim_detail,barang_teknisi,barang_teknisi_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_teknisi.id=" . $_POST['id'] . " and barang_gudang.id=" . $_POST['id_brg'] . "");
    while ($data_que = mysqli_fetch_array($que)) {
        $simpan = mysqli_query($koneksi, "insert into barang_teknisi_detail_teknisi values('','" . $_POST['id'] . "','" . $data_que['idd'] . "','" . $_POST['id_teknisi'] . "','" . $_POST['estimasi'] . "','" . $_POST['tgl_berangkat'] . "','" . $_POST['deskripsi'] . "')");
        mysqli_query($koneksi, "update barang_teknisi_detail set status_teknisi=1 where id=" . $data_que['idd'] . "");
    }
    if ($simpan) {
        echo "S";
    } else {
        echo "F";
    }
}
