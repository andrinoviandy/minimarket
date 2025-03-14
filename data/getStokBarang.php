<?php
include("../config/koneksi.php");
// include("../include/API.php");
session_start();
error_reporting(0);

if (isset($_GET['merk'])) {
    if ($_GET['merk'] == 'all') {
        $query = mysqli_query($koneksi, "select merk_brg, tipe_brg, nama_brg, (
        CASE WHEN barang_gudang.kategori_brg = 'Set' THEN 
        barang_gudang.stok_total -    
            ((select coalesce(sum(qty_jual),0) from barang_dijual_qty where barang_gudang_id=barang_gudang.id) + (select coalesce(sum(jml_total),0) from barang_dijual_qty_detail where barang_gudang_id=barang_gudang.id) - (select coalesce(count(*),0) from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_gudang_detail.barang_gudang_id=barang_gudang.id)) 
        ELSE 
        (select coalesce(count(*),0) from barang_gudang_detail where status_kirim=0 and status_kerusakan=0 and status_kembali_ke_gudang=0 and barang_gudang_id=barang_gudang.id) - 
            ((select coalesce(sum(qty_jual),0) from barang_dijual_qty where barang_gudang_id=barang_gudang.id) + (select coalesce(sum(jml_total),0) from barang_dijual_qty_detail where barang_gudang_id=barang_gudang.id) - (select coalesce(count(*),0) from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_gudang_detail.barang_gudang_id=barang_gudang.id))
        END
        ) 
        as stok, 
        (select sum(qty) as jml from barang_pesan_detail where barang_gudang_id=barang_gudang.id and status_ke_stok = 0) as stok_po from barang_gudang");
    } else if ($_GET['merk'] !== 'all' && !isset($_GET['tipe'])) {
        $merk = '"' . implode('","', $_GET['merk']) . '"';
        $query = mysqli_query($koneksi, "select merk_brg, tipe_brg, nama_brg, (
        CASE WHEN barang_gudang.kategori_brg = 'Set' THEN 
        barang_gudang.stok_total -    
            ((select coalesce(sum(qty_jual),0) from barang_dijual_qty where barang_gudang_id=barang_gudang.id) + (select coalesce(sum(jml_total),0) from barang_dijual_qty_detail where barang_gudang_id=barang_gudang.id) - (select coalesce(count(*),0) from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_gudang_detail.barang_gudang_id=barang_gudang.id)) 
        ELSE 
        (select coalesce(count(*),0) from barang_gudang_detail where status_kirim=0 and status_kerusakan=0 and status_kembali_ke_gudang=0 and barang_gudang_id=barang_gudang.id) - 
            ((select coalesce(sum(qty_jual),0) from barang_dijual_qty where barang_gudang_id=barang_gudang.id) + (select coalesce(sum(jml_total),0) from barang_dijual_qty_detail where barang_gudang_id=barang_gudang.id) - (select coalesce(count(*),0) from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_gudang_detail.barang_gudang_id=barang_gudang.id))
        END
        ) 
        as stok, 
        (select sum(qty) as jml from barang_pesan_detail where barang_gudang_id=barang_gudang.id and status_ke_stok = 0) as stok_po from barang_gudang where barang_gudang.merk_brg in ($merk)");
    } else if ($_GET['merk'] !== 'all' && $_GET['tipe'] !== 'all' && !isset($_GET['alkes'])) {
        $merk = '"' . implode('","', $_GET['merk']) . '"';
        $tipe = '"' . implode('","', $_GET['tipe']) . '"';
        $query = mysqli_query($koneksi, "select merk_brg, tipe_brg, nama_brg, (
        CASE WHEN barang_gudang.kategori_brg = 'Set' THEN 
        barang_gudang.stok_total -    
            ((select coalesce(sum(qty_jual),0) from barang_dijual_qty where barang_gudang_id=barang_gudang.id) + (select coalesce(sum(jml_total),0) from barang_dijual_qty_detail where barang_gudang_id=barang_gudang.id) - (select coalesce(count(*),0) from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_gudang_detail.barang_gudang_id=barang_gudang.id)) 
        ELSE 
        (select coalesce(count(*),0) from barang_gudang_detail where status_kirim=0 and status_kerusakan=0 and status_kembali_ke_gudang=0 and barang_gudang_id=barang_gudang.id) - 
            ((select coalesce(sum(qty_jual),0) from barang_dijual_qty where barang_gudang_id=barang_gudang.id) + (select coalesce(sum(jml_total),0) from barang_dijual_qty_detail where barang_gudang_id=barang_gudang.id) - (select coalesce(count(*),0) from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_gudang_detail.barang_gudang_id=barang_gudang.id))
        END
        ) 
        as stok, 
        (select sum(qty) as jml from barang_pesan_detail where barang_gudang_id=barang_gudang.id and status_ke_stok = 0) as stok_po from barang_gudang where barang_gudang.merk_brg in ($merk) and barang_gudang.tipe_brg in ($tipe)");
    } else if ($_GET['merk'] !== 'all' && $_GET['tipe'] !== 'all' && $_GET['alkes'] !== 'all') {
        $alkes = implode(",", $_GET['alkes']);
        $query = mysqli_query($koneksi, "select merk_brg, tipe_brg, nama_brg, (
        CASE WHEN barang_gudang.kategori_brg = 'Set' THEN 
        barang_gudang.stok_total -    
            ((select coalesce(sum(qty_jual),0) from barang_dijual_qty where barang_gudang_id=barang_gudang.id) + (select coalesce(sum(jml_total),0) from barang_dijual_qty_detail where barang_gudang_id=barang_gudang.id) - (select coalesce(count(*),0) from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_gudang_detail.barang_gudang_id=barang_gudang.id)) 
        ELSE 
        (select coalesce(count(*),0) from barang_gudang_detail where status_kirim=0 and status_kerusakan=0 and status_kembali_ke_gudang=0 and barang_gudang_id=barang_gudang.id) - 
            ((select coalesce(sum(qty_jual),0) from barang_dijual_qty where barang_gudang_id=barang_gudang.id) + (select coalesce(sum(jml_total),0) from barang_dijual_qty_detail where barang_gudang_id=barang_gudang.id) - (select coalesce(count(*),0) from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_gudang_detail.barang_gudang_id=barang_gudang.id))
        END
        ) 
        as stok, 
        (select sum(qty) as jml from barang_pesan_detail where barang_gudang_id=barang_gudang.id and status_ke_stok = 0) as stok_po from barang_gudang where barang_gudang.id in ($alkes)");
    } else {
        $query = mysqli_query($koneksi, "select merk_brg, tipe_brg, nama_brg, (
        CASE WHEN barang_gudang.kategori_brg = 'Set' THEN 
        barang_gudang.stok_total -    
            ((select coalesce(sum(qty_jual),0) from barang_dijual_qty where barang_gudang_id=barang_gudang.id) + (select coalesce(sum(jml_total),0) from barang_dijual_qty_detail where barang_gudang_id=barang_gudang.id) - (select coalesce(count(*),0) from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_gudang_detail.barang_gudang_id=barang_gudang.id)) 
        ELSE 
        (select coalesce(count(*),0) from barang_gudang_detail where status_kirim=0 and status_kerusakan=0 and status_kembali_ke_gudang=0 and barang_gudang_id=barang_gudang.id) - 
            ((select coalesce(sum(qty_jual),0) from barang_dijual_qty where barang_gudang_id=barang_gudang.id) + (select coalesce(sum(jml_total),0) from barang_dijual_qty_detail where barang_gudang_id=barang_gudang.id) - (select coalesce(count(*),0) from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_gudang_detail.barang_gudang_id=barang_gudang.id))
        END
        ) 
        as stok, 
        (select sum(qty) as jml from barang_pesan_detail where barang_gudang_id=barang_gudang.id and status_ke_stok = 0) as stok_po from barang_gudang");
    }
} else {
    $query = mysqli_query($koneksi, "select merk_brg, tipe_brg, nama_brg, (
        CASE WHEN barang_gudang.kategori_brg = 'Set' THEN 
        barang_gudang.stok_total -    
            ((select coalesce(sum(qty_jual),0) from barang_dijual_qty where barang_gudang_id=barang_gudang.id) + (select coalesce(sum(jml_total),0) from barang_dijual_qty_detail where barang_gudang_id=barang_gudang.id) - (select coalesce(count(*),0) from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_gudang_detail.barang_gudang_id=barang_gudang.id)) 
        ELSE 
        (select coalesce(count(*),0) from barang_gudang_detail where status_kirim=0 and status_kerusakan=0 and status_kembali_ke_gudang=0 and barang_gudang_id=barang_gudang.id) - 
            ((select coalesce(sum(qty_jual),0) from barang_dijual_qty where barang_gudang_id=barang_gudang.id) + (select coalesce(sum(jml_total),0) from barang_dijual_qty_detail where barang_gudang_id=barang_gudang.id) - (select coalesce(count(*),0) from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_gudang_detail.barang_gudang_id=barang_gudang.id))
        END
        ) 
        as stok, 
        (select sum(qty) as jml from barang_pesan_detail where barang_gudang_id=barang_gudang.id and status_ke_stok = 0) as stok_po from barang_gudang");
}
while ($data2 = mysqli_fetch_array($query)) {
?>
    <tr>
        <td style="width: 120px;"><?php echo $data2['merk_brg'] ?></td>
        <td style="width: 120px"><?php echo $data2['tipe_brg'] ?></td>
        <td style="width: 150px"><?php echo $data2['nama_brg'] ?></td>
        <td style="width: 100px"><?php echo $data2['stok'] ?></td>
        <td style="width: 100px"><?php if ($data2['stok_po'] == '' || $data2['stok_po'] == null) {
                                        echo "0";
                                    } else {
                                        echo $data2['stok_po'];;
                                    } ?></td>
    </tr>
<?php
}
