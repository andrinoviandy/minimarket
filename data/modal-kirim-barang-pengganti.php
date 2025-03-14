<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<form method="post" enctype="multipart/form-data">
    <div class="modal-body">
        <label>Pilih No PO / No Surat Jalan</label>
        <select class="form-control select2" id="pilihan" name="no_po" required style="width:100%">
            <option value="">...</option>
            <?php
            $q_no_po = mysqli_query($koneksi, "select *,barang_dikirim.id as idd from barang_dikirim,barang_dikirim_detail where barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and status_batal=1 group by no_pengiriman order by no_po_jual ASC");

            while ($data = mysqli_fetch_array($q_no_po)) { ?>
                <option value="<?php echo $data['idd'] ?>"><?php echo $data['no_po_jual'] . " @ " . $data['no_pengiriman'] ?></option>
            <?php } ?>
        </select>
        <br /><br />
        <label>Nama Paket</label>
        <input type="text" class="form-control" placeholder="" name="nama_paket" required>
        <br />
        <label>No. Surat Jalan</label>
        <input id="input" type="text" placeholder="" name="no_peng" required class="form-control">
        <br /><br />
        <label>Ekspedisi</label>
        <input id="input" type="text" placeholder="" name="ekspedisi" required class="form-control">
        <br /><br />
        <label>Tanggal Pengiriman</label>
        <input id="input" type="date" placeholder="" name="tgl_kirim" required class="form-control">
        <br /><br />
        <label>Via Pengiriman</label>
        <input id="input" type="text" placeholder="" name="via_kirim" required class="form-control">
        <br /><br />
        <label>Estimasi Barang Sampai</label>
        <input id="input" type="date" placeholder="" name="estimasi_brg_sampai" class="form-control">
        <br /><br />
        <label>Biaya Jasa</label>
        <input id="input" type="text" placeholder="" name="biaya_kirim" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="kirim_pengganti">Next</button>
    </div>
</form>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
        // $('.select1').select1()
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