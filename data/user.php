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
    $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "");
    $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "");
} else {
    $file = file_get_contents($API . "json/$_GET[page].php?start=$start");
    $file2 = file_get_contents($API . "json/$_GET[page].php");
}
$json = json_decode($file, true);
$jml = count($json);
$jml2 = $file2;

?>
<div>
    <em><?php echo "Jumlah Data Yang Ditemukan : " . $jml2 ?></em>
</div>
<div class="table-responsive no-padding">
    <table width="100%" id="" class="table table-bordered">
        <thead>
            <tr>
                <th align="center">No</th>
                <th align="center">Role</th>
                <th valign="top" class="text-nowrap"><strong>Nama Lengkap</strong></th>
                <th>Username</th>
                <th valign="top" class="text-nowrap">Email</th>
                <th valign="top" class="text-nowrap">No. Wa</th>
                <th align="center" valign="top"><strong>Aksi</strong></th>
            </tr>
        </thead>
        <?php
        for ($i = 0; $i < $jml; $i++) {
        ?>
            <tr>
                <td align="center"><?php
                                    echo $start += 1;
                                    ?></td>
                <td>
                    <?php echo $json[$i]['nama_role']; ?>
                </td>
                <td>
                    <?php echo $json[$i]['nama']; ?>
                </td>
                <td>
                    <?php echo $json[$i]['username']; ?>
                </td>
                <td>
                    <?php echo $json[$i]['email']; ?>
                </td>
                <td>
                    <?php echo $json[$i]['no_wa']; ?>
                </td>
                <td>
                    <div class="row text-nowrap">
                        <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1 && $json[$i]['id'] != 1) { ?>
                            <a onclick="hapus(<?php echo $json[$i]['idd'] ?>)">
                                <button data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-xs">
                                    <span class="ion-android-delete"> Hapus</span>
                                </button>
                            </a>
                        <?php } ?>
                    </div>
                    <!-- <div class="row text-nowrap">
                        <?php if ($json[$i]['status'] == 0) { ?>
                            <button class="btn btn-info btn-xs" onclick="modalStatus('<?php echo $json[$i]['idd']; ?>', '<?php echo $json[$i]['status']; ?>'); return false;">
                                <span data-toggle="tooltip" title="Status" class="fa fa-check-circle"> Status</span>
                            </button>
                        <?php } ?>
                        <a href="#" data-toggle="modal" data-target="#modal-cetak-po<?php echo $json[$i]['idd']; ?>">
                            <button class="btn btn-primary btn-xs">
                                <span data-toggle="tooltip" title="Cetak" class="fa fa-print"> Cetak
                                </span>
                            </button>
                        </a>
                    </div> -->
                </td>
            </tr>
        <?php } ?>
    </table>
</div>