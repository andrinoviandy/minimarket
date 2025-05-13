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
                <th valign="bottom"><strong>Nama Produk</strong></th>
                <td align="center" valign="bottom"><strong>Kategori</strong></td>
                <td align="center" valign="bottom"><strong>Harga Beli Satuan</strong></td>
                <td align="center" valign="bottom"><strong>Kuantitas</strong></td>
                <td align="center" valign="bottom"><strong>Diskon (%)</strong></td>
                <td align="center" valign="bottom"><strong>Sub Total</td>
                <td align="center" valign="bottom"><strong>Aksi</strong></td>
            </tr>
        </thead>
        <?php
        $no = 0;
        $q_akse = mysqli_query($koneksi, "select *,a.id as idd, b.id as id_produk from pembelian_detail_temp a left join produk b on b.id = a.produk_id left join kategori_produk c on c.id = b.kategori_produk_id where a.akun_id=" . $_SESSION['id'] . "");
        $jm = mysqli_num_rows($q_akse);
        if ($jm != 0) {
            while ($data_akse = mysqli_fetch_array($q_akse)) {
                $no++;
        ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $data_akse['nama_produk']; ?>
                    </td>
                    <td align="center"><?php echo $data_akse['kategori']; ?></td>
                    <td align="center"><?php echo "Rp" . number_format($data_akse['harga_beli'], 0, ',', '.'); ?></td>
                    <td align="center"><?php echo $data_akse['qty']; ?></td>
                    <td align="center"><?php echo $data_akse['diskon'] . " %"; ?></td>
                    <td align="center"><?php echo "Rp" . number_format($data_akse['total_harga'], 0, ',', '.'); ?></td>
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
            echo "<tr><td colspan='8' align='center'>Tidak Ada Data</td></tr>";
        } ?>
        <tr>
            <td colspan="6" align="right" valign="bottom"><strong>Total Harga = </strong></td>
            <td align="center">
                <?php
                $total = mysqli_fetch_array(mysqli_query($koneksi, "select sum(total_harga) as total from pembelian_detail_temp where akun_id = ".$_SESSION['id'].""));
                ?>
                <?php echo "Rp".number_format($total['total'], 0, ',', '.'); ?>
            </td>
            <td align="center"></td>
            <td align="center"></td>
        </tr>
        <tr>
            <td colspan="6" align="right" valign="bottom"><strong>Total Price + PPN(<?php echo $_SESSION['ppn']; ?>) =</strong></td>
            <td align="center"><?php echo "Rp".number_format(($total['total']) + (($total['total']) * floatval($_SESSION['ppn']) / 100), 0, ',', '.'); ?>
            <input name="total_harga_ppn" id="total_harga_ppn" class="form-control" type="hidden" required="required" placeholder="" size="10" value="<?php echo number_format(($total['total']) + (($total['total']) * floatval($_SESSION['ppn']) / 100), 2, ',', ''); ?>" />
            </td>
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