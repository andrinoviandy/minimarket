<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
?>
<div class="table-responsive">
    <table width="100%" id="example1" class="table table-bordered table-hover">
        <thead>
            <tr>
                <td width="5%" align="center">#</th>
                <th width="15%" valign="top"><strong>No Akun</strong></th>
                <th width="20%" valign="top">Nama</th>
                <th width="15%" valign="top">Saldo</th>
                <th width="10%" align="center" valign="top"><strong>Aksi</strong></th>
            </tr>
        </thead>
        <?php
        $query = mysqli_query($koneksi, "select *,buku_kas.id as idd from buku_kas where tipe_akun='KAS' order by no_akun ASC");

        $no = 0;
        while ($data = mysqli_fetch_assoc($query)) {
            $no++;
        ?>
            <tr>
                <td align="center"><?php echo $no; ?></td>
                <td>
                    <?php echo $data['no_akun'];  ?>
                </td>
                <td><?php echo $data['nama_akun']; ?></td>
                <td><?php echo "Rp " . number_format($data['saldo'], 2, ',', '.'); ?>
                </td>
                <td>
                    <?php
                    $jm1 = mysqli_num_rows(mysqli_query($koneksi, "select * from biaya_lain where buku_kas_id=" . $data['idd'] . ""));
                    $jm2 = mysqli_num_rows(mysqli_query($koneksi, "select * from utang_piutang_bayar where buku_kas_id=" . $data['idd'] . ""));
                    if ($jm1 == 0 and $jm2 == 0) {
                    ?>
                        <!-- <a href="index.php?page=buku_bank&id_hapus=<?php echo $data['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ? Riwayat Pembayaran Pada Buku Ini Juga Akan Ikut Terhapus !')" class="btn btn-xs btn-danger"> -->
                        <button class="btn btn-xs btn-danger" onclick="hapus('<?php echo $data['idd']; ?>')">
                            <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></button>&nbsp;
                    <?php } ?>
                    <button onclick="modalUbah('<?php echo $data['idd']; ?>')" class="btn btn-xs btn-warning"><span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span></button>
                    &nbsp;
                    <a href="index.php?page=ubah_buku_kas&id=<?php echo $data['idd']; ?>" class="btn btn-xs btn-info">
                        <span data-toggle="tooltip" title="Riwayat Akun" class="fa fa-caret-square-o-right"></span></a><!--&nbsp;<a target="_blank" href="cetak_rekapan_alkes2.php?id=<?php echo $data['idd']; ?>"><span data-toggle="tooltip" title="Print" class="fa fa-print"></span></a>
      -->
                    <!-- Tombol Jual -->

                    <?php /* if ($data['stok_total']!=0 and $data['status_cek']!=0) { ?>
      &nbsp;<a href="index.php?page=barang_masuk&id=<?php echo $data['idd']; ?>#openPilihan"><small data-toggle="tooltip" title="Jual Alkes" class="label bg-blue">Jual</small></a>
      <!--&nbsp;<a href="index.php?page=jual_barang2&id=<?php //echo $data['idd']; ?>"><small data-toggle="tooltip" title="Jual Alkes" class="label bg-blue">Jual</small>-->
      <?php } */ ?>

                </td>
            </tr>
        <?php } ?>
    </table>
    <!-- Modal-->
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