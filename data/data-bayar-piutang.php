<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
?>
<label>No Nota</label>
<input type="hidden" disabled name="id_penjualan" id="id_penjualan" class="form-control" value="<?php echo $_GET['id'] ?>"/>
<input type="text" disabled name="no_nota" id="no_nota" class="form-control" value="<?php echo $_GET['no_nota'] ?>"/>
<br>
<label>No. Pembayaran</label>
<input type="text" id="no_pembayaran" name="no_pembayaran" readonly class="form-control" value="<?php echo $_GET['no_pembayaran'] ?>"/>
<br>
<label>Tanggal Pembayaran</label>
<input type="date" name="tgl_pembayaran" id="tgl_pembayaran" class="form-control" />
<br>
<label>Nominal Pembayaran</label>
<input type="text" name="nominal_pembayaran" id="nominal_pembayaran" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"/>
<br>
<label>Deskripsi</label>
<textarea rows="4" class="form-control" name="deskripsi" id="deskripsi"></textarea>
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