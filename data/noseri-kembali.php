<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<select name="no_seri" id="no_seri" class="form-control select2" required style="width:100%">
    <option value="">...</option>
    <?php
    $q_seri = mysqli_query($koneksi, "select *,barang_demo_kirim_detail.id as idd from pembeli,barang_demo,barang_demo_kirim,barang_demo_kirim_detail,barang_demo_qty,barang_gudang_detail where pembeli.id=barang_demo.pembeli_id and barang_demo.id=barang_demo_qty.barang_demo_id and barang_demo_qty.id=barang_demo_kirim_detail.barang_demo_qty_id and barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_demo_kirim.id=" . $_GET['id'] . " and status_kembali=0 order by no_seri_brg ASC");
    while ($d_seri = mysqli_fetch_array($q_seri)) {
    ?>
        <option id="no_seri" value="<?php echo $d_seri['idd']; ?>" class="<?php echo $d_seri['barang_gudang_id']; ?>"><?php echo $d_seri['no_seri_brg'] . " / " . $d_seri['nama_set']; ?></option>
    <?php } ?>
</select>
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