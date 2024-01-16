<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$q = mysqli_query($koneksi, "select nama_brg,no_seri_brg,status_kembali,tipe_brg from barang_gudang,barang_gudang_detail,barang_demo_kirim_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_demo_kirim_id=" . $_GET['id'] . "");
?>
<div class="table-responsive no-padding">
    <table width="100%" id="example1" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Tipe Barang</th>
                <th>No Seri</th>
                <th></th>
            </tr>
        </thead>
        <?php
        $n = 0;
        while ($d1 = mysqli_fetch_array($q)) {
            $n++;
        ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td>
                    <?php echo $d1['nama_brg']; ?>
                    <?php if ($d1['status_batal'] == 1) { ?>
                        <font class="pull pull-right" size="+1">Batal</font>
                    <?php } ?>
                </td>
                <td><?php echo $d1['tipe_brg']; ?></td>
                <td><?php echo $d1['no_seri_brg']; ?></td>
                <td>
                    <?php if ($d1['status_kembali'] == 1) { ?>
                        <small class="label bg-success pull pull-right">Sudah Kembali</small>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

<!-- DataTables -->
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