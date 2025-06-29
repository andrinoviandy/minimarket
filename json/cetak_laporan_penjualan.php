<?php
// error_reporting(0);
header("Content-type:application/json");
session_start();
//koneksi ke database
require("../config/koneksi.php");
$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;

//menampilkan data dari database, table tb_anggota

$sql = "select
                        a.*,
                        a.id as idd, 
                        b.nama as nama_siswa,
                        c.nama as nama_guru,
                        d.banyak_produk 
                    from
                        penjualan a left join smkhilpa_kantin.siswa b on b.id = a.id_siswa left join smkhilpa_kantin.guru c on c.id = a.id_guru left join (select penjualan_id, sum(qty_jual) as banyak_produk from penjualan_qty_temp where status = 1 group by penjualan_id) d on a.id = d.penjualan_id 
                    where a.status_jual  = 2 and a.tgl_jual between '$_GET[tglPenjualan1]' and '$_GET[tglPenjualan2]' order by a.tgl_jual desc";

$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

while ($row = mysqli_fetch_assoc($result)) {
    $ArrAnggota[] = $row;
}

echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

//tutup koneksi ke database
mysqli_close($koneksi);
