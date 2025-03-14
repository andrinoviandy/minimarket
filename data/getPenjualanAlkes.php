<?php
include("../config/koneksi.php");
// include("../include/API.php");
session_start();
error_reporting(0);
if (isset($_SESSION['administrator'])) {
    $total = 'sum(qty_jual*harga_jual_saat_itu) as jml';
    $font = '25px';
} else {
    $total = 'sum(qty_jual) as jml';
    $font = '35px';
}
?>
<div style="font-size: <?php echo $font ?>; font-weight:bold;">
    <?php
    if (isset($_GET['merk'])) {
        if ($_GET['merk'] == 'all') {
            $query = "select $total from barang_dijual_qty, barang_dijual where barang_dijual.id = barang_dijual_qty.barang_dijual_id and year(tgl_jual) = year(sysdate())";
        } else if ($_GET['merk'] !== 'all' && !isset($_GET['tipe'])) {
            $merk = '"' . implode('","', $_GET['merk']) . '"';
            // $query = "select COUNT(*) as jml from barang_dikirim_detail, barang_gudang_detail, barang_gudang where barang_gudang.id = barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_gudang.merk_brg in ($merk)";
            $query = "select $total from barang_dijual_qty, barang_gudang, barang_dijual where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and barang_gudang.merk_brg in ($merk) and year(tgl_jual) = year(sysdate())";
        } else if ($_GET['merk'] !== 'all' && $_GET['tipe'] !== 'all' && !isset($_GET['alkes'])) {
            $merk = '"' . implode('","', $_GET['merk']) . '"';
            $tipe = '"' . implode('","', $_GET['tipe']) . '"';
            // $query = "select COUNT(*) as jml from barang_dikirim_detail, barang_gudang_detail, barang_gudang where barang_gudang.id = barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_gudang.merk_brg in ($merk) and barang_gudang.tipe_brg in ($tipe)";
            $query = "select $total from barang_dijual_qty, barang_gudang, barang_dijual where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and barang_gudang.merk_brg in ($merk) and barang_gudang.tipe_brg in ($tipe) and year(tgl_jual) = year(sysdate())";
        } else if ($_GET['merk'] !== 'all' && $_GET['tipe'] !== 'all' && $_GET['alkes'] !== 'all') {
            $alkes = implode(",", $_GET['alkes']);
            $query = "select $total from barang_dijual_qty, barang_gudang, barang_dijual where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and barang_gudang.id in ($alkes) and year(tgl_jual) = year(sysdate())";
        } else {
            $query = "select $total from barang_dijual_qty, barang_dijual where barang_dijual.id = barang_dijual_qty.barang_dijual_id and year(tgl_jual) = year(sysdate())";
        }
    } else {
        $query = "select $total from barang_dijual_qty, barang_dijual where barang_dijual.id = barang_dijual_qty.barang_dijual_id and year(tgl_jual) = year(sysdate())";
    }
    $data2 = mysqli_fetch_array(mysqli_query($koneksi, $query));
    if ($data2['jml'] == 0) {
        echo "0";
    } else {
        if (isset($_SESSION['administrator'])) {
            echo "Rp".number_format($data2['jml'],0,',','.');
        } else {
            echo $data2['jml'];
        }
    }
    ?>
</div>