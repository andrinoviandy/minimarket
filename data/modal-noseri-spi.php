<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<label>Pilih No Seri</label>
<div class="form-group" id="metode-pilih">
    <label class="col-lg-6 no-padding">
        <input type="radio" name="r3" id="manual" onclick="metodePilih()" value="0" class="flat-red" checked style="width: 20px;">
        Tidak Semua (Pilih Manual)
    </label>
    <label class="col-lg-6">
        <input type="radio" name="r3" id="semua" onclick="metodePilih()" value="1" class="flat-red" style="width: 20px;">
        Semua
    </label>
    <br>
</div>
<select name="no_seri" id="no_seri" class="form-control select2" multiple="multiple" style="width:100%">
    <?php
    $q_seri = mysqli_query($koneksi, "select *,barang_dikirim_detail.id as idd from barang_dikirim_detail, barang_dikirim,barang_gudang,barang_gudang_detail where barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_detail.status_spi=0 and barang_dikirim_detail.id not in (select barang_dikirim_detail_id from barang_teknisi_hash where akun_id = " . $_SESSION['id'] . ") and barang_dikirim.id=" . $_GET['id_kirim'] . "");
    while ($d_seri = mysqli_fetch_array($q_seri)) {
    ?>
        <option value="<?php echo $d_seri['idd']; ?>">
            <?php echo $d_seri['nama_brg'] . " / " . $d_seri['no_seri_brg']; ?></option>
    <?php } ?>
</select>
<!-- Select2 -->
<script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

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