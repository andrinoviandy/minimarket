<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<div class="form-group">
    <label>Nasabah</label>
    <select name="pinjaman_id" id="pinjaman_id" required class="form-control select2" style="width:100%">
        <option value="">...</option>
        <?php
        $query_teknisi = mysqli_query($koneksi, "select b.id, a.nama_nasabah, a.nik from nasabah a inner join pinjaman b on a.id = b.nasabah_id and b.flag_lunas = 0 order by a.nama_nasabah ASC");
        while ($data_t = mysqli_fetch_array($query_teknisi)) {
        ?>
            <option value="<?php echo $data_t['id']; ?>"><?php echo $data_t['nama_nasabah'] . " - " . $data_t['nik']; ?></option>
        <?php } ?>
    </select>
</div>
<div class="form-group">
    <label>Tanggal Transaksi</label>
    <input type="date" name="tgl_transaksi" required id="tgl_transaksi" class="form-control" />
</div>
<div class="form-group">
    <label>Angsuran</label>
    <input type="text" name="angsuran" id="angsuran" required class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
</div>
<div class="col-lg-12 no-padding">
    <div class="col-lg-3 no-padding">
        <div class="form-group">
            <label>Persen Bunga (%)</label>
            <input type="text" name="persen_bunga" id="persen_bunga" required class="form-control" onchange="persenBunga(this.value)" />
        </div>
    </div>
    <div class="col-lg-9 no-padding">
        <div class="form-group">
            <label>Nilai Bunga</label>
            <input type="text" name="bunga" id="bunga" required class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
        </div>
    </div>
</div>
<div class="form-group">
    <label>Nominal Bayar</label>
    <input type="text" name="nominal_bayar" id="nominal_bayar" required class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
</div>
<div class="form-group">
    <label>Keterangan</label>
    <input type="text" name="keterangan" id="keterangan" required class="form-control" />
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
    function persenBunga(persen) {
        if (persen.includes(',')) {
            alertCustom('W', 'Gunakan Tanda Titik (.) untuk pecahan desimal !', '')
            $('#persen_bunga').val();
            $('#bunga').val();
            $('#nominal_bayar').val();
        } else {
            let angsuran = $('#angsuran').val();
            let bunga = angsuran.replace(/\./g, '') * persen / 100;
            let nominal_bayar = parseFloat(angsuran.replace(/\./g, '')) + parseFloat(bunga);
            let formatBunga = bunga.toLocaleString('id-ID', {
                maximumFractionDigits: 0
            });
            let formatBayar = nominal_bayar.toLocaleString('id-ID', {
                maximumFractionDigits: 0
            });
            $('#bunga').val(formatBunga);
            $('#nominal_bayar').val(formatBayar);
        }
    }

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

    function pilihTabungan(value) {
        $.get("data/pilih_tabungan.php", {
                nasabah_id: value
            },
            function(data, textStatus, jqXHR) {
                $('#option_tabungan').html(data);
            }
        );
    }
</script>