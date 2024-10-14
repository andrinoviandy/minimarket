<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<div class="table-responsive" style="width:100%">
    <table width="100%" id="example1" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th><strong>Tanggal Masuk</strong></th>
                <th>Stok Mutasi</th>
                <td align="center"><strong>Aksi</strong></td>
            </tr>
        </thead>
        <?php
        $q22 = mysqli_query($koneksi, "select *,barang_gudang_po.id as idd from barang_gudang_po,barang_pesan where barang_pesan.no_po_pesan=barang_gudang_po.no_po_gudang and barang_pesan.id=" . $_GET['id'] . " and barang_gudang_id=" . $_GET['id_gudang'] . "");
        $no = 0;
        while ($d = mysqli_fetch_array($q22)) {
            $no++;
        ?>
            <tr>
                <td><?php echo date("d/m/Y", strtotime($d['tgl_po_gudang'])); ?></td>
                <td><?php echo $d['stok']; ?></td>
                <td align="center">
                    <!-- <a href="index.php?page=detail_mutasi&batal_mutasi=1&id=<?php //echo $_GET['id']; 
                                                                                    ?>&id_gudang=<?php //echo $_GET['id_gudang']; 
                                                                                                                        ?>&id_detail=<?php //echo $_GET['id_detail']; 
                                                                                                                                                                        ?>&stok=<?php //echo $d['stok']; 
                                                                                                                                                                                                                ?>&barang_gudang_po_id=<?php //echo $d['idd']; 
                                                                                                                                                                                                                                                                ?>" onclick="return confirm('Anda Yakin Ingin Membatalkan Mutasi Stok Ini ?')"><small data-toggle="tooltip" title="Batalkan Mutasi" class="label bg-red"><span class="fa fa-close"></span> Batalkan Mutasi</small></a> -->
                    <a href="javascript:void();" onclick="batalkanMutasi('<?php echo $_GET['id']; ?>','<?php echo $_GET['id_gudang']; ?>','<?php echo $_GET['id_detail']; ?>','<?php echo $d['stok']; ?>','<?php echo $d['idd']; ?>')"><small data-toggle="tooltip" title="Batalkan Mutasi" class="label bg-red"><span class="fa fa-close"></span> Batalkan Mutasi</small></a>
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