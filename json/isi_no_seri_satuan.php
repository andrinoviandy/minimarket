<?php
error_reporting(0);
header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");

$sql = "select *,TIMESTAMPDIFF(DAY, NOW(), tgl_expired) as selisih_hari,barang_gudang_detail.id as idd from barang_gudang_detail , barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and kategori_brg = 'Satuan' and barang_gudang.id =" . $_GET['id'] . " and status_kirim=0 and status_kerusakan=0 and status_demo=0 and tgl_expired = '0000-00-00'  
union 
select *,TIMESTAMPDIFF(DAY, NOW(), tgl_expired) as selisih_hari,barang_gudang_detail.id as idd from barang_gudang_detail , barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and kategori_brg = 'Satuan' and barang_gudang.id =" . $_GET['id'] . " and status_kirim=0 and status_kerusakan=0 and status_demo=0 and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 180  
union 
select *,TIMESTAMPDIFF(DAY, NOW(), tgl_expired) as selisih_hari,barang_gudang_detail.id as idd from barang_gudang_detail , barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and kategori_brg = 'Satuan' and barang_gudang.id =" . $_GET['id'] . " and status_kirim=0 and status_kerusakan=0 and status_demo=0 and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0  
union 
select *,TIMESTAMPDIFF(DAY, NOW(), tgl_expired) as selisih_hari,barang_gudang_detail.id as idd from barang_gudang_detail , barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and kategori_brg = 'Satuan' and barang_gudang.id =" . $_GET['id'] . " and status_kirim=0 and status_kerusakan=0 and status_demo=0 and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) < 1 ";

$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

//membuat array
while ($row = mysqli_fetch_assoc($result)) {
	$ArrAnggota[] = $row;
}

echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

//tutup koneksi ke database
mysqli_close($koneksi);
