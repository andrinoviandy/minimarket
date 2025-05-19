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
                <th class="text-nowrap">Nama Produk</th>
                <th class="text-nowrap">Kategori Produk</th>
                <th>Kuantitas</th>
                <th class="text-nowrap">Harga Satuan</th>
                <th class="text-nowrap">Total Harga</th>
            </tr>
        </thead>
        <?php
        $q = mysqli_query($koneksi, "select b.nama_produk, c.kategori, a.qty_jual, a.harga_jual_saat_itu as harga_satuan, sum(a.harga_jual_saat_itu*a.qty_jual) as total_harga from penjualan_qty a left join produk b on b.id = a.produk_id left join kategori_produk c on c.id = b.kategori_produk_id where a.penjualan_id=" . $_GET['id'] . "");
        $nn = 0;
        while ($d1 = mysqli_fetch_array($q)) {
            $nn++;
        ?>
            <tr>
                <td><?php echo $nn; ?></td>
                <td>
                    <?php echo $d1['nama_produk']; ?>
                </td>
                <td><?php echo $d1['kategori']; ?></td>
                <td><?php echo $d1['qty_jual']; ?></td>
                <td><?php echo number_format($d1['harga_satuan'], 0, ',', '.'); ?></td>
                <td><?php echo number_format($d1['total_harga'], 0, ',', '.'); ?></td>
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