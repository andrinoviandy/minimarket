<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

</head>

<body>
    <table width="100%" id="example1" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th valign="bottom">No</th>
                <th valign="bottom"><strong>Nama Alkes</strong></th>
                <td align="center" valign="bottom"><strong>Tipe
                    </strong>
                <td align="center" valign="bottom"><strong>Merk
                    </strong>
                <td align="center" valign="bottom"><strong>Qty</strong>
                <td align="center" valign="bottom"><strong>Mata Uang
                    </strong>
                <td align="center" valign="bottom"><strong>Harga Per Unit </strong>
                <td align="center" valign="bottom"><strong>Diskon (%)</strong>
                <td align="center" valign="bottom"><strong>Total Harga
                    </strong>
                <td align="center" valign="bottom"><strong>Catatan Spek</strong>
                <td align="center" valign="bottom"><strong>Aksi</strong>
            </tr>
        </thead>
        <?php
        $no = 0;
        $q_akse = mysqli_query($koneksi, "select *,barang_pesan_hash.id as idd,barang_gudang.id as id_gudang from barang_pesan_hash,barang_gudang,mata_uang where barang_gudang.id=barang_pesan_hash.barang_gudang_id and mata_uang.id=barang_pesan_hash.mata_uang_id and akun_id=" . $_SESSION['id'] . "");
        $jm = mysqli_num_rows($q_akse);
        if ($jm != 0) {
            while ($data_akse = mysqli_fetch_array($q_akse)) {
                $no++;
        ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $data_akse['nama_brg']; ?>
                    </td>
                    <td align="center"><?php echo $data_akse['tipe_brg']; ?></td>
                    <td align="center"><?php echo $data_akse['merk_brg']; ?></td>
                    <td align="center"><?php echo $data_akse['qty']; ?></td>
                    <td align="center"><?php echo $data_akse['jenis_mu']; ?></td>
                    <td align="center"><?php echo $data_akse['simbol'] . " " . number_format($data_akse['harga_perunit'], 2, ',', '.'); ?></td>
                    <td align="center"><?php
                                        if ($data_akse['diskon'] != 0) {
                                            echo $data_akse['diskon'] . " %";
                                        } else {
                                            echo "-";
                                        } ?></td>
                    <td align="center"><?php echo $data_akse['simbol'] . " " . number_format($data_akse['harga_total'], 2, ',', '.'); ?></td>
                    <td align="center"><?php echo $data_akse['catatan_spek']; ?></td>
                    <td align="center">
                        <button class="btn btn-xs btn-danger" onclick="hapus('<?php echo $data_akse['idd']; ?>')">
                            <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                        </button>
                        <!--
                        <br />
                        <a href="index.php?page=simpan_tambah_aksesoris_pesan_sudah_ada&id=<?php echo $data_akse['id_gudang']; ?>"><small data-toggle="tooltip" title="Kelola Aksesoris" class="label bg-green"><span class="fa fa-cogs"></span>&nbsp Akse</small></a>
                                    -->
                    </td>
                </tr>
        <?php }
        } else {
            echo "<tr><td colspan='11' align='center'>Tidak Ada Data</td></tr>";
        } ?>
        <tr>
            <td colspan="8" align="right" valign="bottom"><strong>Total Price =</strong></td>
            <td align="center">
                <?php
                $total = mysqli_fetch_array(mysqli_query($koneksi, "select sum(harga_total) as total from barang_pesan_hash"));
                //$total = mysqli_query($koneksi, "select * from barang_pesan_detail where barang_pesan_id=$id");
                //echo " ".number_format($total_akse2+$total['total'],0,',',',').".00";
                ?>
                <input name="total_price" class="form-control" type="text" required="required" placeholder="" size="10" value="<?php echo number_format($total['total'], 2, ',', ''); ?>" />
            </td>
            <td align="center"></td>
            <td align="center"></td>
        </tr>
        <tr>
            <td colspan="8" align="right" valign="bottom"><strong>Total Price + PPN(<?php echo $_SESSION['ppn']; ?>) =</strong></td>
            <td align="center">
                <input name="total_price_ppn" id="total_price_ppn" class="form-control" type="text" required="required" placeholder="" size="10" value="<?php echo number_format(($total['total']) + (($total['total']) * floatval($_SESSION['ppn']) / 100), 2, ',', ''); ?>" />
            </td>
            <td align="center"></td>
            <td align="center"></td>
        </tr>
        <tr>
            <td colspan="8" align="right" valign="bottom"><strong>Freight Cost by Air to JAKARTA =</strong></td>
            <td align="center" valign="top"><input name="cost_byair" id="cost_byair" class="form-control" type="text" onkeyup="sum_total_keseluruhan();" placeholder="" size="10" value="0" /></td>
            <td align="center"></td>
            <td align="center"></td>
        </tr>
        <tr>
            <td colspan="8" align="right" valign="bottom"><strong>Total Keseluruhan =</strong></td>
            <td align="center" valign="top"><input id="cost_cf" name="cost_cf" class="form-control" type="text" placeholder="" size="10" value="<?php echo number_format(($total['total']) + (($total['total']) * floatval($_SESSION['ppn']) / 100), 2, ',', ''); ?>" /></td>
            <td align="center"></td>
            <td align="center"></td>
        </tr>
    </table>
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
</body>

</html>