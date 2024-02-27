<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<form method="post" enctype="multipart/form-data" onsubmit="simpanAlkes(); return false;">
    <div class="modal-body">
        <label>Alkes</label>
        <select name="id_akse" id="id_akse" class="form-control select2" required onchange="changeValue(this.value); getNoSeri(this.value);" style="width: 100%;">
            <option value="">...</option>
            <?php
            $q = mysqli_query($koneksi, "select *,barang_gudang.id as idd, barang_demo_qty.id as id_qty from barang_gudang,barang_demo_qty where barang_gudang.id=barang_demo_qty.barang_gudang_id and barang_demo_id=" . $_GET['id'] . " group by barang_demo_qty.id order by nama_brg ASC");
            $jsArray = "var dtBrg = new Array();
            ";
            while ($d = mysqli_fetch_array($q)) { ?>
                <option value="<?php echo $d['idd']; ?>"><?php echo $d['nama_brg']; ?></option>
            <?php
                $jsArray .= "dtBrg['" . $d['idd'] . "'] = {tipe_akse:'" . addslashes($d['tipe_brg']) . "',
						merk_akse:'" . addslashes($d['id_qty']) . "',
						merk_akse2:'" . addslashes($d['merk_brg']) . "',
						id_qty:'" . addslashes($d['id_qty']) . "',
						harga:'" . addslashes("Rp " . number_format($d['harga_satuan'], 2, ',', '.')) . "',
						no_akse:'" . addslashes($d['nie_brg']) . "'
						};";
            } ?>
        </select>
        <br />
        <br />
        <label>Tipe</label>
        <input id="tipe_akse" name="tipe_akse" class="form-control" type="text" placeholder="Tipe" disabled="disabled" />
        <br />
        <label>Merk</label>
        <input id="merk_akse" name="merk_akse" class="form-control" type="hidden" placeholder="Merk" />
        <input id="merk_akse2" name="merk_akse2" class="form-control" type="text" disabled="disabled" placeholder="Merk" />
        <br />
        <label>NIE</label>
        <input id="no_akse" name="no_akse" class="form-control" type="text" placeholder="NIE" disabled="disabled" />
        <br />
        <label>No Seri</label>
        <div id="noseri-demo">
            <select class="form-control select2"></select>
        </div>
        <script type="text/javascript">
            <?php
            echo $jsArray;
            ?>

            function changeValue(id_akse) {
                document.getElementById('tipe_akse').value = dtBrg[id_akse].tipe_akse;
                document.getElementById('merk_akse').value = dtBrg[id_akse].merk_akse;
                document.getElementById('merk_akse2').value = dtBrg[id_akse].merk_akse2;
                document.getElementById('no_akse').value = dtBrg[id_akse].no_akse;
                // document.getElementById('harga').value = dtBrg[id_akse].harga;
                // document.getElementById('id_qty').value = dtBrg[id_akse].id_qty;
            };

            function getNoSeri(id) {
                $.get("data/noseri-demo.php", {
                        id: id
                    },
                    function(data) {
                        $('#noseri-demo').html(data);
                    }
                );

            }
        </script>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="simpan_tambah_aksesoris">Simpan</button>
    </div>
</form>
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