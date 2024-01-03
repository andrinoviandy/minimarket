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
                <th>Nama Barang</th>
                <th>Tipe Barang</th>
                <th>Kuantitas</th>
            </tr>
        </thead>
        <?php
        $jml_deal = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dijual where status_deal=1 and no_po_jual='" . $_GET['no_po_jual'] . "'"));
        if ($jml_deal == 0) {
            $d2 = mysqli_fetch_array(mysqli_query($koneksi, "select *,barang_dijual.id as idd from barang_dijual_qty,barang_dijual,barang_gudang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.no_po_jual='" . $_GET['no_po_jual'] . "' order by barang_dijual.id DESC LIMIT 1"));
            $qq2 = mysqli_query($koneksi, "select *,barang_dijual_qty.id as id_det_jual from barang_dijual_qty,barang_dijual,barang_gudang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.id=" . $d2['idd'] . "");
            echo "<center><em>Riwayat Terakhir</em></center>";
        } else {
            $qq2 = mysqli_query($koneksi, "select *,barang_dijual_qty.id as id_det_jual from barang_dijual_qty,barang_dijual,barang_gudang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.no_po_jual='" . $_GET['no_po_jual'] . "' and status_deal=1");
        }

        $nn = 0;
        while ($d1 = mysqli_fetch_array($qq2)) {
            $nn++;
        ?>
            <tr>
                <td><?php echo $nn; ?></td>
                <td>
                    <?php echo $d1['nama_brg']; ?>
                    <?php if ($d1['status_kembali_ke_gudang'] == 1) { ?>
                        <br>
                        <font class="pull pull-right" size="+1">Kembali Ke Gudang</font>
                    <?php } ?>
                </td>
                <td><?php echo $d1['tipe_brg']; ?></td>
                <td><?php echo $d1['qty_jual']; ?></td>
            </tr>
            <?php
            $qq = mysqli_query($koneksi, "select *,barang_teknisi_detail.id as id_dt from barang_gudang_detail,barang_dikirim_detail,barang_teknisi_detail where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_dikirim_detail.barang_dijual_qty_id=" . $d1['id_det_jual'] . "");
            $m = 0;
            while ($dd = mysqli_fetch_array($qq)) {
                $m++;
                $ds = mysqli_num_rows(mysqli_query($koneksi, "select * from alat_uji_detail where barang_teknisi_detail_id=" . $dd['id_dt'] . ""));
                $dt = mysqli_fetch_array(mysqli_query($koneksi, "select tgl_i,tgl_f from alat_uji_detail where barang_teknisi_detail_id=" . $dd['id_dt'] . ""));
                if ($ds != 0) {
                    if ($dt['tgl_i'] != '0000-00-00') {
                        $tgl_i = date("d/m/Y", strtotime($dt['tgl_i']));
                    } else {
                        $tgl_i = "";
                    }
                    if ($dt['tgl_f'] != '0000-00-00') {
                        $tgl_f = date("d/m/Y", strtotime($dt['tgl_f']));
                    } else {
                        $tgl_f = "";
                    }
                } else {
                    $tgl_i = "-";
                    $tgl_f = "-";
                }
            ?>
                <tr>
                    <td></td>
                    <td colspan="3" style="padding: 0px;">
                        <table class="table no-padding table-bordered">
                            <tr>
                                <td>
                                    <?php echo $nn . "." . $m ?>
                                </td>
                                <td>
                                    <?php
                                    echo $dd['no_seri_brg'];
                                    ?>
                                </td>
                                <td><?php echo "Instalasi : " . $tgl_i; ?></td>
                                <td><?php echo "Uji Fungsi : " . $tgl_f; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    </table>
</div>