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
        $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "&status=$_GET[status]&session_id=$_SESSION[id]");
        $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&status=$_GET[status]&session_id=$_SESSION[id]");
    } else {
        $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&status=$_GET[status]&session_id=$_SESSION[id]");
        $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&status=$_GET[status]&session_id=$_SESSION[id]");
    }
} else {
    if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
        $file = file_get_contents($API . "json/$_GET[page].php?start=$start&status=$_GET[status]&session_id=$_SESSION[id]");
        $file2 = file_get_contents($API . "json/$_GET[page].php?status=$_GET[status]&session_id=$_SESSION[id]");
    } else {
        $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&status=$_GET[status]&session_id=$_SESSION[id]");
        $file2 = file_get_contents($API . "json/$_GET[page].php?tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&status=$_GET[status]&session_id=$_SESSION[id]");
    }
}

// var_dump($file);die();
$json = json_decode($file, true);

$jml2 = $file2;

if (isset($_GET['status']) && $_GET['status'] == '0') {
?>
    <div class="table-responsive no-padding">
        <table width="100%" id="example1" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <td width="" align="center"><strong>No</strong>
                    <th width="" valign="top" class="text-nowrap">Nama Produk</th>
                    <th width="" valign="top" class="text-nowrap">Kuantitas</th>
                    <th width="" valign="top" class="text-nowrap">Satuan</th>
                    <th width="" valign="top" class="text-nowrap">Harga Satuan</th>
                    <th width="" valign="top" class="text-nowrap">Sub Total</th>
                    <th width="" align="center" valign="top"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <?php
            $jml = count($json);
            for ($i = 0; $i < $jml; $i++) {
            ?>
                <tr>
                    <td align="center"><?php echo $start += 1; ?></td>
                    <td><?php echo $json[$i]['nama_produk'];  ?></td>
                    <td><?php echo $json[$i]['qty_jual'];  ?></td>
                    <td><?php echo $json[$i]['satuan'];  ?></td>
                    <td><?php echo "Rp" . number_format($json[$i]['harga_jual_saat_itu'], 0, ',', '.');  ?></td>
                    <td><?php echo "Rp" . number_format($json[$i]['sub_total'], 0, ',', '.');  ?></td>
                    <td>
                        <!-- href="index.php?page=karyawan&id_hapus=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')" -->
                        <button class="btn btn-xs btn-danger" onclick="hapus('<?php echo $json[$i]['idd']; ?>')"><span data-toggle="tooltip" title="Hapus" class="fa fa-close"></span> Hapus</button>
                        <!-- <a href="index.php?page=detail_pinjaman&id=<?php echo $json[$i]['idd']; ?>" class="btn btn-xs btn-info" data-toggle="tooltip" data-title="Detai"><span class="fa fa-folder-open"></span></a> -->
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php } else { ?>
    <div class="table-responsive no-padding">
        <table width="100%" id="example1" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <td width="" align="center"><strong>No</strong>
                    <th width="" valign="top" class="text-nowrap">Tanggal</th>
                    <th width="" valign="top" class="text-nowrap">No Nota</th>
                    <th width="" valign="top" class="text-nowrap">Nama Siswa / Guru</th>
                    <th width="" valign="top" class="text-nowrap">Banyak Produk</th>
                    <th width="" valign="top" class="text-nowrap">Total Harga</th>
                    <th width="" align="center" valign="top"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <?php
            $jmll = count($json);
            for ($i = 0; $i < $jmll; $i++) {
            ?>
                <tr>
                    <td align="center"><?php echo $start += 1; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($json[$i]['tgl_po']));  ?></td>
                    <td><?php echo $json[$i]['no_po_jual'];  ?></td>
                    <td><?php echo ($json[$i]['nama_siswa'] != '' || $json[$i]['nama_siswa'] != NULL) ? $json[$i]['nama_siswa'] : $json[$i]['nama_guru'];  ?></td>
                    <td><?php echo $json[$i]['banyak_produk'];  ?></td>
                    <td><?php echo "Rp" . number_format($json[$i]['total_harga'], 0, ',', '.');  ?></td>
                    <td>
                        <!-- href="index.php?page=karyawan&id_hapus=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')" -->
                        <button class="btn btn-xs btn-success" onclick="openTransaksi('<?php echo $json[$i]['idd']; ?>','<?php echo $json[$i]['no_po_jual'];  ?>')"><span data-toggle="tooltip" title="Open Transaksi" class="fa fa-folder-open"></span> Open</button>
                        <!-- <a href="index.php?page=detail_pinjaman&id=<?php echo $json[$i]['idd']; ?>" class="btn btn-xs btn-info" data-toggle="tooltip" data-title="Detai"><span class="fa fa-folder-open"></span></a> -->
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php } ?>