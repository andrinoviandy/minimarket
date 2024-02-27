<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Nama RS/Dinas/Puskesmas/Klinik/Dll
<div class="input-group">
    <select name="pembeli" id="pembeli" class="form-control select2" onchange="changeValue(this.value)" required style="width:100%">
        <option value="">...</option>

        <?php
        $result = mysqli_query($koneksi, "select *,pembeli.id as idd from pembeli,alamat_provinsi,alamat_kabupaten,alamat_kecamatan where alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id order by nama_pembeli ASC");

        while ($row = mysqli_fetch_array($result)) {
        ?>
            <option value="<?php echo $row['idd']; ?>"><?php echo $row['nama_pembeli'] . '&nbsp;(' . $row['kontak_rs'] . ')'; ?></option>
        <?php
            $jsArray .= "dtPembeli['" . $row['idd'] . "'] = {nama_pembeli:'" . addslashes($row['nama_pembeli']) . "',
                      provinsi:'" . addslashes($row['nama_provinsi']) . "',
                      provinsi_id:'" . addslashes($row['provinsi_id']) . "',
                    kabupaten:'" . addslashes($row['nama_kabupaten']) . "',
                    kabupaten_id:'" . addslashes($row['kabupaten_id']) . "',
                    kecamatan:'" . addslashes($row['nama_kecamatan']) . "',
                    kecamatan_id:'" . addslashes($row['kecamatan_id']) . "',
                    kelurahan:'" . addslashes($row['kelurahan_id']) . "',
                    jalan:'" . addslashes(substr($row['jalan'], 0, 17) . ".....") . "',
                    kontak_rs:'" . addslashes($row['kontak_rs']) . "'
                    };
                    ";
        }
        ?>
    </select>
    <a href="#" class="input-group-addon label-success" data-toggle="modal" data-target="#modal-tambahrs"><i class="fa fa-plus"></i></a>
</div><br />
<div class="well">
    <div class="box-header" align="center"><strong>Alamat RS/Dinas/Puskesmas/Klinik/Dll</strong></div>
    <input class="form-control" type="hidden" name="nama_pembeli" id="nama_pembeli">
    Provinsi
    <input class="form-control" type="text" name="provinsi2" id="provinsi2" disabled="disabled"><input class="form-control" type="hidden" name="id_provinsi" id="id_provinsi"><br />

    Kabupaten
    <input class="form-control" type="text" name="kabupaten2" id="kabupaten2" disabled="disabled"><input class="form-control" type="hidden" name="id_kabupaten" id="id_kabupaten"><br />

    Kecamatan
    <input class="form-control" type="text" name="kecamatan2" id="kecamatan2" disabled="disabled"><input class="form-control" type="hidden" name="id_kecamatan" id="id_kecamatan"><br />

    Kelurahan
    <input class="form-control" type="text" placeholder="" name="kelurahan2" id="kelurahan2" readonly="readonly"><br />
    Alamat Jalan
    <input class="form-control" type="text" placeholder="" name="jalan2" id="jalan2" readonly="readonly"><br />
    Kontak RS/Dinas/Dll
    <input class="form-control" type="text" placeholder="" name="kontak_rs2" required id="kontak_rs2" readonly="readonly"><br />
</div>
<script type="text/javascript">
    <?php
    echo $jsArray;
    ?>

    function changeValue(pembeli) {
        document.getElementById('nama_pembeli').value = dtPembeli[pembeli].nama_pembeli;
        document.getElementById('provinsi2').value = dtPembeli[pembeli].provinsi;
        document.getElementById('id_provinsi').value = dtPembeli[pembeli].provinsi_id;
        document.getElementById('kabupaten2').value = dtPembeli[pembeli].kabupaten;
        document.getElementById('id_kabupaten').value = dtPembeli[pembeli].kabupaten_id;
        document.getElementById('kecamatan2').value = dtPembeli[pembeli].kecamatan;
        document.getElementById('id_kecamatan').value = dtPembeli[pembeli].kecamatan_id;
        document.getElementById('kelurahan2').value = dtPembeli[pembeli].kelurahan;
        document.getElementById('jalan2').value = dtPembeli[pembeli].jalan;
        document.getElementById('kontak_rs2').value = dtPembeli[pembeli].kontak_rs;
    };
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
</body>
</html>