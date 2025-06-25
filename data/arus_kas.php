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
        if (!isset($_GET['tglArus1']) && !isset($_GET['tglArus2'])) {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "");
        } else {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "&tglArus1=" . $_GET['tglArus1'] . "&tglArus2=" . $_GET['tglArus2'] . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tglArus1=" . $_GET['tglArus1'] . "&tglArus2=" . $_GET['tglArus2'] . "");
        }
    } else {
        if (!isset($_GET['tglArus1']) && !isset($_GET['tglArus2'])) {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php");
        } else {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&tglArus1=" . $_GET['tglArus1'] . "&tglArus2=" . $_GET['tglArus2'] . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?tglArus1=" . $_GET['tglArus1'] . "&tglArus2=" . $_GET['tglArus2'] . "");
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
                    <th align="center">#</th>
                    <th valign="top"><strong>Tgl Transaksi</strong></th>
                    <th valign="top">No. Transaksi</th>
                    <th valign="top" class="text-nowrap"><strong>Uraian</strong></th>
                    <!-- <th valign="top">Barang</th> -->
                    <th valign="top">Pemasukan</th>
                    <th valign="top">Pengeluaran</th>
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
                            <td align="center">
                                <?php echo $start += 1; ?>
                            </td>
                            <td>
                                <?php echo date("d/m/Y", strtotime($json[$i]['tgl'])); ?>
                            </td>
                            <td><?php echo $json[$i]['no_transaksi']; ?></td>
                            <td>
                                <?php
                                echo $json[$i]['uraian'];
                                ?>
                            </td>
                            <!-- <td>
                                <a href="javascript:void();" onclick="modalBarang('<?php echo $json[$i]['idd']; ?>')">
                                    <button class="btn btn-primary btn-xs">
                                        <span class="fa fa-folder-open"></span>
                                    </button>
                                </a>
                                <?php //} 
                                ?>
                            </td> -->
                            <td align="right"><?php echo $json[$i]['pemasukan'] != '-' ? number_format($json[$i]['pemasukan'], 0, ',', '.') : '-'; ?></td>
                            <td align="right"><?php echo $json[$i]['pengeluaran'] != '-' ? number_format($json[$i]['pengeluaran'], 0, ',', '.') : '-'; ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td align="center" colspan="5">Tidak Ada Data</td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr class="bg-primary">
                    <td align="right" colspan="4"><strong>TOTAL</strong></td>
                    <td valign="top" align="right"><strong><?php echo number_format($json[0]['total_pemasukan'], 0, ',', '.'); ?></strong></td>
                    <td valign="top" align="right"><strong><?php echo number_format($json[0]['total_pengeluaran'], 0, ',', '.'); ?></strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

</body>

</html>