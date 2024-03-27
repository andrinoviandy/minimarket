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
                <th width="">No</th>
                <th width=""><strong>Nama Barang</strong></th>
                <th width=""><strong>Tipe</strong></th>
                <th width="">Harga Beli</th>
                <th width="">Harga Jual</th>
                <th width="">Qty</th>
                <th width="">Sisa Stok</th>
                <th width=""><strong>Aksi</strong></th>
            </tr>
        </thead>
        <?php
        $q2 = mysqli_query($koneksi, "select *,barang_gudang_detail_set.id as idd from barang_gudang_detail_set, barang_gudang where barang_gudang.id=barang_gudang_detail_set.barang_gudang_id and barang_gudang_set_id=" . $_GET['id'] . " order by nama_brg ASC");
        $no = 0;
        while ($d = mysqli_fetch_array($q2)) {
            $no++;
        ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $d['nama_brg']; ?></td>
                <td><?php echo $d['tipe_brg']; ?></td>
                <td><?php echo number_format($d['harga_beli'], 0, '.', ','); ?></td>
                <td><?php echo number_format($d['harga_satuan'], 0, '.', ','); ?></td>
                <td><?php echo $d['qty']; ?></td>
                <td><?php 
                $stok_total = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_gudang_detail where status_kirim=0 and status_kerusakan=0 and status_kembali_ke_gudang=0 and barang_gudang_id=" . $d['barang_gudang_id'] . ""));
                $stok_po1 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty_jual) as stok_po from barang_dijual_qty where barang_gudang_id=" . $d['barang_gudang_id'] . ""));
                $stok_po11 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(jml_total) as stok_po from barang_dijual_qty_detail where barang_gudang_id=" . $d['barang_gudang_id'] . ""));
                $stok_po2 = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_dijual_qty.barang_gudang_id=" . $d['barang_gudang_id'] . ""));
                $stok_po = $stok_po1['stok_po'] + $stok_po11['stok_po'] - $stok_po2['jml'];
                echo $stok_total['jml'] - $stok_po; ?></td>
                <td>
                    <?php //if (isset($_SESSION['user_administrator']) or isset($_SESSION['admin_gudang']) ) { 
                    ?>
                    <!-- <a href="index.php?page=ubah_barang_set&id=<?php echo $_GET['id']; ?>&id_hapus=<?php echo $d['idd']; ?>" onclick="return confirm('Yakin Akan Menghapus Item Ini ?')"> -->
                    <button class="btn btn-xs btn-danger" onclick="hapus('<?php echo $d['idd']; ?>')">
                    <span data-toggle="tooltip" title="Hapus" class="fa fa-trash"></span></button>&nbsp;
                    <?php //} 
                    ?>
                    <!--<a href="index.php?page=ubah_barang_set&id=<?php echo $_GET['id']; ?>&id_ubah=<?php echo $d['idd']; ?>"><span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span></a>&nbsp;-->
                    <!--&nbsp;
                        <a href="index.php?page=ubah_barang_masuk&id=<?php //echo $data['idd']; 
                                                                        ?>#openPilihan"><small data-toggle="tooltip" title="Jual Aksesoris" class="label bg-blue">Jual</small></a>-->
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