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
                <th><strong>Nama Produk</strong></th>
                <th>Kategori</th>
                <th><strong>Qty</strong></th>
                <th><strong>Harga Satuan</strong></th>
                <th>Diskon</th>
                <th><strong>Total</strong></th>
            </tr>
        </thead>
        <?php
        $q = mysqli_query($koneksi, "select a.*,a.id as idd, c.kategori, b.* from pembelian_detail a left join produk b on b.id = a.produk_id left join kategori_produk c on c.id = b.kategori_produk_id where a.pembelian_id=" . $_GET['id'] . "");
        $no = 0;
        while ($d = mysqli_fetch_array($q)) {
            $no++;
        ?>
            <tr>
                <td><?php echo $d['nama_produk']; ?></td>
                <td><?php echo $d['kategori']; ?></td>
                <td><?php echo $d['qty']; ?></td>
                <td><?php echo "Rp".number_format($d['harga_beli'], 0, ',', ','); ?></td>
                <td><?php echo $d['diskon'] . " %"; ?></td>
                <td><?php echo "Rp".number_format($d['total_harga'], 0, ',', ',') . ".00"; ?></td>
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