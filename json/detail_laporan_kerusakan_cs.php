<?php
error_reporting(0);
header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");
mysqli_set_charset($koneksi, 'utf8');

$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;
$start = mysqli_real_escape_string($koneksi, $_GET['start']);

//menampilkan data dari database, table tb_anggota
if (isset($_GET['start'])) {

    // yang dipakai
    if (isset($_GET['cari'])) {
        $sql = "select tgl_lapor, nama_penelepon, kontak_penelepon, keluhan, nama_pembeli, jalan as alamat_instansi, kontak_rs as kontak_instansi, no_po_jual_cs as no_po, no_pengiriman, no_spk, nama_brg, tipe_brg, no_seri_brg, tgl_garansi_habis, nama_job as kategori_kerusakan, problem as detail_permasalahan, nama_teknisi from tb_laporan_kerusakan_cs join tb_laporan_kerusakan_cs_detail on tb_laporan_kerusakan_cs.id=tb_laporan_kerusakan_cs_detail.tb_laporan_kerusakan_cs_id join tb_laporan_kerusakan_detail on tb_laporan_kerusakan_cs_detail.id=tb_laporan_kerusakan_detail.tb_laporan_kerusakan_cs_detail_id left join alat_pelatihan on alat_pelatihan.id=tb_laporan_kerusakan_detail.alat_pelatihan_id left join alat_uji_detail on alat_uji_detail.id=alat_pelatihan.alat_uji_detail_id left join barang_teknisi_detail on barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id left join barang_dikirim_detail on barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id left join barang_gudang_detail on barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id left join barang_gudang on barang_gudang.id=barang_gudang_detail.barang_gudang_id left join tb_teknisi on tb_teknisi.id=tb_laporan_kerusakan_detail.teknisi_id left join barang_dikirim on barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id left join barang_teknisi on barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id left join pembeli on pembeli.id = tb_laporan_kerusakan_cs.pembeli_id left join kategori_job on kategori_job.id = tb_laporan_kerusakan_detail.kategori_job_id where (nama_pembeli like '%$_GET[cari]%' or jalan like '%$_GET[cari]%' or kontak_rs like '%$_GET[cari]%' or nama_penelepon like '%$_GET[cari]%' or keluhan like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or no_po_jual_cs like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%' or no_spk like '%$_GET[cari]%' or nama_job like '%$_GET[cari]%' or nama_teknisi like '%$_GET[cari]%') order by tgl_lapor desc LIMIT $start, $limit";
    } else {
        $sql = "select tgl_lapor, nama_penelepon, kontak_penelepon, keluhan, nama_pembeli, jalan as alamat_instansi, kontak_rs as kontak_instansi, no_po_jual_cs as no_po, no_pengiriman, no_spk, nama_brg, tipe_brg, no_seri_brg, tgl_garansi_habis, nama_job as kategori_kerusakan, problem as detail_permasalahan, nama_teknisi from tb_laporan_kerusakan_cs join tb_laporan_kerusakan_cs_detail on tb_laporan_kerusakan_cs.id=tb_laporan_kerusakan_cs_detail.tb_laporan_kerusakan_cs_id join tb_laporan_kerusakan_detail on tb_laporan_kerusakan_cs_detail.id=tb_laporan_kerusakan_detail.tb_laporan_kerusakan_cs_detail_id left join alat_pelatihan on alat_pelatihan.id=tb_laporan_kerusakan_detail.alat_pelatihan_id left join alat_uji_detail on alat_uji_detail.id=alat_pelatihan.alat_uji_detail_id left join barang_teknisi_detail on barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id left join barang_dikirim_detail on barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id left join barang_gudang_detail on barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id left join barang_gudang on barang_gudang.id=barang_gudang_detail.barang_gudang_id left join tb_teknisi on tb_teknisi.id=tb_laporan_kerusakan_detail.teknisi_id left join barang_dikirim on barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id left join barang_teknisi on barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id left join pembeli on pembeli.id = tb_laporan_kerusakan_cs.pembeli_id left join kategori_job on kategori_job.id = tb_laporan_kerusakan_detail.kategori_job_id order by tgl_lapor desc LIMIT $start, $limit";
    }

    $result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

    //membuat array
    while ($row = mysqli_fetch_assoc($result)) {
        $ArrAnggota[] = $row;
    }

    echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

    //tutup koneksi ke database
    mysqli_close($koneksi);
} else {
    //untuk jumlah

    if (isset($_GET['cari'])) {
        $sql = "select COUNT(DISTINCT tb_laporan_kerusakan_detail.id) as jml from tb_laporan_kerusakan_cs join tb_laporan_kerusakan_cs_detail on tb_laporan_kerusakan_cs.id=tb_laporan_kerusakan_cs_detail.tb_laporan_kerusakan_cs_id join tb_laporan_kerusakan_detail on tb_laporan_kerusakan_cs_detail.id=tb_laporan_kerusakan_detail.tb_laporan_kerusakan_cs_detail_id left join alat_pelatihan on alat_pelatihan.id=tb_laporan_kerusakan_detail.alat_pelatihan_id left join alat_uji_detail on alat_uji_detail.id=alat_pelatihan.alat_uji_detail_id left join barang_teknisi_detail on barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id left join barang_dikirim_detail on barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id left join barang_gudang_detail on barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id left join barang_gudang on barang_gudang.id=barang_gudang_detail.barang_gudang_id left join tb_teknisi on tb_teknisi.id=tb_laporan_kerusakan_detail.teknisi_id left join barang_dikirim on barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id left join barang_teknisi on barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id left join pembeli on pembeli.id = tb_laporan_kerusakan_cs.pembeli_id left join kategori_job on kategori_job.id = tb_laporan_kerusakan_detail.kategori_job_id where (nama_pembeli like '%$_GET[cari]%' or jalan like '%$_GET[cari]%' or kontak_rs like '%$_GET[cari]%' or nama_penelepon like '%$_GET[cari]%' or keluhan like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or no_po_jual_cs like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%' or no_spk like '%$_GET[cari]%' or nama_job like '%$_GET[cari]%' or nama_teknisi like '%$_GET[cari]%')";
    } else {
        $sql = "select COUNT(DISTINCT tb_laporan_kerusakan_detail.id) as jml from tb_laporan_kerusakan_cs join tb_laporan_kerusakan_cs_detail on tb_laporan_kerusakan_cs.id=tb_laporan_kerusakan_cs_detail.tb_laporan_kerusakan_cs_id join tb_laporan_kerusakan_detail on tb_laporan_kerusakan_cs_detail.id=tb_laporan_kerusakan_detail.tb_laporan_kerusakan_cs_detail_id left join alat_pelatihan on alat_pelatihan.id=tb_laporan_kerusakan_detail.alat_pelatihan_id left join alat_uji_detail on alat_uji_detail.id=alat_pelatihan.alat_uji_detail_id left join barang_teknisi_detail on barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id left join barang_dikirim_detail on barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id left join barang_gudang_detail on barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id left join barang_gudang on barang_gudang.id=barang_gudang_detail.barang_gudang_id left join tb_teknisi on tb_teknisi.id=tb_laporan_kerusakan_detail.teknisi_id left join barang_dikirim on barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id left join barang_teknisi on barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id left join pembeli on pembeli.id = tb_laporan_kerusakan_cs.pembeli_id left join kategori_job on kategori_job.id = tb_laporan_kerusakan_detail.kategori_job_id";
    }

    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
//batasssssssssssssss
