<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start()
?>
<?php
$start = $_GET['start'];

if (isset($_GET['cari'])) {
    $search = str_replace(" ", "%20", $_GET['cari']);
    if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
        $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "");
        $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "");
    } else {
        $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
        $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
    }
} else {
    if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
        $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "");
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
                <th align="center">&nbsp;</th>


                <th valign="top"><strong>Nama Alat</strong></th>
                <th valign="top"><strong>Merk</strong></th>
                <th valign="top"><strong>Tipe</strong></th>
                <th valign="top">NIE</th>
                <th align="center" valign="top">Negara</th>
                <th align="center" valign="top"><strong>Deskripsi
                    </strong></th>
                <th align="center" valign="top">Jumlah Item</th>
                <th align="center" valign="top"><strong>Aksi</strong></th>
            </tr>
        </thead>
        <?php
        for ($i = 0; $i < $jml; $i++) {
            $jml_item = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_gudang_set_detail where barang_gudang_set_id = ".$json[$i]['idd'].""));
            //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
            //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
        ?>
            <tr>
                <td align="center"><?php echo $i + 1; ?></td>

                <td>
                    <?php echo $json[$i]['nama_brg']; ?>
                </td>

                <td><?php echo $json[$i]['merk_brg']; ?></td>
                <td><?php echo $json[$i]['tipe_brg']; ?></td>
                <td><?php echo $json[$i]['nie_brg']; ?></td>
                <td align=""><?php echo $json[$i]['negara_asal']; ?></td>
                <td align=""><?php echo $json[$i]['deskripsi_alat']; ?></td>
                <td align="" class="<?php if ($jml_item == 0) {
                                        echo "bg-danger";
                                    } ?>">
                    <?php
                    echo $jml_item['jml'];
                    ?>
                </td>

                <td align="">

                    <input type="hidden" name="id" value="<?php echo $json[$i]['idd']; ?>" />

                    <a onclick="hapus(<?php echo $json[$i]['idd']; ?>)">
                        <button class="btn btn-danger btn-xs">
                            <span data-toggle="tooltip" title="Hapus" class="fa fa-trash"></span>
                        </button>
                    </a>
                    &nbsp;
                    <a href="index.php?page=ubah_barang_set&id=<?php echo $json[$i]['idd']; ?>">
                        <button class="btn btn-info btn-xs">
                            <span data-toggle="tooltip" title="Ubah" class="fa fa-folder-open"></span>
                        </button>
                    </a>
                </td>

            </tr>
        <?php } ?>
    </table>
</div>