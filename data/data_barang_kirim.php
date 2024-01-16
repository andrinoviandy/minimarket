<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
?>
<table width="100%" id="example2" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th valign="bottom">No</th>
            <th valign="bottom">Kategori</th>
            <th valign="bottom"><strong>Nama Alkes</strong></th>
            <th valign="bottom"><strong>Rincian</strong></th>
            <td align="center" valign="bottom"><strong>Tipe
                </strong></td>
            <td align="center" valign="bottom"><strong>Merk
                </strong></td>
            <td align="center" valign="bottom"><strong>NIE
                </strong></td>
            <td align="center" valign="bottom"><strong>No Seri / No Loth</strong></td>
            <td align="center" valign="bottom"><strong>Aksi</strong></td>
        </tr>
    </thead>
    <tbody>
        <?php
        $q_akse = mysqli_query($koneksi, "select nama_brg, no_seri_brg, no_lot, tipe_brg, merk_brg, nie_brg, barang_dikirim_detail_hash.id as idd, barang_dikirim_detail_hash.*, barang_gudang.id as id_gudang from barang_dikirim_detail_hash, barang_gudang_detail, barang_gudang where barang_gudang.id = barang_gudang_detail.barang_gudang_id and  barang_gudang_detail.id = barang_dikirim_detail_hash.barang_gudang_detail_id and akun_id=" . $_SESSION['id'] . "");
        $no = 0;
        while ($data = mysqli_fetch_array($q_akse)) {
            $no++;
        ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $data['kategori_brg']; ?></td>
                <td>
                    <?php
                    if ($data['barang_gudang_set_id'] != 0) {
                        $dt = mysqli_fetch_array(mysqli_query($koneksi, "select nama_brg, tipe_brg, merk_brg, nie_brg from barang_gudang where id = $data[barang_gudang_set_id]"));
                    }
                    else if ($data['barang_gudang_satuan_id'] != 0) {
                        $dt = mysqli_fetch_array(mysqli_query($koneksi, "select nama_brg, tipe_brg, merk_brg, nie_brg from barang_gudang where id = $data[barang_gudang_satuan_id]"));
                    }
                    else if ($data['barang_gudang_akse_id'] != 0) {
                        $dt = mysqli_fetch_array(mysqli_query($koneksi, "select nama_brg, tipe_brg, merk_brg, nie_brg from barang_gudang where id = $data[barang_gudang_akse_id]"));
                    }
                    
                    echo $dt['nama_brg'];
                    ?>
                </td>
                <td><?php echo $data['nama_brg']; ?></td>
                <td align="center"><?php echo $data['tipe_brg']; ?></td>
                <td align="center"><?php echo $data['merk_brg']; ?></td>
                <td align="center"><?php echo $data['nie_brg']; ?></td>
                <td align="center"><?php echo $data['no_seri_brg']."<br>No Loth : ".$data['no_lot']; ?></td>
                <td align="center">
                    <!-- <a href="index.php?page=pilih_no_seri&id=<?php echo $_GET['id']; ?>&id_hapus=<?php echo $data['idd']; ?>" onclick="return confirm('Yakin Akan Menghapus Item Ini ?')"> -->
                    <?php //if ($data['kategori_brg'] == 'Aksesoris' && $data['barang_gudang_satuan_id'] != 0) { ?>
                        <!-- Data Rincian -->
                    <?php //} else { ?>
                        <a href="javascript:void();" onclick="hapus('<?php echo $_GET['id']; ?>', '<?php echo $data['idd']; ?>')">
                            <button class="btn btn-xs btn-danger">
                                <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                            </button>
                        </a>
                        &nbsp;
                        <a href="javascript:void();" onclick="modalUbahNoSeri('<?php echo $data['idd']; ?>', '<?php echo $data['id_gudang']; ?>')">
                            <button class="btn btn-xs btn-info">
                                <span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span>
                            </button>
                        </a>
                    <?php // } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
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