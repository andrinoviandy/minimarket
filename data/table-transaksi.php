<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<div class="table-responsive no-padding">
    <table class="table table-hover table-bordered" id="example1">
        <thead>
            <tr>
                <th class="bg-info">RS/Dinas/Dll</th>
                <th class="bg-info">Alkes</th>
                <th class="bg-info">Tipe</th>
                <th class="bg-primary">Januari</th>
                <th class="bg-primary">Februari</th>
                <th class="bg-primary">Maret</th>
                <th class="bg-primary">April</th>
                <th class="bg-primary">Mei</th>
                <th class="bg-primary">Juni</th>
                <th class="bg-primary">Juli</th>
                <th class="bg-primary">Agustus</th>
                <th class="bg-primary">September</th>
                <th class="bg-primary">Oktober</th>
                <th class="bg-primary">November</th>
                <th class="bg-primary">Desember</th>
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
        $file = file_get_contents($API . "json/transaksi_penjualan.php?alkes=" . $_GET['alkes'] . "&pembeli=" . $_GET['pembeli'] . "&provinsi=" . $_GET['provinsi'] . "&kabupaten=" . $_GET['kabupaten'] . "&kecamatan=" . $_GET['kecamatan'] . "&tahun=" . $_GET['tahun'] . "&filter=" . $_GET['filter'] . "");
        //     $file2 = file_get_contents($API . "json/$_GET[page].php?tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
        // }
        // }

        $filter = "";
        if ($_GET['alkes'] && $_GET['alkes'] !== 'all') {
            $filter = $filter . " and barang_gudang_id = $_GET[alkes] ";
        }
        if ($_GET['filter'] == 1) {
            $filter = $filter . " and pembeli.id = $_GET[pembeli] ";
        } else if ($_GET['filter'] == 2) {
            if ($_GET['provinsi'] && $_GET['provinsi'] !== 'all') {
                $filter = $filter . " and provinsi_id = $_GET[provinsi] ";
                if ($_GET['kabupaten'] && $_GET['kabupaten'] !== 'all') {
                    $filter = $filter . " and kabupaten_id = $_GET[kabupaten] ";
                    if ($_GET['kecamatan'] && $_GET['kecamatan'] !== 'all') {
                        $filter = $filter . " and kecamatan_id = $_GET[kecamatan] ";
                    }
                }
            }
        }

        $json = json_decode($file, true);
        $jml = count($json);

        // $jml2 = $file2;

        ?>
        <tbody>
            <?php
            for ($i = 0; $i < $jml; $i++) {
            ?>
                <tr>
                    <td class="bg-info"><?php echo $json[$i]['nama_pembeli']; ?></td>
                    <td class="bg-info"><?php echo $json[$i]['nama_brg']; ?></td>
                    <td class="bg-info"><?php echo $json[$i]['tipe_brg']; ?></td>
                    <td align="center">
                        <?php
                        $jan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT CASE WHEN sum(barang_dijual_qty.qty_jual) IS NULL THEN '-' ELSE sum(barang_dijual_qty.qty_jual) END as jumlah from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '1' and year(tgl_jual) = '$_GET[tahun]' and pembeli.id = " . $json[$i]['pembeli_id'] . " and barang_gudang.id= " . $json[$i]['barang_id'] . ""));
                        echo $jan['jumlah'];
                        ?>
                    </td>
                    <td align="center">
                        <?php
                        $feb = mysqli_fetch_array(mysqli_query($koneksi, "SELECT CASE WHEN sum(barang_dijual_qty.qty_jual) IS NULL THEN '-' ELSE sum(barang_dijual_qty.qty_jual) END as jumlah from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '2' and year(tgl_jual) = '$_GET[tahun]' and pembeli.id = " . $json[$i]['pembeli_id'] . " and barang_gudang.id= " . $json[$i]['barang_id'] . ""));
                        echo $feb['jumlah'];
                        ?>
                    </td>
                    <td align="center">
                        <?php
                        $mar = mysqli_fetch_array(mysqli_query($koneksi, "SELECT CASE WHEN sum(barang_dijual_qty.qty_jual) IS NULL THEN '-' ELSE sum(barang_dijual_qty.qty_jual) END as jumlah from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '3' and year(tgl_jual) = '$_GET[tahun]' and pembeli.id = " . $json[$i]['pembeli_id'] . " and barang_gudang.id= " . $json[$i]['barang_id'] . ""));
                        echo $mar['jumlah'];
                        ?>
                    </td>
                    <td align="center">
                        <?php
                        $apr = mysqli_fetch_array(mysqli_query($koneksi, "SELECT CASE WHEN sum(barang_dijual_qty.qty_jual) IS NULL THEN '-' ELSE sum(barang_dijual_qty.qty_jual) END as jumlah from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '4' and year(tgl_jual) = '$_GET[tahun]' and pembeli.id = " . $json[$i]['pembeli_id'] . " and barang_gudang.id= " . $json[$i]['barang_id'] . ""));
                        echo $apr['jumlah'];
                        ?>
                    </td>
                    <td align="center">
                        <?php
                        $mei = mysqli_fetch_array(mysqli_query($koneksi, "SELECT CASE WHEN sum(barang_dijual_qty.qty_jual) IS NULL THEN '-' ELSE sum(barang_dijual_qty.qty_jual) END as jumlah from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '5' and year(tgl_jual) = '$_GET[tahun]' and pembeli.id = " . $json[$i]['pembeli_id'] . " and barang_gudang.id= " . $json[$i]['barang_id'] . ""));
                        echo $mei['jumlah'];
                        ?>
                    </td>
                    <td align="center">
                        <?php
                        $jun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT CASE WHEN sum(barang_dijual_qty.qty_jual) IS NULL THEN '-' ELSE sum(barang_dijual_qty.qty_jual) END as jumlah from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '6' and year(tgl_jual) = '$_GET[tahun]' and pembeli.id = " . $json[$i]['pembeli_id'] . " and barang_gudang.id= " . $json[$i]['barang_id'] . ""));
                        echo $jun['jumlah'];
                        ?>
                    </td>
                    <td align="center">
                        <?php
                        $jul = mysqli_fetch_array(mysqli_query($koneksi, "SELECT CASE WHEN sum(barang_dijual_qty.qty_jual) IS NULL THEN '-' ELSE sum(barang_dijual_qty.qty_jual) END as jumlah from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '7' and year(tgl_jual) = '$_GET[tahun]' and pembeli.id = " . $json[$i]['pembeli_id'] . " and barang_gudang.id= " . $json[$i]['barang_id'] . ""));
                        echo $jul['jumlah'];
                        ?>
                    </td>
                    <td align="center">
                        <?php
                        $agu = mysqli_fetch_array(mysqli_query($koneksi, "SELECT CASE WHEN sum(barang_dijual_qty.qty_jual) IS NULL THEN '-' ELSE sum(barang_dijual_qty.qty_jual) END as jumlah from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '8' and year(tgl_jual) = '$_GET[tahun]' and pembeli.id = " . $json[$i]['pembeli_id'] . " and barang_gudang.id= " . $json[$i]['barang_id'] . ""));
                        echo $agu['jumlah'];
                        ?>
                    </td>
                    <td align="center">
                        <?php
                        $sep = mysqli_fetch_array(mysqli_query($koneksi, "SELECT CASE WHEN sum(barang_dijual_qty.qty_jual) IS NULL THEN '-' ELSE sum(barang_dijual_qty.qty_jual) END as jumlah from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '9' and year(tgl_jual) = '$_GET[tahun]' and pembeli.id = " . $json[$i]['pembeli_id'] . " and barang_gudang.id= " . $json[$i]['barang_id'] . ""));
                        echo $sep['jumlah'];
                        ?>
                    </td>
                    <td align="center">
                        <?php
                        $okt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT CASE WHEN sum(barang_dijual_qty.qty_jual) IS NULL THEN '-' ELSE sum(barang_dijual_qty.qty_jual) END as jumlah from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '10' and year(tgl_jual) = '$_GET[tahun]' and pembeli.id = " . $json[$i]['pembeli_id'] . " and barang_gudang.id= " . $json[$i]['barang_id'] . ""));
                        echo $okt['jumlah'];
                        ?>
                    </td>
                    <td align="center">
                        <?php
                        $nov = mysqli_fetch_array(mysqli_query($koneksi, "SELECT CASE WHEN sum(barang_dijual_qty.qty_jual) IS NULL THEN '-' ELSE sum(barang_dijual_qty.qty_jual) END as jumlah from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '11' and year(tgl_jual) = '$_GET[tahun]' and pembeli.id = " . $json[$i]['pembeli_id'] . " and barang_gudang.id= " . $json[$i]['barang_id'] . ""));
                        echo $nov['jumlah'];
                        ?>
                    </td>
                    <td align="center">
                        <?php
                        $des = mysqli_fetch_array(mysqli_query($koneksi, "SELECT CASE WHEN sum(barang_dijual_qty.qty_jual) IS NULL THEN '-' ELSE sum(barang_dijual_qty.qty_jual) END as jumlah from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '12' and year(tgl_jual) = '$_GET[tahun]' and pembeli.id = " . $json[$i]['pembeli_id'] . " and barang_gudang.id= " . $json[$i]['barang_id'] . ""));
                        echo $des['jumlah'];
                        ?>
                    </td>
                </tr>
            <?php } ?>
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