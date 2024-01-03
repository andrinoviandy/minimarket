<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
?>
<table width="100%" id="example1" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th valign="bottom">No</th>
            <th valign="bottom">Kategori</th>
            <th valign="bottom"><strong>Nama Alkes</strong></th>
            <td align="center" valign="bottom"><strong>No Seri</strong></td>
        </tr>
    </thead>
    <tbody>
        <?php
        $q = mysqli_query($koneksi, "select barang_gudang.kategori_brg,nama_brg,no_seri_brg from barang_gudang,barang_gudang_detail,barang_dikirim_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_id=" . $_GET['id'] . "");
        $no = 0;
        while ($d1 = mysqli_fetch_array($q)) {
            $no++;
        ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $d1['kategori_brg']; ?></td>
                <td><?php echo $d1['nama_brg']; ?>
                    <?php if ($d1['status_kembali_ke_gudang'] == 1) { ?>
                        <font class="pull pull-right" size="+1">Kembali Ke Gudang</font>
                    <?php } ?>
                    <font class="pull pull-right" size="+2">
                        <?php
                        if ($d1['status_spi'] == 1) {
                            echo "(<span class='fa fa-sticky-note-o'></span>)";
                        }
                        ?>
                    </font>
                </td>
                <td align="center"><?php echo $d1['no_seri_brg']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
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