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
                <th>No PO</th>
                <th>No SJ</th>
                <th>No SPI</th>
                <th>Nama Barang</th>
                <th>Tipe Barang</th>
                <th>No Seri</th>
                <th>Teknisi</th>
            </tr>
        </thead>
        <?php
        $q = mysqli_query($koneksi, "select * from tb_laporan_kerusakan_cs,tb_laporan_kerusakan_cs_detail,tb_laporan_kerusakan_detail,alat_pelatihan,alat_uji_detail,barang_teknisi_detail,barang_dikirim_detail,barang_gudang_detail,barang_gudang,tb_teknisi, barang_dikirim, barang_teknisi where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and alat_uji_detail.id=alat_pelatihan.alat_uji_detail_id and alat_pelatihan.id=tb_laporan_kerusakan_detail.alat_pelatihan_id and tb_laporan_kerusakan_cs.id=tb_laporan_kerusakan_cs_detail.tb_laporan_kerusakan_cs_id and tb_laporan_kerusakan_cs_detail.id=tb_laporan_kerusakan_detail.tb_laporan_kerusakan_cs_detail_id and tb_teknisi.id=tb_laporan_kerusakan_detail.teknisi_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and tb_laporan_kerusakan_cs.id=" . $_GET['id'] . "");
        $n = 0;
        while ($d1 = mysqli_fetch_array($q)) {
            $n++;
        ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo $d1['no_po_jual']; ?></td>
                <td><?php echo $d1['no_pengiriman']; ?></td>
                <td><?php echo $d1['no_spk']; ?></td>
                <td><?php echo $d1['nama_brg']; ?></td>
                <td><?php echo $d1['tipe_brg']; ?></td>
                <td><?php echo $d1['no_seri_brg']; ?></td>
                <td><?php echo $d1['nama_teknisi']; ?></td>
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