<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<div class="table-reponsive">
    <table width="100%" id="example1" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th><strong>Nama Alkes</strong></th>
                <th>Merk</th>

                <th><strong>Tipe</strong></th>
                <th><strong>Qty</strong></th>
                <th><strong>Harga Satuan</strong></th>
                <th>Diskon</th>
                <th><strong>Total</strong></th>
                <!--<th>Aksi</th>
                          <th>#</th>-->
            </tr>
        </thead>
        <?php
        $q = mysqli_query($koneksi, "select *,barang_pesan_detail.id as idd from barang_gudang,barang_pesan_detail,barang_pesan,mata_uang where barang_gudang.id=barang_pesan_detail.barang_gudang_id and barang_pesan.id=barang_pesan_detail.barang_pesan_id and mata_uang.id=barang_pesan_detail.mata_uang_id and barang_pesan.id=" . $_GET['id'] . "");
        $no = 0;
        while ($d = mysqli_fetch_array($q)) {
            $no++;
        ?>
            <tr>
                <td><?php echo $d['nama_brg']; ?></td>
                <td><?php echo $d['merk_brg']; ?></td>
                <td><?php echo $d['tipe_brg']; ?></td>
                <td><?php echo $d['qty']; ?></td>
                <td><?php echo $d['simbol'] . " " . number_format($d['harga_perunit'], 0, ',', ',') . ".00"; ?></td>
                <td><?php echo $d['diskon'] . " %"; ?></td>
                <td><?php echo $d['simbol'] . " " . number_format($d['harga_total'], 0, ',', ',') . ".00"; ?></td>
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