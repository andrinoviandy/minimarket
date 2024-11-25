<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<div class="table-responsive no-padding">
    <table width="100%" id="example1" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pengiriman/Keluar</th>
                <th>No SJ</th>
                <th>Barang (Tipe) / No Seri / Kadaluarsa (Bila Ada)</th>
                <th>Tanggal Sampai</th>
            </tr>
        </thead>
        <?php
        $qq2 = mysqli_query($koneksi, "select * from barang_dikirim where barang_dijual_id='" . $_GET['barang_dijual_id'] . "' order by tgl_kirim asc");
        $jml = mysqli_num_rows($qq2);
        $nn = 0;
        while ($d1 = mysqli_fetch_array($qq2)) {
            $nn++;
        ?>
            <tr>
                <td><?php echo $nn; ?></td>
                <td>
                    <?php
                    if ($d1['tgl_kirim'] != '0000-00-00') {
                        echo date("d/M/Y", strtotime($d1['tgl_kirim']));
                    }
                    ?>
                </td>
                <td><?php echo $d1['no_pengiriman']; ?></td>
                <td style="padding: 0px;">
                    <table width="100%" border="1">
                        <?php
                        $q_brg = mysqli_query($koneksi, "select barang_gudang.nama_brg, barang_gudang.tipe_brg, barang_gudang_detail.no_seri_brg, barang_gudang_detail.tgl_expired, barang_dikirim_detail.status_batal from barang_dikirim_detail inner join barang_gudang_detail on barang_gudang_detail.id = barang_dikirim_detail.barang_gudang_detail_id inner join barang_gudang on barang_gudang.id = barang_gudang_detail.barang_gudang_id where barang_dikirim_detail.barang_dikirim_id = " . $d1['id'] . " order by barang_gudang.nama_brg asc, barang_gudang_detail.no_seri_brg asc");
                        while ($d2 = mysqli_fetch_array($q_brg)) {
                        ?>
                            <tr>
                                <td style="padding: 3px"><?php echo $d2['nama_brg'] . " (" . $d2['tipe_brg'] . ")"; ?></td>
                                <td style="padding: 3px">
                                    <?php echo $d2['no_seri_brg'] !== '' ? $d2['no_seri_brg'] : '-'; ?>
                                    <?php if ($d2['status_batal'] == 1) {
                                        echo '<br><div class="label label-danger">Batal</div>';
                                    } ?>
                                </td>
                                <td style="padding: 3px">
                                    <?php
                                    if ($d2['tgl_expired'] !== '0000-00-00') {
                                        echo date("d/M/Y", strtotime($d2['tgl_expired']));
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </td>
                <td valign="top">
                    <?php
                    if ($d1['tgl_sampai'] != '0000-00-00') {
                        echo date("d/M/Y", strtotime($d1['tgl_sampai']));
                    }
                    ?>
                </td>
            </tr>
        <?php }
        if ($jml == 0) { ?>
            <tr>
                <td colspan="5" align="center">Belum Ada Pengiriman Dari Gudang</td>
            </tr>
        <?php } ?>
    </table>
</div>