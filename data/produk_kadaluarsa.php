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
    <title>Document</title>
</head>

<body>
    <?php
    $start = $_GET['start'];

    if (isset($_GET['cari'])) {
        $search = str_replace(" ", "%20", $_GET['cari']);
        if (!isset($_GET['expired_to'])) {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "");
        } else {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "&expired_to=" . $_GET['expired_to'] . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&expired_to=" . $_GET['expired_to'] . "");
        }
    } else {
        if (!isset($_GET['expired_to'])) {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php");
        } else {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&expired_to=" . $_GET['expired_to'] . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?expired_to=" . $_GET['expired_to'] . "");
        }
    }
    $json = json_decode($file, true);
    $jml2 = $file2;

    ?>
    <div>
        <em><?php echo "Jumlah Data Yang Ditemukan : " . $jml2 ?></em>
    </div>
    <div class="table-responsive p-0">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th align="center">No</th>
                    <th align="center">Kategori</th>
                    <th valign="top" class="text-nowrap"><strong>Nama Produk</strong></th>
                    <th>Satuan</th>
                    <th>BarCode/QrCode</th>
                    <th align="center" valign="top">Stok Gudang</th>
                    <th>Tanggal Kadaluarsa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($json != null || $json != NULL) {
                    $jml = count($json);
                    for ($i = 0; $i < $jml; $i++) {
                        // if ($json[$i]['status_jual'] == 0) {
                        //     $bg = "bg-danger";
                        // } else {
                        //     $bg = "";
                        // }
                ?>
                        <tr class="<?php echo $bg; ?>">
                            <td align="left"><?php
                                                echo $start += 1;
                                                ?></td>
                            <td>
                                <?php echo $json[$i]['kategori']; ?>
                            </td>
                            <td>
                                <?php echo $json[$i]['nama_produk']; ?>
                            </td>
                            <td>
                                <?php echo $json[$i]['satuan']; ?>
                            </td>
                            <td><?php echo $json[$i]['qrcode']; ?></td>
                            <td><?php echo $json[$i]['stok_masuk']; ?></td>
                            <td class="text-nowrap">
                                <?php echo date("d-m-Y", strtotime($json[$i]['tgl_expired']));
                                if ($json[$i]['sisa_hari'] < 0) {
                                    echo " <font color='red'>[" . str_replace("-","",$json[$i]['sisa_hari']) . " hari yang lalu]</font>";
                                } else {
                                    echo " <font color='green'>[" . str_replace("-","",$json[$i]['sisa_hari']) . " hari lagi]</font>";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td align="center" colspan="6">Tidak Ada Data</td>
                    </tr>
                <?php } ?>
            </tbody>
            <!-- <tfoot>
                <tr class="bg-primary">
                    <td align="right" colspan="8"><strong>TOTAL</strong></td>
                    <td valign="top" align="right"><strong><?php echo number_format($json[0]['total_pemasukan'], 0, ',', '.'); ?></strong></td>
                    <td valign="top" align="right"><strong><?php echo number_format($json[0]['total_pengeluaran'], 0, ',', '.'); ?></strong></td>
                    <td></td>
                </tr>
            </tfoot> -->
        </table>
    </div>

</body>

</html>