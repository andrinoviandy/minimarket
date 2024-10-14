<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<div class="table-responsive">
    <table width="100%" id="example1" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th align="center" valign="bottom">No</th>
                <th valign="bottom"><strong>No PO</strong></th>
                <th valign="bottom"><strong>No SJ</strong></th>
                <th align="center" valign="bottom"><strong>Tgl_Sampai</strong></th>
                <th align="center" valign="bottom"><strong>RS/Dinas/Dll
                    </strong></th>
                <th align="center" valign="bottom"><strong>Nama Barang</strong></th>
                <th align="center" valign="bottom"><strong>No Seri</strong></th>
                <th align="center" valign="bottom"><strong>Aksi</strong></th>
            </tr>
        </thead>
        <?php

        $no = 0;
        $q_akse = mysqli_query($koneksi, "select *,barang_teknisi_hash.id as idd from barang_teknisi_hash,barang_dikirim_detail,barang_dikirim,barang_dijual,pembeli,barang_gudang_detail,barang_gudang where barang_dikirim_detail.id=barang_teknisi_hash.barang_dikirim_detail_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dijual.id=barang_dikirim.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and akun_id=" . $_SESSION['id'] . "");
        $jm = mysqli_num_rows($q_akse);
        if ($jm != 0) {
            while ($data_akse = mysqli_fetch_array($q_akse)) {
                $no++;
        ?>
                <tr>
                    <td align="center"><?php echo $no; ?></td>
                    <td align="left"><?php echo $data_akse['no_po_jual'] ?></td>
                    <td align="left"><?php echo $data_akse['no_pengiriman']; ?></td>
                    <td align="left"><?php echo date("d-m-Y", strtotime($data_akse['tgl_kirim'])); ?></td>
                    <td align="left"><?php echo $data_akse['nama_pembeli']; ?></td>
                    <td align="left"><?php echo $data_akse['nama_brg']; ?></td>
                    <td align="left"><?php echo $data_akse['no_seri_brg']; ?></td>
                    <td align="center">
                        <!-- <a href="index.php?page=tambah_spk_masuk2&id_hapus=<?php echo $data_akse['idd']; ?>" onclick="return confirm('Yakin Akan Menghapus Item Ini ?')"> -->
                        <a href="javascript:void()" onclick="hapusData('<?php echo $data_akse['idd']; ?>')">
                            <button class="btn btn-danger btn-xs">
                                <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                            </button>
                        </a>
                    </td>
                </tr>
        <?php }
        } else {
            echo "<tr><td colspan='7' align='center'>Tidak Ada Data</td></tr>";
        } ?>
    </table>
</div>

<!-- DataTables -->
<script>
    $(function() {
        $('#example1').DataTable()
        $('#example2').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': true,
            'ordering': false,
            'info': false,
            'autoWidth': true
        })
        $('#example3').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': false,
            'autoWidth': true
        })
        $('#example5').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true
        })
        $('#example4').DataTable()
    })
</script>