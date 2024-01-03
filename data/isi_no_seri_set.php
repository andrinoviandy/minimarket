<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select tipe_brg, merk_brg from barang_gudang where id = $_GET[idd]"));
$data_j = mysqli_fetch_array(mysqli_query($koneksi, "select qty_jual from barang_dijual_qty where id = $_GET[id_qty]"));
$data_k = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(DISTINCT *) as jml from barang_dikirim_detail where barang_dijual_qty_id = $_GET[id_qty] and kategori_brg = 'Set'"));
$data_hash = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_dikirim_detail_hash where barang_dijual_qty_id = $_GET[id_qty] and kategori_brg = 'Set'"));
?>
<label>Kategori</label>
<input id="kategori_brg" name="kategori_brg" class="form-control" type="text" placeholder="Kategori" value="<?php echo $_GET['kategori'] ?>" readonly />
<br />
<label>Tipe / Merk</label>
<input class="form-control" type="text" placeholder="" disabled="disabled" value="<?php echo $data['tipe_brg'] . " / " . $data['merk_brg'] ?>" />
<input id="id_qty" name="id_qty" class="form-control" type="hidden" value="<?php echo $_GET['id_qty']; ?>" readonly placeholder="Merk" />
<br />
<div class="row no-padding">
    <div class="col-lg-6">
        <label>Jumlah Dijual</label>
        <input id="jumlah_jual" name="jumlah_jual" class="form-control" type="number" value="<?php echo $data_j['qty_jual'] ?>" readonly />
    </div>
    <div class="col-lg-6">
        <label>Sisa Kirim</label>
        <input id="sisa_kirim" name="sisa_kirim" class="form-control" type="number" value="<?php echo $data_j['qty_jual'] - $data_k['jml']-$data_hash['jml'] ?>" readonly />
    </div>
</div>
<br />
<label>Jumlah Dikirim (Set)</label>
<input id="jumlah_kirim" name="jumlah_kirim" class="form-control" required onchange="cekJumlahKirimAkse();" placeholder="Jumlah Kirim" type="number" />
<br>
<label>Keterangan</label>
<p align="justify">
    Pemilihan No Seri Rincian Barang Set Ini Akan Otomatis Dilakukan Oleh Sistem. Silakan Pilih Metode Pemilihan No Seri Yang Diinginkan : <br>
<div class="form-group" id="metode-pilih-rincian">
    <label class="col-lg-6 no-padding">
        <input type="radio" name="r4" id="terlama" onclick="metodePilihRincian()" value="0" class="flat-red" checked style="width: 20px;">
        Dari Data Yang Terlama
    </label>
    <label class="col-lg-6">
        <input type="radio" name="r4" id="terbaru" onclick="metodePilihRincian()" value="1" class="flat-red" style="width: 20px;">
        Dari Data Yang Terbaru
    </label>
    <br>
</div>
</p>
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