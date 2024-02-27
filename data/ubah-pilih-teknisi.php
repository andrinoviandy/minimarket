<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$sim = mysqli_query($koneksi, "update barang_teknisi,barang_teknisi_detail,barang_teknisi_detail_teknisi,barang_dikirim,barang_dikirim_detail,pembeli,barang_dijual,barang_gudang,barang_gudang_detail,tb_teknisi set estimasi='" . $_POST['estimasi'] . "', tgl_berangkat_teknisi='" . $_POST['tgl_berangkat'] . "',deskripsi='" . $_POST['deskripsi'] . "' where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and barang_teknisi.id=" . $_POST['id_ubah'] . " and barang_gudang.id=" . $_POST['id_gudang'] . "");
if ($sim) {
    echo "S";
} else {
    echo "F";
}
