<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$dt = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_gudang where id=" . $_POST['id_akse'] . ""));
if ($dt['harga_satuan'] != 0) {
    $cek = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_dijual_qty where barang_gudang_id = $_POST[id_akse] and barang_dijual_id = $_POST[idd]"));
    if ($cek['jml'] > 0) {
        echo "SA";
        die();
    }
    //$stok = mysqli_fetch_array(mysqli_query($koneksi, "select stok_total from barang_gudang where id=".$_POST['id_akse'].""));
    //$stok_po1 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty_jual) as stok_po from barang_dijual_qty where barang_gudang_id=".$_POST['id_akse'].""));
    //$stok_po2 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_dijual_qty.barang_gudang_id=".$_POST['id_akse'].""));
    //$go=$stok['stok_total']-($stok_po1['stok_po']-$stok_po2);
    //if ($go>=$_POST['qty']) {
    $sel_hrg_jual = mysqli_fetch_array(mysqli_query($koneksi, "select harga_satuan from barang_gudang where id=" . $_POST['id_akse'] . ""));
    $simpan = mysqli_query($koneksi, "insert into barang_dijual_qty values('','" . $_POST['idd'] . "','" . $_POST['id_akse'] . "','" . $sel_hrg_jual['harga_satuan'] . "','" . $_POST['qty'] . "','" . str_replace(".", "", $_POST['ongkirr']) . "','')");
    if ($simpan) {
        if ($dt['kategori_brg'] == 'Set') {
            $q = mysqli_query($koneksi, "select * from barang_gudang_detail_set where barang_gudang_set_id = $dt[id]");
            $max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as idd from barang_dijual_qty"));
            while ($dd = mysqli_fetch_array($q)) {
                $hrg = mysqli_fetch_array(mysqli_query($koneksi, "select harga_satuan from barang_gudang where id = '$dd[barang_gudang_id]'"));
                $jml_total = $dd['qty'] * $_POST['qty'];
                mysqli_query($koneksi, "insert into barang_dijual_qty_detail values ('','$max[idd]','$dd[barang_gudang_id]','$hrg[harga_satuan]','$dd[qty]', '$jml_total')");
            }
        }
        if ($dt['kategori_brg'] == 'Satuan' && $_POST['inc'] == '1') {
            $q = mysqli_query($koneksi, "select * from barang_gudang_detail_akse where barang_gudang_akse_id = $dt[id]");
            $max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as idd from barang_dijual_qty"));
            while ($dd = mysqli_fetch_array($q)) {
                $hrg = mysqli_fetch_array(mysqli_query($koneksi, "select harga_satuan from barang_gudang where id = '$dd[barang_gudang_id]'"));
                $jml_total = $dd['qty'] * $_POST['qty'];
                mysqli_query($koneksi, "insert into barang_dijual_qty_detail values ('','$max[idd]','$dd[barang_gudang_id]','$hrg[harga_satuan]','$dd[qty]', '$jml_total')");
            }
        }

        $jml = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty_jual*harga_jual_saat_itu) as total from barang_dijual_qty where barang_dijual_id=" . $_POST['idd'] . ""));

        mysqli_query($koneksi, "update barang_dijual set ongkir=ongkir+" . str_replace(".", "", $_POST['ongkirr']) . "");
        $data = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dijual where id=" . $_POST['idd'] . ""));
        $dpp = ($jml['total'] + $data['ongkir']) / 1.1;
        mysqli_query($koneksi, "update barang_dijual set total_harga=$jml[total], neto='" . ($dpp - ($jml['total'] * $data['diskon_jual'] / 100) - (($dpp * $data['ppn_jual'] / 100) + ($dpp * $data['pph'] / 100) + $data['zakat'] + $data['biaya_bank'])) . "' where id=" . $_POST['idd'] . "");

        //$update_piutang = mysqli_query($koneksi, "update utang_piutang set nominal=$jml[total] where no_faktur_no_po='".$data['no_po_jual']."'");

        if ($data['status_deal'] == 1) {
            $update_piutang = mysqli_query($koneksi, "update utang_piutang set nominal=" . ($dpp - ($jml['total'] * $data['diskon_jual'] / 100) - ($dpp * $data['ppn_jual'] / 100) - ($dpp * $data['pph'] / 100) - $data['zakat'] - $data['biaya_bank']) . " where no_faktur_no_po='" . $data['no_po_jual'] . "'");
        }
        echo "S";
    } else {
        echo "F";
    }
} else {
    // echo "<script>alert('Harga jual alat tidak boleh 0 , update harga jual nya terlebih dahulu !');
    //       </script>";;
    echo "K";
}
