<?php
if (isset($_POST['tambah_laporan'])) {
    mysqli_begin_transaction($koneksi);
    $stmt = $koneksi->prepare("
        INSERT INTO produk (
            kategori_produk_id, nama_produk, harga_beli, harga_jual, satuan
        )
        VALUES (?, ?, ?, ?, ?)
        ");
    $params = [$_POST['kategori_produk_id'], $_POST['nama_produk'], str_replace(".", "", $_POST['harga_beli']), str_replace(".", "", $_POST['harga_jual']), $_POST['satuan']];
    $types = getBindTypes($params);
    $stmt->bind_param($types, ...$params);
    $Result = $stmt->execute();
    if ($Result) {
        mysqli_commit($koneksi);
        echo "<script type='text/javascript'>
		Swal.fire('Data Berhasil Disimpan');
        window.location='index.php?page=produk';
		</script>";
    } else {
        mysqli_rollback($koneksi);
    }
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tambah Produk Baru
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><a href="index.php?page=barang_masuk">Produk</a></li>
            <li class="active">Tambah Produk Bary</li>
        </ol>
    </section>


    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) --><!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-6 connectedSortable">
                <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

                <!-- Chat box -->
                <div class="box box-success"><!-- /.chat -->
                    <div class="box-footer">
                        <div class="box-header with-border">
                            <h3 class="box-title">Tambah Produk Baru</h3>
                        </div>
                        <div class="box-body">
                            <form method="post">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="kategori_produk_id" class="form-control select2" required style="width:100%">
                                        <option value="">...</option>
                                        <?php
                                        $query = mysqli_query($koneksi, "select * from kategori_produk");
                                        while ($data = mysqli_fetch_array($query)) {
                                        ?>
                                            <option value="<?php echo $data['id']; ?>"><?php echo $data['kategori']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input name="nama_produk" class="form-control" type="text" placeholder="" required>
                                </div>
                                <div class="form-group">
                                    <label>Harga Beli</label>
                                    <input name="harga_beli" class="form-control" type="text" placeholder="" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                                </div>
                                <div class="form-group">
                                    <label>Harga Jual</label>
                                    <input name="harga_jual" class="form-control" type="text" placeholder="" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                                </div>
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input name="satuan" class="form-control" type="text" placeholder="" required>
                                </div>
                                <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Simpan</button>
                            </form>
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