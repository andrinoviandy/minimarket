<?php
include("../config/koneksi.php");
// include("../include/API.php");
session_start();
error_reporting(0);
if (isset($_SESSION['administrator'])) {
    $total = 'sum(total_price_ppn) as totall';
    $font = '25px';
} else {
    $total = 'sum(qty) as totall';
    $font = '35px';
}
?>
<div style="font-size: <?php echo $font ?>; font-weight:bold;">
    <?php
    if (isset($_GET['merk'])) {
        if ($_GET['merk'] == 'all') {
            $query = "select $total from barang_pesan_detail,barang_pesan where barang_pesan.id=barang_pesan_detail.barang_pesan_id and jenis_po='Dalam Negeri' and year(tgl_po_pesan) = year(sysdate())";
        } else if ($_GET['merk'] !== 'all' && !isset($_GET['tipe'])) {
            $merk = '"' . implode('","', $_GET['merk']) . '"';
            $query = "select $total from barang_pesan_detail,barang_pesan,barang_gudang where barang_gudang.id=barang_pesan_detail.barang_gudang_id and barang_pesan.id=barang_pesan_detail.barang_pesan_id and jenis_po='Dalam Negeri' and barang_gudang.merk_brg in ($merk) and year(tgl_po_pesan) = year(sysdate())";
        } else if ($_GET['merk'] !== 'all' && $_GET['tipe'] !== 'all' && !isset($_GET['alkes'])) {
            $merk = '"' . implode('","', $_GET['merk']) . '"';
            $tipe = '"' . implode('","', $_GET['tipe']) . '"';
            $query = "select $total from barang_pesan_detail,barang_pesan,barang_gudang where barang_gudang.id=barang_pesan_detail.barang_gudang_id and barang_pesan.id=barang_pesan_detail.barang_pesan_id and jenis_po='Dalam Negeri' and barang_gudang.merk_brg in ($merk) and barang_gudang.tipe_brg in ($tipe) and year(tgl_po_pesan) = year(sysdate())";
        } else if ($_GET['merk'] !== 'all' && $_GET['tipe'] !== 'all' && $_GET['alkes'] !== 'all') {
            $alkes = implode(",", $_GET['alkes']);
            $query = "select $total from barang_pesan_detail,barang_pesan,barang_gudang where barang_gudang.id=barang_pesan_detail.barang_gudang_id and barang_pesan.id=barang_pesan_detail.barang_pesan_id and jenis_po='Dalam Negeri' and barang_gudang.id in ($alkes) and year(tgl_po_pesan) = year(sysdate())";
        } else {
            $query = "select $total from barang_pesan_detail,barang_pesan where barang_pesan.id=barang_pesan_detail.barang_pesan_id and jenis_po='Dalam Negeri' and year(tgl_po_pesan) = year(sysdate())";
        }
    } else {
        $query = "select $total from barang_pesan_detail,barang_pesan where barang_pesan.id=barang_pesan_detail.barang_pesan_id and jenis_po='Dalam Negeri' and year(tgl_po_pesan) = year(sysdate())";
    }
    $data5 = mysqli_fetch_array(mysqli_query($koneksi, $query));
    if ($data5['totall'] == 0) {
        echo "0";
    } else {
        if (isset($_SESSION['administrator'])) {
            echo "Rp".number_format($data5['totall'],0,',','.');
        } else {
            echo $data5['totall'];
        }
    }
    ?>
</div>