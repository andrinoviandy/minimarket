<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$q2 = mysqli_query($koneksi, "select *,pembeli.id as idd from pembeli,alamat_provinsi,alamat_kabupaten,alamat_kecamatan where alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id order by nama_pembeli ASC");
?>
<form method="post" id="formPembeli" enctype="multipart/form-data" onsubmit="tambahPembeli(); return false;">
    <div class="modal-body">
        Nama RS/Dinas/Puskesmas/Klinik/Dll
        <input name="nama_pembeli" class="form-control" placeholder="Nama Rumah Sakit/Dinas/Dll" type="text" required="required"><br />
        <div class="well">
            <div class="box-header" align="center"><strong>Alamat RS/Dinas/Puskesmas/Klinik/Dll</strong></div>
            <label>Provinsi</label>
            <select class="form-control select2" required name="provinsi" id="provinsi1" style="width: 100%;" onchange="pilihProvinsi(this.value)">
                <option value="">....</option>
                <?php $q1 = mysqli_query($koneksi, "select * from alamat_provinsi order by nama_provinsi ASC");
                while ($row1 = mysqli_fetch_array($q1)) {
                ?>
                    <option value="<?php echo $row1['id']; ?>"><?php echo $row1['nama_provinsi']; ?></option>
                <?php
                }
                ?>
            </select>
            <br><br>
            <label>Kabupaten</label>
            <select class="form-control select2" required name="kabupaten" id="kabupaten1" style="width: 100%;" onchange="pilihKabupaten(this.value)">
            </select>
            <br><br>
            <label>Kecamatan</label>
            <select class="form-control select2" required name="kecamatan" id="kecamatan1" style="width: 100%;">
            </select>
            <br><br>
            <label>Kelurahan</label>
            <input class="form-control" type="text" placeholder="Kelurahan" name="kelurahan" required><br />
            <label>Alamat Jalan</label>
            <input class="form-control" type="text" placeholder="Jl.Xxx" name="alamat" required><br />
            <label>
                Kontak RS/Dinas/Dll
            </label>
            <input class="form-control" type="text" placeholder="" name="kontak_rs" required><br />

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="simpan_rs">Simpan</button>
    </div>
</form>

<script>
    var kabupaten = document.getElementById("kabupaten1");
    var kecamatan = document.getElementById("kecamatan1");

    kabupaten.disabled = true;
    kecamatan.disabled = true;

    function pilihProvinsi(id) {
        kabupaten.disabled = false;
        $.get("data/kabupatenPembeli.php", {
                provinsi_id: id
            },
            function(data) {
                $('#kabupaten1').html(data);
            }
        );
        // const xhr = new XMLHttpRequest()
        // xhr.onreadystatechange = () => {
        //     if (xhr.readyState == 4 && xhr.status == 200) {
        //         kabupaten.innerHTML = xhr.responseText
        //     }
        // }
        // xhr.open('GET', "data/kabupaten.php?provinsi_id=" + id, true)
        // xhr.send()
    }

    function pilihKabupaten(id) {
        kecamatan.disabled = false
        $.get("data/kecamatanPembeli.php", {
                kabupaten_id: id
            },
            function(data) {
                $('#kecamatan1').html(data);
            }
        );

        // const xhr = new XMLHttpRequest()
        // xhr.onreadystatechange = () => {
        //     if (xhr.readyState == 4 && xhr.status == 200) {
        //         kecamatan.innerHTML = xhr.responseText
        //     }
        // }
        // xhr.open('GET', "data/kecamatan.php?kabupaten_id=" + id, true)
        // xhr.send()
    }
</script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
        $('.select1').select1()
        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {
            'placeholder': 'mm/dd/yyyy'
        })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            format: 'MM/DD/YYYY h:mm A'
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function(start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        )

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        })

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        })
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        })
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        })

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        //Timepicker
        $('.timepicker').timepicker({
            showInputs: false
        })
    })
</script>