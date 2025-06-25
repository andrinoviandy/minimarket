<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
?>
<div class="table-responsive no-padding">
    <table width="100%" id="example1" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th class="text-nowrap">No Pembayaran</th>
                <th class="text-nowrap">Tanggal Pembayaran</th>
                <th>Nominal</th>
                <th class="text-nowrap">Deskripsi</th>
            </tr>
        </thead>
        <?php
        $q = mysqli_query($koneksi, "select * from piutang a where a.penjualan_id=" . $_GET['id'] . "");
        $nn = 0;
        while ($d1 = mysqli_fetch_array($q)) {
            $nn++;
        ?>
            <tr>
                <td><?php echo $nn; ?></td>
                <td>
                    <?php echo $d1['no_pembayaran']; ?>
                </td>
                <td><?php echo date("d/m/Y", strtotime($d1['tgl_pembayaran'])); ?></td>
                <td><?php echo number_format($d1['nominal_pembayaran'], 0, ',', '.'); ?></td>
                <td><?php echo $d1['deskripsi']; ?></td>
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