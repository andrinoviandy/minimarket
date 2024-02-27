<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$query = mysqli_query($koneksi, "select *,principle.id as id_principle from barang_pesan,principle where principle.id=barang_pesan.principle_id and barang_pesan.id='" . $_GET['id'] . "'");
$data = mysqli_fetch_array($query);
?>
<div class="table-responsive no-padding">
    <table width="100%" id="example1" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th valign="bottom">No</th>
                <th valign="bottom"><strong>Nama Alkes</strong></th>
                <td align="center" valign="bottom"><strong>Tipe
                    </strong></td>
                <td align="center" valign="bottom"><strong>Merk
                    </strong></td>
                <td align="center" valign="bottom"><strong>Qty</strong></td>
                <td align="center" valign="bottom"><strong>Mata Uang
                    </strong></td>
                <td align="center" valign="bottom"><strong>Harga Per Unit </strong> </td>
                <td align="center" valign="bottom"><strong>Diskon (%)</strong> </td>
                <td align="center" valign="bottom"><strong>Total Harga
                    </strong>
                </td>
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
        $q_akse = mysqli_query($koneksi, "select *,barang_pesan_detail.id as idd,barang_gudang.id as id_gudang from barang_pesan_detail,barang_gudang,mata_uang where barang_gudang.id=barang_pesan_detail.barang_gudang_id and mata_uang.id=barang_pesan_detail.mata_uang_id and barang_pesan_detail.barang_pesan_id=$_GET[id]");
        $jm = mysqli_num_rows($q_akse);
        if ($jm != 0) {
            while ($data_akse = mysqli_fetch_array($q_akse)) {
                $no++;
        ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $data_akse['nama_brg']; ?>
                    </td>
                    <td align="center"><?php echo $data_akse['tipe_brg']; ?></td>
                    <td align="center"><?php echo $data_akse['merk_brg']; ?></td>
                    <td align="center"><?php echo $data_akse['qty']; ?></td>
                    <td align="center"><?php echo $data_akse['jenis_mu']; ?></td>
                    <td align="center"><?php echo number_format($data_akse['harga_perunit'], 2, ',', '.'); ?></td>
                    <td align="center"><?php
                                        if ($data_akse['diskon'] != 0) {
                                            echo $data_akse['diskon'] . " %";
                                        } else {
                                            echo "0 %";
                                        } ?></td>
                    <td align="center"><?php echo number_format($data_akse['harga_total'], 2, ',', '.'); ?></td>
                    <td align="center">
                        <!-- <a href="#" data-toggle="modal" data-target="#modal-ubahbarang<?php echo $data_akse['idd']; ?>"><span data-toggle="tooltip" title="Hapus" class="fa fa-edit"></span></a>&nbsp;&nbsp;<a href="index.php?page=tambah_po_alkes2&id_hapus=<?php echo $data_akse['idd']; ?>&id=<?php echo $_GET['id']; ?>" onclick="return confirm('Yakin Akan Menghapus Item Ini ?')"><span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a> -->
                        <!--&nbsp;&nbsp;&nbsp;<a href="index.php?page=simpan_tambah_aksesoris_pesan2&id=<?php echo $data_akse['id_gudang']; ?>"><small data-toggle="tooltip" title="Kelola Aksesoris" class="label bg-green"><span class="fa fa-cogs"></span>&nbsp Akse</small></a>-->
                        <table>
                            <tr>
                                <td>
                                    <!-- <a href="#" data-toggle="modal" data-target="#modal-ubahbarang<?php echo $data_akse['idd']; ?>" class="btn btn-xs btn-info"> -->
                                    <a href="javascript:void()" onclick="modalUbah('<?php echo $data_akse['idd']; ?>','<?php echo $data_akse['qty']; ?>','<?php echo number_format($data_akse['harga_perunit'], 0, ',', '.'); ?>','<?php echo $data_akse['diskon']; ?>')" class="btn btn-xs btn-info">
                                        <span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span></a>
                                </td>
                                <td width="5%"></td>
                                <td>
                                    <!-- <a href="index.php?page=tambah_po_alkes&id_hapus=<?php echo $data_akse['idd']; ?>&id=<?php echo $_GET['id']; ?>" onclick="return confirm('Yakin Akan Menghapus Item Ini ?')"> -->
                                    <a class="btn btn-xs btn-danger" onclick="hapusData('<?php echo $data_akse['idd']; ?>')">
                                        <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a>
                                </td>
                            </tr>
                            <!--&nbsp;&nbsp;&nbsp;<a href="index.php?page=simpan_tambah_aksesoris_pesan&id=<?php echo $data_akse['id_gudang']; ?>"><small data-toggle="tooltip" title="Kelola Aksesoris" class="label bg-green"><span class="fa fa-cogs"></span>&nbsp Akse</small></a>-->
                        </table>
                    </td>
                </tr>
                <?php /* ?>
                <div class="modal fade" id="modal-ubahbarang<?php echo $data_akse['idd']; ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" align="center">Ubah Barang</h4>
                            </div>
                            <form method="post">
                                <div class="modal-body">
                                    <input type="hidden" name="id_ubah" value="<?php echo $data_akse['idd']; ?>" />
                                    <label>Qty</label>
                                    <input name="qty2" id="qty<?php echo $data_akse['idd']; ?>" class="form-control" type="text" required placeholder="" value="<?php echo $data_akse['qty']; ?>" onkeyup="sum<?php echo $data_akse['idd']; ?>();" autofocus>
                                    <br />
                                    <label>Harga Per Unit</label>
                                    <input name="harga_perunit2" id="harga_perunit<?php echo $data_akse['idd']; ?>" class="form-control" type="text" required value="<?php echo $data_akse['harga_perunit']; ?>" onkeyup="sum<?php echo $data_akse['idd']; ?>();" placeholder="">
                                    <br />
                                    <label>Diskon</label>
                                    <input name="diskon2" id="diskon<?php echo $data_akse['idd']; ?>" class="form-control" type="text" required value="<?php echo $data_akse['diskon']; ?>" onkeyup="sum<?php echo $data_akse['idd']; ?>();" placeholder="">
                                    <br />
                                    <label>Total Harga</label>
                                    <input name="total_harga2" id="total_harga<?php echo $data_akse['idd']; ?>" class="form-control" type="text" readonly="readonly" required placeholder="" value="<?php echo $data_akse['harga_total']; ?>">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan</button>
                                    <script type="text/javascript">
                                        function sum<?php echo $data_akse['idd']; ?>() {
                                            var txtFirstNumberValue = document.getElementById('qty<?php echo $data_akse['idd']; ?>').value;
                                            var txtSecondNumberValue = document.getElementById('harga_perunit<?php echo $data_akse['idd']; ?>').value;
                                            var txtThirdNumberValue = document.getElementById('diskon<?php echo $data_akse['idd']; ?>').value;
                                            var result = parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue) - (parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue) * (parseFloat(txtThirdNumberValue) / 100));
                                            if (!isNaN(result)) {
                                                document.getElementById('total_harga<?php echo $data_akse['idd']; ?>').value = result;
                                            }
                                        }
                                    </script>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <?php */ ?>
        <?php }
        } else {
            echo "<tr><td colspan='11' align='center'>Tidak Ada Data</td></tr>";
        } ?>
        <!-- <form method="post"> -->
        <tr>
            <td colspan="8" align="right" valign="bottom"><strong>Total Price =</strong></td>
            <td align="left">
                <input type="hidden" name="id_simpan" id="id_simpan" value="<?php echo $_GET['id'] ?>">
                <?php
                $total = mysqli_fetch_array(mysqli_query($koneksi, "select *,sum(harga_total) as total from barang_pesan_detail where barang_pesan_id=$_GET[id]"));
                echo number_format($total['total'], 2, ',', '.')
                //$total = mysqli_query($koneksi, "select * from barang_pesan_detail where barang_pesan_id=$id");
                //echo " ".number_format($total_akse2+$total['total'],0,',',',').".00";
                ?>
                <input name="total_price" id="total_price" class="form-control" type="hidden" required="required" placeholder="" size="10" value="<?php echo number_format($total['total'], 2, ',', ''); ?>" />
            </td>
            <td align="left">&nbsp;</td>

        </tr>
        <tr>
            <td colspan="8" align="right" valign="bottom"><strong>Total Price + PPN(<?php echo $data['ppn'] . "%"; ?>) =</strong></td>
            <td align="left">
                <?php echo number_format(($total['total']) + (($total['total']) * floatval($data['ppn']) / 100), 2, ',', '.'); ?>
                <input id="total_price_ppn" name="total_price_ppn" class="form-control" type="hidden" required="required" placeholder="" size="20" value="<?php echo number_format(($total['total']) + (($total['total']) * floatval($data['ppn']) / 100), 2, ',', ''); ?>" />
            </td>
            <td align="left">&nbsp;</td>

        </tr>
        <tr>
            <td colspan="8" align="right" valign="bottom"><strong>Freight Cost by Air to JAKARTA =</strong></td>
            <td align="left" valign="top"><input name="cost_byair" id="cost_byair" class="form-control" type="text" required="required" value="<?php
                                                                                                                                                                // if ($data['cost_byair'] != 0) {
                                                                                                                                                                    echo $data['cost_byair'];
                                                                                                                                                                //} ?>" placeholder="Isi 0 Jika Tidak Ada Ongkir" size="20" onkeyup="sum_total_keseluruhan();" /></td>
            <td align="left" valign="top">&nbsp;</td>

        </tr>
        <tr>
            <td colspan="8" align="right" valign="bottom"><strong>Total Keseluruhan =</strong></td>
            <td align="left" valign="top"><input id="cost_cf" name="cost_cf" class="form-control" type="text" required="required" readonly value="<?php echo $data['cost_cf']; ?>" onkeyup="sum_total_keseluruhan();" placeholder="" size="20" /></td>
            <td align="left" valign="top">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="8" align="right" valign="bottom">Nilai Tukar (Satuan Dalam Rupiah) =</td>
            <td align="left" valign="top"><input id="nilai_tukar" name="nilai_tukar" class="form-control" type="text" required="required" value="<?php echo $data['nilai_tukar']; ?>" placeholder="" size="20" onkeyup="sum_total_keseluruhan();" /></td>
            <td align="left" valign="top">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="8" align="right" valign="bottom"><strong>Total Keseluruhan</strong> (Rupiah) =</td>
            <td align="left" valign="top">
                <?php
                $mu = mysqli_fetch_array(mysqli_query($koneksi, " select * from utang_piutang where no_faktur_no_po='" . $data['no_po_pesan'] . "'"));
                if ($mu['nominal'] != 0) {
                    $total_rupiah = $mu['nominal'];
                }
                ?>
                <input readonly name="dalam_rupiah" id="dalam_rupiah" type="text" required class="form-control" value="<?php echo $data['cost_cf'] * $data['nilai_tukar']; ?>" placeholder="Auto" size="20" />
            </td>
            <td align="left" valign="top">&nbsp;</td>
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