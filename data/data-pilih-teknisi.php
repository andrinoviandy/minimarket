<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
?>
<table width="100%" id="example1" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th align="center" valign="bottom">No</th>
            <th valign="bottom"><strong> Nama Alkes</strong></th>
            <th valign="bottom"><strong> Teknisi</strong></th>
            <th valign="bottom"><strong>Estimasi</strong></th>
            <th valign="bottom"><strong>Tgl Berangkat</strong></th>
            <th valign="bottom"><strong>Deskripsi</strong></th>
            <th align="center" valign="bottom"><strong>Aksi</strong></th>
        </tr>
    </thead>
    <?php
    $no = 0;
    $q_akse = mysqli_query($koneksi, "select *,barang_teknisi.id as idd,barang_gudang.id as id_gudang from barang_teknisi,barang_teknisi_detail,barang_teknisi_detail_teknisi,barang_dikirim,barang_dikirim_detail,pembeli,barang_dijual,barang_gudang,barang_gudang_detail,tb_teknisi where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and barang_teknisi.id=" . $_GET['id'] . " group by barang_gudang.id order by nama_brg ASC");
    $jm = mysqli_num_rows($q_akse);
    while ($data_akse = mysqli_fetch_array($q_akse)) {
        $no++;
    ?>
        <tr>
            <td align=""><?php echo $no; ?></td>
            <td align="left"><?php echo $data_akse['nama_brg'] . " / " . $data_akse['tipe_brg']; ?>
            </td>
            <td align="left"><?php echo $data_akse['nama_teknisi'] ?></td>
            <td><?php echo date("d/M/Y", strtotime($data_akse['estimasi'])); ?></td>
            <td><?php
                if ($data_akse['tgl_berangkat_teknisi'] != 0000 - 00 - 00) {
                    echo date("d/M/Y", strtotime($data_akse['tgl_berangkat_teknisi']));
                }
                ?></td>
            <td><?php echo $data_akse['deskripsi']; ?></td>
            <td>
                <!-- <a href="#" data-toggle="modal" data-target="#modal-ubah<?php echo $data_akse['idd'] ?>"> -->
                <a href="javascript:void()" onclick="modalUbah('<?php echo $data_akse['idd'] ?>')">
                    <button class="btn btn-xs btn-warning">
                        <span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span>
                    </button>
                </a>
                &nbsp;
                <!-- <a href="index.php?page=pilih_teknisi&id_hapus=<?php echo $data_akse['id_gudang']; ?>&id=<?php echo $_GET['id']; ?>" onclick="return confirm('Yakin Akan Menghapus Item Ini ?')"> -->
                <a href="javascript:void()" onclick="hapus(<?php echo $_GET['id']; ?>, <?php echo $data_akse['id_gudang']; ?>)">
                    <button class="btn btn-xs btn-danger">
                        <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                    </button>
                </a>
            </td>
        </tr>
    <?php } ?>
</table>
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