<?php require("config/koneksi.php"); ?>
<?php
$simpan = mysqli_query($koneksi, "update barang_dijual_qty,barang_gudang set harga_jual_saat_itu=harga_satuan where barang_gudang.id=barang_dijual_qty.barang_gudang_id");
if ($simpan) {
	echo "<script>
	alert('Berhasil Di Update');
	history.back();</script>";
	}
	else {
		echo "<script>
	alert('Gagal Di Update');
	history.back();</script>";
		}
?>