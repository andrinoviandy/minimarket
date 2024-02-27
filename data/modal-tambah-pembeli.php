<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$q2 = mysqli_query($koneksi, "select *,pembeli.id as idd from pembeli,alamat_provinsi,alamat_kabupaten,alamat_kecamatan where alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id order by nama_pembeli ASC");
?>
<form method="post" enctype="multipart/form-data">
    <div class="modal-body">
        Nama RS/Dinas/Puskesmas/Klinik/Dll
        <input name="nama_pembeli" class="form-control" placeholder="Nama Rumah Sakit/Dinas/Dll" type="text" required="required"><br />
        <div class="well">
            <div class="box-header" align="center"><strong>Alamat RS/Dinas/Puskesmas/Klinik/Dll</strong></div>
            Provinsi
            <select class="form-control" name="provinsi" id="provinsi" required>
                <option value="">-- Pilih Provinsi --</option>
                <?php $q1 = mysqli_query($koneksi, "select * from alamat_provinsi order by nama_provinsi ASC");
                while ($row1 = mysqli_fetch_array($q1)) {
                ?>
                    <option value="<?php echo $row1['id']; ?>"><?php echo $row1['nama_provinsi']; ?></option>
                <?php
                } ?>
            </select><br />

            Kabupaten
            <select class="form-control" name="kabupaten" id="kabupaten" required>
                <option value="">-- Pilih Kabupaten/Kota --</option>
                <?php $q2 = mysqli_query($koneksi, "select *,alamat_kabupaten.id as idd from alamat_kabupaten INNER JOIN alamat_provinsi ON alamat_provinsi.id=alamat_kabupaten.provinsi_id order by nama_kabupaten ASC");
                while ($row2 = mysqli_fetch_array($q2)) {
                ?>
                    <option id="kabupaten" class="<?php echo $row2['provinsi_id']; ?>" value="<?php echo $row2['idd']; ?>"><?php echo $row2['nama_kabupaten']; ?></option>
                <?php } ?>
            </select><br />

            Kecamatan
            <select class="form-control" name="kecamatan" id="kecamatan" required>
                <option value="">-- Pilih Kecamatan --</option>
                <?php $q3 = mysqli_query($koneksi, "select *,alamat_kecamatan.id as idd from alamat_kecamatan INNER JOIN alamat_kabupaten ON alamat_kabupaten.id=alamat_kecamatan.kabupaten_id order by nama_kecamatan ASC");
                while ($row3 = mysqli_fetch_array($q3)) {
                ?>
                    <option id="kecamatan" class="<?php echo $row3['kabupaten_id']; ?>" value="<?php echo $row3['idd']; ?>"><?php echo $row3['nama_kecamatan']; ?></option>
                <?php } ?>
            </select><br />
            <script src="jquery-1.10.2.min.js"></script>
            <script src="jquery.chained.min.js"></script>
            <script>
                $("#kabupaten").chained("#provinsi");
                $("#kecamatan").chained("#kabupaten");
                $("#kelurahan").chained("#kecamatan");
                //$("#kecamatan").chained("#kota");
            </script>
            Kelurahan
            <input class="form-control" type="text" placeholder="Kelurahan" name="kelurahan" required><br />
            Alamat Jalan
            <input class="form-control" type="text" placeholder="Jl.Xxx" name="alamat" required><br />
            Kontak RS/Dinas/Dll
            <input class="form-control" type="text" placeholder="" name="kontak_rs" required><br />

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="simpan_rs">Simpan</button>
    </div>
</form>

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