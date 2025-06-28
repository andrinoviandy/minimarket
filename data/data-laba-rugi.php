<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<div class="box-footer">
    <div class="box-header with-border" style="background-color:#FC9">
        <h3 class="box-title"><strong>Pemasukan</strong></h3>
        <h3 class="box-title pull pull-right">
            <strong>
                <?php
                if (isset($_GET['tgl1']) && isset($_GET['tgl2']) && $_GET['tgl1'] != '' && $_GET['tgl2'] != '') {
                    $pemasukan1 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(total_harga) as total from penjualan where status_jual = 2 and tgl_jual between '$_GET[tgl1] 00:00:00' and '$_GET[tgl2] 23:59:59'"));
                    $piutang = mysqli_fetch_array(mysqli_query($koneksi, "select sum(nominal_pembayaran) as total from piutang where tgl_pembayaran between '$_GET[tgl1]' and '$_GET[tgl2]'"));
                    $biaya1 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(nominal) as total from biaya_lain where jenis_transaksi = 0 and tgl between '$_GET[tgl1]' and '$_GET[tgl2]'"));
                } else {
                    $pemasukan1 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(total_harga) as total from penjualan where status_jual = 2"));
                    $piutang = mysqli_fetch_array(mysqli_query($koneksi, "select sum(nominal_pembayaran) as total from piutang"));
                    $biaya1 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(nominal) as total from biaya_lain where jenis_transaksi = 0"));
                }
                echo number_format($pemasukan1['total'] + $biaya1['total'] + $piutang['total'], 2, ',', '.')
                ?>
            </strong>
        </h3>
    </div>
    <div class="box-body">
        <ul class="list-group list-group-unbordered">
            <?php
            //$q_coa4 = mysqli_query($koneksi, "select * from coa_sub where coa_id=4");
            //while ($d_coa = mysqli_fetch_array($q_coa4)) {
            ?>
            <li class="list-group-item">
                Pendapatan Bersih Dari Penjualan (Sudah Dikurangi Diskon)
                <font class="pull-right">
                    <?php
                    echo number_format($pemasukan1['total'] + $piutang['total'], 2, ',', '.');
                    ?>
                </font>
            </li>
            <li class="list-group-item">
                Pendapatan Lain - Lain
                <font class="pull-right">
                    <?php
                    echo number_format($biaya1['total'], 2, ',', '.');
                    ?>
                </font>
            </li>
            <?php //} 
            ?>
        </ul>
    </div>
    <div class="box-header with-border" style="background-color:#FC9">
        <h3 class="box-title"><strong>Dikurangi Pengeluaran</strong></h3>
        <h3 class="box-title pull pull-right">
            <strong><?php
                    if (isset($_GET['tgl1']) && isset($_GET['tgl2']) && $_GET['tgl1'] != '' && $_GET['tgl2'] != '') {
                        $biaya2 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(nominal) as total from biaya_lain where jenis_transaksi = 1 and tgl between '$_GET[tgl1]' and '$_GET[tgl2]'"));
                    } else {
                        $biaya2 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(nominal) as total from biaya_lain where jenis_transaksi = 1"));
                    }
                    echo number_format($biaya2['total'], 2, ',', '.');
                    ?>
            </strong>
        </h3>
    </div>
    <div class="box-body">
        <ul class="list-group list-group-unbordered">
            <?php
            // $q_coa5 = mysqli_query($koneksi, "select * from coa_sub where coa_id=5");
            // while ($d_coa = mysqli_fetch_array($q_coa5)) {
            ?>
            <li class="list-group-item">
                Beban Operasional
                <font class="pull-right">
                    <?php
                    if (isset($_GET['tgl1']) && isset($_GET['tgl2']) && $_GET['tgl1'] != '' && $_GET['tgl2'] != '') {
                        $biaya2_1 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(nominal) as total from biaya_lain where kategori_biaya_id IN (2) and tgl between '$_GET[tgl1]' and '$_GET[tgl2]'"));
                    } else {
                        $biaya2_1 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(nominal) as total from biaya_lain where kategori_biaya_id IN (2)"));
                    }
                    echo number_format($biaya2_1['total'], 2, ',', '.');
                    ?>
                </font>
            </li>
            <li class="list-group-item">
                Beban Lain-Lain
                <font class="pull-right">
                    <?php
                    if (isset($_GET['tgl1']) && isset($_GET['tgl2']) && $_GET['tgl1'] != '' && $_GET['tgl2'] != '') {
                        $biaya2_2 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(nominal) as total from biaya_lain where kategori_biaya_id IN (3) and tgl between '$_GET[tgl1]' and '$_GET[tgl2]'"));
                    } else {
                        $biaya2_2 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(nominal) as total from biaya_lain where kategori_biaya_id IN (3)"));
                    }
                    echo number_format($biaya2_2['total'], 2, ',', '.');
                    ?>
                </font>
            </li>
            <?php //} 
            ?>
        </ul>
    </div>
    <div class="box-header with-border" style="background-color:#FC9">
        <h3 class="box-title"><strong>
                Laba Rugi</strong></h3>
        <h3 class="box-title pull pull-right">
            <strong><?php
                    echo number_format($pemasukan1['total'] + $piutang['total'] + $biaya1['total'] - $biaya2['total'], 2, ',', '.');
                    ?>
            </strong>
        </h3>
    </div>
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