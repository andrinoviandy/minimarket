<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<table width="100%" id="example2" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th valign="bottom">No</th>
            <th valign="bottom"><strong>Nama Alkes</strong></th>
            <th align="center" valign="bottom"><strong>Tipe
                </strong></th>
            <th align="center" valign="bottom"><strong>Merk
                </strong></th>
            <th align="center" valign="bottom"><strong>NIE
                </strong></th>
            <th align="center" valign="bottom"><strong>No Seri</strong></th>
            <th align="center" valign="bottom"><strong>Aksi</strong></th>
        </tr>
    </thead>
    <?php

    $no = 0;
    $q_akse = mysqli_query($koneksi, "select *,barang_pinjam_detail_hash.id as idd from barang_dikirim,barang_dikirim_detail,barang_dijual,pembeli,barang_gudang,barang_gudang_detail,barang_pinjam_detail_hash where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_pinjam_detail_hash.barang_gudang_detail_id and barang_dikirim_id=" . $_SESSION['barang_dikirim_id'] . " and akun_id=" . $_SESSION['id'] . " order by nama_brg ASC");

    while ($data_akse = mysqli_fetch_array($q_akse)) {
        $no++;
    ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $data_akse['nama_brg']; ?>
            </td>
            <td><?php echo $data_akse['tipe_brg']; ?></td>
            <td><?php echo $data_akse['merk_brg']; ?></td>
            <td><?php echo $data_akse['nie_brg']; ?></td>
            <td><?php echo $data_akse['no_seri_brg']; ?></td>
            <td>
                <!-- <a href="index.php?page=pilih_peminjaman_barang&id_hapus=<?php echo $data_akse['idd']; ?>" onclick="return confirm('Yakin Akan Menghapus Item Ini ?')"> -->
                <a href="javascript:void()" onclick="hapusAlkes('<?php echo $data_akse['idd']; ?>')" class="label bg-red">
                <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a></td>
        </tr>
    <?php } ?>
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