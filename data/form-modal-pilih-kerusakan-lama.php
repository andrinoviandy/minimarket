<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
?>
<form method="post" onsubmit="pilihNoSeri(); return false;" id="formPilih">
    <div class="modal-body">
        <p align="justify">
            <input type="hidden" name="id_lapor" value="<?php echo $_GET['id_lapor'] ?>" />
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
            <label>Nama Alkes</label>
            <select name="id_akse" id="id_akse" class="form-control select2" autofocus="autofocus" required onchange="changeValue(this.value)" style="width:100%">
                <option value="">...</option>
                <?php
                $q = mysqli_query($koneksi, "select *,tb_laporan_kerusakan_cs_detail.id as id_lapor,alat_pelatihan.id as idd,pembeli_id as id_rumkit from barang_teknisi,barang_teknisi_detail,barang_teknisi_detail_teknisi, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli, tb_teknisi,alat_uji_detail,alat_pelatihan,tb_laporan_kerusakan_cs_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and alat_uji_detail.id=alat_pelatihan.alat_uji_detail_id and barang_gudang.id=tb_laporan_kerusakan_cs_detail.barang_gudang_id and pembeli.id=" . $_GET['id'] . " and alat_pelatihan.id not in (select tb_laporan_kerusakan_detail.alat_pelatihan_id from tb_laporan_kerusakan_detail, tb_laporan_kerusakan_cs, tb_laporan_kerusakan_cs_detail where tb_laporan_kerusakan_cs.id =tb_laporan_kerusakan_cs_detail.tb_laporan_kerusakan_cs_id and tb_laporan_kerusakan_cs_detail.id = tb_laporan_kerusakan_detail.tb_laporan_kerusakan_cs_detail_id and tb_laporan_kerusakan_cs.pembeli_id = ".$_GET['id'].")");
                $jsArray = "var dtBrg = new Array();
              ";
                while ($d = mysqli_fetch_array($q)) { ?>
                    <option value="<?php echo $d['idd']; ?>"><?php echo $d['nama_brg'] . " / " . $d['no_seri_brg']; ?></option>
                <?php
                    $jsArray .= "dtBrg['" . $d['idd'] . "'] = {
						id_lapor:'" . addslashes($d['id_lapor']) . "',
						no_akse:'" . addslashes($d['no_seri_brg']). "',
						tgl_garansi_habis:'" . addslashes(date("d-m-Y", strtotime($d['tgl_garansi_habis']))) . "'
						};";
                } ?>
            </select>
            <br /><br />
            <input id="id_lapor" name="id_lapor" class="form-control" type="hidden" placeholder="" size="5" />
            <label>No Seri</label>
            <input id="no_akse" name="no_akse" class="form-control" type="text" placeholder="No Seri" disabled="disabled" size="5" />
            <br />
            <label>Tanggal Garansi Habis</label>
            <input id="tgl_garansi_habis" name="tgl_garansi_habis" class="form-control" type="text" placeholder="Garansi" readonly="readonly" size="5" />
            <br />
            <label>Kategori</label>
            <select id="" name="id_kategori" required class="form-control select2" style="width:100%">
                <option value="">--Pilih--</option>
                <?php $query3 = mysqli_query($koneksi, "select * from kategori_job order by id ASC");
                while ($data = mysqli_fetch_array($query3)) { ?>
                    <option value="<?php echo $data['id']; ?>"><?php echo $data['nama_job']; ?></option>
                <?php } ?>
            </select>
            <br /><br />
            <label>Detail Permasalahan</label>
            <textarea required="required" name="problem" class="form-control" cols="" rows="3"></textarea>
            <br />
            <label>Teknisi</label>
            <select name="teknisi" class="form-control select2" required style="width:100%">
                <option value="">...</option>
                <?php
                $query_teknisi = mysqli_query($koneksi, "select * from tb_teknisi order by nama_teknisi ASC");
                while ($data_t = mysqli_fetch_array($query_teknisi)) {
                ?>
                    <option value="<?php echo $data_t['id']; ?>"><?php echo $data_t['nama_teknisi'] . " - " . $data_t['bidang']; ?></option>
                <?php } ?>
            </select>
        </p>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button name="tambah" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah</button>
    </div>
</form>
<script type="text/javascript">
    <?php
    echo $jsArray;
    ?>

    function changeValue(id_akse) {
        //document.getElementById('tipe_akse').value = dtBrg[id_akse].tipe_akse; 
        //document.getElementById('merk_akse').value = dtBrg[id_akse].merk_akse;
        document.getElementById('id_lapor').value = dtBrg[id_akse].id_lapor;
        document.getElementById('no_akse').value = dtBrg[id_akse].no_akse;
        document.getElementById('tgl_garansi_habis').value = dtBrg[id_akse].tgl_garansi_habis;

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