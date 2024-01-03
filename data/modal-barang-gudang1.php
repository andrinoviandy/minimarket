<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
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
                <th></th>
            </tr>
        </thead>
        <?php
        $q = mysqli_query($koneksi, "select * from barang_pesan,barang_pesan_detail,barang_gudang where barang_gudang.id=barang_pesan_detail.barang_gudang_id and barang_pesan.id=barang_pesan_detail.barang_pesan_id and barang_pesan_detail.barang_pesan_id=" . $_GET['id'] . "");
        $n = 0;
        while ($d1 = mysqli_fetch_array($q)) {
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
                <td><?php echo $d1['qty']; ?></td>
                <td>
                    <?php $stok_sudah_mutasi = mysqli_fetch_array(mysqli_query($koneksi, "select stok as stok_sudah from barang_gudang_po where no_po_gudang='" . $d1['no_po_pesan'] . "' and barang_gudang_id=" . $d1['barang_gudang_id'] . ""));
                    if ($d1['qty'] - $stok_sudah_mutasi['stok_sudah'] == 0) { ?>
                        <span class="fa fa-share"></span>
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