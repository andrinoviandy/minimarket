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
                <th>Nama Produk</th>
                <th>Kategori Produk</th>
                <th>Kuantitas</th>
            </tr>
        </thead>
        <?php
        $q = mysqli_query($koneksi, "select b.nama_produk, c.kategori, a.qty, a.status_ke_stok from pembelian_detail a left join produk b on b.id = a.produk_id left join kategori_produk c on c.id = b.kategori_produk_id where a.pembelian_id=" . $_GET['id'] . "");
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
                <td><?php echo $d1['qty']; ?></td>
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