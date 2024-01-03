<?php
error_reporting(0);
header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");

$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;
$start = mysqli_real_escape_string($koneksi, $_GET['start']);


if (isset($_GET['start'])) {
    if (isset($_SESSION['id_b'])) {
        if (isset($_GET['cari'])) {
            $sql = "select *,alat_uji_detail.id as idd,pembeli.id as id_rumkit from alat_uji_detail,barang_teknisi_detail,barang_dikirim_detail,barang_dikirim,barang_dijual,pembeli,tb_teknisi,barang_teknisi_detail_teknisi where pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and tb_teknisi.id=$_SESSION[id_b] and (nama_pembeli like '%$_GET[cari]%' or kelurahan_id like '%$_GET[cari]%' or jalan like '%$_GET[cari]%' or kontak_rs like '%$_GET[cari]%' or barang_dijual.no_po_jual like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%') group by pembeli.id order by nama_pembeli ASC LIMIT $start, $limit";
        } else {
            $sql = "select *,alat_uji_detail.id as idd,pembeli.id as id_rumkit from alat_uji_detail,barang_teknisi_detail,barang_dikirim_detail,barang_dikirim,barang_dijual,pembeli,tb_teknisi,barang_teknisi_detail_teknisi where pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and tb_teknisi.id=$_SESSION[id_b] group by pembeli.id order by nama_pembeli ASC LIMIT $start, $limit";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select *,alat_uji_detail.id as idd,pembeli.id as id_rumkit from alat_uji_detail,barang_teknisi_detail,barang_dikirim_detail,barang_dikirim,barang_dijual,pembeli where pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and (nama_pembeli like '%$_GET[cari]%' or kelurahan_id like '%$_GET[cari]%' or jalan like '%$_GET[cari]%' or kontak_rs like '%$_GET[cari]%' or barang_dijual.no_po_jual like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%') group by pembeli.id order by nama_pembeli ASC LIMIT $start, $limit";
        } else {
            $sql = "select *,alat_uji_detail.id as idd,pembeli.id as id_rumkit from alat_uji_detail,barang_teknisi_detail,barang_dikirim_detail,barang_dikirim,barang_dijual,pembeli where pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id group by pembeli.id order by nama_pembeli ASC LIMIT $start, $limit";
        }
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
    if (isset($_SESSION['id_b'])) {
        if (isset($_GET['cari'])) {
            $sql = "select COUNT(DISTINCT pembeli.id) as jml from alat_uji_detail,barang_teknisi_detail,barang_dikirim_detail,barang_dikirim,barang_dijual,pembeli,tb_teknisi,barang_teknisi_detail_teknisi where pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and tb_teknisi.id=$_SESSION[id_b] and (nama_pembeli like '%$_GET[cari]%' or kelurahan_id like '%$_GET[cari]%' or jalan like '%$_GET[cari]%' or kontak_rs like '%$_GET[cari]%' or barang_dijual.no_po_jual like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%')";
        } else {
            $sql = "select COUNT(DISTINCT pembeli.id) as jml from alat_uji_detail,barang_teknisi_detail,barang_dikirim_detail,barang_dikirim,barang_dijual,pembeli,tb_teknisi,barang_teknisi_detail_teknisi where pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and tb_teknisi.id=$_SESSION[id_b]";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select COUNT(DISTINCT pembeli.id) as jml from alat_uji_detail,barang_teknisi_detail,barang_dikirim_detail,barang_dikirim,barang_dijual,pembeli where pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and (nama_pembeli like '%$_GET[cari]%' or kelurahan_id like '%$_GET[cari]%' or jalan like '%$_GET[cari]%' or kontak_rs like '%$_GET[cari]%' or barang_dijual.no_po_jual like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%')";
        } else {
            $sql = "select COUNT(DISTINCT pembeli.id) as jml from alat_uji_detail,barang_teknisi_detail,barang_dikirim_detail,barang_dikirim,barang_dijual,pembeli where pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id";
        }
    }
    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}

// if (isset($_SESSION['id_b'])) {
//     $query = mysqli_query($koneksi, "select *,alat_uji_detail.id as idd,pembeli.id as id_rumkit from alat_uji_detail,barang_teknisi_detail,barang_dikirim_detail,barang_dikirim,barang_dijual,pembeli,tb_teknisi,barang_teknisi_detail_teknisi where pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and tb_teknisi.id=$_SESSION[id_b] group by pembeli.id order by nama_pembeli ASC");
// } else {
//     $query = mysqli_query($koneksi, "select *,alat_uji_detail.id as idd,pembeli.id as id_rumkit from alat_uji_detail,barang_teknisi_detail,barang_dikirim_detail,barang_dikirim,barang_dijual,pembeli where pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id group by pembeli.id order by nama_pembeli ASC");
// }
//menampilkan data dari database, table tb_anggota
// $sql = "select *,pembeli.id as idd from pembeli,alamat_provinsi,alamat_kabupaten,alamat_kecamatan where alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id group by nama_pembeli order by nama_pembeli ASC";
