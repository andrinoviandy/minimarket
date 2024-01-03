<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start()
?>
<?php
$start = $_GET['start'];

if (isset($_GET['cari'])) {
    $search = str_replace(" ", "%20", $_GET['cari']);
    if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
        $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "");
        $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "");
    } else {
        $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
        $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
    }
} else {
    if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
        $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "");
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
<div class="table-responsive no-padding">
    <table width="100%" id="" class="table table-bordered">
        <thead>
            <tr>
                <td align="center">#</td>
                <th valign="top"><strong>Tgl PO</strong></th>
                <th valign="top">No PO</th>
                <th valign="top"><strong>Principle</strong></th>
                <th valign="top">Barang</th>
                <th align="center" valign="top"><strong>PPN</strong></th>

                <th align="center" valign="top"><strong>Cara Pembayaran (COD/Tempo)</strong></th>
                <th align="center" valign="top"><strong> Pengiriman</strong></th>
                <th align="center" valign="top">Keuangan</th>
                <th align="center" valign="top"><strong>Aksi</strong></th>
            </tr>
        </thead>
        <?php
        for ($i = 0; $i < $jml; $i++) {
            //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
            //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
            if ($json[$i]['status_po_batal'] == 1) {
                $bg = "bg-red";
            } else {
                $bg = "";
            }
        ?>
            <tr class="<?php echo $bg; ?>">
                <td align="center"><?php
                                    echo $start += 1;
                                    ?></td>
                <td><?php echo date("d/m/Y", strtotime($json[$i]['tgl_po_pesan'])); ?>
                </td>
                <td><?php echo $json[$i]['no_po_pesan']; ?></td>

                <td><a href="#" data-toggle="modal" data-target="#modal-principle<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Detail Principle" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a></td>
                <td>
                    <?php if ($_GET['tampil'] == 1) { ?>
                        <?php
                        $q23 = mysqli_query($koneksi, "select nama_brg,tipe_brg,qty,status_ke_stok from barang_pesan_detail,barang_gudang where barang_gudang.id=barang_pesan_detail.barang_gudang_id and barang_pesan_detail.barang_pesan_id=" . $json[$i]['idd'] . "");
                        $n2 = 0;
                        while ($d1 = mysqli_fetch_array($q23)) {
                            $n2++;
                        ?>
                            <?php if ($d1['status_ke_stok'] == 1) { ?>
                                <font class="pull pull-right" size="+1"><span class="fa fa-share"></span></font>
                            <?php } ?>
                            <?php echo $n2 . ".[" . $d1['nama_brg'] . "]-[" . $d1['tipe_brg'] . "]-[" . $d1['qty']; ?>
                            <hr style="margin:0px; border-top:1px double; width:100%" />
                        <?php } ?>
                    <?php } else { ?>
                        <a href="#" data-toggle="modal" data-target="#modal-detailbarang<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Detail Barang" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a>
                    <?php } ?>
                </td>
                <td align="center"><?php echo $json[$i]['ppn'] . "%"; ?></td>
                <td align="center"><?php echo $json[$i]['cara_pembayaran']; ?></td>
                <td><a href="#" data-toggle="modal" data-target="#modal-pengiriman<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Detail Barang" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a></td>
                <td align="center"><?php if ($json[$i]['nilai_tukar'] != 0) {
                                        echo "<i class='fa fa-check'></i>";
                                    } ?></td>
                <td align="center">
                    <?php if ($json[$i]['status_po_batal'] == 0) { ?>
                        <?php if (isset($_SESSION['pass_administrator'])) { ?>
                            <!-- <a href="index.php?page=pembelian_alkes2&id_hapus=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"> -->
                            <a onclick="hapus(<?php echo $json[$i]['idd'] ?>)">
                                <button class="btn btn-danger btn-xs">
                                    <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                                </button>
                            </a>
                        <?php } ?>
                        <?php
                        $cek_uang = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_pesan,utang_piutang,utang_piutang_bayar where barang_pesan.no_po_pesan=utang_piutang.no_faktur_no_po and utang_piutang.id=utang_piutang_bayar.utang_piutang_id and no_po_pesan='" . $json[$i]['no_po_pesan'] . "'"));
                        if ($cek_uang == 0 and isset($_SESSION['adminpoluar']) or isset($_SESSION['user_administrator'])) {
                        ?>
                            <a href="index.php?page=ubah_pembelian_alkes2&id=<?php echo $json[$i]['idd']; ?>">
                                <button class="btn btn-warning btn-xs">
                                    <span data-toggle="tooltip" title="Ubah" class="fa fa-folder-open"></span>
                                </button>
                            </a>
                        <?php } ?>
                        <a href="cetak_surat_po_pemesanan.php?id=<?php echo $json[$i]['idd']; ?>" target="_blank">
                            <button class="btn btn-primary btn-xs">
                                <span data-toggle="tooltip" title="Cetak" class="fa fa-print"></span>
                            </button>
                        </a>
                        <?php
                        //$j_cek = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_pesan_detail,barang_gudang where barang_gudang.id=barang_pesan_detail.barang_gudang_id and barang_pesan_detail.barang_pesan_id=" . $json[$i]['idd'] . " and status_ke_stok=1"));
                        //if ($cek_uang == 0 and $j_cek == 0) { 
                        ?>
                        <!--<a href="index.php?page=pembelian_alkes2&id=<?php echo $json[$i]['idd']; ?>#openBatal"><small data-toggle="tooltip" title="Batalkan PO" class="label bg-red">Batalkan</small></a>-->
                        <!-- <a href="#" data-toggle="modal" data-target="#modal-batalpo<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Batalkan PO" class="label bg-red">Batalkan</small></a> -->
                    <?php //}
                    } else { ?>
                        <!-- <a href="index.php?page=pembelian_alkes2&id_pulih=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda yakin akan memulihkan PO ini ?')"> -->
                        <a onclick="pulihkan(<?php echo $json[$i]['idd']; ?>)" href="#">
                            <small data-toggle="tooltip" title="Pulihkan PO" class="label bg-green">Pulihkan PO</small>
                        </a>
                        <?php if ($json[$i]['deskripsi_batal'] != '') {
                        ?><br /><a href="#" data-toggle="modal" data-target="#modal-pesanbatal<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Lihat Alasan" class="label bg-primary"><span class="fa fa-envelope"></span></small></a><?php
                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                    } ?>
                </td>
            </tr>
            <div class="modal fade" id="modal-pesanbatal<?php echo $json[$i]['idd']; ?>">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Alasan Pembatalan</h4>
                        </div>
                        <form method="post">
                            <div class="modal-body">
                                <p align="justify">
                                    <?php echo $json[$i]['deskripsi_batal']; ?>
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
                                    $q = mysqli_query($koneksi, "select nama_brg,tipe_brg,qty,status_ke_stok from barang_pesan_detail,barang_gudang where barang_gudang.id=barang_pesan_detail.barang_gudang_id and barang_pesan_detail.barang_pesan_id=" . $json[$i]['idd'] . "");
                                    $n = 0;
                                    while ($d1 = mysqli_fetch_array($q)) {
                                        $n++;
                                    ?>
                                        <?php if ($d1['status_ke_stok'] == 1) { ?>
                                            <font class="pull pull-right" size="+1"><span class="fa fa-share"></span></font>
                                        <?php } ?>
                                        <?php echo $n . ". " . $d1['nama_brg'] . "     |    "; ?>
                                        <?php echo $d1['tipe_brg'] . "  |  " ?>
                                        <?php echo $d1['qty'] . "  |  "; ?>

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

            <div class="modal fade" id="modal-principle<?php echo $json[$i]['idd']; ?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" align="center">Data Principle</h4>
                        </div>
                        <form method="post">
                            <div class="modal-body">
                                <p align="justify">
                                    <?php
                                    $sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from principle where id=" . $json[$i]['principle_id'] . ""));
                                    echo "<b>Nama Principle :</b> <br/>" . $sel['nama_principle']; ?>
                                    <hr />
                                    <?php echo "<b>Alamat Principle :</b> <br/>" . $sel['alamat_principle']; ?>
                                    <hr />
                                    <?php echo "<b>Telepon Principle :</b> <br/>" . $sel['telp_principle']; ?>
                                    <hr />
                                    <?php echo "<b>Fax Principle :</b> <br/>" . $sel['fax_principle']; ?>
                                    <hr />
                                    <?php echo "<b>Attn Principle :</b> <br/>" . $sel['attn_principle']; ?>
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

            <div class="modal fade" id="modal-pengiriman<?php echo $json[$i]['idd']; ?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" align="center">Data Pengiriman</h4>
                        </div>
                        <form method="post">
                            <div class="modal-body">
                                <p align="justify">
                                    <?php
                                    echo "<b>Alamat Pengiriman :</b> <br/>" . $json[$i]['alamat_pengiriman']; ?>
                                    <hr />
                                    <?php echo "<b>Jalur Pengiriman :</b> <br/>" . $json[$i]['jalur_pengiriman']; ?>
                                    <hr />
                                    <?php echo "<b>Estimasi Pengiriman :</b> <br/>"; ?>
                                    <?php
                                    if ($json[$i]['estimasi_pengiriman'] != 0000 - 00 - 00) {
                                        echo date("d/m/Y", strtotime($json[$i]['estimasi_pengiriman']));
                                    } ?>
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