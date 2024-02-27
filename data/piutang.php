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
    <div class="table-responsive no-padding">
        <table width="100%" id="" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <td width="3%" align="center"><strong>No</strong>
                        </th>
                    <th width="" valign="top">ID</th>
                    <th width="10%" valign="top"><strong>Tanggal </strong></th>
                    <th width="" valign="top">No PO</th>
                    <th width="" valign="top">No_Kontrak</th>
                    <th width="" valign="top">Barang</th>
                    <th width="" valign="top">Klien</th>
                    <th width="" valign="top"><strong>Deskripsi</strong></th>
                    <th width="" valign="top">Nominal</th>
                    <th valign="top">Status</th>
                    <th width="" align="center" valign="top"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <?php
            for ($i = 0; $i < $jml; $i++) {
                $dd = mysqli_fetch_array(mysqli_query($koneksi, "select no_kontrak, (select id from barang_dijual where status_deal = 1 and no_po_jual = '" . $json[$i]['no_faktur_no_po'] . "') as id_jual, (select count(*) over() from barang_dijual where no_po_jual = '" . $json[$i]['no_faktur_no_po'] . "') as jml from barang_dijual where no_po_jual='" . $json[$i]['no_faktur_no_po'] . "'"));
            ?>
                <tr>
                    <td align="center"><?php echo $start += 1; ?></td>
                    <td><?php echo "PI" . $json[$i]['idd']; ?></td>

                    <td>
                        <?php echo date("d M Y", strtotime($json[$i]['tgl_input']));  ?><br />
                        <font style="font-size:11px"><?php if ($json[$i]['jatuh_tempo'] != 0000 - 00 - 00) {
                                                            echo "Jatuh Tempo : " . date("d M Y", strtotime($json[$i]['jatuh_tempo']));
                                                        }  ?></font>
                    </td>
                    <td>
                        <?php echo $json[$i]['no_faktur_no_po']; ?>
                    </td>
                    <td>
                        <?php echo $dd['no_kontrak']; ?>
                    </td>
                    <td><a href="#" onclick="modalDetailBarang('<?php echo $dd['id_jual'] ?>'); return false;"><small data-toggle="tooltip" title="Detail Barang" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a></td>
                    <td><?php echo $json[$i]['klien']; ?></td>
                    <td><?php echo $json[$i]['deskripsi']; ?></td>
                    <?php if ($dd['id_jual'] != '') { ?>
                        <td><?php echo "Rp" . number_format($json[$i]['nominal'], 2, ',', '.'); ?>
                            <hr / style="margin:0px; padding:0px">
                            <font style="font-size:10px">
                                <?php
                                $t_b = mysqli_fetch_array(mysqli_query($koneksi, "select sum(nominal) as total from utang_piutang_bayar where utang_piutang_id=" . $json[$i]['idd'] . ""));
                                if ($t_b['total'] == 0) {
                                    echo "Belum Ada Pembayaran";
                                } else {
                                    echo "Sisa Hutang : Rp" . number_format($json[$i]['nominal'] - $t_b['total'], 2, ',', '.');
                                }
                                ?>
                            </font>
                        </td>
                        <?php if ($json[$i]['status_lunas'] == 0) {
                            if ($t_b['total'] == 0) {
                                $b = "btn-danger";
                            } else {
                                $b = "btn-warning";
                            }
                        } else {
                            $b = "btn-success";
                        } ?>
                        <td class="<?php echo $b; ?>" align="center"><?php if ($json[$i]['status_lunas'] == 0) {
                                                                            echo "Belum Lunas";
                                                                        } else {
                                                                            echo "Sudah Lunas";
                                                                        } ?></td>
                        <td>
                            <?php if ($json[$i]['status_lunas'] == 0) { ?>
                                <a href="index.php?page=bayar_piutang&id=<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Bayar" class="label bg-green"><span class="fa fa-plus"></span> Pembayaran</small></a>
                            <?php } else { ?>
                                <a href="index.php?page=bayar_piutang&id=<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Batalkan" class="label bg-yellow">Riwayat Pembayaran</small></a>
                            <?php } ?>
                        </td>
                    <?php } else { ?>
                        <td colspan="3" align="center">
                            <?php if ($dd['jml'] == 0) {
                                echo "<font color='red'><em><strong>PO Telah Dihapus</strong></em></font>";
                            } else { ?>
                                <small class="label bg-red">Belum Deal</small>
                            <?php } ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>