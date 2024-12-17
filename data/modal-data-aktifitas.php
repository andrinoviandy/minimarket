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
                <th>Waktu</th>
                <th>Aktifitas</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $q2 = mysqli_query($koneksi, "select *,riwayat_aktifitas.id as idd from riwayat_aktifitas where riwayat_admin_id = " . $_GET['id'] . "");

            $nn = 0;
            while ($d1 = mysqli_fetch_array($q2)) {
                $nn++;
            ?>
                <tr>
                    <td><?php echo $nn; ?></td>
                    <td><?php echo date("d-m-Y H:i:s", strtotime($d1['waktu'])); ?></td>
                    <td>
                        <?php echo $d1['aktifitas']; ?>
                    </td>
                    <td><?php echo $d1['keterangan']; ?></td>
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