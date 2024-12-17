<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<div class="table-responsive no-padding">
    <table width="100%" id="example1" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Nama Barang</th>
                <th>Tipe Barang</th>
                <th>Harga Jual</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <?php
        $q2 = mysqli_query($koneksi, "select *,barang_dijual_qty_detail.id as id_det_jual from barang_dijual_qty_detail,barang_gudang where barang_gudang.id=barang_dijual_qty_detail.barang_gudang_id and barang_dijual_qty_id=" . $_GET['id_qty'] . "");

        $nn = 0;
        while ($d1 = mysqli_fetch_array($q2)) {
            $nn++;
        ?>
            <tr>
                <td><?php echo $nn; ?></td>
                <td><?php echo $d1['kategori_brg']; ?></td>
                <td>
                    <?php echo $d1['nama_brg']; ?>
                </td>
                <td>
                    <?php echo $d1['tipe_brg']; ?>
                </td>
                <td><?php echo $d1['harga_jual_saat_itu']; ?></td>
                <td><?php echo $d1['jml_total']; ?></td>
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