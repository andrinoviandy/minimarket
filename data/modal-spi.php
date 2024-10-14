<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>

<label>No. PO / No. Surat Jalan <font color="#FF0000">(*Akan Muncul Jika Tanggal Sampai Di Menu Data Pengiriman Alkes Sudah Ada)</font></label>
<span class="form-group">
    <select name="id_akse" id="id_akse" class="form-control select2" autofocus="autofocus" required="required" onchange="changeValue(this.value)" style="width:100%">
        <option>...</option>
        <?php
        $q = mysqli_query($koneksi, "select *,barang_dikirim.id as idd from barang_dikirim,barang_dijual,pembeli,barang_dikirim_detail where barang_dijual.id=barang_dikirim.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and tgl_sampai!='0000-00-00' and status_spi=0 group by barang_dikirim.id order by barang_dikirim.no_pengiriman ASC");
        $jsArray = "var dtBrg = new Array();
              ";
        while ($d = mysqli_fetch_array($q)) { ?>
            <option value="<?php echo $d['idd']; ?>"><?php echo "No. PO : " . $d['no_po_jual'] . " / No. Surat Jalan : " . $d['no_pengiriman']; ?></option>
        <?php
            $jsArray .= "dtBrg['" . $d['idd'] . "'] = {tgl_sampai:'" . addslashes(date("d-m-Y", strtotime($d['tgl_sampai']))) . "',
						nama_pembeli:'" . addslashes($d['nama_pembeli']) . "',
						nama_paket:'" . addslashes($d['nama_paket']) . "'
						};";
        } ?>
    </select>
</span><br /><br />
<label>Tanggal Sampai</label>
<input id="tgl_sampai" name="tgl_sampai" class="form-control" type="text" placeholder="Tgl Sampai" disabled="disabled" size="5" />
<br />
<label>RS/Dinas/Klinik/Dll</label>
<input id="rs" name="rs" class="form-control" type="text" placeholder="RS/Dinas/Dll" disabled="disabled" />
<br />
<label>Nama Paket</label>
<input id="nama_paket" name="nama_paket" class="form-control" type="text" placeholder="Nama Paket" disabled="disabled" />
<br />
<div id="no-seri-spi"></div>

<script type="text/javascript">
    <?php
    echo $jsArray;
    ?>

    function changeValue(id_akse) {
        document.getElementById('tgl_sampai').value = dtBrg[id_akse].tgl_sampai;
        document.getElementById('rs').value = dtBrg[id_akse].nama_pembeli;
        document.getElementById('nama_paket').value = dtBrg[id_akse].nama_paket;
        loading2('#no-seri-spi')
        $.get("data/modal-noseri-spi.php", {
                id_kirim: id_akse
            },
            function(data, textStatus, jqXHR) {
                $('#no-seri-spi').html(data);
            }
        );
    };
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