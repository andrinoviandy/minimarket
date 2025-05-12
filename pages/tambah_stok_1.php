<?php
if (isset($_POST['simpan_barang'])) {
    if ($_POST['stok'] > 0) {
        echo "<script type='text/javascript'>
        window.location='index.php?page=tambah_stok_2&id=$_GET[id]';
          </script>
          ";
        $_SESSION['tgl_masuk'] = $_POST['tgl_masuk'];
        $_SESSION['no_po'] = $_POST['no_po'];
        $_SESSION['stok'] = $_POST['stok'];
    } else {
        echo "<script>
      Swal.fire({
        customClass: {
          confirmButton: 'bg-primary',
          cancelButton: 'bg-white',
        },
        title: 'Stok Tidak Boleh Nol',
        icon: 'warning',
        confirmButtonText: 'OK',
      });
      </script>";
    }
}

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tambah Stok Produk</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Tambah Stok Produk</li>
        </ol>
    </section>


    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) --><!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
                <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

                <!-- Chat box -->
                <div class="box box-success"><!-- /.chat -->
                    <div class="box-footer">
                        <div class="box-body">
                            <div class="">
                                <!--<a href="index.php?page=tambah_barang_masuk"><button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Barang</button></a>-->
                                <form method="post" enctype="multipart/form-data">
                                    <div class="table-responsive">
                                        <table width="100%" id="" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th valign="bottom"><strong>Kategori Produk</strong></th>
                                                    <th valign="bottom"><strong>Nama produk</strong></th>
                                                    <th valign="bottom">Harga Beli</th>
                                                    <th valign="bottom">Harga Jual</th>
                                                    <th valign="bottom"><strong>Satuan</strong></th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $data = mysqli_fetch_array(mysqli_query($koneksi, "select a.*, b.* from produk a left join kategori_produk b on b.id = a.kategori_produk_id where a.id=" . $_GET['id'] . ""));
                                            ?>
                                            <tr>
                                                <td><?php echo $data['kategori']; ?></td>
                                                <td><?php echo $data['nama_produkrg']; ?></td>
                                                <td><?php echo number_format($data['harga_beli'], 0, ',', '.'); ?></td>
                                                <td><?php echo number_format($data['harga_jual'], 0, ',', '.'); ?></td>
                                                <td><?php echo $data['satuan']; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <br />
                                    <div class="table-responsive">
                                        <table width="50%" id="" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th valign="bottom">Tgl Masuk</th>
                                                    <th valign="bottom">Nomor PO</th>
                                                    <th valign="bottom">Stok</th>
                                                </tr>
                                            </thead>
                                            <?php

                                            ?>
                                            <tr>
                                                <td><input id="" name="tgl_masuk" class="form-control" type="date" placeholder="" autofocus="autofocus" size="3" required /></td>
                                                <td><input id="" name="no_po" class="form-control" type="text" placeholder="" size="4" required /></td>
                                                <td><input id="no_po" name="stok" class="form-control" type="text" placeholder="" size="1" required="required" /></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <br />
                                    <center>
                                        <button name="simpan_barang" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Next</button>
                                    </center>
                                    <br />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box (chat box) -->

                <!-- TO DO List --><!-- /.box -->

                <!-- quick email widget -->
            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">

                <!-- Map box --><!-- /.box -->

                <!-- solid sales graph --><!-- /.box -->

                <!-- Calendar --><!-- /.box -->

            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
</div>
<?php
if (isset($_POST['tambah_laporan'])) {
    $Result = mysqli_query($koneksi, "insert into aksesoris values('','" . $_POST['nama_akse'] . "','" . $_POST['merk'] . "','" . $_POST['tipe'] . "','" . $_POST['no_seri'] . "','" . $_POST['stok'] . "', '" . $_POST['deskripsi'] . "','" . $_POST['harga_satuan'] . "')");
    if ($Result) {
        echo "<script type='text/javascript'>
		alert('Data Berhasil Di Tambah !');
		window.location='index.php?page=simpan_tambah_aksesoris&id=$_GET[id]';
		</script>";
    }
}
?>
<div id="openAkse" class="modalDialog">
    <div>
        <a href="#" title="Close" class="close">X</a>
        <h3 align="center">Tambah Aksesoris Baru</h3>
        <form method="post">
            <input name="nama_akse" class="form-control" type="text" required placeholder="Nama Aksesoris" autofocus><br />

            <input name="merk" class="form-control" type="text" placeholder="Merk" required><br />

            <input name="tipe" class="form-control" type="text" placeholder="Tipe" required><br />

            <input name="no" class="form-control" type="text" placeholder="Nomor Seri" required><br />

            <input name="stok" class="form-control" type="text" placeholder="Stok" required><br />

            <textarea name="deskripsi" class="form-control" type="text" rows="5" placeholder="Deskripsi Alat" required></textarea><br />
            <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator'])) { ?>
                <input name="harga_satuan" class="form-control" type="text" placeholder="Harga Satuan" required><br />
            <?php } ?>

            <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Simpan</button>
            <br /><br />
        </form>

    </div>
</div>