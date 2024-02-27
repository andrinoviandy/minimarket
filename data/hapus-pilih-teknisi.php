<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$cek = mysqli_num_rows(mysqli_query($koneksi, "select * from alat_uji_detail,barang_teknisi_detail,barang_dikirim_detail,barang_gudang_detail,barang_gudang,barang_teknisi where barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_gudang.id=" . $_POST['id_hapus'] . " and barang_teknisi.id=" . $_POST['id'] . ""));
if ($cek == 0) {
    $sq = mysqli_query($koneksi, "select *,barang_teknisi_detail_teknisi.id as id_detail_teknisi, barang_teknisi_detail.id as id_d from barang_teknisi_detail_teknisi,barang_teknisi_detail,barang_dikirim_detail,barang_gudang_detail,barang_gudang,barang_teknisi where barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_gudang.id=" . $_POST['id_hapus'] . " and barang_teknisi.id=" . $_POST['id'] . "");
    while ($da = mysqli_fetch_array($sq)) {
        $del = mysqli_query($koneksi, "delete from barang_teknisi_detail_teknisi where id=" . $da['id_detail_teknisi'] . "");
        mysqli_query($koneksi, "update barang_teknisi_detail set status_teknisi=0 where id=" . $da['id_d'] . "");
    }
    if ($del) {
        echo "S";
    } else {
        echo "F";
    }
} else {
    echo "TB";
}
