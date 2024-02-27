<?php
error_reporting(0);
header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");

if ($_GET['filter'] == '1') {
    $sql = "select *,barang_dijual.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.status_awal=1 and pembeli.id = $_GET[pembeli] and tgl_jual between '$_GET[tgl1]' and '$_GET[tgl2]' group by no_po_jual order by tgl_jual DESC, barang_dijual.id DESC";
} else if ($_GET['filter'] == '2') {
    $filter = '';
    if ($_GET['provinsi']) {
        if ($_GET['provinsi'] !== 'all') {
            $filter = $filter . "and pembeli.provinsi_id=$_GET[provinsi]";
            if ($_GET['kabupaten']) {
                if ($_GET['kabupaten'] !== 'all') {
                    $filter = $filter . " and pembeli.kabupaten_id=$_GET[kabupaten]";
                    if ($_GET['kecamatan']) {
                        if ($_GET['kecamatan'] !== 'all') {
                            $filter = $filter . " and pembeli.kecamatan_id=$_GET[kecamatan]";
                        }
                    }
                }
            }
        }
    }
    $sql = "select *,barang_dijual.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.status_awal=1 $filter and tgl_jual between '$_GET[tgl1]' and '$_GET[tgl2]' group by no_po_jual order by tgl_jual DESC, barang_dijual.id DESC";
} else {
    $sql = "select *,barang_dijual.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.status_awal=1 and tgl_jual between '$_GET[tgl1]' and '$_GET[tgl2]' group by no_po_jual order by tgl_jual DESC, barang_dijual.id DESC";
}
$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));
//membuat array
while ($row = mysqli_fetch_assoc($result)) {
    $ArrAnggota[] = $row;
}

echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

//tutup koneksi ke database
mysqli_close($koneksi);
