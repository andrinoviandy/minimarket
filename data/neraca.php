<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<section class="col-lg-6 connectedSortable">
    <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

    <!-- Chat box -->
    <div class="box box-success"><!-- /.chat -->
        <h3 align="center">Neraca &nbsp;&nbsp;
            <!-- <a href="index.php?page=kategori#tambah_grup_neraca"> -->
            <button name="tambah_laporan" class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#modal-grup-neraca"><span class="fa fa-plus"></span> Tambah Grup</button>
            <!-- </a>  -->
            <!-- <a href="index.php?page=kategori#tambah_akun_neraca"> -->
            <button name="tambah_laporan2" class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#modal-akun-neraca" onclick="getFormNeraca(); return false;"><span class="fa fa-plus"></span> Tambah Akun</button>
            <!-- </a> -->
        </h3>
        <div class="box-footer">
            <div class="box-header with-border" style="background-color:#FC9">
                <h3 class="box-title"><strong>Aset</strong></h3>
                <h3 class="box-title pull pull-right">&nbsp;</h3>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-responsive">
                    <tr>
                        <td>Aktiva Lancar</td>
                        <td width="10%"><span class="fa fa-times-circle"></span></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table id="example2" class="table table-responsive" style="padding:0px; margin:0px">
                                <tr>
                                    <td width="5%"></td>
                                    <td>Kas di BANK</td>
                                    <td width="5%"><span class="fa fa-times-circle"></span></td>
                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td>Kas di TANGAN</td>
                                    <td width="5%"><span class="fa fa-times-circle"></span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php
                    $q_aset = mysqli_query($koneksi, "select * from coa_sub where coa_id=1");
                    $no = 0;
                    while ($d_aset = mysqli_fetch_array($q_aset)) {
                    ?>
                        <tr>
                            <td><?php echo $d_aset['nama_sub_grup']; ?></td>
                            <td><?php if ($d_aset['id'] != 2) { ?>
                                    <!-- <a href="index.php?page=kategori&hapus_aset=<?php echo $d_aset['id']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Akun Ini ?')"> -->
                                    <a href="javascript:void()" onclick="hapus2('<?php echo $d_aset['id']; ?>')" class="btn btn-xs btn-danger">
                                        <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a><?php } else { ?><span class="fa fa-times-circle"></span><?php } ?>
                            </td>
                        </tr>
                        <?php
                        $cek_sub = mysqli_num_rows(mysqli_query($koneksi, "select * from coa_sub_akun where coa_sub_id=$d_aset[id]"));
                        if ($cek_sub != 0) { ?>
                            <tr>
                                <td colspan="2">
                                    <table id="example2" class="table table-responsive" style="padding:0px; margin:0px">
                                        <?php
                                        $q_sub_akun = mysqli_query($koneksi, "select * from coa_sub_akun where coa_sub_id=$d_aset[id]");
                                        while ($d_sub_akun = mysqli_fetch_array($q_sub_akun)) {
                                        ?>
                                            <tr>
                                                <td width="5%"></td>
                                                <td><?php echo $d_sub_akun['nama_akun']; ?></td>
                                                <td width="5%"><?php if ($d_sub_akun['coa_sub_id'] != 2) { ?>
                                                        <!-- <a href="index.php?page=kategori&hapus_sub_akun=<?php echo $d_sub_akun['id']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"> -->
                                                        <a href="javascript:void()" onclick="hapus3('<?php echo $d_sub_akun['id']; ?>')" class="btn btn-xs btn-danger">
                                                            <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a><?php } else { ?><span class="fa fa-times-circle"></span><?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                </table>

            </div>
            <div class="box-header with-border" style="background-color:#FC9">
                <h3 class="box-title"><strong>Dikurangi Kewajiban</strong></h3>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-responsive">
                    <?php
                    $q_aset2 = mysqli_query($koneksi, "select * from coa_sub where coa_id=2");
                    $no = 0;
                    while ($d_aset2 = mysqli_fetch_array($q_aset2)) {
                    ?>
                        <tr>
                            <td><?php echo $d_aset2['nama_sub_grup']; ?></td>
                            <td width="10%"><?php if ($d_aset2['id'] != 9) { ?>
                                    <!-- <a href="index.php?page=kategori&hapus_aset=<?php echo $d_aset2['id']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Akun Ini ?')"> -->
                                    <a href="javascript:void()" onclick="hapus2('<?php echo $d_aset2['id']; ?>')" class="btn btn-xs btn-danger">
                                        <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a><?php } else { ?><span class="fa fa-times-circle"></span><?php } ?>
                            </td>
                        </tr>
                        <?php
                        $cek_sub2 = mysqli_num_rows(mysqli_query($koneksi, "select * from coa_sub_akun where coa_sub_id=$d_aset2[id]"));
                        if ($cek_sub2 != 0) { ?>
                            <tr>
                                <td colspan="2">
                                    <table id="example1" class="table table-responsive" style="padding:0px; margin:0px">
                                        <?php
                                        $q_sub_akun2 = mysqli_query($koneksi, "select * from coa_sub_akun where coa_sub_id=$d_aset2[id]");
                                        while ($d_sub_akun2 = mysqli_fetch_array($q_sub_akun2)) {
                                        ?>
                                            <tr>
                                                <td width="5%"></td>
                                                <td><?php echo $d_sub_akun2['nama_akun']; ?></td>
                                                <td width="5%"><?php if ($d_sub_akun2['id'] != 45 and $d_sub_akun2['id'] != 46) { ?>
                                                        <!-- <a href="index.php?page=kategori&hapus_sub_akun=<?php echo $d_sub_akun2['id']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"> -->
                                                        <a href="javascript:void()" onclick="hapus3('<?php echo $d_sub_akun2['id']; ?>')" class="btn btn-xs btn-danger">
                                                            <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a><?php } else { ?><span class="fa fa-times-circle"></span><?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                </table>
            </div>
            <div class="box-header with-border" style="background-color:#FC9">
                <h3 class="box-title"><strong>Ekuitas</strong></h3>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-responsive">
                    <?php
                    $q_aset3 = mysqli_query($koneksi, "select * from coa_sub where coa_id=3");
                    $no = 0;
                    while ($d_aset3 = mysqli_fetch_array($q_aset3)) {
                    ?>
                        <tr>
                            <td><?php echo $d_aset3['nama_sub_grup']; ?></td>
                            <td width="10%">
                                <?php if ($d_aset3['id'] != 31 and $d_aset3['id'] != 32) { ?>
                                    <!-- <a href="index.php?page=kategori&hapus_aset=<?php echo $d_aset3['id']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Akun Ini ?')"> -->
                                    <a href="javascript:void()" onclick="hapus2('<?php echo $d_aset3['id']; ?>')" class="btn btn-xs btn-danger">
                                        <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a>
                                <?php } else { ?>
                                    <span class="fa fa-times-circle"></span>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                        $cek_sub3 = mysqli_num_rows(mysqli_query($koneksi, "select * from coa_sub_akun where coa_sub_id=$d_aset3[id]"));
                        if ($cek_sub3 != 0) { ?>
                            <tr>
                                <td colspan="3">
                                    <table id="example1" class="table table-responsive" style="padding:0px; margin:0px">
                                        <?php
                                        $q_sub_akun3 = mysqli_query($koneksi, "select * from coa_sub_akun where coa_sub_id=$d_aset3[id]");
                                        while ($d_sub_akun3 = mysqli_fetch_array($q_sub_akun3)) {
                                        ?>
                                            <tr>
                                                <td width="5%"></td>
                                                <td><?php echo $d_sub_akun3['nama_akun']; ?></td>
                                                <td width="5%">
                                                    <!-- <a href="index.php?page=kategori&hapus_sub_akun=<?php echo $d_sub_akun3['id']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"> -->
                                                    <a href="javascript:void()" onclick="hapus3('<?php echo $d_sub_akun3['id']; ?>')" class="btn btn-xs btn-danger">
                                                        <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                </table>
            </div>
        </div>
    </div>
</section>