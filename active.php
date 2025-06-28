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
	} else if ($_GET['page'] == 'laporan_pembelian') {
		$laporan = "active";
		$laporan_pembelian = "active";
	} else if ($_GET['page'] == 'laporan_penjualan') {
		$laporan = "active";
		$laporan_penjualan = "active";
	} else if ($_GET['page'] == 'stok_limit') {
		$laporan = "active";
		$stok_limit = "active";
	} else if ($_GET['page'] == 'produk_kadaluarsa') {
		$laporan = "active";
		$produk_kadaluarsa = "active";
	} else if ($_GET['page'] == 'produk_terlaris') {
		$laporan = "active";
		$produk_terlaris = "active";
	} else if ($_GET['page'] == 'stok_harian') {
		$laporan = "active";
		$stok_harian = "active";
	} else if ($_GET['page'] == 'laporan_piutang') {
		$laporan = "active";
		$laporan_piutang = "active";
	} else if ($_GET['page'] == 'laba_rugi') {
		$laporan = "active";
		$laba_rugi = "active";
	} else {
		$act1 = "active";
	}
}
