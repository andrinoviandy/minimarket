<?php

header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");

mysqli_set_charset($koneksi, "utf8");
error_reporting(0);
session_start();
$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;
$start = mysqli_real_escape_string($koneksi, $_GET['start']);

//menampilkan data dari database, table tb_anggota
if (isset($_SESSION['id_b'])) {
    if (isset($_GET['start'])) {
        if (isset($_GET['cari'])) {
            $sql = "select *,alat_pelatihan.id as idd,pembeli_id as id_rumkit from barang_teknisi,barang_teknisi_detail,barang_teknisi_detail_teknisi, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli, tb_teknisi,alat_uji_detail,alat_pelatihan where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and alat_uji_detail.id=alat_pelatihan.alat_uji_detail_id and pembeli.id=$_GET[id_rumkit] and tb_teknisi.id=$_SESSION[id_b] and (no_seri_brg like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or date_format(tgl_pelatihan, '%d/%m%Y') like '%$_GET[cari]%' or pelatih like '%$_GET[cari]%' pelatihan_oleh like '%$_GET[cari]%') order by alat_pelatihan.id DESC LIMIT $start, $limit";
        } else {
            $sql = "select *,alat_pelatihan.id as idd,pembeli_id as id_rumkit from barang_teknisi,barang_teknisi_detail,barang_teknisi_detail_teknisi, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli, tb_teknisi,alat_uji_detail,alat_pelatihan where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and alat_uji_detail.id=alat_pelatihan.alat_uji_detail_id and pembeli.id=$_GET[id_rumkit] and tb_teknisi.id=$_SESSION[id_b] order by alat_pelatihan.id DESC LIMIT $start, $limit";
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
        // untuk jumlah
        if (isset($_GET['cari'])) {
            $sql = "select COUNT(DISTINCT alat_pelatihan.id) as jml from barang_teknisi,barang_teknisi_detail,barang_teknisi_detail_teknisi, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli, tb_teknisi,alat_uji_detail,alat_pelatihan where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and alat_uji_detail.id=alat_pelatihan.alat_uji_detail_id and pembeli.id=$_GET[id_rumkit] and tb_teknisi.id=$_SESSION[id_b] and (no_seri_brg like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or date_format(tgl_pelatihan, '%d/%m%Y') like '%$_GET[cari]%' or pelatih like '%$_GET[cari]%' pelatihan_oleh like '%$_GET[cari]%') order by alat_pelatihan.id DESC";
        } else {
            $sql = "select COUNT(DISTINCT alat_pelatihan.id) as jml from barang_teknisi,barang_teknisi_detail,barang_teknisi_detail_teknisi, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli, tb_teknisi,alat_uji_detail,alat_pelatihan where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and alat_uji_detail.id=alat_pelatihan.alat_uji_detail_id and pembeli.id=$_GET[id_rumkit] and tb_teknisi.id=$_SESSION[id_b] order by alat_pelatihan.id DESC";
        }
        $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
        echo $result['jml'];
        //tutup koneksi ke database
        mysqli_close($koneksi);
    }
} else {
    if (isset($_GET['start'])) {
        if (isset($_GET['cari'])) {
            $sql = "select *,alat_pelatihan.id as idd,pembeli_id as id_rumkit from barang_teknisi,barang_teknisi_detail,barang_teknisi_detail_teknisi, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli, tb_teknisi,alat_uji_detail,alat_pelatihan where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and alat_uji_detail.id=alat_pelatihan.alat_uji_detail_id and pembeli.id=$_GET[id_rumkit] and (no_seri_brg like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or pelatih like '%$_GET[cari]%' pelatihan_oleh like '%$_GET[cari]%') order by alat_pelatihan.id DESC LIMIT $start, $limit";
        } else {
            $sql = "select *,alat_pelatihan.id as idd,pembeli_id as id_rumkit from barang_teknisi,barang_teknisi_detail,barang_teknisi_detail_teknisi, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli, tb_teknisi,alat_uji_detail,alat_pelatihan where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and alat_uji_detail.id=alat_pelatihan.alat_uji_detail_id and pembeli.id=$_GET[id_rumkit] order by alat_pelatihan.id DESC LIMIT $start, $limit";
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
        // untuk jumlah
        if (isset($_GET['cari'])) {
            $sql = "select COUNT(DISTINCT alat_pelatihan.id) as jml from barang_teknisi,barang_teknisi_detail,barang_teknisi_detail_teknisi, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli, tb_teknisi,alat_uji_detail,alat_pelatihan where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and alat_uji_detail.id=alat_pelatihan.alat_uji_detail_id and pembeli.id=$_GET[id_rumkit] and (no_seri_brg like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or pelatih like '%$_GET[cari]%' pelatihan_oleh like '%$_GET[cari]%')";
        } else {
            $sql = "select COUNT(DISTINCT alat_pelatihan.id) as jml from barang_teknisi,barang_teknisi_detail,barang_teknisi_detail_teknisi, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli, tb_teknisi,alat_uji_detail,alat_pelatihan where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and alat_uji_detail.id=alat_pelatihan.alat_uji_detail_id and pembeli.id=$_GET[id_rumkit]";
        }
        $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
        echo $result['jml'];
        //tutup koneksi ke database
        mysqli_close($koneksi);
    }
}
