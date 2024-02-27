<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dijual where id=" . $_GET['id'] . ""));
?>
<div class="table-responsive">
    <table width="100%" id="" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th colspan="7" align="left">
                    <table width="">
                        <tr valign="top">
                            <td><strong>Marketing </strong></td>
                            <td><strong>&nbsp;:&nbsp;</strong></td>
                            <td><strong><?php echo $data['marketing']; ?></strong></td>
                            <td><strong> &nbsp;&nbsp;,&nbsp;&nbsp; </strong></td>
                            <td><strong>Sub Distributor </strong></td>
                            <td><strong> &nbsp;:&nbsp; </strong></td>
                            <td><strong><?php echo $data['subdis']; ?></strong></td>
                            <td><strong>
                                    <!--&nbsp;&nbsp;&nbsp;&nbsp; , Diskon : <?php echo $_SESSION['diskon'] . " %"; ?>&nbsp;&nbsp;&nbsp;&nbsp; , PPN : <?php echo $_SESSION['ppn'] . " %"; ?>-->
                                </strong></td>
                        </tr>
                    </table>
                </th>
            </tr>
            <tr>
                <th colspan="4" valign="bottom">&nbsp;</th>
                <th valign="bottom">&nbsp;</th>
                <th valign="bottom">&nbsp;</th>
                <th valign="bottom">&nbsp;</th>

            </tr>
            <tr>
                <th valign="bottom"><strong>Tgl Jual</strong></th>
                <th valign="bottom">No PO</th>
                <th valign="bottom">No Kontrak</th>
                <th valign="bottom">Nama RS/Dinas/Klinik/dll</th>
                <th valign="bottom"><strong>Kelurahan</strong></th>
                <th valign="bottom">Alamat</th>
                <th valign="bottom"><strong>Kontak RS/Dinas/dll</strong></th>

            </tr>
        </thead>
        <tr>
            <td>
                <?php echo $data['tgl_jual']; ?></td>
            <td>
                <?php echo $data['no_po_jual']; ?></td>
            <td><?php echo $data['no_kontrak']; ?></td>
            <td><?php
                $sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from pembeli where id=" . $data['pembeli_id'] . ""));
                echo $sel['nama_pembeli']; ?></td>
            <td><?php echo $sel['kelurahan_id']; ?></td>
            <td><?php echo $sel['jalan']; ?></td>
            <td><?php echo $sel['kontak_rs']; ?></td>

        </tr>
    </table>
</div>
<br />
<div class="table-responsive">
    <table width="100%" class="table table-bordered table-hover">
        <tr>
            <td><strong>Nama Pemakai</strong></td>
            <td><strong>Kontak 1</strong></td>
            <td><strong>Kontak 2</strong></td>
            <td><strong>Email</strong></td>
            <td><strong>Include DPP</strong></td>
            <td><strong>Status PO</strong></td>
        </tr>
        <tr>
            <td><?php
                $sel_pemakai = mysqli_fetch_array(mysqli_query($koneksi, "select * from pemakai where id=" . $data['pemakai_id'] . "")); ?>
                <?php echo $sel_pemakai['nama_pemakai']; ?></td>
            <td>
                <?php echo $sel_pemakai['kontak1_pemakai']; ?></td>
            <td><?php echo $sel_pemakai['kontak2_pemakai']; ?></td>
            <td>
                <?php echo $sel_pemakai['email_pemakai']; ?></td>
            <td>
                <?php if ($data['include_dpp'] == 1) {echo "<small class='label bg-green'>YA</small>";} else { echo "<small class='label bg-red'>TIDAK</small>"; } ?></td>
            <td><?php
                $jm_deal3 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dijual where no_po_jual='" . $data['no_po_jual'] . "' and status_deal=1"));
                if ($jm_deal3 != 0) {
                    echo "<small class='label bg-green'>Deal</small>";
                } else {
                    echo "<small class='label bg-red'>Belum Deal</small>";
                } ?></td>
        </tr>

    </table>
</div>