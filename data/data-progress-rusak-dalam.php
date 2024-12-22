<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<table width="100%" id="example1" class="table table-bordered table-hover">
    <thead>
        <tr>
            <td><strong>
                    Tanggal Progress
                </strong></td>
            <td><strong>Deskripsi Kerusakan</strong></td>
            <td><strong>Deskripsi Perbaikan</strong></td>
            <td><strong>Lampiran</strong></td>
            <td><strong>Aksi</strong></td>

        </tr>
    </thead>
    <?php

    //$query = mysqli_query($koneksi, "select *,tb_laporan_kerusakan.id as idd from tb_laporan_kerusakan,akun_customer,kategori_job,barang_dikirim,barang_dikirim_detail,barang_dijual,barang_dijual_detail,barang_gudang,barang_gudang_detail where akun_customer.id=tb_laporan_kerusakan.akun_customer_id and barang_dikirim_detail.id=tb_laporan_kerusakan.barang_dikirim_detail_id and kategori_job.id=tb_laporan_kerusakan.kategori_job_id and barang_dijual_detail.id=barang_dikirim_detail.barang_dijual_detail_id and barang_dijual.id=barang_dijual_detail.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dijual_detail.barang_gudang_detail_id order by tb_laporan_kerusakan.tgl_lapor ".$limiter['urut']." LIMIT ".$limiter['limiter']."");
    $query = mysqli_query($koneksi, "select * from barang_gudang_detail_rusak_progress where barang_gudang_detail_rusak_id=" . $_GET['id_ubah'] . "");

    $no = 0;
    while ($data = mysqli_fetch_assoc($query)) {
        $no++;
    ?>
        <tr>
            <td><?php echo date("d-m-Y", strtotime($data['tgl_progress'])); ?></td>
            <td><?php echo $data['deskripsi_kerusakan']; ?></td>
            <td><?php echo $data['deskripsi_perbaikan']; ?></td>
            <td><?php if ($data['lampiran'] != "") { ?>
                    <a href="gambar_progress_belum_dijual/<?php echo $data['lampiran']; ?>" target="_blank"><img src="gambar_progress_belum_dijual/<?php echo $data['lampiran']; ?>" width="50px" /></a>
                <?php } ?>
            </td>
            <td>
                <?php
                //$d = mysqli_fetch_array(mysqli_query($koneksi, "select * from tb_maintenance_detail.id="));
                if ($da['status_progress'] == 0) { ?>
                    <button onclick="hapus('<?php echo $data['id']; ?>')" class="btn btn-xs btn-danger"><span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></button>
                <?php } ?>
            </td>
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