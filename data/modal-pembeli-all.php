<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$q2 = mysqli_query($koneksi, "select *,pembeli.id as idd from pembeli,alamat_provinsi,alamat_kabupaten,alamat_kecamatan where alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id order by nama_pembeli ASC");
?>
<div class="table-responsive no-padding">
    <table width="100%" id="example1" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama RS/Dinas/Dll</th>
                <th>Provinsi</th>
                <th>Kelurahan</th>
                <th>Alamat</th>
                <th>Pilih</th>
            </tr>
        </thead>
        <?php
        $n = 0;
        while ($d1 = mysqli_fetch_array($q2)) {
            $n++;
        ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo $d1['nama_pembeli']; ?></td>
                <td><?php echo $d1['nama_provinsi']; ?></td>
                <td><?php echo $d1['kelurahan_id']; ?></td>
                <td><?php echo $d1['jalan']; ?></td>
                <td><a href="javascript:void()" class="btn btn-primary" onclick="pilihPembeli('<?php echo $d1['idd'] ?>','<?php echo $d1['nama_pembeli'] ?>', '<?php echo $d1['nama_provinsi'] ?>','<?php echo $d1['nama_kabupaten'] ?>','<?php echo $d1['nama_kecamatan'] ?>','<?php echo $d1['kelurahan_id'] ?>', '<?php echo $d1['jalan'] ?>', '<?php echo $d1['kontak_rs'] ?>')"><i class="fa fa-check"></i> Pilih</a></td>
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