<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
?>
<label>Merk Barang</label>
<select class="form-control select2" style="width:100%" name="alkes" id="alkes" onchange="changeMerk(this.value);">
    <option value="all">Semua</option>
    <?php
    $q_brg = mysqli_query($koneksi, "select merk_brg from barang_gudang group by merk_brg order by merk_brg asc");
    while ($dt = mysqli_fetch_array($q_brg)) {
    ?>
        <option <?php if (strtolower($_GET['merk']) == strtolower($dt['merk_brg'])) {
                    echo "selected";
                } ?> value="<?php echo $dt['merk_brg'] ?>"><?php echo $dt['merk_brg'] ?></option>
    <?php } ?>
</select>
<br><br>
<label>Tipe Barang</label>
<div id="data_tipe_barang">
    <select class="form-control" disabled>
        <option value="">...</option>
    </select>
    <br>
</div>
<!-- <label>Filter Berdasarkan</label>
<select class="form-control select2" id="filterRekap" onchange="filterCetak(this.value)" style="width:100%" name="filterRekap">
    <option value="0">...</option>
    <option value="1">Nama Dinas/RS/Dll</option>
    <option value="2">Provinsi/Kabupaten/Kecamatan</option>
</select>
<br><br>
<div id="filterData"></div> -->
<label>Tahun</label>
<select class="form-control select2" id="tahun_now1" name="tahun_now1" style="width: 100%;">
    <?php
    $q99 = mysqli_query($koneksi, "select DISTINCT year(tgl_jual) as thn, max(year(tgl_jual)) OVER() as maks_thn from barang_dijual group by year(tgl_jual) order by year(tgl_jual) ASC");
    $dd = mysqli_fetch_array($q99);
    while ($d = mysqli_fetch_array($q99)) {
    ?>
        <option <?php if (($_GET['tahun'] == $d['thn']) && $_GET['tahun'] !== 'All') {
                    echo "selected";
                } ?> value="<?php echo $d['thn']; ?>"><?php echo $d['thn']; ?></option>
    <?php } ?>
    <?php for ($i = (intval($dd['maks_thn']) + 1); $i <= intval(date('Y')); $i++) { ?>
        <option <?php if (($_GET['tahun'] == $i) && $_GET['tahun'] !== 'All') {
                    echo "selected";
                } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
    <?php } ?>
</select>

<script>
    var kabupaten = document.getElementById("kabupaten1");
    var kecamatan = document.getElementById("kecamatan1");

    kabupaten.disabled = true;
    kecamatan.disabled = true;

    function pilihProvinsi(id) {
        kabupaten.disabled = false;
        $.get("data/kabupaten.php", {
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
        $.get("data/kecamatan.php", {
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

    function changeMerk(merk) {
        $.get("data/getTipeBarang.php", {
                merk: merk,
                tipe: '<?php echo $_GET['tipe'] ?>'
            },
            function(data) {
                $('#data_tipe_barang').html(data);
            }
        );
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