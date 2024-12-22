<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$q2 = mysqli_query($koneksi, "select barang_dikirim_detail.kategori_brg,(select nama_brg from barang_gudang where id = barang_gudang_set_id) as nama_set, (select tipe_brg from barang_gudang where id = barang_gudang_set_id) as tipe_set, (select nama_brg from barang_gudang where id = barang_gudang_satuan_id) as nama_satuan, (select tipe_brg from barang_gudang where id = barang_gudang_satuan_id) as tipe_satuan, nama_brg,no_seri_brg,status_spi,status_kerusakan,status_batal,tipe_brg from barang_gudang,barang_gudang_detail,barang_dikirim_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_id=" . $_GET['id'] . "");
?>
<div class="table-responsive no-padding">
    <table width="100%" id="example1" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Set</th>
                <th>Tipe Set</th>
                <th>Satuan</th>
                <th>Tipe Satuan</th>
                <th>Rincian</th>
                <th>Tipe Rincian</th>
                <th>No Seri</th>
                <th></th>
            </tr>
        </thead>
        <?php
        $n = 0;
        while ($d1 = mysqli_fetch_array($q2)) {
            $n++;
        ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo $d1['nama_set']; ?></td>
                <td><?php echo $d1['tipe_set']; ?></td>
                <td><?php echo $d1['kategori_brg'] !== 'Set' ? $d1['nama_satuan'] : '-'; ?></td>
                <td><?php echo $d1['kategori_brg'] !== 'Set' ? $d1['tipe_satuan'] : '-'; ?></td>
                <td>
                    <?php echo $d1['kategori_brg'] !== 'Satuan' ? $d1['nama_brg'] : '-'; ?>
                    <?php if ($d1['status_batal'] == 1) { ?>
                        <font class="pull pull-right" size="+1">Batal</font>
                    <?php } ?>
                </td>
                <td><?php echo $d1['kategori_brg'] !== 'Satuan' ? $d1['tipe_brg'] : '-'; ?></td>
                <td><?php echo $d1['no_seri_brg']; ?></td>
                <td>
                    <font class="pull pull-right" size="+2">
                        <?php
                        if ($d1['status_spi'] == 1) {
                            echo "(<span class='fa fa-sticky-note-o'></span>)";
                        }
                        ?>
                    </font>
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