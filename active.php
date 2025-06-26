<?php
if (isset($_GET['page'])) {
	if ($_GET['page'] == 'beranda') {
		$act1 = "active";
	} else if ($_GET['page'] == 'produk' || $_GET['page'] == 'tambah_produk' || $_GET['page'] == 'detail_produk' || $_GET['page'] == 'tambah_stok_1') {
		$produk = "active";
	} else if ($_GET['page'] == 'pembelian' || $_GET['page'] == 'ubah_pembelian' || $_GET['page'] == 'detail_pembelian_produk' || $_GET['page'] == 'tambah_pembelian' || $_GET['page'] == 'simpan_tambah_pembelian') {
		$pembelian = "active";
	} else if ($_GET['page'] == 'penjualan' || $_GET['page'] == 'tambah_penjualan') {
		$penjualan = "active";
	} else if ($_GET['page'] == 'piutang') {
		$piutang = "active";
	} else if ($_GET['page'] == 'arus_kas') {
		$arus_kas = "active";
	} else if ($_GET['page'] == 'pemasok' || $_GET['page'] == 'tambah_pemasok') {
		$pemasok = "active";
	} else if ($_GET['page'] == 'user') {
		$pengaturan = "active";
		$user = "active";
	} else {
		$act1 = "active";
	}
}
