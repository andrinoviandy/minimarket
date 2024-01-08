<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
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
    <table width="100%" id="example1" class="table table-bordered">
        <thead>
            <tr>
                <th align="center">#</th>
                <th valign="top"><strong>Tgl PO</strong></th>
                <th valign="top">No PO</th>
                <th valign="top"><strong>Nama Principle</strong></th>
                <th valign="top"><strong>Alamat</strong></th>
                <th valign="top">
                    <table width="100%">
                        <tr>
                            <td>Nama Barang</td>

                            <td style="color:#F00">Qty</td>
                        </tr>
                    </table>
                </th>
                <th align="center" valign="top"><strong>PPN</strong></th>

                <th align="center" valign="top"><strong>Cara Pembayaran (COD/Tempo)</strong></th>
                <th align="center" valign="top"><strong>Alamat Pengiriman</strong></th>
                <th align="center" valign="top"><strong>Jalur Pengiriman</strong> </th>
                <th align="center" valign="top">Estimasi Pengiriman</th>
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
                <td align="center"><?php echo $start += 1; ?></td>
                <td><?php echo date("d/m/Y", strtotime($json[$i]['tgl_po_pesan'])); ?>
                </td>
                <td><?php echo $json[$i]['no_po_pesan']; ?></td>

                <td><?php
                    $sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from principle where id=" . $json[$i]['principle_id'] . ""));
                    echo $sel['nama_principle']; ?></td>
                <td><?php echo $sel['alamat_principle'] . "<br>Telp : " . $sel['telp_principle'] . "<br>Fax : " . $sel['fax_principle'] . "<br>Attn : " . $sel['attn_principle']; ?></td>
                <td>
                    <table width="100%" border="0">
                        <?php
                        $q = mysqli_query($koneksi, "select nama_brg,qty,status_ke_stok from barang_pesan_inventory_detail,barang_inventory where barang_inventory.id=barang_pesan_inventory_detail.barang_inventory_id and barang_pesan_inventory_id=" . $json[$i]['idd'] . "");
                        $n = 0;
                        while ($d1 = mysqli_fetch_array($q)) {
                            $n++;
                            if ($n % 2 == 0) {
                                $col = "#CCCCCC";
                            } else {
                                $col = "#999999";
                            }
                        ?>
                            <tr bgcolor="<?php echo $col; ?>">
                                <td style="padding-left:5px"><?php echo $d1['nama_brg']; ?></td>
                                <td style="padding-left:1px; padding-right:1px; color:#F00"><?php echo $d1['qty']; ?>
                                    <?php if ($d1['status_ke_stok'] == 1) { ?>
                                        <span class="fa fa-share"></span>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </td>
                <td align="center"><?php echo $json[$i]['ppn'] . "%"; ?></td>
                <td align="center"><?php echo $json[$i]['cara_pembayaran']; ?></td>
                <td><?php echo $json[$i]['alamat_pengiriman']; ?></td>
                <td align="center"><?php echo $json[$i]['jalur_pengiriman']; ?></td>
                <td align="center"><?php
                                    if ($json[$i]['estimasi_pengiriman'] != 0000 - 00 - 00) {
                                        echo date("d/m/Y", strtotime($json[$i]['estimasi_pengiriman']));
                                    } ?></td>
                <td align="center">
                    <?php if ($json[$i]['status_po_batal'] == 0) { ?>
                        <?php if (isset($_SESSION['pass_administrator'])) { ?>
                            <a onclick="hapus(<?php echo $json[$i]['idd'] ?>)">
                                <button data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-xs">
                                    <i class="ion-android-delete"></i>
                                </button>
                            </a>
                        <?php } ?>
                        <?php
                        $cek_uang = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_pesan_inventory,utang_piutang_inventory,utang_piutang_inventory_bayar where barang_pesan_inventory.no_po_pesan=utang_piutang_inventory.no_faktur_no_po_inven and utang_piutang_inventory.id=utang_piutang_inventory_bayar.utang_piutang_inventory_id and no_po_pesan='" . $json[$i]['no_po_pesan'] . "'"));
                        if ($cek_uang == 0 and isset($_SESSION['adminpodalam']) or isset($_SESSION['user_administrator'])) {
                        ?>
                            <a href="index.php?page=ubah_pembelian_inventory&id=<?php echo $json[$i]['idd']; ?>">
                                <button class="btn btn-warning btn-xs">
                                    <span data-toggle="tooltip" title="Ubah" class="fa fa-folder-open"></span>
                                </button>

                            </a>
                        <?php } ?>
                        <a href="#" data-toggle="modal" data-target="#modal-cetak-po<?php echo $json[$i]['idd']; ?>">
                            <button class="btn btn-primary btn-xs">
                                <span data-toggle="tooltip" title="Cetak" class="fa fa-print">
                                </span>
                            </button>
                        </a>
                        <!-- <a href="cetak_surat_po_inventory1.php?id=<?php //echo $json[$i]['idd']; 
                                                                        ?>" target="_blank"><span data-toggle="tooltip" title="Cetak 1" class="fa fa-print"></span></a>
                        <a href="cetak_surat_po_inventory2.php?id=<?php //echo $json[$i]['idd']; 
                                                                    ?>" target="_blank"><span data-toggle="tooltip" title="Cetak 2" class="fa fa-print"></span></a> -->
                    <?php
                    } else { ?>
                        <!-- <a href="index.php?page=pembelian_inventory&id_pulih=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda yakin akan memulihkan PO ini ?')"> -->
                        <a onclick="pulihkan(<?php echo $json[$i]['idd']; ?>)" href="#">
                            <small data-toggle="tooltip" title="Pulihkan PO" class="label bg-green">Pulihkan PO</small>
                        </a>
                    <?php if ($json[$i]['deskripsi_batal'] != '') {
                            echo $json[$i]['deskripsi_batal'];
                        }
                    } ?>
                </td>
            </tr>
            <div class="modal fade" id="modal-cetak-po<?php echo $json[$i]['idd']; ?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Cetak PO</h4>
                        </div>
                        <div class="modal-body">
                            <a href="cetak_surat_po_inventory1.php?id=<?php echo $json[$i]['idd']; ?>" target="_blank" class="btn btn-app"><i class="fa fa-print"></i> Format 1</a>
                            <a href="cetak_surat_po_inventory2.php?id=<?php echo $json[$i]['idd']; ?>" target="_blank" class="btn btn-app"><i class="fa fa-print"></i> Format 2</a>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        <?php } ?>
    </table>
</div>