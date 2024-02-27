<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$data_akse = mysqli_fetch_array(mysqli_query($koneksi, "select *,barang_teknisi.id as idd,barang_gudang.id as id_gudang from barang_teknisi,barang_teknisi_detail,barang_teknisi_detail_teknisi,barang_dikirim,barang_dikirim_detail,pembeli,barang_dijual,barang_gudang,barang_gudang_detail,tb_teknisi where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and barang_teknisi.id=" . $_GET['id'] . " group by barang_gudang.id order by nama_brg ASC"));
?>
<p align="justify">
    <input type="hidden" value="<?php echo $data_akse['idd']; ?>" name="id_ubah" id="id_ubah" />
    <input type="hidden" value="<?php echo $data_akse['id_gudang']; ?>" name="id_gudang" />
    <label>Nama Alkes</label>
    <select name="id_brg" id="id_brg" class="form-control select2" disabled="disabled" autofocus="autofocus" required onchange="changeValue(this.value)" style="width:100%">
        <option value="">--Pilih--</option>
        <option value="all">SEMUA NYA</option>
        <?php
        $q = mysqli_query($koneksi, "select *,barang_gudang.id as idd from barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang,barang_gudang_detail,barang_teknisi,barang_teknisi_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=" . $_GET['id'] . " group by tipe_brg order by barang_dikirim.no_po_jual ASC");
        $jsArray = "var dtBrg = new Array();
                                    ";
        while ($d = mysqli_fetch_array($q)) { ?>
            <option <?php if ($data_akse['id_gudang'] == $d['idd']) {
                        echo "selected";
                    } ?> value="<?php echo $d['idd']; ?>"><?php echo $d['nama_brg'] . " / " . $d['tipe_brg']; ?></option>
        <?php
            $jsArray .= "dtBrg['" . $d['idd'] . "'] = {tgl_kirim:'" . addslashes($d['tgl_kirim']) . "',
                                      nama_pembeli:'" . addslashes($d['nama_pembeli']) . "',
                                      nama_paket:'" . addslashes($d['nama_paket']) . "'
                                      };";
        } ?>
    </select>
    <br><br>
    <label>Teknisi</label>
    <select name="id_teknisi" id="id_teknisi" class="form-control select2" disabled="disabled" required style="width:100%">
        <option value="">...</option>
        <?php
        $q_seri = mysqli_query($koneksi, "select * from tb_teknisi order by nama_teknisi ASC");
        while ($d_seri = mysqli_fetch_array($q_seri)) {
        ?>
            <option <?php if ($data_akse['teknisi_id'] == $d_seri['id']) {
                        echo "selected";
                    } ?> value="<?php echo $d_seri['id']; ?>">
                <?php echo $d_seri['nama_teknisi'] . " / Bidang : " . $d_seri['bidang']; ?></option>
        <?php } ?>
    </select>
    <br><br>
    <label>Estimasi</label>
    <input type="date" name="estimasi" id="" class="form-control" required="required" value="<?php echo $data_akse['estimasi'] ?>" />
    <br>
    <label>Tanggal Berangkat</label>
    <input type="date" name="tgl_berangkat" id="" class="form-control" value="<?php echo $data_akse['tgl_berangkat_teknisi'] ?>" />
    <br>
    <label>Deskripsi</label>
    <input type="text" class="form-control" name="deskripsi" value="<?php echo $data_akse['deskripsi'] ?>" />
</p>
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