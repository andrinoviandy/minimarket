<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select * from biaya_lain,buku_kas,keuangan,keuangan_detail where buku_kas.id=biaya_lain.buku_kas_id and keuangan.id=biaya_lain.keuangan_id and keuangan.id=keuangan_detail.keuangan_id and biaya_lain.id=" . $_GET['id_ubah'] . ""));
?>
<input name="id_ubah" value="<?php echo $_GET['id_ubah']; ?>" type="hidden">
<label>Jenis Transaksi</label>
<select required name="jenis_transaksi" class="form-control select2" style="width:100%">
    <option value="">...</option>
    <option <?php if ($data['jenis_transaksi'] == 'Penerimaan') {
                echo "selected";
            } ?> value="Penerimaan">Penerimaan</option>
    <option <?php if ($data['jenis_transaksi'] == 'Pembayaran') {
                echo "selected";
            } ?> value="Pembayaran">Pembayaran</option>
</select>
<br /><br />
<label>Tanggal</label>
<input name="tanggal" class="form-control" type="date" placeholder="" value="<?php echo $data['tgl']; ?>" required="required"><br />
<label>Akun Bank / Kas</label>
<select name="buku_kas_id" class="form-control select2" style="width:100%" required>
    <option value="">...</option>
    <?php $query = mysqli_query($koneksi, "SELECT id,nama_akun FROM buku_kas");
    while ($row = mysqli_fetch_array($query)) {
    ?>
        <option <?php if ($data['buku_kas_id'] == $row['id']) {
                    echo "selected";
                } ?> value="<?php echo $row['id']; ?>"><?php echo $row['nama_akun']; ?></option>
    <?php } ?>
</select>
<br /><br />
<label>Diterima Oleh / Diterima Dari</label>
<input name="penerima" class="form-control" type="text" placeholder="" value="<?php echo $data['penerima']; ?>"><br />
<label>Akun COA</label>
<div class="well">
    <select required name="coa_id" class="form-control select2" id="coa_id" style="width: 100%;" onchange="pilih22(this.value)">
        <option value="">...</option>
        <?php $query1 = mysqli_query($koneksi, "SELECT * FROM coa");
        while ($row1 = mysqli_fetch_array($query1)) {
        ?>
            <option <?php if ($data['coa_id'] == $row1['id']) {
                        echo "selected";
                    } ?> value="<?php echo $row1['id'] ?>"><?php echo $row1['nama_grup']; ?></option>
        <?php } ?>
    </select><br />
    <br />
    <div id="pilih22">
        <select required name="coa_sub_id2" class="form-control select2" id="coa_sub_id2" style="width: 100%;">
            <option value="">...</option>
        </select>
    </div>
    <br>
    <div id="pilih33">
        <select name="coa_sub_akun_id2" class="form-control select2" style="width:100%" id="coa_sub_akun_id2">
            <option value="">...</option>
        </select>
    </div>
    <!-- <script src="jquery-1.10.2.min.js"></script> -->
    <!-- <script src="jquery.chained.min.js"></script>
    <script>
        $("#coa_sub_id").chained("#coa_id");
        $("#coa_sub_akun_id").chained("#coa_sub_id");
    </script> -->
</div>
<label>Deskripsi</label>
<textarea name="deskripsi" class="form-control" rows="4"><?php echo $data['deskripsi']; ?></textarea><br />
<label>Harga</label>
<input name="harga" class="form-control" type="text" placeholder="" value="<?php echo number_format($data['harga'], 0, ',', '.'); ?>" required="required" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
<script>
    function pilih22(id) {
        $.get("data/pilih22.php", {
                id: id,
                id2: <?php echo $data['coa_sub_id']; ?>
            },
            function(data) {
                $('#pilih22').html(data);
            }
        );
    }

    function pilih33(id) {
        $.get("data/pilih33.php", {
                id: id,
                id2: <?php echo $data['coa_sub_akun_id']; ?>
            },
            function(data) {
                $('#pilih33').html(data);
            }
        );
    }
    $(document).ready(function() {
        $.get("data/pilih22.php", {
                id: <?php echo $data['coa_id']; ?>,
                id2: <?php echo $data['coa_sub_id']; ?>
            },
            function(data) {
                $('#pilih22').html(data);
            }
        );
        $.get("data/pilih33.php", {
                id: <?php echo $data['coa_sub_id']; ?>,
                id2: <?php echo $data['coa_sub_akun_id']; ?>
            },
            function(data) {
                $('#pilih33').html(data);
            }
        );
    });
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