<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$que2 = mysqli_query($koneksi, "select * from barang_dijual where status_deal=1 and id='" . $_GET['id'] . "' order by id ASC");
$dt = mysqli_fetch_array($que2);
?>
<div class="table-responsive">
    <table width="100%" id="example1" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th valign="bottom">No</th>
                <th valign="bottom"><strong>Kategori</strong></th>
                <th valign="bottom"><strong>Nama Alkes</strong></th>
                <th align="center" valign="bottom"><strong>Tipe
                    </strong></th>
                <th align="center" valign="bottom"><strong>Satuan
                    </strong></th>
                <th align="center" valign="bottom"><strong>Harga Jual</strong></th>
                <th align="center" valign="bottom"><strong>Qty</strong></th>
                <th valign="bottom" align="right"><strong>Total</strong></th>
                <th align="right" valign="bottom"><strong>Ongkir Per Barang</strong></th>
            </tr>
        </thead>
        <?php
        $no = 0;
        $q_akse = mysqli_query($koneksi, "select barang_dijual_qty.*, barang_gudang.*, barang_dijual_qty.id as idd from barang_dijual_qty,barang_gudang,barang_dijual where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and status_deal=1 and barang_dijual_id=" . $_GET['id'] . "");
        $jm = mysqli_num_rows($q_akse);
        if ($jm != 0) {
            while ($data_akse = mysqli_fetch_array($q_akse)) {
                $no++;
        ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td align="left"><?php echo $data_akse['kategori_brg']; ?>
                    </td>
                    <td align="left"><?php echo $data_akse['nama_brg']; ?>
                    </td>
                    <td align="left"><?php echo $data_akse['tipe_brg']; ?></td>
                    <td align="left"><?php echo $data_akse['satuan']; ?>
                        <?php
                        if ($data_akse['satuan_header'] != '') {
                            echo "<br>(" . $data_akse['jumlah_rincian_to_satuan'] . " " . $data_akse['satuan'] . "=1 " . $data_akse['satuan_header'] . ")";
                        }
                        ?>
                    </td>
                    <td align="left"><?php echo "Rp" . number_format($data_akse['harga_jual_saat_itu'], 2, ',', '.'); ?></td>
                    <td align="center"><?php echo $data_akse['qty_jual']; ?></td>
                    <td align="right"><?php echo "Rp" . number_format($data_akse['harga_jual_saat_itu'] * $data_akse['qty_jual'], 2, ',', '.'); ?></td>
                    <td align="right" bgcolor="#FFFF00"><?php echo "Rp" . number_format($data_akse['okr'], 2, ',', '.'); ?></td>
                </tr>
        <?php }
        } else {
            echo "<tr><td colspan='9' align='center'>Tidak Ada Data</td></tr>";
        } ?>
        <tr bgcolor="#009900">
            <td colspan="9"></td>
        </tr>
        <tr>
            <td colspan="7" align="right"><strong> Total</strong></td>
            <td align="right"><?php
                                $total1 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty_jual*harga_satuan) as total1 from barang_gudang,barang_dijual_qty where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual_id=" . $dt['id'] . ""));
                                echo number_format($total1['total1'], 2, ',', '.');
                                ?></td>
            <td align="center" bgcolor="#FFFF00"></td>
        </tr>
        <tr>
            <td colspan="7" align="right">Total Ongkir
                <!-- <button type="button" data-toggle="modal" data-target="#modal-ongkir1" class="btn btn-info btn-xs"><span class="fa fa-edit"></span></button> -->
                <!-- <button type="button" onclick="openModalLainnya();" class="btn btn-info btn-xs"><span class="fa fa-edit"></span></button> -->
            </td>
            <td align="right" bgcolor="#FFFF00"><?php
                                                $data3 = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dijual where id=" . $dt['id'] . ""));
                                                echo number_format($data3['ongkir'], 2, ',', '.'); ?></td>
            <td align="center" bgcolor="#FFFF00"></td>
        </tr>
        <!--
                              <tr>
                                <td colspan="7" align="right"><strong>DPP</strong></td>
                                <td align="right"><?php echo number_format($data['dpp'], 2, ',', '.'); ?></td>
                                <td align="center"></td>
                              </tr>
                              -->
        <tr>
            <td colspan="7" align="right">DPP ((Total + Ongkir) /1.1)</td>
            <td align="right">
                <?php

                $dpp = ($data3['ongkir'] + $total1['total1']) / 1.1;
                echo number_format($dpp, 2, ',', '.');

                ?>
            </td>
            <td align="center"></td>
        </tr>
        <tr>
            <td colspan="7" align="right">PPN (<?php echo $data3['ppn_jual'] . "%"; ?>)
                <!-- <button type="button" onclick="openModalLainnya();" class="btn btn-info btn-xs"><span class="fa fa-edit"></span></button> -->
            </td>
            <td align="right">
                <?php
                $ppn = ($dpp) * $data3['ppn_jual'] / 100;
                echo number_format($ppn, 2, ',', '.');
                ?>
            </td>
            <td align="center"></td>
        </tr>
        <tr>
            <td colspan="7" align="right">PPh (<?php echo $data3['pph'] . "%"; ?>)
                <!-- <button type="button" onclick="openModalLainnya();" class="btn btn-info btn-xs"><span class="fa fa-edit"></span></button> -->
            </td>
            <td align="right"><?php
                                $pph = ($dpp) * $data3['pph'] / 100;
                                echo number_format($pph, 2, ',', '.');
                                ?></td>
            <td align="center"></td>
        </tr>

        <tr>
            <td colspan="7" align="right">Zakat (<?php echo $data3['zakat'] . "%"; ?>)
                <!-- <button type="button" onclick="openModalLainnya();" class="btn btn-info btn-xs"><span class="fa fa-edit"></span></button> -->
            </td>
            <td align="right"><?php $zakat = $dpp * $data3['zakat'] / 100;
                                echo number_format($dpp * $data3['zakat'] / 100, 2, ',', '.'); ?></td>
            <td align="center"></td>
        </tr>
        <tr>
            <td colspan="7" align="right">Biaya Bank
                <!-- <button type="button" onclick="openModalLainnya();" class="btn btn-info btn-xs"><span class="fa fa-edit"></span></button> -->
            </td>
            <td align="right"><?php echo number_format($data3['biaya_bank'], 2, ',', '.'); ?></td>
            <td align="center"></td>
        </tr>
        <tr>
            <td colspan="7" align="right" valign="bottom">
                <h4><strong>Neto (DPP(Dengan Ongkir)-(PPN dari DPP(Dengan Ongkir)+PPh dari DPP(Dengan Ongkir)+Zakat dari DPP(Dengan Ongkir)+Biaya Bank)</strong>)</h4>
            </td>
            <td align="right" valign="bottom">
                <h4><strong>
                        <?php
                        $total2 = $dpp - ($ppn + $pph + $zakat + $data3['biaya_bank']);
                        echo number_format($total2, 2, ',', '.'); ?>
                    </strong></h4>
            </td>
            <td align="center"></td>
        </tr>
        <tr>
            <td colspan="7" align="right">Diskon (<?php echo $data3['diskon_jual'] . "%"; ?>)
                <!-- <button type="button" onclick="openModalLainnya();" class="btn btn-info btn-xs"><span class="fa fa-edit"></span></button> -->
            </td>
            <td align="right"><?php
                                $diskon = $data3['diskon_jual'];
                                echo $diskon . "%";
                                ?></td>
            <td align="center"></td>
        </tr>
        <tr>
            <td colspan="7" align="right" valign="bottom"><strong>Fee Supplier (DPP(Tanpa Ongkir)-(PPh dari DPP(Tanpa Ongkir)+Zakat dari DPP(Tanpa Ongkir)+Biaya Bank)</strong>)<strong>*Diskon</strong></td>
            <td align="right" valign="bottom">
                <?php
                $dpp_m = ($total1['total1'] / 1.1);
                //$ppn_m = $dpp_m*$data['ppn_jual']/100;
                $pph_m = $dpp_m * $data3['pph'] / 100;
                $zakat_m = $dpp_m * $data3['zakat'] / 100;
                $biaya_bank_m = $data3['biaya_bank'];
                $fee_marketing = ($dpp_m - ($pph_m + $zakat_m + $biaya_bank_m)) * ($diskon / 100);
                echo "Rp" . number_format($fee_marketing, 2, ',', '.'); ?>
            </td>
            <td align="center"></td>
        </tr>
    </table>
    <!-- Modal-->
</div>