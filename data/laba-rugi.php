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
        <h3 align="center">Laporan Laba Rugi &nbsp;&nbsp;
            <!-- <a href="index.php?page=kategori#tambah_grup_laba_rugi"> -->
            <button name="tambah_grup_labarugi" class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#modal-grup-laba"><span class="fa fa-plus"></span> Tambah Grup</button>
            <!-- </a> <a href="index.php?page=kategori#tambah_akun_laba_rugi"> -->
            <button name="tambah_akun_labarugi" class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#modal-akun-laba" onclick="getFormLaba(); return false;"><span class="fa fa-plus"></span> Tambah Akun</button>
            <!-- </a> -->
        </h3>
        <div class="box-footer">
            <div class="box-header with-border" style="background-color:#FC9">
                <h3 class="box-title"><strong>Pemasukan</strong></h3>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-responsive">
                    <?php
                    $q_aset4 = mysqli_query($koneksi, "select * from coa_sub where coa_id=4");
                    $no = 0;
                    while ($d_aset4 = mysqli_fetch_array($q_aset4)) {
                    ?>
                        <tr>
                            <td><?php echo $d_aset4['nama_sub_grup']; ?></td>
                            <td width="10%">
                                <!-- <a href="index.php?page=kategori&hapus_aset=<?php echo $d_aset4['id']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Akun Ini ?')"> -->
                                <a href="javascript:void()" onclick="hapus2('<?php echo $d_aset4['id']; ?>')" class="btn btn-xs btn-danger">
                                    <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a>
                            </td>
                        </tr>
                        <?php
                        $cek_sub4 = mysqli_num_rows(mysqli_query($koneksi, "select * from coa_sub_akun where coa_sub_id=$d_aset4[id]"));
                        if ($cek_sub4 != 0) { ?>
                            <tr>
                                <td colspan="4">
                                    <table id="example1" class="table table-responsive" style="padding:0px; margin:0px">
                                        <?php
                                        $q_sub_akun4 = mysqli_query($koneksi, "select * from coa_sub_akun where coa_sub_id=$d_aset4[id]");
                                        while ($d_sub_akun4 = mysqli_fetch_array($q_sub_akun4)) {
                                        ?>
                                            <tr>
                                                <td width="5%"></td>
                                                <td><?php echo $d_sub_akun4['nama_akun']; ?></td>
                                                <td width="5%">
                                                    <a href="javascript:void()" onclick="hapus3('<?php echo $d_sub_akun4['id']; ?>')" class="btn btn-xs btn-danger">
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
            <div class="box-header with-border" style="background-color:#FC9">
                <h3 class="box-title"><strong>Dikurangi Pengeluaran</strong></h3>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-responsive">
                    <?php
                    $q_aset5 = mysqli_query($koneksi, "select * from coa_sub where coa_id=5");
                    $no = 0;
                    while ($d_aset5 = mysqli_fetch_array($q_aset5)) {
                    ?>
                        <tr>
                            <td><?php echo $d_aset5['nama_sub_grup']; ?></td>
                            <td width="10%">
                                <a href="javascript:void()" onclick="hapus2('<?php echo $d_aset5['id']; ?>')" class="btn btn-xs btn-danger">
                                    <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a>
                            </td>
                        </tr>
                        <?php
                        $cek_sub5 = mysqli_num_rows(mysqli_query($koneksi, "select * from coa_sub_akun where coa_sub_id=$d_aset5[id]"));
                        if ($cek_sub5 != 0) { ?>
                            <tr>
                                <td colspan="5">
                                    <table id="example1" class="table table-responsive" style="padding:0px; margin:0px">
                                        <?php
                                        $q_sub_akun5 = mysqli_query($koneksi, "select * from coa_sub_akun where coa_sub_id=$d_aset5[id]");
                                        while ($d_sub_akun5 = mysqli_fetch_array($q_sub_akun5)) {
                                        ?>
                                            <tr>
                                                <td width="5%"></td>
                                                <td><?php echo $d_sub_akun5['nama_akun']; ?></td>
                                                <td width="5%">
                                                    <a href="javascript:void()" onclick="hapus3('<?php echo $d_sub_akun5['id']; ?>')" class="btn btn-xs btn-danger">
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
            <div class="box-header with-border" style="background-color:#FC9">
                <h3 class="box-title"><strong>Laba Bersih</strong></h3>
            </div>
        </div>
    </div>
</section>