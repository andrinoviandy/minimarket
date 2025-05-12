<?php
$data = mysqli_fetch_array(mysqli_query($koneksi, "select * from produk where id=" . $_GET['id'] . ""));

if (isset($_POST['pencarian'])) {
    if ($_POST['pilihan'] == 'tgl_po_pesan') {
        echo "<script>window.location='index.php?page=$_GET[page]&tgl_awal=$_POST[tgl_awal]&tgl_akhir=$_POST[tgl_akhir]&tampil=$_POST[tampil]'</script>";
    } else {
        echo "<script>window.location='index.php?page=$_GET[page]&pilihan=$_POST[pilihan]&kunci=$_POST[kata_kunci]&id=$_GET[id]'</script>";
    }
}

if (isset($_POST['simpan_perubahan'])) {
    $Result = mysqli_query($koneksi, "update produk set nama_produk='" . $_POST['nama_produk'] . "', kategori_produk_id='" . $_POST['kategori_produk_id'] . "', harga_beli='" . str_replace(".", "", $_POST['harga_beli']) . "', harga_jual='" . str_replace(".", "", $_POST['harga_jual']) . "', satuan='" . $_POST['satuan'] . "' where id=" . $_GET['id'] . "");
    if ($Result) {
        echo "<script>
      Swal.fire({
        customClass: {
          confirmButton: 'bg-green',
          cancelButton: 'bg-white',
        },
        title: 'Data Berhasil Diubah',
        icon: 'success',
        confirmButtonText: 'OK',
      }).then(() => {
        window.location.href = '?page=detail_produk&id=$_GET[id]';
      })
      </script>";
    }
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Detail Produk</h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><a href="index.php?page=barang_masuk">Produk</a></li>
            <li class="active">Detail Produk</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-4 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <!-- /.nav-tabs-custom -->

                <!-- Chat box -->
                <div class="box box-success">
                    <!-- /.chat -->
                    <div class="box-footer">
                        <div class="box-header with-border">
                            <h3 class="box-title">Ubah Data Produk</h3>
                        </div>
                        <div class="box-body"><br />
                            <form method="post">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="kategori_produk_id" class="form-control select2" required style="width:100%">
                                        <option value="">...</option>
                                        <?php
                                        $query = mysqli_query($koneksi, "select * from kategori_produk");
                                        while ($kate = mysqli_fetch_array($query)) {
                                        ?>
                                            <option <?php if ($data['kategori_produk_id'] === $kate['id']) {
                                                        echo "selected";
                                                    } ?> value="<?php echo $kate['id']; ?>"><?php echo $kate['kategori']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input name="nama_produk" class="form-control" type="text" placeholder="" required value="<?php echo $data['nama_produk'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>Harga Beli</label>
                                    <input name="harga_beli" class="form-control" type="text" placeholder="" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo number_format($data['harga_beli'], 0, ',', '.') ?>">
                                </div>
                                <div class="form-group">
                                    <label>Harga Jual</label>
                                    <input name="harga_jual" class="form-control" type="text" placeholder="" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo number_format($data['harga_jual'], 0, ',', '.') ?>">
                                </div>
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input name="satuan" class="form-control" type="text" placeholder="" required value="<?php echo $data['satuan'] ?>">
                                </div>
                                <button name="simpan_perubahan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.box (chat box) -->

                <!-- TO DO List -->
                <!-- /.box -->

                <!-- quick email widget -->
            </section>

            <section class="<?php if (!isset($_SESSION['adminpjt'])) {
                                echo "col-lg-8";
                            } else {
                                echo "col-lg-12";
                            } ?> connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <!-- /.nav-tabs-custom -->

                <!-- Chat box -->
                <div class="box box-success">
                    <!-- /.chat -->
                    <div class="box-footer">
                        <div class="box-header with-border">
                            <div class="pull pull-left">
                                <h3 class="box-title">Detail Data Produk</h3>
                            </div>
                            <div class="pull pull-right">
                                <div id="detail-data-alkes"></div>
                            </div>
                            <!--<a href="cetak_barcode_no_seri.php?id=<?php echo $_GET['id']; ?>&pilihan=tersedia" class="pull pull-right" target="_blank"><button name="barcode" class="btn btn-danger"><span class="fa fa-barcode"></span> Generate QRCode</button></a>-->
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="index.php?page=tambah_stok_1&id=<?php echo $_GET['id']; ?>"><button name="tambah_detail" class="btn btn-success" type="submit"><span class="fa fa-edit"></span> Tambah Stok</button>
                                    </a>
                                    <div class="pull pull-right">
                                        <?php //include "include/getFilter.php"; 
                                        ?>
                                        <?php include "include/atur_halaman.php"; ?>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <hr>
                                </div>
                                <div class="col-lg-12">
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
                </div>
                <!-- /.box (chat box) -->

                <!-- TO DO List -->
                <!-- /.box -->

                <!-- quick email widget -->
            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">

                <!-- Map box -->
                <!-- /.box -->

                <!-- solid sales graph -->
                <!-- /.box -->

                <!-- Calendar -->
                <!-- /.box -->

            </section>
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
                        <option value="no_po_gudang">Berdasarkan Nomor PO</option>
                        <option value="no_bath">Berdasarkan Nomor Bath</option>
                        <option value="no_lot">Berdasarkan Nomor Lot</option>
                        <option value="no_seri_brg">Berdasarkan No Seri</option>
                    </select>
                    <br /><br />
                    <input type="text" class="form-control" name="kata_kunci" placeholder="Kata Kunci" />
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

<div class="modal fade" id="modal-ubah-item">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ubah Data Barang</h4>
            </div>
            <div id="modal-data-item"></div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ubah-barcode">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" align="center">Buat QRCode
                </h4>
            </div>
            <div id="modal-data-barcode"></div>
        </div>

    </div>

</div>

<div class="modal fade" id="modal-cetak-barcode">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" align="center">Jumlah QRCode Yang Ingin Di Cetak
                </h4>
            </div>
            <form method="post" action="cetak_barcode_jenis.php" target="_blank">
                <div class="modal-body">
                    <p align="justify">
                        <!--<input type="hidden" name="kode_barcode" value="<?php //echo "(" . $json[$i]['nama_brg'] . ")(" . $json[$i]['tipe_brg'] . ")(" . $json[$i]['merk_brg'] . ")(" . $json[$i]['no_po_gudang'] . ")(" . date_format("d/m/Y", strtotime($json[$i]['tgl_po_gudang'])) . ")(" . $json[$i]['no_seri_brg'] . ")(" . ($i + 1) . " of " . $jml . ")"; 
                                                                            ?>"/>-->
                        <input type="hidden" id="kode_barcode" name="kode_barcode" />
                        <input type="hidden" id="nie_brg_cetak" name="nie_brg" />
                        <input type="hidden" id="no_seri_cetak" name="no_seri" />
                        <input type="number" id="jml_cetak" name="jml" class="form-control" placeholder="Jumlah QRCode Yang Ingin Di Cetak" />
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="print_barcode"><i class="fa fa-print"></i> Print</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    function ubahBarcode() {
        $.post("data/simpan_ubah_barcode.php", {
                id_ubah: $('#idd').val(),
                qrcode: $('#qrcode').val()
            },
            function(data) {
                if (data == 'S') {
                    addRiwayat('UPDATE', 'barang_gudang_detail', $('#idd').val(), 'Mengubah Barcode Barang')
                    alertSimpan('S');
                    $('#modal-ubah-barcode').modal('hide');
                    loading();
                    loadMore(load_flag, key, status_b)
                } else {
                    alertSimpan('F');
                    $('#modal-ubah-barcode').modal('hide');
                }
            }
        );
    }

    function ubahItem() {
        var dataform = $('#formUbah')[0];
        var data = new FormData(dataform);
        $.ajax({
            type: "post",
            url: "data/simpan_ubah_item.php",
            data: data,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            success: function(response) {
                if (response == 'S') {
                    addRiwayat('UPDATE', 'barang_gudang_detail', $('#idd').val(), 'Mengubah Detail Barang')
                    alertSimpan('S');
                    $('#modal-ubah-item').modal('hide');
                    loading();
                    loadMore(load_flag, key, status_b)
                } else if (response == 'SA') {
                    alertCustom('F', 'Tidak Dapat Dilanjutkan', 'No Seri Sudah Terdaftar !');
                } else {
                    alertSimpan('F');
                    $('#modal-ubah-item').modal('hide');
                }
            }
        });
    }

    function modalUbahItem(id_ubah) {
        $.get("data/modal-ubah-item.php", {
                id: id_ubah
            },
            function(data) {
                $('#modal-data-item').html(data);
                $('#modal-ubah-item').modal('show');
            }
        );
    }

    function modalUbahBarcode(id_ubah) {
        $.get("data/modal-ubah-barcode.php", {
                id: id_ubah
            },
            function(data) {
                $('#modal-data-barcode').html(data);
                $('#modal-ubah-barcode').modal('show');
            }
        );
    }

    function modalCetakBarcode(id_ubah) {
        $.get("data/modal-cetak-barcode.php", {
                id: id_ubah
            },
            function(data) {
                var dt = JSON.parse(data);
                $('#kode_barcode').val(dt.qrcode);
                $('#nie_brg_cetak').val(dt.nie_brg);
                $('#no_seri_cetak').val(dt.no_seri_brg);
                $('#modal-cetak-barcode').modal('show');
            }
        );
    }

    function hapus(id_hapus, id_po) {
        Swal.fire({
            customClass: {
                confirmButton: 'bg-red',
                cancelButton: 'bg-white',
            },
            title: 'Anda Yakin Akan Menghapus Data Ini ?',
            text: 'Data Akan Dihapus Secara Permanen',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya , Hapus',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("data/hapus_ubah_item.php", {
                        id_hapus: id_hapus,
                        id_po: id_po,
                        id: '<?php echo $_GET['id'] ?>'
                    },
                    function(data) {
                        if (data == 'S') {
                            addRiwayat('DELETE', 'barang_gudang_detail', id_hapus, 'Menghapus No Seri (ID_PO:' + id_po + ')')
                            alertHapus('S')
                            dataStok();
                            loading();
                            loadMore(load_flag, key, status_b)
                        } else if (data == 'F') {
                            alertHapus('F')
                        } else {
                            alertCustom('F', 'Data Tidak Dapat Dihapus !', 'Data Sedang Digunakan');
                        }
                    }
                );
            }
        })
    }

    function dataStok() {
        $.get("data/detail-data-produk.php", {
                id: '<?php echo $_GET['id']; ?>'
            },
            function(data) {
                $('#detail-data-alkes').html(data);
            }
        );
    }

    $(document).ready(function() {
        dataStok();
    });
</script>