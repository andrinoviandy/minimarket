<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<div class="form-group">
    <label>Nasabah</label>
    <select name="nasabah_id" id="nasabah_id" required class="form-control select2" style="width:100%" onchange="pilihTabungan(this.value)">
        <option value="">...</option>
        <?php
        $query_teknisi = mysqli_query($koneksi, "select * from nasabah order by nama_nasabah ASC");
        while ($data_t = mysqli_fetch_array($query_teknisi)) {
        ?>
            <option value="<?php echo $data_t['id']; ?>"><?php echo $data_t['nama_nasabah'] . " - " . $data_t['nik']; ?></option>
        <?php } ?>
    </select>
</div>
<div class="form-group">
    <label>Jenis Tabungan</label>
    <div id="option_tabungan">
        <select required class="form-control select2" style="width:100%">
            <option value="">...</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label>Tanggal Transaksi</label>
    <input type="date" name="tgl_transaksi" required id="tgl_transaksi" class="form-control" />
</div>
<div class="form-group">
    <label>Nominal</label>
    <input type="text" name="nominal" id="nominal" required class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
</div>
<div class="form-group">
    <label>Keterangan</label>
    <input type="text" name="keterangan" id="keterangan" required class="form-control" />
</div>
<input type="hidden" name="setor_ambil" id="setor_ambil" value="1" />
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

<script>
    function pilihTabungan(value) {
        $.get("data/pilih_tabungan.php", {nasabah_id : value},
            function (data, textStatus, jqXHR) {
                $('#option_tabungan').html(data);   
            }
        );
    }
</script>