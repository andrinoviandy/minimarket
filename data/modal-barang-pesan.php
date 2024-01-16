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
                <th>Nama Barang</th>
                <th>Tipe Barang</th>
                <th>Kuantitas</th>
            </tr>
        </thead>
        <?php
        $q = mysqli_query($koneksi, "select nama_brg,tipe_brg,qty,status_ke_stok from barang_pesan_detail,barang_gudang where barang_gudang.id=barang_pesan_detail.barang_gudang_id and barang_pesan_detail.barang_pesan_id=" . $_GET['id'] . "");

        $nn = 0;
        while ($d1 = mysqli_fetch_array($q)) {
            $nn++;
        ?>
            <tr>
                <td><?php echo $nn; ?></td>
                <td>
                    <?php echo $d1['nama_brg']; ?>
                </td>
                <td><?php echo $d1['tipe_brg']; ?></td>
                <td><?php echo $d1['qty']; ?>
                    <?php if ($d1['status_ke_stok'] == 1) { ?>
                        <font class="pull pull-right" size="+1"><span class="fa fa-share"></span></font>
                    <?php } ?>
                </td>
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