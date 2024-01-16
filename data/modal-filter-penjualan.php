<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
?>
<label>Provinsi</label>
<select class="form-control select2" required name="provinsi" id="provinsi1" style="width: 100%;" onchange="pilihProvinsi(this.value)">
    <option value="all">Semua</option>
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
<select class="form-control select2" name="kabupaten" id="kabupaten1" style="width: 100%;" onchange="pilihKabupaten(this.value)">
</select>
<br><br>
<label>Kecamatan</label>
<select class="form-control select2" name="kecamatan" id="kecamatan1" style="width: 100%;">
</select>
<br><br>
<label>Tahun</label>
<select class="form-control select2" id="tahun_now1" name="tahun_now1" style="width: 100%;">
    <?php
    $q99 = mysqli_query($koneksi, "select DISTINCT year(tgl_jual) as thn, max(year(tgl_jual)) OVER() as maks_thn from barang_dijual group by year(tgl_jual) order by year(tgl_jual) ASC");
    $dd = mysqli_fetch_array($q99);
    while ($d = mysqli_fetch_array($q99)) {
    ?>
        <option <?php
                if (isset($_GET['thn'])) {
                    if ($_GET['thn'] != 'all') {
                        if ($_GET['thn'] == $d['thn']) {
                            echo "selected";
                        }
                    }
                } else {
                    if (!isset($_GET['pilihan'])) {
                        if (date('Y') == $d['thn']) {
                            echo "selected";
                        }
                    }
                }
                ?> value="<?php echo $d['thn']; ?>"><?php echo $d['thn']; ?></option>
    <?php } ?>
    <?php for ($i = (intval($dd['maks_thn']) + 1); $i <= intval(date('Y')); $i++) { ?>
        <option <?php
                if (isset($_GET['thn'])) {
                    if ($_GET['thn'] != 'all') {
                        if ($_GET['thn'] == $i) {
                            echo "selected";
                        }
                    }
                } else {
                    if (!isset($_GET['pilihan'])) {
                        if (date('Y') == $i) {
                            echo "selected";
                        }
                    }
                }
                ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
    <?php } ?>
</select>

<script>
    var kabupaten = document.getElementById("kabupaten1");
    var kecamatan = document.getElementById("kecamatan1");

    kabupaten.disabled = true;
    kecamatan.disabled = true;

    function pilihProvinsi(id) {
        kabupaten.disabled = false;
        const xhr = new XMLHttpRequest()
        xhr.onreadystatechange = () => {
            if (xhr.readyState == 4 && xhr.status == 200) {
                kabupaten.innerHTML = xhr.responseText
            }
        }
        xhr.open('GET', "data/kabupaten.php?provinsi_id=" + id, true)
        xhr.send()
    }

    function pilihKabupaten(id) {
        kecamatan.disabled = false
        const xhr = new XMLHttpRequest()
        xhr.onreadystatechange = () => {
            if (xhr.readyState == 4 && xhr.status == 200) {
                kecamatan.innerHTML = xhr.responseText
            }
        }
        xhr.open('GET', "data/kecamatan.php?kabupaten_id=" + id, true)
        xhr.send()
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