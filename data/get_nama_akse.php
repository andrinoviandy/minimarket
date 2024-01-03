<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
?>
<select name="id_akse" id="id_akse" class="form-control select2" required onchange="changeValue(this.value)" style="width:100%">
    <option value="">...</option>
    <?php
    $q = mysqli_query($koneksi, "select id, nama_brg, tipe_brg, nie_brg, merk_brg from barang_gudang where kategori_brg = 'Aksesoris' order by nama_brg ASC");
    $jsArray2 = "var dtBrg = new Array();
            ";
    while ($d = mysqli_fetch_array($q)) { ?>
        <option value="<?php echo $d['id']; ?>"><?php echo $d['nama_brg'] . " - " . $d['tipe_brg']; ?></option>
    <?php
        $stok_total = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_gudang_detail where status_kirim=0 and status_kerusakan=0 and status_kembali_ke_gudang=0 and barang_gudang_id=" . $d['id'] . ""));

        $stok_po1 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty_jual) as stok_po from barang_dijual_qty where barang_gudang_id=" . $d['id'] . ""));
        $stok_po2 = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_dijual_qty.barang_gudang_id=" . $d['id'] . ""));

        $jsArray2 .= "dtBrg['" . $d['id'] . "'] = {tipe_brg:'" . addslashes($d['tipe_brg']) . "',
                        no_akse:'" . addslashes($d['nie_brg']) . "',
						merk_brg:'" . addslashes($d['merk_brg']) . "'
						};";
    } ?>
</select>
<script type="text/javascript">
    <?php
    echo $jsArray2;
    ?>

    function changeValue(id_akse) {
        document.getElementById('tipe_brg').value = dtBrg[id_akse].tipe_brg;
        document.getElementById('merk_brg').value = dtBrg[id_akse].merk_brg;
        document.getElementById('nie_brg').value = dtBrg[id_akse].no_akse;

    };
</script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
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