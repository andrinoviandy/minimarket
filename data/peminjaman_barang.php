<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

</head>

<body>
    <?php
    $start = $_GET['start'];

    if (isset($_GET['cari'])) {
        $search = str_replace(" ", "%20", $_GET['cari']);
        if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
            $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "");
        } else {
            $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
        }
    } else {
        if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
            $file = file_get_contents($API . "json/$_GET[page].php?start=$start");
            $file2 = file_get_contents($API . "json/$_GET[page].php");
        } else {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
        }
    }
    $json = json_decode($file, true);
    $jml = count($json);

    $jml2 = $file2;

    ?>
    <div>
        <em><?php echo "Jumlah Data Yang Ditemukan : " . $jml2 ?></em>
    </div>
    <div class="table-responsive">
        <table width="100%" id="<?php if (isset($_GET['pilihan']) or isset($_GET['tgl_awal'])) {
                                    echo "example1";
                                } else {
                                    echo "example3";
                                } ?>" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th valign="top">No</th>

                    <th valign="top">Tanggal Peminjaman</th>
                    <th valign="top">RS/Dinas/Dll</th>
                    <th valign="top">No. Surat Jalan</th>
                    <th valign="top">Kegiatan</th>
                    <th valign="top">Barang</th>
                    <th valign="top"><strong>Estimasi Pengembalian</strong></th>

                    <!--<th valign="top"><strong>Teknisi</strong></th>-->
                    <th valign="top"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <?php
            // if (isset($_GET['pilihan']) and isset($_GET['kunci'])) {
            //     $file = file_get_contents("http://localhost/ALKES/json/peminjaman_barang.php?pilihan=$_GET[pilihan]&kunci=" . str_replace(" ", "%20", $_GET['kunci']) . "");
            // } elseif (isset($_GET['tgl_awal']) and isset($_GET['tgl_akhir'])) {
            //     $file = file_get_contents("http://localhost/ALKES/json/peminjaman_barang.php?tgl_awal=" . $_GET['tgl_awal'] . "&tgl_akhir=" . $_GET['tgl_akhir'] . "");
            // } else {
            //     $file = file_get_contents("http://localhost/ALKES/json/peminjaman_barang.php");
            // }
            // // membuka file JSON

            // $json = json_decode($file, true);
            // $jml = count($json);
            for ($i = 0; $i < $jml; $i++) {
                //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
                //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
            ?>
                <tr>

                    <td align="center"><?php echo $i + 1; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($json[$i]['tgl_peminjaman'])); ?>
                    </td>
                    <td><?php
                        echo $json[$i]['nama_pembeli']; ?></td>
                    <td><?php
                        echo $json[$i]['no_pengiriman']; ?></td>
                    <td><?php
                        echo $json[$i]['kegiatan']; ?></td>
                    <td>
                        <?php if ($_GET['tampil'] == 1) { ?>
                            <?php
                            $q23 = mysqli_query($koneksi, "select *,barang_pinjam_detail.id as idd from barang_dikirim,barang_dikirim_detail,barang_dijual,pembeli,barang_gudang,barang_gudang_detail,barang_pinjam_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_pinjam_detail.barang_gudang_detail_id and barang_pinjam_id=" . $json[$i]['idd'] . "");
                            $n2 = 0;
                            while ($d1 = mysqli_fetch_array($q23)) {
                                $n2++;
                            ?>
                                <?php echo $n2 . ".[" . $d1['nama_brg'] . "]-[" . $d1['tipe_brg'] . "]-[" . $d1['no_seri_brg'] . "]"; ?>
                                <hr style="margin:0px; border-top:1px double; width:100%" />
                            <?php } ?>
                        <?php } else { ?>
                            <a href="#" data-toggle="modal" data-target="#modal-detailbarang<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Detail Barang" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a>
                        <?php } ?>
                    </td>
                    <td>
                        <?php
                        if ($json[$i]['estimasi_pengembalian'] != '0000-00-00') {
                            echo date("d-m-Y", strtotime($json[$i]['estimasi_pengembalian']));
                        } ?></td>

                    <!--<td><?php
                            $data_tek = mysqli_fetch_array(mysqli_query($koneksi, "select * from tb_teknisi where id=" . $json[$i]['teknisi_id'] . ""));
                            echo $data_tek['nama_teknisi']; ?>
                  <a href="index.php?page=spi&id_tek=<?php echo $json[$i]['teknisi_id']; ?>#open_teknisi"><span data-toggle="tooltip" title="Detail Teknisi" class="fa fa-eye pull pull-left"></span></a>
                  </td>-->
                    <td align="center">
                        <!-- <a href="index.php?page=peminjaman_barang&id_hapus=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"> -->
                        <a href="#" onclick="hapus(<?php echo $json[$i]['idd']; ?>)">
                            <button class="btn btn-xs btn-danger">
                                <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                            </button>
                        </a>
                        <?php
                        $n_cek = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_pinjam_detail where barang_pinjam_id=" . $json[$i]['idd'] . " and status_kirim=0"));
                        if ($n_cek != 0) {
                        ?>
                            <br />
                            <!-- <a href="#" data-toggle="modal" data-target="#modal-kirim<?php echo $json[$i]['idd']; ?>"> -->
                            <a href="javascript:void()" onclick="modalkirim('<?php echo $json[$i]['idd']; ?>')">
                                <small data-toggle="tooltip" title="Kirim" class="label bg-green">Kirim</small>
                            </a>
                        <?php } ?>
                    </td>
                </tr>

                <div class="modal fade" id="modal-detailbarang<?php echo $json[$i]['idd']; ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" align="center">Detail Barang</h4>
                            </div>
                            <form method="post">
                                <div class="modal-body">
                                    <p align="justify">

                                        <?php
                                        $q2 = mysqli_query($koneksi, "select *,barang_pinjam_detail.id as idd from barang_dikirim,barang_dikirim_detail,barang_dijual,pembeli,barang_gudang,barang_gudang_detail,barang_pinjam_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_pinjam_detail.barang_gudang_detail_id and barang_pinjam_id=" . $json[$i]['idd'] . " group by barang_pinjam_detail.id order by nama_brg ASC");
                                        $n = 0;
                                        while ($d1 = mysqli_fetch_array($q2)) {
                                            $n++;
                                        ?>
                                            <?php echo "<b>Nama Barang : </b>" . $d1['nama_brg'] . "<br>"; ?>
                                            <?php echo "<b>Tipe Barang : </b>" . $d1['tipe_brg'] . "<br>" ?>
                                            <?php echo "<b>No Seri : </b>" . $d1['no_seri_brg'] . "<br>"; ?>
                                            <?php if ($d1['tgl_pengembalian'] != 0000 - 00 - 00) {
                                                echo " (Sudah Dikembalikan)";
                                            } ?>
                                            <hr />
                                        <?php } ?>

                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="modal fade" id="modal-detailpengembalian<?php echo $json[$i]['idd']; ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" align="center">Detail Pengembalian</h4>
                            </div>
                            <form method="post">
                                <div class="modal-body">
                                    <p align="justify">

                                        <?php
                                        $q2 = mysqli_query($koneksi, "select *,barang_pinjam_detail.id as idd from barang_dikirim,barang_dikirim_detail,barang_dijual,pembeli,barang_gudang,barang_gudang_detail,barang_pinjam_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_pinjam_detail.barang_gudang_detail_id and barang_pinjam_id=" . $json[$i]['idd'] . " group by barang_pinjam_detail.id order by nama_brg ASC");
                                        $n = 0;
                                        while ($d1 = mysqli_fetch_array($q2)) {
                                            $n++;
                                        ?>
                                            <a href="#" data-toggle="modal" data-target="#modal-inputtanggal<?php echo $d1['idd'] ?>" class="pull pull-right">
                                                <h3><span data-toggle="tooltip" title="Ubah Tanggal Pengembalian" class="fa fa-calendar"></span></h3>
                                            </a>
                                            <?php echo "<b>Nama Barang : </b>" . $d1['nama_brg'] . "<br>"; ?>
                                            <?php echo "<b>Tipe Barang : </b>" . $d1['tipe_brg'] . "<br>" ?>
                                            <?php echo "<b>No Seri : </b>" . $d1['no_seri_brg'] . "<br>"; ?>
                                            <?php echo "<font style='font-size:18px'><b>Tanggal Pengembalian : </b>";
                                            if ($d1['tgl_pengembalian'] != 0000 - 00 - 00) {
                                                echo date("d/M/Y", strtotime($d1['tgl_pengembalian']));
                                            }
                                            echo "</font><br>"; ?>
                                            <hr />

                                    <div class="modal fade" id="modal-inputtanggal<?php echo $d1['idd']; ?>">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" align="center">Input Tanggal Pengembalian Barang</h4>
                                                </div>
                                                <form method="post">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="barang_pinjam_detail_id" value="<?php echo $d1['idd']; ?>" />
                                                        <input type="date" class="form-control" name="tgl_pengembalian" />
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                        <button type="submit" name="simpan_tanggal" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                <?php } ?>

                                </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            <?php } ?>
        </table>
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
</body>

</html>