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

//menampilkan data dari database, table tb_anggota
if (isset($_GET['id'])) {
    if (isset($_GET['start'])) {
        if (isset($_GET['cari'])) {
            $sql = "select *,barang_dikirim_set.id as idd from barang_dikirim_set where barang_dijual_set_id=" . $_GET['id'] . " and (nama_paket like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%' or po_no like '%$_GET[cari]%') order by barang_dikirim_set.tgl_kirim DESC,barang_dikirim_set.id DESC LIMIT $start, $limit";
        } else {
            $sql = "select *,barang_dikirim_set.id as idd from barang_dikirim_set where barang_dijual_set_id=" . $_GET['id'] . " order by barang_dikirim_set.tgl_kirim DESC,barang_dikirim_set.id DESC LIMIT $start, $limit";
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
            $sql = "select COUNT(*) as jml from barang_dikirim_set where barang_dijual_set_id=" . $_GET['id'] . " and (nama_paket like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%' or po_no like '%$_GET[cari]%')";
        } else {
            $sql = "select COUNT(*) as jml from barang_dikirim_set where barang_dijual_set_id=" . $_GET['id'] . "";
        }
        $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
        echo $result['jml'];
        //tutup koneksi ke database
        mysqli_close($koneksi);
    }
} else if (isset($_GET['id_riwayat'])) {
    if (isset($_GET['start'])) {
        if (isset($_GET['cari'])) {
            $sql = "select *,barang_dikirim_set.id as idd from barang_dikirim_set where id=" . $_GET['id_riwayat'] . " and (nama_paket like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%' or po_no like '%$_GET[cari]%') LIMIT $start, $limit";
        } else {
            $sql = "select *,barang_dikirim_set.id as idd from barang_dikirim_set where id=" . $_GET['id_riwayat'] . " LIMIT $start, $limit";
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
            $sql = "select COUNT(*) as jml from barang_dikirim_set where id=" . $_GET['id_riwayat'] . " and (nama_paket like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%' or po_no like '%$_GET[cari]%')";
        } else {
            $sql = "select COUNT(*) as jml from barang_dikirim_set where id=" . $_GET['id_riwayat'] . "";
        }
        $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
        echo $result['jml'];
        //tutup koneksi ke database
        mysqli_close($koneksi);
    }
} else {
    if (isset($_GET['start'])) {
        if (isset($_GET['cari'])) {
            $sql = "select *,barang_dikirim_set.id as idd from barang_dikirim_set where (nama_paket like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%' or po_no like '%$_GET[cari]%') order by barang_dikirim_set.tgl_kirim DESC,barang_dikirim_set.id DESC LIMIT $start, $limit";
        } else {
            $sql = "select *,barang_dikirim_set.id as idd from barang_dikirim_set order by barang_dikirim_set.tgl_kirim DESC,barang_dikirim_set.id DESC LIMIT $start, $limit";
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
            $sql = "select COUNT(*) as jml from barang_dikirim_set where (nama_paket like '%$_GET[cari]%' or no_pengiriman like '%$_GET[cari]%' or po_no like '%$_GET[cari]%') order by barang_dikirim_set.tgl_kirim DESC,barang_dikirim_set.id DESC";
        } else {
            $sql = "select COUNT(*) as jml from barang_dikirim_set order by barang_dikirim_set.tgl_kirim DESC,barang_dikirim_set.id DESC";
        }
        $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
        echo $result['jml'];
        //tutup koneksi ke database
        mysqli_close($koneksi);
    }
}
