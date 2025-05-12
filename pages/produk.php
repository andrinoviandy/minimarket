<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Produk</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Produk</li>
        </ol>
    </section>


    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-12">
                <!-- Custom tabs (Charts with tabs)-->
                <!-- /.nav-tabs-custom -->

                <!-- Chat box -->
                <div class="box box-default">
                    <!-- /.chat -->
                    <div class="box-footer">
                        <div class="box-body table-responsive no-padding">
                            <div class="">
                                <div class="input-group pull pull-left col-xs-1" style="padding-right:10px">
                                    <a href="index.php?page=tambah_produk">
                                        <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Produk</button></a>
                                </div>
                                <div class="pull pull-right">
                                    <?php include "include/rekapBulanan.php";
                                    ?>
                                    <?php include "include/atur_halaman.php"; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php include "include/header_pencarian.php"; ?>
            <section class="col-lg-12 connectedSortable">
                <div class=""></div>
                <!-- Custom tabs (Charts with tabs)-->
                <!-- /.nav-tabs-custom -->

                <!-- Chat box -->
                <div class="box box-success">
                    <!-- /.chat -->
                    <div class="box-footer">
                        <div class="box-body">

                            <div class="">
                                <?php include "include/getInputSearch.php"; ?>
                                <div id="table" style="margin-top: 10px;"></div>
                                <section class="col-lg-12">
                                    <center>
                                        <ul class="pagination">
                                            <button class="btn btn-default" id="paging-1"><a><i class="fa fa-angle-double-left"></i></a></button>
                                            <button class="btn btn-default" id="paging-2"><a><i class="fa fa-angle-double-right"></i></a></button>
                                        </ul>
                                        <?php include "include/getInfoPagingData.php"; ?>
                                    </center>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box (chat box) -->

                <!-- TO DO List -->
                <!-- /.box -->

                <!-- quick email widget -->
            </section>

            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->

            <!-- right col -->
        </div>
        <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="modal-pencarian">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pencarian</h4>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <select class="form-control select2" name="pilihan" required style="width:100%">
                        <option value="">...</option>
                        <option value="nama_brg">Berdasarkan Nama Alkes</option>
                        <option value="nie_brg">Berdasarkan NIE Alkes</option>
                        <option value="tipe_brg">Berdasarkan Tipe Alkes</option>
                        <option value="merk_brg">Berdasarkan Merk Alkes</option>
                        <option value="negara_asal">Berdasarkan Negara Asal</option>
                        <option value="qrcode">Berdasarkan Kode QRCode</option>
                    </select>
                    <br /><br />
                    <input type="text" class="form-control" name="kata_kunci" placeholder="Kata Kunci" />
                    <br />
                    <select name="tampil" class="form-control select2" style="width:100%">
                        <option value="">...</option>
                        <option value="1">Tampilkan Detail Barang</option>
                        <option value="0">Tidak Tampilkan Detail Barang</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="pencarian">Cari</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-detailbarang">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" align="center">Data Lengkap Alkes</h4>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div id="data-detail"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    function modalDetailBarang(id) {
        $('#modal-detailbarang').modal('show');
        $.get("data/modal-barang-masuk.php", {
                id: id
            },
            function(data) {
                $('#data-detail').html(data);
            }
        );
    }

    function hapus(id, nm_brg) {
        Swal.fire({
            customClass: {
                confirmButton: 'bg-red',
                cancelButton: 'bg-white',
            },
            title: 'Anda Yakin Akan Menghapus Barang Ini ?',
            text: 'Data Akan Dihapus Secara Permanen',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya , Hapus',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("data/hapus-barang-masuk.php", {
                        id_hapus: id
                    },
                    function(data) {
                        if (data == 'S') {
                            addRiwayat('DELETE', 'barang_gudang', id, 'Menghapus Barang (Nama : ' + nm_brg + ')')
                            alertHapus('S');
                            loadMore(load_flag, key, status_b);
                        } else if (data == 'T') {
                            alertCustom('F', 'Tidak Dapat Dihapus !', 'Data Ini Sedang Digunakan');
                        } else {
                            alertHapus('F');
                        }
                    }
                );
            }
        })
    }
</script>