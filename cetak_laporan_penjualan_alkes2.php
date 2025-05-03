<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Rekapan Penjualan Alkes - " . date("m/Y", strtotime($_GET['month'])) . ".xls");
error_reporting(0);
?>
<?php require("config/koneksi.php"); ?>
<h2 align="center" style="margin-bottom:0px"><strong>PT. CIPTA VARIA KHARISMA UTAMA</strong></h2>
<center style="font-size: 17px">
    Rekapan Penjualan Alkes
    <br />
    Bulan : <?php echo date("m/Y", strtotime($_GET['month'])) ?>
</center>
<br />
<table width="100%" id="" border="1">
    <thead>
        <tr style="font-size: 14px">
            <th align="center">No</th>
            <th align="center">Tanggal</th>
            <th align="center">No. PO/Faktur</th>
            <th align="center">Nama Customer</th>
            <th align="center">Code Barang</th>
            <th align="center">Nama Barang</th>
            <th align="center">Qty</th>
            <th align="center">Harga</th>
            <th align="center">Jumlah</th>
            <th align="center">Disc</th>
            <th align="center">Jumlah Disc</th>
            <th align="center">Total 2</th>
            <th align="center">Keterangan</th>
        </tr>
        <tr>
            <td colspan="13" style="height: 5px; background-color:cadetblue"></td>
        </tr>
    </thead>
    <?php
    // membuka file JSON
    $file = file_get_contents("http://localhost/BANK/json/rekapan_penjualan2.php?month=" . $_GET['month'] . "");

    $json = json_decode($file, true);
    $jml = count($json);
    for ($i = 0; $i < $jml; $i++) {
        //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
        //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
    ?>
        <tr>
            <td align="center" valign="top"><?php echo $i + 1; ?></td>
            <td valign="top">
                <?php if ($json[$i]['tgl_jual'] != '0000-00-00') {
                    echo date("d F Y", strtotime($json[$i]['tgl_jual']));
                }
                ?>
            </td>
            <td valign="top"><?php echo $json[$i]['no_po_jual'];
                                ?></td>
            <td valign="top"><?php echo $json[$i]['nama_pembeli'];
                                ?></td>
            <td colspan="8" valign="top">
                <table border="1">
                    <?php
                    $q23 = mysqli_query($koneksi, "select *,barang_dijual_qty.id as id_det_jual from barang_dijual_qty,barang_dijual,barang_gudang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.no_po_jual='" . $json[$i]['no_po_jual'] . "' and status_deal=1");
                    $n2 = 0;
                    while ($d1 = mysqli_fetch_array($q23)) {
                        $n2++;
                    ?>
                        <tr>
                            <td valign="top" align="center"><?php echo $d1['tipe_brg'] ?></td>
                            <td valign="top"><?php echo $d1['nama_brg'] ?></td>
                            <td valign="top" align="center"><?php echo $d1['qty_jual'] ?>
                            </td>
                            <td valign="top" align="right"><?php echo number_format($d1['harga_jual_saat_itu'], 0, '.', ',') ?></td>
                            <td valign="top" align="right"><?php echo number_format(($d1['qty_jual'] * $d1['harga_jual_saat_itu']), 0, '.', ',') ?></td>
                            <td></td>
                            <td></td>
                            <td valign="top" align="right"><?php echo number_format(($d1['qty_jual'] * $d1['harga_jual_saat_itu']), 0, '.', ',') ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td align="left">PPN</td>
            <td align="center"><?php echo $json[$i]['ppn_jual']; ?></td>
            <td></td>
            <td valign="top" align="right">
                <?php
                $str = explode("-", $_GET['month']);
                $tahunJual = intval($str[0]);
                $bulanJual = intval($str[1]);
                $total = mysqli_fetch_array(mysqli_query($koneksi, "select sum(harga_jual_saat_itu*qty_jual) as total from barang_dijual_qty,barang_dijual where barang_dijual.id=barang_dijual_qty.barang_dijual_id and YEAR(tgl_jual)='$tahunJual' and MONTH(tgl_jual) = '$bulanJual' and no_po_jual = '" . $json[$i]['no_po_jual'] . "' and barang_dijual.status_deal=1"));
                $jumlahPPN = $total['total'] * ($json[$i]['ppn_jual'] / 100);
                echo number_format($jumlahPPN, 0, '.', ',') ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td valign="top" align="right">
                <?php
                echo number_format(($total['total'] + $jumlahPPN), 0, '.', ',') ?>
            </td>
        </tr>
        <tr>
            <td colspan="13" style="height: 5px; background-color:cadetblue"></td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="12" align="center" style="font-size: 20px; font-weight:bold"><strng>TOTAL</strng></td>
        <td align="right" style="font-size: 17px; font-weight:bold">
            <?php
            $str2 = explode("-", $_GET['month']);
            $tahunJual2 = intval($str[0]);
            $bulanJual2 = intval($str[1]);
            $total2 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(harga_jual_saat_itu*qty_jual) as total from barang_dijual_qty,barang_dijual where barang_dijual.id=barang_dijual_qty.barang_dijual_id and YEAR(tgl_jual)='$tahunJual2' and MONTH(tgl_jual) = '$bulanJual2' and barang_dijual.status_deal=1"));
            echo number_format($total2['total'], 0, '.', ',')
            ?>
        </td>
    </tr>
</table>