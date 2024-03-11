<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<div class="table-responsive">
    <table width="100%" id="example1" class="table table-bordered table-hover">
        <thead>
            <tr>
                <td width="5%" align="center">&nbsp;</td>
                <td width="16%"><strong>Mata Uang<span class="active"></span></strong></td>
                <td width="12%"><strong>Simbol</strong></td>
                <td width="14%"><strong>Negara</strong></td>
                <td width="22%"><strong>Satuan Dalam Rupiah</strong></td>
                <td width="14%"><strong>Exp Time</strong></td>
                <td width="17%" align="center"><strong>Aksi</strong></td>

            </tr>
        </thead>
        <?php
        $query = mysqli_query($koneksi, "select * from mata_uang");
        $no = 0;
        while ($data = mysqli_fetch_assoc($query)) {
            $no++;
        ?>
            <tr>
                <td align="center"><?php echo $no; ?></td>
                <td><?php echo $data['jenis_mu']; ?></td>
                <td><?php echo $data['simbol']; ?></td>
                <td><?php echo $data['negara_mu']; ?></td>
                <td><?php echo "Rp" . number_format($data['dalam_rupiah'], 2, ',', '.'); ?></td>
                <td><?php echo date("d F Y", strtotime($data['exp_time'])); ?></td>
                <td align="center">
                    <a href="javascript:void()" onclick="hapus('<?php echo $data['id']; ?>')" class="btn btn-xs btn-danger"><span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a> &nbsp;&nbsp;
                    <a href="index.php?page=ubah_mata_uang&id=<?php echo $data['id']; ?>" class="btn btn-xs btn-warning"><span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span></a> &nbsp;&nbsp;
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