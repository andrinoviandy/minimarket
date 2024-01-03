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

// $pg = @$_GET['paging'];
// if (empty($pg)) {
// 	$curr = 0;
// 	$pg = 1;
// } else {
// 	$curr = ($pg - 1) * $limit;
// }

if (isset($_GET['start'])) {
    if (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
        if (isset($_GET['cari'])) {
            $sql = "select barang_dijual.*,barang_dijual.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.status_awal=1 and (no_po_jual like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or marketing like '%$_GET[cari]%' or subdis like '%$_GET[cari]%') and tgl_jual between '$_GET[tgl1]' and '$_GET[tgl2]' group by no_po_jual order by tgl_jual DESC, barang_dijual.id DESC LIMIT $start, $limit";
        } else {
            $sql = "select barang_dijual.*,barang_dijual.id as idd from barang_dijual where status_awal=1 and tgl_jual between '$_GET[tgl1]' and '$_GET[tgl2]' group by no_po_jual order by tgl_jual DESC, barang_dijual.id DESC LIMIT $start, $limit";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select barang_dijual.*,barang_dijual.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.status_awal=1 and (no_po_jual like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or marketing like '%$_GET[cari]%' or subdis like '%$_GET[cari]%') group by no_po_jual order by tgl_jual DESC, barang_dijual.id DESC LIMIT $start, $limit";
        } else {
            $sql = "select barang_dijual.*,barang_dijual.id as idd from barang_dijual where status_awal=1 group by no_po_jual order by tgl_jual DESC, barang_dijual.id DESC LIMIT $start, $limit";
        }
    }
    $result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

    //membuat array
    while ($row = mysqli_fetch_assoc($result)) {
        $ArrAnggota[] = $row;
    }

    echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

    //tutup koneksi ke database
    mysqli_close($koneksi);
} else {
    //untuk jumlah
    if ($_GET['tgl1'] && $_GET['tgl2']) {
        if (isset($_GET['cari'])) {
            $sql = "select COUNT(DISTINCT barang_dijual.id) as jml from barang_dijual,barang_dijual_qty,barang_gudang,pembeli where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.status_awal=1 and (no_po_jual like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or marketing like '%$_GET[cari]%' or subdis like '%$_GET[cari]%') and tgl_jual between '$_GET[tgl1]' and '$_GET[tgl2]'";
        } else {
            $sql = "select COUNT(DISTINCT barang_dijual.id) as jml from barang_dijual where status_awal=1 and tgl_jual between '$_GET[tgl1]' and '$_GET[tgl2]'";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select COUNT(DISTINCT barang_dijual.id) as jml from barang_dijual,barang_dijual_qty,barang_gudang,pembeli where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.status_awal=1 and (no_po_jual like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or marketing like '%$_GET[cari]%' or subdis like '%$_GET[cari]%')";
        } else {
            $sql = "select COUNT(DISTINCT barang_dijual.id) as jml from barang_dijual where status_awal=1";
        }
    }
    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
//menampilkan data dari database, table tb_anggota
// if (isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
// 	$sql = "select *,barang_dijual.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.status_awal=1 and tgl_jual between '$_GET[tgl1]' and '$_GET[tgl2]' group by no_po_jual order by tgl_jual DESC, barang_dijual.id DESC LIMIT $curr, $limit";
// } elseif (isset($_GET['kunci']) and isset($_GET['pilihan'])) {
// 	$sql = "select *,barang_dijual.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and pembeli.id=barang_dijual.pembeli_id and $_GET[pilihan] like '%$_GET[kunci]%' and barang_dijual.status_awal=1 group by no_po_jual order by tgl_jual DESC, barang_dijual.id DESC LIMIT $curr, $limit";
// } elseif (isset($_GET['status_barang'])) {
// 	if ($_GET['status_barang'] == 'Belum') {
// 		$sel = mysqli_query($koneksi, "select * from barang_dijual_qty");
// 		while ($d = mysqli_fetch_array($sel)) {
// 			$ss = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dikirim_detail where barang_dijual_qty_id=$d[id]"));
// 			if ($ss == 0) {
// 				$sql = "select *,barang_dijual.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual_qty.id=$d[id] and barang_dijual.status_awal=1 group by no_po_jual order by tgl_jual DESC, barang_dijual.id DESC LIMIT $curr, $limit";
// 			}
// 		}
// 	} elseif ($_GET['status_barang'] == 'Sudah') {
// 		$sql = "select *,barang_dijual.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,barang_dikirim_detail where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_dijual.status_awal=1 group by no_po_jual order by tgl_jual DESC, barang_dijual.id DESC LIMIT $curr, $limit";
// 	}
// } else {
// 	$sql = "select *,barang_dijual.id as idd from barang_dijual where status_awal=1 group by no_po_jual order by tgl_jual DESC, barang_dijual.id DESC LIMIT $curr, $limit";
// }
