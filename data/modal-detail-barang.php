<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$q2 = mysqli_query($koneksi, "select *,barang_dijual_qty.id as id_det_jual from barang_dijual_qty,barang_dijual,barang_gudang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual_qty.barang_dijual_id=" . $_GET['id'] . "");
?>
<div class="table-responsive no-padding">
    <table width="100%" id="example1" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Nama Barang</th>
                <th>Tipe Barang</th>
                <th>Kuantitas</th>
            </tr>
        </thead>
        <?php
        $n = 0;
        while ($d1 = mysqli_fetch_array($q2)) {
            $n++;
        ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo $d1['kategori_brg']; ?></td>
                <td>
                    <?php echo $d1['nama_brg']; ?>
                    <?php if ($d1['status_kembali_ke_gudang'] == 1) { ?>
                        <br>
                        <font class="pull pull-right" size="+1">Kembali Ke Gudang</font>
                    <?php } ?>
                </td>
                <td><?php echo $d1['tipe_brg']; ?></td>
                <td><?php echo $d1['qty_jual']; ?></td>
            </tr>
        <?php } ?>
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