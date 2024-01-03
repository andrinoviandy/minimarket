<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
?>
<table width="100%" id="" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th valign="bottom">No</th>
            <th valign="bottom"><strong>Nama Aksesoris</strong></th>
            <td align="center" valign="bottom"><strong>Tipe
                </strong>
            <td align="center" valign="bottom"><strong>Merk
                </strong>
            <td align="center" valign="bottom"><strong>NIE
                </strong>
            <td align="center" valign="bottom"><strong>Qty</strong>
            <td align="center" valign="bottom"><strong>Aksi</strong>
        </tr>
    </thead>

    <!-- <tr>
        <td>#</td>
        <form method="post" enctype="multipart/form-data">
            <td>
                <select name="id_akse" id="id_akse" class="form-control" autofocus="autofocus" required onchange="changeValue(this.value)">
                    <option>-- Pilih Aksesoris</option>
                    <?php
                    // $q = mysqli_query($koneksi, "select * from aksesoris order by nama_akse ASC");
                    // $jsArray = "var dtBrg = new Array();
                    //       ";
                    // while ($d = mysqli_fetch_array($q)) { ?>
                    //     <option value="<?php echo $d['id']; ?>"><?php echo $d['nama_akse']; ?></option>
                    // <?php
                    //     $jsArray .= "dtBrg['" . $d['id'] . "'] = {tipe_akse:'" . addslashes($d['tipe_akse']) . "',
                    //         merk_akse:'" . addslashes($d['merk_akse']) . "',
                    //         no_akse:'" . addslashes($d['nie_akse']) . "'
                    //         };";
                    // } ?>
                </select>
            </td>
            <td align="center"><input id="tipe_akse" name="tipe_akse" class="form-control" type="text" placeholder="Tipe" disabled="disabled" /></td>
            <td align="center"><input id="merk_akse" name="merk_akse" class="form-control" type="text" placeholder="Merk" disabled="disabled" /></td>
            <td align="center"><input id="no_akse" name="no_akse" class="form-control" type="text" placeholder="No Akse" disabled="disabled" /></td>
            <td align="center"><input required="required" name="qty" class="form-control" type="text" placeholder="Qty" /></td>
            <td align="center"><button name="simpan_tambah_aksesoris" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah</button></td>
        </form>
    </tr> -->
    <?php

    $no = 0;
    $q_akse = mysqli_query($koneksi, "select *,barang_gudang_detail_akse.id as idd from barang_gudang_detail_akse, barang_gudang where barang_gudang.id = barang_gudang_detail_akse.barang_gudang_id and barang_gudang_akse_id=" . $_GET['id'] . " order by nama_brg asc");
    $jm = mysqli_num_rows($q_akse);
    if ($jm != 0) {
        while ($data_akse = mysqli_fetch_array($q_akse)) {
            $no++;
    ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $data_akse['nama_brg']; ?>
                </td>
                <td align="center"><?php echo $data_akse['tipe_brg']; ?></td>
                <td align="center"><?php echo $data_akse['merk_brg']; ?></td>
                <td align="center"><?php echo $data_akse['nie_brg']; ?></td>
                <td align="center"><?php echo $data_akse['qty']; ?></td>
                <td align="center"><a href="index.php?page=simpan_tambah_aksesoris&id=<?php echo $_GET['id']; ?>&id_hapus=<?php echo $data_akse['idd']; ?>" onclick="return confirm('Yakin Akan Menghapus Item Ini ?')"><span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a></td>
            </tr>
    <?php }
    } else {
        echo "<tr><td colspan='7' align='center'>Tidak Ada Aksesoris</td></tr>";
    } ?>
</table>