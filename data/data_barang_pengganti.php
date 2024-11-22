<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
?>
<table width="100%" id="example2" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th valign="bottom">No</th>
            <th valign="bottom"><strong>Nama Alkes</strong></th>
            <td align="center" valign="bottom"><strong>Tipe
                </strong></td>
            <td align="center" valign="bottom"><strong>Merk
                </strong></td>
            <td align="center" valign="bottom"><strong>NIE
                </strong></td>
            <td align="center" valign="bottom"><strong>No Seri Lama</strong></td>
            <td align="center" valign="bottom"><strong>No Seri Pengganti</strong></td>
            <td align="center" valign="bottom"><strong>Aksi</strong></td>
        </tr>
    </thead>
    <?php

    $no = 0;
    $q_akse = mysqli_query($koneksi, "select *,barang_dikirim_detail.id as idd from barang_dikirim_detail,barang_gudang,barang_gudang_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and status_batal=1 and barang_dikirim_id=" . $_SESSION['no_po'] . "");
    while ($data_akse = mysqli_fetch_array($q_akse)) {
        $no++;
    ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $data_akse['nama_brg']; ?>
            </td>
            <td align="center"><?php echo $data_akse['tipe_brg']; ?></td>
            <td align="center"><?php echo $data_akse['merk_brg']; ?></td>
            <td align="center"><?php echo $data_akse['nie_brg']; ?></td>
            <td align="center"><?php echo $data_akse['no_seri_brg']; ?></td>
            <td align="center"><?php
                                $data = mysqli_fetch_array(mysqli_query($koneksi, "select *,barang_dikirim_detail_pengganti_hash.id as idd from barang_dikirim_detail_pengganti_hash,barang_gudang_detail where barang_gudang_detail.id=barang_dikirim_detail_pengganti_hash.barang_gudang_detail_id and barang_dikirim_detail_id=" . $data_akse['idd'] . ""));
                                echo $data['no_seri_brg'];
                                ?></td>
            <td align="center">
                <!-- <button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-pilihnoseri<?php echo $data_akse['idd'] ?>"> -->
                <button class="btn btn-xs btn-warning" onclick="showModal('<?php echo $data_akse['idd'] ?>')">
                Ganti</button>&nbsp;
                <!-- <a href="?page=<?php echo $_GET['page']; ?>&id_hapus=<?php echo $data['idd'] ?>"> -->
                <a href="javascript:void()" onclick="hapusPengganti('<?php echo $data['idd'] ?>')">
                <button class="btn btn-xs btn-danger">Hapus Pengganti</button></a>
            </td>
        </tr>
        <!--<div class="modal fade" id="modal-pilihnoseri<?php echo $data_akse['idd'] ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" align="center">Ganti No Seri</h4>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" name="barang_dikirim_detail_id" value="<?php echo $data_akse['idd']; ?>" />
                            <input type="hidden" name="barang_dijual_qty_id" value="<?php echo $data_akse['barang_dijual_qty_id']; ?>" />
                            <input type="hidden" name="barang_dikirim_detail_hash_id" value="<?php echo $data['idd']; ?>" />
                            <input type="hidden" name="jml_kirim" value="<?php echo $data_akse['jml_kirim']; ?>" />
                            <input type="hidden" name="kategori_brg" value="<?php echo $data_akse['kategori_brg']; ?>" />
                            <input type="hidden" name="barang_gudang_set_id" value="<?php echo $data_akse['barang_gudang_set_id']; ?>" />
                            <input type="hidden" name="barang_gudang_satuan_id" value="<?php echo $data_akse['barang_gudang_satuan_id']; ?>" />
                            <input type="hidden" name="barang_gudang_akse_id" value="<?php echo $data_akse['barang_gudang_akse_id']; ?>" />

                            <select name="no_seri" class="form-control select2" style="width:100%" required>
                                <option value="">... Pilih No Seri ...</option>
                                <?php
                                //$q_seri = mysqli_query($koneksi, "select no_seri_brg,barang_gudang_detail.id as idd from barang_gudang_detail INNER JOIN barang_gudang ON barang_gudang.id=barang_gudang_detail.barang_gudang_id and status_kirim=0 and status_kerusakan=0 and status_demo=0 and barang_gudang_id=" . $data_akse['barang_gudang_id'] . " and barang_gudang_detail.id not in (select barang_gudang_detail_id from barang_dikirim_detail_pengganti_hash where akun_id = '" . $_SESSION['id'] . "') order by no_seri_brg ASC");
                                //while ($d_seri = mysqli_fetch_array($q_seri)) {
                                ?>
                                    <option value="<?php echo $d_seri['idd']; ?>"><?php echo $d_seri['no_seri_brg']; ?></option>
                                <?php //} ?>
                            </select>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning" name="simpan_tambah_aksesoris">Ganti</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    -->
    <?php } ?>
</table>
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
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