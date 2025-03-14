<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
?>
<label>Merk</label>
<select class="form-control select22" multiple="multiple" required name="merk" id="merk" style="width: 100%;" onchange="pilihMerk()" data-placeholder="Pilih Merk">
    <?php $q1 = mysqli_query($koneksi, "select distinct merk_brg from barang_gudang order by merk_brg ASC");
    while ($row1 = mysqli_fetch_array($q1)) {
    ?>
        <option value="<?php echo $row1['merk_brg']; ?>"><?php echo $row1['merk_brg']; ?></option>
    <?php
    }
    ?>
</select>
<br><br>
<label>Tipe</label>
<div id="data_tipe">
    <select class="form-control select22" style="width: 100%;">
        <option>...</option>
    </select>
</div>
<br>
<label>Nama Alkes</label>
<div id="data_alkes">
    <select class="form-control select22" style="width: 100%;">
        <option>...</option>
    </select>
</div>
<br>
<!-- <label>Tahun</label>
<select class="form-control select2" id="tahun_noww" name="tahun_noww" style="width: 100%;">
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
</select> -->

<script>
    // var tipe = document.getElementById("tipe");
    // var alkes = document.getElementById("alkes");

    // tipe.disabled = true;
    // alkes.disabled = true;

    function pilihMerk() {
        // tipe.disabled = false;
        let merk = $('#merk').val()
        loading2('#data_tipe')
        if (merk.length > 0) {
            console.log('merk', merk);
            
            $.get("data/tipe_brg.php", {
                    merk_brg: merk
                },
                function(data) {
                    $('#data_tipe').html(data);
                }
            );
        } else {
            $('#data_tipe').html('<select class="form-control select22" style="width: 100%;"><option>...</option></select>');
        }
        // const xhr = new XMLHttpRequest()
        // xhr.onreadystatechange = () => {
        //     if (xhr.readyState == 4 && xhr.status == 200) {
        //         kabupaten.innerHTML = xhr.responseText
        //     }
        // }
        // xhr.open('GET', "data/kabupaten.php?provinsi_id=" + id, true)
        // xhr.send()
    }

    function pilihTipe() {
        let tipe = $('#tipe').val()
        loading2('#data_alkes')
        if (tipe.length > 0) {
            $.get("data/beranda_alkes.php", {
                    merk_brg: $('#merk').val(),
                    tipe_brg: tipe
                },
                function(data) {
                    $('#data_alkes').html(data);
                }
            );
        } else {
            $('#data_alkes').html('<select class="form-control select22" style="width: 100%;"><option>...</option></select>');
        }

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
        $('.select22').select2()
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