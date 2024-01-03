<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<div class="table-responsive no-padding">
    <table width="100%" id="example1" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Nama Barang</th>
                <th>Sisa Kirim</th>
                <th>Status</th>
            </tr>
        </thead>
        <?php
        $q22 = mysqli_query($koneksi, "select *,barang_dijual_qty.id as id_det_jual from barang_dijual_qty,barang_dijual,barang_gudang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual_qty.barang_dijual_id=" . $_GET['id'] . "");
        $nn = 0;
        while ($d1 = mysqli_fetch_array($q22)) {
            $nn++;
            $q4 = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_dikirim_detail where barang_dijual_qty_id=" . $d1['id_det_jual'] . ""));
        ?>
            <tr <?php
                if ($d1['qty_jual'] - $q4['jml'] != 0) {
                    echo "class='btn-danger'";
                }
                ?>>
                <td><?php echo $nn; ?></td>
                <td><?php echo $d1['kategori']; ?></td>
                <td><?php echo $d1['nama_brg']; ?></td>
                <td><?php echo $d1['qty_jual'] - $q4['jml']; ?></td>
                <td>
                    <?php
                    if ($d1['qty_jual'] - $q4['jml'] == 0) {
                        echo "<span class='fa fa-check'></span>";
                    }
                    ?>
                    <?php if ($d1['status_kembali_ke_gudang'] == 1) { ?>
                        <font class="pull pull-right" size="+1">Kembali Ke Gudang</font>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>