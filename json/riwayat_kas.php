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
                        z.* 
                    from 
                        ((select a.id, a.tgl as tgl_transaksi, a.jenis_transaksi , a.deskripsi, case when a.jenis_transaksi = 'Penerimaan' then a.harga else '-' end as debet, case when a.jenis_transaksi = 'Pembayaran' then a.harga else '-' end as kredit from biaya_lain a 
                        where a.buku_kas_id = '$_GET[id]')
                        union (select b.id, b.tgl_pinjam as tgl_transaksi, 'Buka Pinjaman' as jenis_transaksi , b.keterangan, '-' as debet, case when b.nominal_pinjam is not null then b.nominal_pinjam else '-' end as kredit from pinjaman b 
                        where b.buku_kas_id = '$_GET[id]')
                        union (select c.id, c.tgl_transaksi, 'Bayar Pinjaman' as jenis_transaksi , c.keterangan, case when c.nominal_bayar is not null then c.nominal_bayar else '-' end as debet, '-' as kredit from pinjaman_bayar c join pinjaman a on a.id = c.pinjaman_id where a.buku_kas_id = '$_GET[id]')) z 
                    where (z.deskripsi like ('%$_GET[cari]%') 
                        or z.jenis_transaksi like ('%$_GET[cari]%') 
                        or DATE_FORMAT(z.tgl_transaksi, '%d-%m-%Y') like ('%$_GET[cari]%'))
                    order by z.tgl_transaksi desc LIMIT $start, $limit";
    } else {
        $sql = "select
                        z.* 
                    from 
                        ((select a.id, a.tgl as tgl_transaksi, a.jenis_transaksi , a.deskripsi, case when a.jenis_transaksi = 'Penerimaan' then a.harga else '-' end as debet, case when a.jenis_transaksi = 'Pembayaran' then a.harga else '-' end as kredit from biaya_lain a 
                        where a.buku_kas_id = '$_GET[id]')
                        union (select b.id, b.tgl_pinjam as tgl_transaksi, 'Buka Pinjaman' as jenis_transaksi , b.keterangan, '-' as debet, case when b.nominal_pinjam is not null then b.nominal_pinjam else '-' end as kredit from pinjaman b 
                        where b.buku_kas_id = '$_GET[id]')
                        union (select c.id, c.tgl_transaksi, 'Bayar Pinjaman' as jenis_transaksi , c.keterangan, case when c.nominal_bayar is not null then c.nominal_bayar else '-' end as debet, '-' as kredit from pinjaman_bayar c join pinjaman a on a.id = c.pinjaman_id where a.buku_kas_id = '$_GET[id]')) z 
                    order by z.tgl_transaksi desc LIMIT $start, $limit";
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
                        count(z.id) as jml 
                    from 
                        ((select a.id, a.tgl as tgl_transaksi, a.jenis_transaksi , a.deskripsi, case when a.jenis_transaksi = 'Penerimaan' then a.harga else '-' end as debet, case when a.jenis_transaksi = 'Pembayaran' then a.harga else '-' end as kredit from biaya_lain a 
                        where a.buku_kas_id = '$_GET[id]')
                        union (select b.id, b.tgl_pinjam as tgl_transaksi, 'Buka Pinjaman' as jenis_transaksi , b.keterangan, '-' as debet, case when b.nominal_pinjam is not null then b.nominal_pinjam else '-' end as kredit from pinjaman b 
                        where b.buku_kas_id = '$_GET[id]')
                        union (select c.id, c.tgl_transaksi, 'Bayar Pinjaman' as jenis_transaksi , c.keterangan, case when c.nominal_bayar is not null then c.nominal_bayar else '-' end as debet, '-' as kredit from pinjaman_bayar c join pinjaman a on a.id = c.pinjaman_id where a.buku_kas_id = '$_GET[id]')) z 
                    where (z.deskripsi like ('%$_GET[cari]%') 
                        or z.jenis_transaksi like ('%$_GET[cari]%') 
                        or DATE_FORMAT(z.tgl_transaksi, '%d-%m-%Y') like ('%$_GET[cari]%'))";
    } else {
        $sql = "select count(z.id) as jml from 
                        ((select a.id from biaya_lain a 
                        where a.buku_kas_id = '$_GET[id]')
                        union (select b.id from pinjaman b 
                        where b.buku_kas_id = '$_GET[id]')
                        union (select c.id from pinjaman_bayar c join pinjaman a on a.id = c.pinjaman_id where a.buku_kas_id = '$_GET[id]')) z";
    }

    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
