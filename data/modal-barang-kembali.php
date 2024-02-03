<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<form method="post" enctype="multipart/form-data" id="formTambah" onsubmit="simpanAlkes(); return false;">
    <div class="modal-body">
        <p align="justify">
            <label>Pilih Alkes</label>
            <select name="id_akse" id="id_akse" class="form-control select2" required style="width: 100%;" onchange="changeValue(this.value); getNoSeri(this.value);">
                <option value="">...</option>
                <?php
                $q = mysqli_query($koneksi, "select *,barang_gudang.id as idd from pembeli,barang_demo,barang_demo_kirim,barang_demo_kirim_detail,barang_demo_qty,barang_gudang where pembeli.id=barang_demo.pembeli_id and barang_demo.id=barang_demo_qty.barang_demo_id and barang_demo_qty.id=barang_demo_kirim_detail.barang_demo_qty_id and barang_demo_kirim.id=barang_demo_kirim_detail.barang_demo_kirim_id and barang_gudang.id=barang_demo_qty.barang_gudang_id and barang_demo_kirim.id=" . $_GET['id'] . " group by barang_gudang.id order by tipe_brg ASC");
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
            <br><br>
            <label>Tipe</label>
            <input id="tipe_akse" name="tipe_akse" class="form-control" type="text" placeholder="Tipe" disabled="disabled" />
            <input id="merk_akse" name="merk_akse" class="form-control" type="hidden" placeholder="Merk" />
            <br>
            <label>No Seri</label>
            <font class="pull pull-right" color="#FF0000">
                Jika No Seri Nya Tidak Muncul Berarti Barang Tersebut Sudah Di Kembalikan
            </font>
        <div id="noseri-kembali">
            <select class="form-control select2" style="width: 100%;"><option>...</option></select>
        </div>
        <br>
        <!-- <script src="jquery-1.10.2.min.js"></script>
            <script src="jquery.chained.min.js"></script> -->
        <!-- <script>
                $("#no_seri").chained("#id_akse");
            </script> -->
        <label>Tanggal Kembali</label>
        <input id="tgl_kembali" name="tgl_kembali" required class="form-control" type="date" placeholder="" />
        <br>
        <label>Kondisi Barang</label>
        <select name="kondisi" id="kondisi" class="form-control" required="required">
            <option value="Bagus">Bagus</option>
            <option value="Rusak">Rusak</option>
        </select>
        <br>
        <label>Keterangan</label>
        <input id="keterangan" name="keterangan" class="form-control" type="text" placeholder="" />

        <script type="text/javascript">
            <?php
            echo $jsArray;
            ?>

            function changeValue(id_akse) {
                document.getElementById('tipe_akse').value = dtBrg[id_akse].tipe_akse;
                document.getElementById('merk_akse').value = dtBrg[id_akse].merk_akse;
                // document.getElementById('merk_akse2').value = dtBrg[id_akse].merk_akse2;
                // document.getElementById('no_akse').value = dtBrg[id_akse].no_akse;
                // document.getElementById('harga').value = dtBrg[id_akse].harga;
                // document.getElementById('id_qty').value = dtBrg[id_akse].id_qty;
            };

            function getNoSeri(id) {
                $.get("data/noseri-kembali.php", {
                        id: <?php echo $_GET['id']; ?>
                    },
                    function(data) {
                        $('#noseri-kembali').html(data);
                    }
                );

            }
        </script>
        </p>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button name="simpan_tambah_aksesoris" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah</button>
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