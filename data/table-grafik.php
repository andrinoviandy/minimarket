<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
?>
<div class="table-responsive no-padding">
    <table class="table table-hover table-bordered" id="example3">
        <thead>
            <tr>
                <!-- <th class="bg-info">RS/Dinas/Dll</th>
                <th class="bg-info">Alkes</th>
                <th class="bg-info">Tipe</th> -->
                <th>#</th>
                <th>Januari</th>
                <th>Februari</th>
                <th>Maret</th>
                <th>April</th>
                <th>Mei</th>
                <th>Juni</th>
                <th>Juli</th>
                <th>Agustus</th>
                <th>September</th>
                <th>Oktober</th>
                <th>November</th>
                <th>Desember</th>
            </tr>
        </thead>
        <?php
        // $start = $_GET['start'];

        // if (isset($_GET['cari'])) {
        //     $search = str_replace(" ", "%20", $_GET['cari']);
        //     if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
        //         $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "");
        //         $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "");
        //     } else {
        //         $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
        //         $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
        //     }
        // } else {
        // if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
        //     $file = file_get_contents($API . "json/$_GET[page].php?start=$start");
        //     $file2 = file_get_contents($API . "json/$_GET[page].php");
        // } else {
        // $file = file_get_contents("http://173.212.225.28/ALKES_2/json/transaksi_in_out.php?alkes=" . $_GET['alkes'] . "&tahun=" . $_GET['tahun'] . "");
        //     $file2 = file_get_contents($API . "json/$_GET[page].php?tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
        // }
        // }

        // $json = json_decode($file, true);

        // $jml2 = $file2;

        $filter = "";
        if ($_GET['alkes'] && $_GET['alkes'] !== 'all') {
            $filter = $filter . " and merk_brg = '" . $_GET['alkes'] . "' ";
            // $distinct = "CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END";
            if ($_GET['tipe'] && $_GET['tipe'] !== 'all') {
                $filter = $filter . " and tipe_brg = '" . $_GET['tipe'] . "' ";
            }
        }

        $sql = "select 
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '1' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as jan_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '2' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as feb_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '3' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as mar_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '4' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as apr_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '5' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as mei_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '6' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as jun_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '7' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as jul_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '8' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as agu_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '9' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as sep_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '10' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as okt_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '11' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as nov_in,
(SELECT CASE WHEN SUM(barang_gudang_po.stok) IS NULL THEN 0 ELSE SUM(barang_gudang_po.stok) END from barang_gudang, barang_gudang_po where barang_gudang.id = barang_gudang_po.barang_gudang_id and month(tgl_po_gudang) = '12' and year(tgl_po_gudang) = '$_GET[tahun]' $filter) as des_in,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '1' and year(tgl_jual) = '$_GET[tahun]' $filter) as jan_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '2' and year(tgl_jual) = '$_GET[tahun]' $filter) as feb_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '3' and year(tgl_jual) = '$_GET[tahun]' $filter) as mar_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '4' and year(tgl_jual) = '$_GET[tahun]' $filter) as apr_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '5' and year(tgl_jual) = '$_GET[tahun]' $filter) as mei_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '6' and year(tgl_jual) = '$_GET[tahun]' $filter) as jun_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '7' and year(tgl_jual) = '$_GET[tahun]' $filter) as jul_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '8' and year(tgl_jual) = '$_GET[tahun]' $filter) as agu_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '9' and year(tgl_jual) = '$_GET[tahun]' $filter) as sep_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '10' and year(tgl_jual) = '$_GET[tahun]' $filter) as okt_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '11' and year(tgl_jual) = '$_GET[tahun]' $filter) as nov_out,
(SELECT CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '12' and year(tgl_jual) = '$_GET[tahun]' $filter) as des_out 
from dual";

        ?>
        <tbody>
            <?php
            $data = mysqli_fetch_array(mysqli_query($koneksi, $sql));
            ?>
            <tr>
                <td style="background-color: rgba(210, 214, 222, 1);">IN</td>
                <td class="bg-info"><?php echo $data['jan_in']; ?></td>
                <td class="bg-info"><?php echo $data['feb_in']; ?></td>
                <td class="bg-info"><?php echo $data['mar_in']; ?></td>
                <td class="bg-info"><?php echo $data['apr_in']; ?></td>
                <td class="bg-info"><?php echo $data['mei_in']; ?></td>
                <td class="bg-info"><?php echo $data['jun_in']; ?></td>
                <td class="bg-info"><?php echo $data['jul_in']; ?></td>
                <td class="bg-info"><?php echo $data['agu_in']; ?></td>
                <td class="bg-info"><?php echo $data['sep_in']; ?></td>
                <td class="bg-info"><?php echo $data['okt_in']; ?></td>
                <td class="bg-info"><?php echo $data['nov_in']; ?></td>
                <td class="bg-info"><?php echo $data['des_in']; ?></td>
            </tr>
            <tr>
                <td style="background-color: rgba(60,141,188,0.9);">OUT</td>
                <td class="bg-info"><?php echo $data['jan_out']; ?></td>
                <td class="bg-info"><?php echo $data['feb_out']; ?></td>
                <td class="bg-info"><?php echo $data['mar_out']; ?></td>
                <td class="bg-info"><?php echo $data['apr_out']; ?></td>
                <td class="bg-info"><?php echo $data['mei_out']; ?></td>
                <td class="bg-info"><?php echo $data['jun_out']; ?></td>
                <td class="bg-info"><?php echo $data['jul_out']; ?></td>
                <td class="bg-info"><?php echo $data['agu_out']; ?></td>
                <td class="bg-info"><?php echo $data['sep_out']; ?></td>
                <td class="bg-info"><?php echo $data['okt_out']; ?></td>
                <td class="bg-info"><?php echo $data['nov_out']; ?></td>
                <td class="bg-info"><?php echo $data['des_out']; ?></td>
            </tr>
            <?php //} 
            ?>
        </tbody>
    </table>
</div>
<script>
    $(function() {
        $('#example1').DataTable()
        $('#example2').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': true,
            'ordering': false,
            'info': false,
            'autoWidth': true
        })
        $('#example3').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': false,
            'autoWidth': true
        })
        $('#example5').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true
        })
        $('#example4').DataTable()
    })
</script>