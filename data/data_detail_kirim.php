<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
?>
<div class="table-responsive no-padding">
    <table width="100%" id="example1" class="table table-bordered table-hover">
        <tr class="bg-green">
            <td style="vertical-align: middle; font-weight: bold;" valign="middle" rowspan="2">Kategori Barang</td>
            <td style="vertical-align: middle; font-weight: bold;" rowspan="2">Nama Barang</td>
            <td style="vertical-align: middle; font-weight: bold;" rowspan="2">Tipe Barang</td>
            <td style="vertical-align: middle; font-weight: bold;" rowspan="2">Qty Jual</td>
            <td style="vertical-align: middle; font-weight: bold;" rowspan="1" colspan="3" align="center">Jumlah No Seri</td>
        </tr>
        <tr class="bg-green">
            <td style="vertical-align: middle; font-weight: bold;">Harus Dikirim</td>
            <td style="vertical-align: middle; font-weight: bold;">Sudah Dikirim</td>
            <td style="vertical-align: middle; font-weight: bold;">Akan Dikirim</td>
        </tr>
        <?php
        $qty = mysqli_query($koneksi, "select *,barang_dijual_qty.id as id_qty from barang_dijual_qty,barang_gudang where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual_id=" . $_GET['id'] . " order by nama_brg ASC");
        while ($d_qty = mysqli_fetch_array($qty)) {
            $sel = mysqli_fetch_array(mysqli_query($koneksi, "select (CASE WHEN sum(jml_satuan) IS NULL THEN $d_qty[qty_jual] ELSE sum(jml_satuan) END) as jml from barang_dijual_qty_detail where barang_dijual_qty_id=" . $d_qty['id_qty'] . ""));
            $sel1 = mysqli_fetch_array(mysqli_query($koneksi, "select (CASE WHEN sum(jml_total) IS NULL THEN $d_qty[qty_jual] ELSE sum(jml_total) END) as jml from barang_dijual_qty_detail where barang_dijual_qty_id=" . $d_qty['id_qty'] . ""));
            $sel2 = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_dikirim_detail where barang_dijual_qty_id=" . $d_qty['id_qty'] . ""));
            $sel3 = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_dikirim_detail_hash where barang_dijual_qty_id=" . $d_qty['id_qty'] . ""));
            // if (($sel2['jml'] + $sel3['jml']) - $sel1['jml'] == 0) {
            //   $color2 = 'bg-success';
            // } else {
            //   $color2 = 'bg-danger';
            // }
        ?>
            <tr>
                <td><?php echo $d_qty['kategori_brg'] ?></td>
                <td><?php echo $d_qty['nama_brg'] ?></td>
                <td><?php echo $d_qty['tipe_brg'] ?></td>
                <td><?php echo $d_qty['qty_jual'] ?></td>
                <td>
                    <?php
                    if ($d_qty['kategori_brg'] == 'Aksesoris') {
                        echo $d_qty['qty_jual'];
                    } else if ($d_qty['kategori_brg'] == 'Satuan') {
                        echo $d_qty['qty_jual'] + $sel1['jml'];
                    } else if ($d_qty['kategori_brg'] == 'Set') {
                        echo $sel1['jml'];
                    }
                    ?>
                </td>
                <td><?php echo $sel2['jml'] ?></td>
                <td><?php echo $sel3['jml'] ?></td>
            </tr>
        <?php } ?>
</div>
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