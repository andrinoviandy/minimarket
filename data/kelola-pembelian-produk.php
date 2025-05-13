<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$query = mysqli_query($koneksi, "select a.*, b.*, b.id as id_supplier from pembelian a left join supplier b on b.id = a.supplier_id where a.id='" . $_GET['id'] . "'");
$data = mysqli_fetch_array($query);
?>
<div class="table-responsive no-padding">
    <table width="100%" id="example1" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th valign="bottom">No</th>
                <th valign="bottom"><strong>Nama Produk</strong></th>
                <td align="center" valign="bottom"><strong>Kategori
                    </strong></td>
                <td align="center" valign="bottom"><strong>Qty</strong></td>
                <td align="center" valign="bottom"><strong>Harga Beli /Satuan </strong> </td>
                <td align="center" valign="bottom"><strong>Diskon (%)</strong> </td>
                <td align="center" valign="bottom"><strong>Total Harga</strong></td>
                <td align="center" valign="bottom"><strong>Aksi</strong></td>
            </tr>
        </thead>

        <script type="text/javascript">
            <?php
            echo $jsArray;
            ?>

            function changeValue(id_akse) {
                document.getElementById('tipe_akse').value = dtBrg[id_akse].tipe_akse;
                document.getElementById('merk_akse').value = dtBrg[id_akse].merk_akse;

            };
        </script>
        <?php

        $no = 0;
        $q_akse = mysqli_query($koneksi, "select *,a.id as idd,b.id as id_gudang from pembelian_detail a left join produk b on b.id = a.produk_id left join kategori_produk c on c.id = b.kategori_produk_id where a.pembelian_id=$_GET[id]");
        $jm = mysqli_num_rows($q_akse);
        if ($jm != 0) {
            while ($data_akse = mysqli_fetch_array($q_akse)) {
                $no++;
        ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $data_akse['nama_produk']; ?>
                    </td>
                    <td align="center"><?php echo $data_akse['kategori']; ?></td>
                    <td align="center"><?php echo $data_akse['qty']; ?></td>
                    <td align="center"><?php echo number_format($data_akse['harga_beli'], 0, ',', '.'); ?></td>
                    <td align="center"><?php
                                        if ($data_akse['diskon'] != 0) {
                                            echo $data_akse['diskon'] . " %";
                                        } else {
                                            echo "0 %";
                                        } ?></td>
                    <td align="right"><?php echo number_format($data_akse['total_harga'], 0, ',', '.'); ?></td>
                    <td align="center">
                        <table>
                            <tr>
                                <td>
                                    <!-- <a href="#" data-toggle="modal" data-target="#modal-ubahbarang<?php echo $data_akse['idd']; ?>" class="btn btn-xs btn-info"> -->
                                    <a href="javascript:void()" onclick="modalUbah('<?php echo $data_akse['idd']; ?>','<?php echo $data_akse['qty']; ?>','<?php echo number_format($data_akse['harga_beli'], 0, ',', '.'); ?>','<?php echo $data_akse['diskon']; ?>')" class="btn btn-xs btn-info">
                                        <span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span></a>
                                </td>
                                <td width="5%"></td>
                                <td>
                                    <!-- <a href="index.php?page=tambah_po_alkes&id_hapus=<?php echo $data_akse['idd']; ?>&id=<?php echo $_GET['id']; ?>" onclick="return confirm('Yakin Akan Menghapus Item Ini ?')"> -->
                                    <a class="btn btn-xs btn-danger" onclick="hapusData('<?php echo $data_akse['idd']; ?>')">
                                        <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
        <?php }
        } else {
            echo "<tr><td colspan='8' align='center'>Tidak Ada Data</td></tr>";
        } ?>
        <!-- <form method="post"> -->
        <tr>
            <td colspan="6" align="right" valign="bottom"><strong>Total Harga = </strong></td>
            <td align="right">
                <input type="hidden" name="id_simpan" id="id_simpan" value="<?php echo $_GET['id'] ?>">
                <?php
                $total = mysqli_fetch_array(mysqli_query($koneksi, "select *,sum(total_harga) as total from pembelian_detail where pembelian_id=$_GET[id]"));
                echo number_format($total['total'], 0, ',', '.')
                //$total = mysqli_query($koneksi, "select * from barang_pesan_detail where barang_pesan_id=$id");
                //echo " ".number_format($total_akse2+$total['total'],0,',',',').".00";
                ?>
                <input name="total_price" id="total_price" class="form-control" type="hidden" required="required" placeholder="" size="10" value="<?php echo number_format($total['total'], 2, ',', ''); ?>" />
            </td>
            <td align="left">&nbsp;</td>

        </tr>
        <tr>
            <td colspan="6" align="right" valign="bottom"><strong>Total Price + PPN(<?php echo $data['ppn'] . "%"; ?>) =</strong></td>
            <td align="right">
                <?php echo number_format($total['total']+($data['ppn']/100*$total['total']), 0, ',', '.') ?>
            </td>
            <td align="left">&nbsp;</td>
        </tr>
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