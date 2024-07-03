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
        <table width="100%" id="" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th align="center">#</th>
                    <th align="center" width="5%"><strong>Status PO</strong></th>
                    <th align="center"><strong>Tanggal_Jual</strong></th>
                    <th align="center">No_PO</th>
                    <th align="center">No_Kontrak</th>
                    <!--<th align="center">No_PO</th>-->
                    <th align="center">Barang</th>
                    <th align="center"><strong>Dinas/RS/Puskemas/Klinik</strong></th>
                    <th align="center">Nama_Pemakai</th>
                    <th align="center">Marketing</th>
                    <th align="center">Subdis</th>

                    <th align="center">Total_Harga</th>
                    <th align="center">Ongkir</th>
                    <th align="center">DPP</th>
                    <th align="center">Diskon</th>
                    <th align="center">PPN</th>
                    <th align="center">PPh</th>
                    <th align="center">Zakat</th>
                    <th align="center">Biaya_Bank</th>
                    <th align="center">Neto</th>
                    <th align="center">Fee_Subdis</th>

                    <th align="center">Status_Pengiriman</th>
                    <th align="center">Instalasi<br />Uji_Fungsi</th>
                    <?php if (!isset($_SESSION['adminmanajermarketing'])) { ?>
                        <th align="center" style="padding-left: 20px; padding-right: 20px;"><strong>Aksi</strong></th>
                    <?php } ?>
                </tr>
            </thead>
            <?php
            for ($i = 0; $i < $jml; $i++) {
            ?>
                <tr>
                    <td align="center"><?php echo $start += 1; ?></td>
                    <td><?php $jm_deal = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_dijual where no_po_jual='" . $json[$i]['no_po_jual'] . "' and status_deal=1"));
                        if ($jm_deal['jml'] == 0) {
                            echo "<span class='label bg-red'>Belum Deal</span>";
                        } else {
                            echo "<span class='label bg-green'>Sudah Deal</span>";
                        } ?></td>
                    <td>
                        <?php if ($json[$i]['tgl_jual'] != '0000-00-00') {
                            echo date("d F Y", strtotime($json[$i]['tgl_jual']));
                        }
                        ?>
                    </td>
                    <td><?php echo $json[$i]['no_po_jual'];
                        ?></td>
                    <td><?php echo $json[$i]['no_kontrak'];
                        ?></td>
                    <td>
                        <?php /*if ($_GET['tampil'] == 1) { ?>
                            <?php
                            $jml_deal = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_dijual where status_deal=1 and no_po_jual='" . $json[$i]['no_po_jual'] . "'"));
                            if ($jml_deal['jml'] == 0) {
                                // $d2 = mysqli_fetch_array(mysqli_query($koneksi, "select barang_dijual.id as idd from barang_dijual_qty,barang_dijual,barang_gudang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.no_po_jual='" . $json[$i]['no_po_jual'] . "' order by barang_dijual.id DESC LIMIT 1"));
                                // $q23 = mysqli_query($koneksi, "select *,barang_dijual_qty.id as id_det_jual from barang_dijual_qty,barang_dijual,barang_gudang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.id=" . $d2['idd'] . "");
                                $q23 = mysqli_query($koneksi, "select nama_brg, tipe_brg, qty_jual from barang_dijual_qty,barang_dijual,barang_gudang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.id=" . $json[$i]['idd'] . "");
                                echo "<center><em>Riwayat Terakhir</em></center>";
                            } else {
                                $q23 = mysqli_query($koneksi, "select nama_brg, tipe_brg, qty_jual from barang_dijual_qty,barang_dijual,barang_gudang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.no_po_jual='" . $json[$i]['no_po_jual'] . "' and status_deal=1");
                            }
                            $n2 = 0;
                            while ($d1 = mysqli_fetch_array($q23)) {
                                $n2++;
                            ?>
                                <!-- <?php if ($d1['status_kembali_ke_gudang'] == 1) { ?>
                                    <font class="float-right" size="1px" color="#FF0000">(Kembali Ke Gudang)</font>
                                <?php } ?> -->
                                <?php echo $n2 . ".[" . $d1['nama_brg'] . "]-[" . $d1['tipe_brg'] . "]-[" . $d1['qty_jual'] . "]"; ?>
                                <hr style="margin:0px; border-top:1px double; width:100%" />
                            <?php } ?>
                        <?php } else { */?>
                            <button data-toggle="tooltip" title="Detail Barang" class="btn btn-xs bg-primary" onclick="modalBarang('<?php echo $json[$i]['no_po_jual']; ?>')"><span class="fa fa-folder-open"></span></button>
                        <?php //} ?>
                    </td>
                    <td><a href="javascript:void();" onclick="modalPembeli('<?php echo $json[$i]['pembeli_id'] ?>')" style="color:#060" title="Klik Untuk Lebih Lengkap"><u><?php
                                                                                                                                                                            $data_pem = mysqli_fetch_array(mysqli_query($koneksi, "select pembeli.nama_pembeli, pemakai.nama_pemakai from barang_dijual,pembeli,pemakai where pembeli.id=barang_dijual.pembeli_id and pemakai.id=barang_dijual.pemakai_id and barang_dijual.id=" . $json[$i]['idd'] . ""));
                                                                                                                                                                            echo $data_pem['nama_pembeli']; ?></u></a></td>
                    <td><?php echo $data_pem['nama_pemakai']; ?></td>
                    <td align="center"><?php echo $json[$i]['marketing']; ?></td>
                    <td align="center"><?php echo $json[$i]['subdis']; ?></td>

                    <td><?php
                        $jml_deal = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_dijual where status_deal=1 and no_po_jual='" . $json[$i]['no_po_jual'] . "'"));
                        if ($jml_deal['jml'] == 0) {
                            $data_deal = mysqli_fetch_array(mysqli_query($koneksi, "select total_harga, ongkir, diskon_jual, ppn_jual, pph, zakat, biaya_bank, neto, barang_dijual.id as idd,barang_dijual_qty.id as id_det_jual from barang_dijual_qty,barang_dijual,barang_gudang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.no_po_jual='" . $json[$i]['no_po_jual'] . "' order by barang_dijual.id DESC LIMIT 1"));
                        } else {
                            $data_deal = mysqli_fetch_array(mysqli_query($koneksi, "select total_harga, ongkir, diskon_jual, ppn_jual, pph, zakat, biaya_bank, neto,barang_dijual.id as idd,barang_dijual_qty.id as id_det_jual from barang_dijual_qty,barang_dijual,barang_gudang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.no_po_jual='" . $json[$i]['no_po_jual'] . "' and status_deal=1"));
                        }
                        echo number_format($data_deal['total_harga'], 0, ',', '.'); ?></td>
                    <td><?php echo number_format($data_deal['ongkir'], 0, ',', '.'); ?></td>
                    <td><?php
                        $dpp = $json[$i]['include_dpp'] == 1 ? (($data_deal['total_harga'] + $data_deal['ongkir']) / 1.1) : 0;
                        echo number_format($dpp, 2, ',', '.'); ?></td>
                    <td><?php echo $data_deal['diskon_jual'] . " %"; ?>
                    </td>
                    <td><?php echo $data_deal['ppn_jual'] . " %"; ?><br />
                        <?php 
                        $tot_ppn = $json[$i]['include_dpp'] == 1 ? $dpp : $data_deal['total_harga'];
                        echo "(" . number_format(($data_deal['ppn_jual'] / 100) * ($tot_ppn), 2, ',', '.') . ")"; ?>
                    </td>
                    <td><?php echo $data_deal['pph'] . " %"; ?><br />
                        <?php echo "(" . number_format($data_deal['pph'] / 100 * $dpp, 2, ',', '.') . ")"; ?>
                    </td>
                    <td>
                        <?php echo $data_deal['zakat'] . " %"; ?><br />
                        <?php echo "(" . number_format($data_deal['zakat'] / 100 * $dpp, 2, ',', '.') . ")"; ?></td>
                    <td><?php echo number_format($data_deal['biaya_bank'], 0, ',', '.'); ?></td>
                    <td><strong><?php echo number_format($data_deal['neto'], 0, ',', '.'); ?></strong></td>
                    <td><?php
                        $dpp_m = $data_deal['total_harga'] / 1.1;
                        //$ppn_m = $dpp_m * $json[$i]['ppn_jual']/100;
                        $pph_m = $dpp_m * $data_deal['pph'] / 100;
                        $zakat_m = $dpp_m * $data_deal['zakat'] / 100;
                        $biaya_bank_m = $data_deal['biaya_bank'];
                        $fee = ($dpp_m - ($pph_m + $zakat_m + $biaya_bank_m)) * $data_deal['diskon_jual'] / 100;
                        echo number_format($fee, 0, ',', '.'); ?></td>

                    <td align="center"><?php
                                        $ttl = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_dikirim where no_po_jual = '". $json[$i]['no_po_jual'] . "'"));
                                        $brg_sm = mysqli_fetch_array(mysqli_query($koneksi, "select tgl_sampai from barang_dikirim where barang_dijual_id=" . $data_deal['idd'] . ""));
                                        if ($ttl['jml'] > 0) {
                                            if ($brg_sm['tgl_sampai'] != '0000-00-00') {
                                                echo "<span class='label bg-green'>Sudah Sampai</span><br>";
                                                echo date("d/m/Y", strtotime($brg_sm['tgl_sampai']));
                                            } else {
                                                echo "<span class='label bg-yellow'>Dalam Pengiriman</span>";
                                            }
                                        } else {
                                            echo "<span class='label bg-gray'>Belum Dikirim</span>";
                                        }
                                        ?></td>
                    <td align="center">
                        <button data-toggle="tooltip" title="Detail" class="btn btn-xs bg-primary" onclick="modalInstalasi('<?php echo $json[$i]['no_po_jual']; ?>')"><span class="fa fa-folder-open"></span></button>
                    </td>
                    <?php if (!isset($_SESSION['adminmanajermarketing'])) { ?>
                        <td align="center">
                            <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator']) or isset($_SESSION['user_admin_keuangan']) && isset($_SESSION['pass_admin_keuangan'])) { ?>
                                <!--<a href="pages/delete_barang_jual.php?id_hapus=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"><span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a>&nbsp;-->
                                <?php if ($ttl['jml'] == 0) { ?>
                                    <div class="row">
                                        <a href="index.php?page=ubah_jual_barang_uang&id=<?php echo $json[$i]['idd']; ?>" class="btn btn-xs btn-warning">
                                            <span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span>
                                        </a>&nbsp;
                                        <!-- <a href="index.php?page=jual_barang_uang&id_batal=<?php echo $json[$i]['idd']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Yakin Akan Membatalkan Penjualan Item Ini ? . Proses ini akan berhasil jika bagian gudang belum memilih no seri atau belum ada pembayaran di keuangan !')"> -->
                                        <button class="btn btn-xs btn-danger" onclick="batalkanPenjualan('<?php echo $json[$i]['idd']; ?>')">
                                            <span data-toggle="tooltip" title="Batalkan Penjualan" class="fa fa-close"></span>
                                        </button>
                                    </div>
                                <?php } ?>
                                <?php } ?><?php if (!isset($_SESSION['user_admin_gudang'])) { ?>
                                <!-- <a target="blank" href="cetak_faktur_penjualan_uang.php?id=<?php echo $data_deal['idd']; ?>" class="btn btn-xs btn-primary"> -->
                                <a onclick="modalCetak('<?php echo $data_deal['idd']; ?>')" class="btn btn-xs btn-primary">
                                    <span data-toggle="tooltip" title="Cetak Faktur Penjualan" class="glyphicon glyphicon-print"></span>
                                </a>
                            <?php } ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>