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
        $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "&id_pelanggan=" . $_GET['id_pelanggan'] . "&status_jatuh_tempo=" . $_GET['status_jatuh_tempo'] . "&status_lunas=" . $_GET['status_lunas']);
        $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&id_pelanggan=" . $_GET['id_pelanggan'] . "&status_jatuh_tempo=" . $_GET['status_jatuh_tempo'] . "&status_lunas=" . $_GET['status_lunas']);
    } else {
        $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&id_pelanggan=" . $_GET['id_pelanggan'] . "&status_jatuh_tempo=" . $_GET['status_jatuh_tempo'] . "&status_lunas=" . $_GET['status_lunas']);
        $file2 = file_get_contents($API . "json/$_GET[page].php?id_pelanggan=" . $_GET['id_pelanggan'] . "&status_jatuh_tempo=" . $_GET['status_jatuh_tempo'] . "&status_lunas=" . $_GET['status_lunas']);
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
                    <th valign="top">No. Nota</th>
                    <th valign="top" class="text-nowrap"><strong>Nama Pelanggan</strong></th>
                    <th valign="top">Produk</th>
                    <th align="center" valign="top"><strong>Diskon</strong></th>
                    <th valign="top">Tgl Jatuh Tempo</th>
                    <th align="center" valign="top" class="text-nowrap">Total Piutang</th>
                    <th align="center" valign="top" class="text-nowrap">Sudah Dibayar</th>
                    <th align="center" valign="top" class="text-nowrap">Sisa Piutang</th>
                    <th align="center" valign="top" class="text-nowrap">Jatuh Tempo</th>
                    <th align="center" valign="top" class="text-nowrap">Status</th>
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
                                <?php echo date("d/m/Y", strtotime($json[$i]['tgl_jual'])); ?>
                            </td>
                            <td><?php echo $json[$i]['no_po_jual']; ?></td>
                            <td>
                                <?php
                                if ($json[$i]['nama_siswa'] != '' || $json[$i]['nama_siswa'] != NULL) {
                                    echo $json[$i]['nama_siswa'];
                                }
                                if ($json[$i]['nama_guru'] != '' || $json[$i]['nama_guru'] != NULL) {
                                    echo $json[$i]['nama_guru'];
                                }
                                if ($json[$i]['nama_pelanggan'] != '' || $json[$i]['nama_pelanggan'] != NULL) {
                                    echo $json[$i]['nama_pelanggan'];
                                }
                                ?>
                            </td>
                            <td>
                                <a href="javascript:void();" onclick="modalBarang('<?php echo $json[$i]['idd']; ?>')">
                                    <button class="btn btn-primary btn-xs">
                                        <span class="fa fa-folder-open"></span>
                                    </button>
                                </a>
                                <?php //} 
                                ?>
                            </td>
                            <td><?php echo $json[$i]['diskon_jual'] . "%"; ?></td>
                            <td>
                                <?php echo $json[$i]['tgl_jatuh_tempo'] != null ? date("d/m/Y", strtotime($json[$i]['tgl_jatuh_tempo'])) : '-'; ?>
                            </td>
                            <td><?php echo number_format($json[$i]['total_harga'], 0, ',', '.'); ?></td>
                            <td><?php echo number_format($json[$i]['total_pembayaran'], 0, ',', '.'); ?>
                            </td>
                            <td>
                                <?php
                                // if ($json[$i]['total_pembayaran'] >= $json[$i]['total_harga']) {
                                //     echo "<span class='badge bg-green'>Lunas</span>";
                                // } else {
                                echo number_format($json[$i]['total_harga'] - $json[$i]['total_pembayaran'], 0, ',', '.');
                                // }
                                ?>
                            </td>
                            <td><?php echo $json[$i]['jatuh_tempo']; ?></td>
                            <td>
                                <?php
                                if ($json[$i]['total_pembayaran'] >= $json[$i]['total_harga']) {
                                    echo "<span class='badge bg-green'>Lunas</span>";
                                } else {
                                    echo "<span class='badge bg-red text-nowrap'>Belum Lunas</span>";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td align="center" colspan="11">Tidak Ada Data</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="col-lg-12">
        <div class="pull pull-right">
            <table class="table text-bold">
                <tr>
                    <td>Total Piutang</td>
                    <td> : </td>
                    <td align="right"><?php echo number_format($json[0]['total_harga_all'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>Sudah Dibayar</td>
                    <td> : </td>
                    <td align="right"><?php echo number_format($json[0]['total_pembayaran_all'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>Sisa Piutang</td>
                    <td> : </td>
                    <td align="right"><?php echo number_format($json[0]['total_harga_all'] - $json[0]['total_pembayaran_all'], 0, ',', '.'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>