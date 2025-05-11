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
    if (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
        if (isset($_GET['cari'])) {
            $sql = "select
                        z.* 
                    from 
                        ((select a.id, a.tgl as tgl_transaksi, a.jenis_transaksi , a.deskripsi as keterangan, case when a.jenis_transaksi = 'Penerimaan' then a.harga else '-' end as debet, case when a.jenis_transaksi = 'Pembayaran' then a.harga else '-' end as kredit, 'biaya_lain' as tabel from biaya_lain a 
                        where a.buku_kas_id = '$_GET[id]')
                        union (select b.id, b.tgl_pinjam as tgl_transaksi, 'Buka Pinjaman' as jenis_transaksi , b.keterangan, '-' as debet, b.nominal_pinjam as kredit, 'pinjaman' as tabel from pinjaman b 
                        where b.buku_kas_id = '$_GET[id]')
                        union (select c.id, c.tgl_transaksi, 'Bayar Pinjaman' as jenis_transaksi , c.keterangan, c.nominal_bayar as debet, '-' as kredit, 'pinjaman_bayar' as tabel from pinjaman_bayar c join pinjaman a on a.id = c.pinjaman_id where a.buku_kas_id = '$_GET[id]') 
                        union (select d.id, d.tgl_deposit as tgl_transaksi, 'Mutasi Kas' as jenis_transaksi , d.deskripsi as keterangan, '-' as debet, d.nominal_deposit as kredit, 'deposit' as tabel from deposit d where d.dari_akun_id = '$_GET[id]') 
                        union (select d.id, d.tgl_deposit as tgl_transaksi, 'Mutasi Kas' as jenis_transaksi , d.deskripsi as keterangan, d.nominal_deposit as debet, '-' as kredit, 'deposit' as tabel from deposit d where d.ke_akun_id = '$_GET[id]')) z 
                    where z.tgl_transaksi between '$_GET[tgl1]' and '$_GET[tgl2]' and (z.deskripsi like ('%$_GET[cari]%') 
                        or z.jenis_transaksi like ('%$_GET[cari]%') 
                        or DATE_FORMAT(z.tgl_transaksi, '%d-%m-%Y') like ('%$_GET[cari]%')) 
                    order by z.tgl_transaksi desc LIMIT $start, $limit";
        } else {
            $sql = "select
                        z.* 
                    from 
                        ((select a.id, a.tgl as tgl_transaksi, a.jenis_transaksi , a.deskripsi as keterangan, case when a.jenis_transaksi = 'Penerimaan' then a.harga else '-' end as debet, case when a.jenis_transaksi = 'Pembayaran' then a.harga else '-' end as kredit, 'biaya_lain' as tabel from biaya_lain a 
                        where a.buku_kas_id = '$_GET[id]')
                        union (select b.id, b.tgl_pinjam as tgl_transaksi, 'Buka Pinjaman' as jenis_transaksi , b.keterangan, '-' as debet, b.nominal_pinjam as kredit, 'pinjaman' as tabel from pinjaman b 
                        where b.buku_kas_id = '$_GET[id]')
                        union (select c.id, c.tgl_transaksi, 'Bayar Pinjaman' as jenis_transaksi , c.keterangan, c.nominal_bayar as debet, '-' as kredit, 'pinjaman_bayar' as tabel from pinjaman_bayar c join pinjaman a on a.id = c.pinjaman_id where a.buku_kas_id = '$_GET[id]') 
                        union (select d.id, d.tgl_deposit as tgl_transaksi, 'Mutasi Kas' as jenis_transaksi , d.deskripsi as keterangan, '-' as debet, d.nominal_deposit as kredit, 'deposit' as tabel from deposit d where d.dari_akun_id = '$_GET[id]') 
                        union (select d.id, d.tgl_deposit as tgl_transaksi, 'Mutasi Kas' as jenis_transaksi , d.deskripsi as keterangan, d.nominal_deposit as debet, '-' as kredit, 'deposit' as tabel from deposit d where d.ke_akun_id = '$_GET[id]')) z 
                    where z.tgl_transaksi between '$_GET[tgl1]' and '$_GET[tgl2]' 
                    order by z.tgl_transaksi desc LIMIT $start, $limit";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select
                        z.* 
                    from 
                        ((select a.id, a.tgl as tgl_transaksi, a.jenis_transaksi , a.deskripsi as keterangan, case when a.jenis_transaksi = 'Penerimaan' then a.harga else '-' end as debet, case when a.jenis_transaksi = 'Pembayaran' then a.harga else '-' end as kredit, 'biaya_lain' as tabel from biaya_lain a 
                        where a.buku_kas_id = '$_GET[id]')
                        union (select b.id, b.tgl_pinjam as tgl_transaksi, 'Buka Pinjaman' as jenis_transaksi , b.keterangan, '-' as debet, b.nominal_pinjam as kredit, 'pinjaman' as tabel from pinjaman b 
                        where b.buku_kas_id = '$_GET[id]')
                        union (select c.id, c.tgl_transaksi, 'Bayar Pinjaman' as jenis_transaksi , c.keterangan, c.nominal_bayar as debet, '-' as kredit, 'pinjaman_bayar' as tabel from pinjaman_bayar c join pinjaman a on a.id = c.pinjaman_id where a.buku_kas_id = '$_GET[id]') 
                        union (select d.id, d.tgl_deposit as tgl_transaksi, 'Mutasi Kas' as jenis_transaksi , d.deskripsi as keterangan, '-' as debet, d.nominal_deposit as kredit, 'deposit' as tabel from deposit d where d.dari_akun_id = '$_GET[id]') 
                        union (select d.id, d.tgl_deposit as tgl_transaksi, 'Mutasi Kas' as jenis_transaksi , d.deskripsi as keterangan, d.nominal_deposit as debet, '-' as kredit, 'deposit' as tabel from deposit d where d.ke_akun_id = '$_GET[id]')) z 
                    where (z.deskripsi like ('%$_GET[cari]%') 
                        or z.jenis_transaksi like ('%$_GET[cari]%') 
                        or DATE_FORMAT(z.tgl_transaksi, '%d-%m-%Y') like ('%$_GET[cari]%'))
                    order by z.tgl_transaksi desc LIMIT $start, $limit";
        } else {
            $sql = "select
                        z.* 
                    from 
                        ((select a.id, a.tgl as tgl_transaksi, a.jenis_transaksi , a.deskripsi as keterangan, case when a.jenis_transaksi = 'Penerimaan' then a.harga else '-' end as debet, case when a.jenis_transaksi = 'Pembayaran' then a.harga else '-' end as kredit, 'biaya_lain' as tabel from biaya_lain a 
                        where a.buku_kas_id = '$_GET[id]')
                        union (select b.id, b.tgl_pinjam as tgl_transaksi, 'Buka Pinjaman' as jenis_transaksi , b.keterangan, '-' as debet, b.nominal_pinjam as kredit, 'pinjaman' as tabel from pinjaman b 
                        where b.buku_kas_id = '$_GET[id]')
                        union (select c.id, c.tgl_transaksi, 'Bayar Pinjaman' as jenis_transaksi , c.keterangan, c.nominal_bayar as debet, '-' as kredit, 'pinjaman_bayar' as tabel from pinjaman_bayar c join pinjaman a on a.id = c.pinjaman_id where a.buku_kas_id = '$_GET[id]') 
                        union (select d.id, d.tgl_deposit as tgl_transaksi, 'Mutasi Kas' as jenis_transaksi , d.deskripsi as keterangan, '-' as debet, d.nominal_deposit as kredit, 'deposit' as tabel from deposit d where d.dari_akun_id = '$_GET[id]') 
                        union (select d.id, d.tgl_deposit as tgl_transaksi, 'Mutasi Kas' as jenis_transaksi , d.deskripsi as keterangan, d.nominal_deposit as debet, '-' as kredit, 'deposit' as tabel from deposit d where d.ke_akun_id = '$_GET[id]')) z 
                    order by z.tgl_transaksi desc LIMIT $start, $limit";
        }
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
    if (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
        if (isset($_GET['cari'])) {
            $sql = "select
                        count(z.id) as jml 
                    from 
                        ((select a.id, a.tgl as tgl_transaksi, a.jenis_transaksi , a.deskripsi as keterangan, case when a.jenis_transaksi = 'Penerimaan' then a.harga else '-' end as debet, case when a.jenis_transaksi = 'Pembayaran' then a.harga else '-' end as kredit, 'biaya_lain' as tabel from biaya_lain a 
                        where a.buku_kas_id = '$_GET[id]')
                        union (select b.id, b.tgl_pinjam as tgl_transaksi, 'Buka Pinjaman' as jenis_transaksi , b.keterangan, '-' as debet, b.nominal_pinjam as kredit, 'pinjaman' as tabel from pinjaman b 
                        where b.buku_kas_id = '$_GET[id]')
                        union (select c.id, c.tgl_transaksi, 'Bayar Pinjaman' as jenis_transaksi , c.keterangan, c.nominal_bayar as debet, '-' as kredit, 'pinjaman_bayar' as tabel from pinjaman_bayar c join pinjaman a on a.id = c.pinjaman_id where a.buku_kas_id = '$_GET[id]') 
                        union (select d.id, d.tgl_deposit as tgl_transaksi, 'Mutasi Kas' as jenis_transaksi , d.deskripsi as keterangan, '-' as debet, d.nominal_deposit as kredit, 'deposit' as tabel from deposit d where d.dari_akun_id = '$_GET[id]') 
                        union (select d.id, d.tgl_deposit as tgl_transaksi, 'Mutasi Kas' as jenis_transaksi , d.deskripsi as keterangan, d.nominal_deposit as debet, '-' as kredit, 'deposit' as tabel from deposit d where d.ke_akun_id = '$_GET[id]')) z 
                    where z.tgl_transaksi between '$_GET[tgl1]' and '$_GET[tgl2]' and (z.deskripsi like ('%$_GET[cari]%') 
                        or z.jenis_transaksi like ('%$_GET[cari]%') 
                        or DATE_FORMAT(z.tgl_transaksi, '%d-%m-%Y') like ('%$_GET[cari]%'))";
        } else {
            $sql = "select count(z.id) as jml from 
                        ((select a.id, a.tgl as tgl_transaksi from biaya_lain a 
                        where a.buku_kas_id = '$_GET[id]')
                        union (select b.id, b.tgl_pinjam as tgl_transaksi from pinjaman b 
                        where b.buku_kas_id = '$_GET[id]')
                        union (select c.id, c.tgl_transaksi from pinjaman_bayar c join pinjaman a on a.id = c.pinjaman_id where a.buku_kas_id = '$_GET[id]') 
                        union (select d.id, d.tgl_deposit as tgl_transaksi from deposit d where d.dari_akun_id = '$_GET[id]') 
                        union (select d.id, d.tgl_deposit as tgl_transaksi from deposit d where d.ke_akun_id = '$_GET[id]')) z where z.tgl_transaksi between '$_GET[tgl1]' and '$_GET[tgl2]' ";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select
                        count(z.id) as jml 
                    from 
                        ((select a.id, a.tgl as tgl_transaksi, a.jenis_transaksi , a.deskripsi as keterangan, case when a.jenis_transaksi = 'Penerimaan' then a.harga else '-' end as debet, case when a.jenis_transaksi = 'Pembayaran' then a.harga else '-' end as kredit, 'biaya_lain' as tabel from biaya_lain a 
                        where a.buku_kas_id = '$_GET[id]')
                        union (select b.id, b.tgl_pinjam as tgl_transaksi, 'Buka Pinjaman' as jenis_transaksi , b.keterangan, '-' as debet, b.nominal_pinjam as kredit, 'pinjaman' as tabel from pinjaman b 
                        where b.buku_kas_id = '$_GET[id]')
                        union (select c.id, c.tgl_transaksi, 'Bayar Pinjaman' as jenis_transaksi , c.keterangan, c.nominal_bayar as debet, '-' as kredit, 'pinjaman_bayar' as tabel from pinjaman_bayar c join pinjaman a on a.id = c.pinjaman_id where a.buku_kas_id = '$_GET[id]') 
                        union (select d.id, d.tgl_deposit as tgl_transaksi, 'Mutasi Kas' as jenis_transaksi , d.deskripsi as keterangan, '-' as debet, d.nominal_deposit as kredit, 'deposit' as tabel from deposit d where d.dari_akun_id = '$_GET[id]') 
                        union (select d.id, d.tgl_deposit as tgl_transaksi, 'Mutasi Kas' as jenis_transaksi , d.deskripsi as keterangan, d.nominal_deposit as debet, '-' as kredit, 'deposit' as tabel from deposit d where d.ke_akun_id = '$_GET[id]')) z 
                    where (z.deskripsi like ('%$_GET[cari]%') 
                        or z.jenis_transaksi like ('%$_GET[cari]%') 
                        or DATE_FORMAT(z.tgl_transaksi, '%d-%m-%Y') like ('%$_GET[cari]%'))";
        } else {
            $sql = "select count(z.id) as jml from 
                        ((select a.id from biaya_lain a 
                        where a.buku_kas_id = '$_GET[id]')
                        union (select b.id from pinjaman b 
                        where b.buku_kas_id = '$_GET[id]')
                        union (select c.id from pinjaman_bayar c join pinjaman a on a.id = c.pinjaman_id where a.buku_kas_id = '$_GET[id]') 
                        union (select d.id from deposit d where d.dari_akun_id = '$_GET[id]') 
                        union (select d.id from deposit d where d.ke_akun_id = '$_GET[id]')) z";
        }
    }

    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
