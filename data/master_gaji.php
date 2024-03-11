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
                <td width="" align="center"><strong>No</strong>
                    </th>
                <th width="" valign="top">Kategori</th>
                <th width="" valign="top"><strong>Nama Gaji</strong></th>
                <th width="" valign="top">Besar Gaji</th>
                <th width="" align="center" valign="top"><strong>Aksi</strong></th>
            </tr>
        </thead>
        <?php
        $query = mysqli_query($koneksi, "SELECT *,gaji.id as idd FROM gaji");

        $no = 0;
        while ($data = mysqli_fetch_assoc($query)) {
            $no++;
        ?>
            <tr>
                <td align="center"><?php echo $no; ?></td>
                <td><?php echo $data['kategori'];  ?></td>

                <td><?php echo $data['nama_gaji'];  ?></td>
                <td><?php echo "Rp" . number_format($data['besar_gaji'], 0, ',', '.');  ?></td>
                <td>
                    <a href="javascript:void()" onclick="hapus('<?php echo $data['idd']; ?>')" class="btn btn-xs btn-danger">
                        <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                    </a>
                    &nbsp;
                    <a href="index.php?page=ubah_master_gaji&id_ubah=<?php echo $data['idd']; ?>" class="btn btn-xs btn-warning"><span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span></a>

                </td>
            </tr>
        <?php } ?>
    </table><br />
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