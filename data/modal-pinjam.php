<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<div class="form-group">
    <label>Nasabah</label>
    <select name="nasabah_id" id="nasabah_id" required class="form-control select2" style="width:100%">
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
    <label>Tanggal Pinjam</label>
    <input type="date" name="tgl_pinjam" required id="tgl_pinjam" class="form-control" />
</div>
<div class="form-group">
    <label>Nominal Pinjam</label>
    <input type="text" name="nominal_pinjam" id="nominal_pinjam" required class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
</div>
<div class="form-group">
    <label>Keterangan</label>
    <input type="text" name="keterangan" id="keterangan" required class="form-control" />
</div>
<div class="form-group">
    <label>Asal Dana</label>
    <select name="buku_kas_id" id="buku_kas_id" class="form-control select2" style="width:100%" required>
        <option value="">...</option>
        <?php $query = mysqli_query($koneksi, "SELECT id,nama_akun FROM buku_kas");
        while ($row = mysqli_fetch_array($query)) {
        ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['nama_akun']; ?></option>
        <?php } ?>
    </select>
</div>
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
    <?php
    echo $jsArray;
    ?>

    function changeValue(id_akse) {
        if (id_akse !== '') {
            $('#ketentuan').html(dtBrg[id_akse].ketentuan);
        } else {
            $('#ketentuan').html('');
        }
    };
</script>