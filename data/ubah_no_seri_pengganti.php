<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
$data_akse = mysqli_fetch_array(mysqli_query($koneksi, "select *,barang_dikirim_detail.id as idd from barang_dikirim_detail,barang_gudang,barang_gudang_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and status_batal=1 and barang_dikirim_detail.id=" . $_GET['id'] . ""));
?>
<input type="hidden" name="barang_dikirim_detail_id" value="<?php echo $data_akse['idd']; ?>" />
<input type="hidden" name="barang_dijual_qty_id" value="<?php echo $data_akse['barang_dijual_qty_id']; ?>" />
<input type="hidden" name="jml_kirim" value="<?php echo $data_akse['jml_kirim']; ?>" />
<input type="hidden" name="kategori_brg" value="<?php echo $data_akse['kategori_brg']; ?>" />
<input type="hidden" name="barang_gudang_set_id" value="<?php echo $data_akse['barang_gudang_set_id']; ?>" />
<input type="hidden" name="barang_gudang_satuan_id" value="<?php echo $data_akse['barang_gudang_satuan_id']; ?>" />
<input type="hidden" name="barang_gudang_akse_id" value="<?php echo $data_akse['barang_gudang_akse_id']; ?>" />

<select name="no_seri" class="form-control select2" style="width:100%" required>
    <option value="">....</option>
    <?php
    $q_seri = mysqli_query($koneksi, "select no_seri_brg,barang_gudang_detail.id as idd from barang_gudang_detail INNER JOIN barang_gudang ON barang_gudang.id=barang_gudang_detail.barang_gudang_id and status_kirim=0 and status_kerusakan=0 and status_demo=0 and barang_gudang_id=" . $data_akse['barang_gudang_id'] . " and barang_gudang_detail.id not in (select barang_gudang_detail_id from barang_dikirim_detail_pengganti_hash where akun_id = '" . $_SESSION['id'] . "') order by no_seri_brg ASC");
    while ($d_seri = mysqli_fetch_array($q_seri)) {
    ?>
        <option value="<?php echo $d_seri['idd']; ?>"><?php echo $d_seri['no_seri_brg']; ?></option>
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