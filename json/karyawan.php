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
if (isset($_GET['start'])) {
    if (isset($_GET['cari'])) {
        $sql = "select
                        *,
                        karyawan.id as idd 
                    from
                        karyawan 
                    where nik like ('%$_GET[cari]%') 
                        or nama_karyawan like ('%$_GET[cari]%') 
                        or tempat_lahir like ('%$_GET[cari]%') 
                        or alamat like ('%$_GET[cari]%') 
                        or pendidikan_terakhir like ('%$_GET[cari]%') 
                        or jabatan like ('%$_GET[cari]%') 
                        or divisi like ('%$_GET[cari]%') 
                        or email like ('%$_GET[cari]%') 
                    order by nama_karyawan asc LIMIT $start, $limit";
    } else {
        $sql = "select *, karyawan.id as idd from karyawan order by nama_karyawan asc LIMIT $start, $limit";
    }
    $result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

    while ($row = mysqli_fetch_assoc($result)) {
        $ArrAnggota[] = $row;
    }

    echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

    //tutup koneksi ke database
    mysqli_close($koneksi);
} else {
    // untuk jumlah
    if (isset($_GET['cari'])) {
        $sql = "select count(DISTINCT karyawan.id) as jml from
                        karyawan 
                    where nik like ('%$_GET[cari]%') 
                        or nama_karyawan like ('%$_GET[cari]%') 
                        or tempat_lahir like ('%$_GET[cari]%') 
                        or alamat like ('%$_GET[cari]%') 
                        or pendidikan_terakhir like ('%$_GET[cari]%') 
                        or jabatan like ('%$_GET[cari]%') 
                        or divisi like ('%$_GET[cari]%') 
                        or email like ('%$_GET[cari]%')";
    } else {
        $sql = "select count(*) as jml from karyawan";
    }

    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
