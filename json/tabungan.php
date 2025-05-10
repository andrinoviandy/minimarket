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
                        COALESCE(tsa.nominal_setor, 0) - COALESCE(tsa.nominal_ambil, 0) AS nominal,
                        a.id as idd 
                    from
                        tabungan a left join nasabah b on b.id = a.nasabah_id left join jenis_tabungan c on c.id = a.jenis_tabungan_id left join 
                        (
                        SELECT
                            tabungan_id,
                            SUM(CASE WHEN setor_ambil = 1 THEN nominal ELSE 0 END) AS nominal_setor,
                            SUM(CASE WHEN setor_ambil = 2 THEN nominal ELSE 0 END) AS nominal_ambil
                        FROM
                            tabungan_setor_ambil
                        GROUP BY
                            tabungan_id
                        ) tsa ON a.id = tsa.tabungan_id 
                    where b.nik like ('%$_GET[cari]%') 
                        or b.nama_nasabah like ('%$_GET[cari]%') 
                        or c.jenis_tabungan like ('%$_GET[cari]%') 
                        or a.keterangan like ('%$_GET[cari]%') 
                        or a.operator like ('%$_GET[cari]%') 
                    order by a.tgl_buka_tabungan desc, a.id desc LIMIT $start, $limit";
    } else {
        $sql = "select
                        *,
                        COALESCE(tsa.nominal_setor, 0) - COALESCE(tsa.nominal_ambil, 0) AS nominal,
                        a.id as idd 
                    from
                        tabungan a left join nasabah b on b.id = a.nasabah_id left join jenis_tabungan c on c.id = a.jenis_tabungan_id LEFT JOIN (
                        SELECT
                            tabungan_id,
                            SUM(CASE WHEN setor_ambil = 1 THEN nominal ELSE 0 END) AS nominal_setor,
                            SUM(CASE WHEN setor_ambil = 2 THEN nominal ELSE 0 END) AS nominal_ambil
                        FROM
                            tabungan_setor_ambil
                        GROUP BY
                            tabungan_id
                        ) tsa ON a.id = tsa.tabungan_id 
                    order by a.tgl_buka_tabungan desc, a.id desc LIMIT $start, $limit";
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
        $sql = "select
                        count(a.id) as jml 
                    from
                        tabungan a left join nasabah b on b.id = a.nasabah_id left join jenis_tabungan c on c.id = a.jenis_tabungan_id 
                    where b.nik like ('%$_GET[cari]%') 
                        or b.nama_nasabah like ('%$_GET[cari]%') 
                        or c.jenis_tabungan like ('%$_GET[cari]%') 
                        or a.keterangan like ('%$_GET[cari]%') 
                        or a.operator like ('%$_GET[cari]%')";
    } else {
        $sql = "select count(a.id) as jml from tabungan a";
    }

    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
