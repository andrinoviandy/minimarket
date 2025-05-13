<?php
if (isset($_POST['simpan_barang'])) {
    $ns = '';
    for ($k = 0; $k < $_SESSION['stok']; $k++) {
        //$no_s=$_POST['no_seri'][$k];
        for ($l = 0; $l != $k and $l < $_SESSION['stok']; $l++) {
            if ($_POST['no_seri'][$k] == $_POST['no_seri'][$l] and $_POST['no_seri'][$k] != '-' and $_POST['no_seri'][$k] != '') {
                $ns = $ns . $_POST['no_seri'][$k] . ",";
            }
        }
    }
    if ($ns == '') {
        $jml_cek = 0;
        $sn = '';
        for ($jj = 0; $jj < $_SESSION['stok']; $jj++) {
            $ce = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where barang_gudang_id=" . $_GET['id'] . " and no_seri_brg!='-' and no_seri_brg!='' and no_seri_brg='" . $_POST['no_seri'][$jj] . "'"));
            if ($ce != 0) {
                $sn = $sn . $_POST['no_seri'][$jj] . ",";
            }
            $jml_cek = $jml_cek + $ce;
        }
        if ($jml_cek == 0) {
            $nilai_maks = $_GET['id'];
            $update_stok = mysqli_query($koneksi, "update barang_gudang set stok_total=stok_total+" . $_SESSION['stok'] . " where id=$nilai_maks");

            $simpan_po = mysqli_query($koneksi, "insert into barang_gudang_po values('','$nilai_maks','" . $_SESSION['tgl_masuk'] . "','" . $_SESSION['no_po'] . "','" . $_SESSION['stok'] . "')");

            $max_po = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as max_po from barang_gudang_po"));
            for ($j = 0; $j < $_SESSION['stok']; $j++) {

                $s = mysqli_query($koneksi, "insert into barang_gudang_detail values('','$nilai_maks','" . $max_po['max_po'] . "','" . $_POST['no_bath'][$j] . "','" . $_POST['no_lot'][$j] . "','" . $_POST['no_seri'][$j] . "','" . $_POST['tgl_expired'][$j] . "','" . $_POST['qrcode'][$j] . "','0','0','0','0')");
            }
            if ($s) {
                echo "<script type='text/javascript'>
		alert('Data Alkes Berhasil Disimpan ! Silakan Tambah Lagi !');		window.location='index.php?page=simpan_tambah_barang_masuk5&id=$_GET[id]';
		</script>
		";
                unset($_SESSION['tgl_masuk']);
                unset($_SESSION['no_po']);
                unset($_SESSION['stok']);
            }
        } else {
            echo "<script type='text/javascript'>
		alert('Data Gagal Di Simpan Karena SN dengan Nomor : ($sn) sudah ada !');
		history.back();		
		</script>
		";
        }
    } else {
        echo "<script type='text/javascript'>
		alert('Data Gagal Di Simpan , SN Yang anda input dengan Nomor : ($ns) ada yang sama !');
		history.back();
		</script>
		";
    }
}

if (isset($_POST['simpan_barang_baru'])) {
    $ns = '';
    for ($k = 0; $k < $_SESSION['stok']; $k++) {
        //$no_s=$_POST['no_seri'][$k];
        for ($l = 0; $l != $k and $l < $_SESSION['stok']; $l++) {
            if ($_POST['no_seri'][$k] == $_POST['no_seri'][$l] and $_POST['no_seri'][$k] != '-' and $_POST['no_seri'][$k] != '') {
                $ns = $ns . $_POST['no_seri'][$k] . ",";
            }
        }
    }
    if ($ns == '') {
        $jml_cek = 0;
        $sn = '';
        for ($jj = 0; $jj < $_SESSION['stok']; $jj++) {
            $ce = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where barang_gudang_id=" . $_GET['id'] . " and no_seri_brg!='-' and no_seri_brg!='' and no_seri_brg='" . $_POST['no_seri'][$jj] . "'"));
            if ($ce != 0) {
                $sn = $sn . $_POST['no_seri'][$jj] . ",";
            }
            $jml_cek = $jml_cek + $ce;
        }
        if ($jml_cek == 0) {
            $nilai_maks = $_GET['id'];

            $update_stok = mysqli_query($koneksi, "update barang_gudang set stok_total=stok_total+" . $_SESSION['stok'] . " where id=$nilai_maks");

            $simpan_po = mysqli_query($koneksi, "insert into barang_gudang_po values('','$nilai_maks','" . $_SESSION['tgl_masuk'] . "','" . $_SESSION['no_po'] . "','" . $_SESSION['stok'] . "')");

            $max_po = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as max_po from barang_gudang_po"));
            for ($j = 0; $j < $_SESSION['stok']; $j++) {

                $s = mysqli_query($koneksi, "insert into barang_gudang_detail values('','$nilai_maks','" . $max_po['max_po'] . "','" . $_POST['no_bath'][$j] . "','" . $_POST['no_lot'][$j] . "','" . $_POST['no_seri'][$j] . "','" . $_POST['tgl_expired'][$j] . "','" . $_POST['qrcode'][$j] . "','0','0','0','0')");
            }
            if ($s) {
                echo "<script type='text/javascript'>
		alert('Data Alkes Berhasil Disimpan !');		window.location='index.php?page=tambah_barang_masuk';
		</script>
		";
                unset($_SESSION['tgl_masuk']);
                unset($_SESSION['no_po']);
                unset($_SESSION['stok']);
            }
        } else {
            echo "<script type='text/javascript'>
		alert('Data Gagal Di Simpan Karena SN dengan Nomor : ($sn) sudah ada !');
		history.back();		
		</script>
		";
        }
    } else {
        echo "<script type='text/javascript'>
		alert('Data Gagal Di Simpan , SN Yang anda input dengan Nomor : ($ns) ada yang sama !');
		history.back();
		</script>
		";
    }
}

if (isset($_POST['simpan_akse'])) {
    $nilai_maks = $_GET['id'];

    $simpan_po = mysqli_query($koneksi, "insert into produk_po values('','$_GET[id]','" . $_SESSION['tgl_masuk'] . "','" . $_SESSION['no_po'] . "','" . $_SESSION['stok'] . "', '')");

    $max_po = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as max_po from produk_po"));

    for ($j = 0; $j < $_SESSION['stok']; $j++) {
        $s = mysqli_query($koneksi, "insert into produk_detail(produk_id, produk_po_id, tgl_expired, qrcode) values('$_GET[id]','$max_po[max_po]','" . $_POST['tgl_expired'][$j] . "','" . $_POST['qrcode'][$j] . "')");
    }
    if ($s) {
        unset($_SESSION['tgl_masuk']);
        unset($_SESSION['no_po']);
        unset($_SESSION['stok']);
        echo "<script>
                Swal.fire({
                    customClass: {
                    confirmButton: 'bg-green',
                    cancelButton: 'bg-white',
                    },
                    title: 'Data Berhasil Disimpan !',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false,
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
                                                    <th valign="bottom">Tgl Masuk</th>
                                                    <th valign="bottom">Nomor PO</th>
                                                    <th valign="bottom">Kategori</th>
                                                    <th valign="bottom"><strong>Nama Produk</strong></th>
                                                    <th valign="bottom">Satuan</th>
                                                    <th valign="bottom">Stok Masuk</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $data = mysqli_fetch_array(mysqli_query($koneksi, "select a.*, b.* from produk a left join kategori_produk b on b.id = a.kategori_produk_id where a.id=" . $_GET['id'] . ""));
                                            ?>
                                            <tr>
                                                <td><?php echo date("d F Y", strtotime($_SESSION['tgl_masuk'])); ?></td>
                                                <td><?php echo $_SESSION['no_po']; ?></td>
                                                <td><?php echo $data['kategori']; ?>
                                                <td><?php echo $data['nama_produk']; ?></td>
                                                <td><?php echo $data['satuan']; ?></td>
                                                <td bgcolor="#00FF00"><?php echo $_SESSION['stok']; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <br />
                                    <br />
                                    <div class="table-responsive">
                                        <table width="100%" id="" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <td width="15%" align="center" valign="bottom">Data Ke-</td>
                                                    <td width="26%" align="center" valign="bottom"><strong>Kode Barcode/QRCode</strong></td>
                                                    <td width="26%" align="center" valign="bottom"><strong>Tgl Expired</strong></td>
                                                </tr>
                                                <tr>
                                                    <td align="center" valign="bottom">#</td>
                                                    <td align="center" valign="bottom">
                                                        <div class="input-group col-lg-12">
                                                            <input id="no_barcode_all" name="no_barcode_all" class="form-control" type="text" placeholder="" size="3" />
                                                            <span class="input-group-btn">
                                                                <button type="submit" name="tampilkan" onclick="handleBarcode(); return false" class="btn btn-success"><span class="fa fa-check"></span></button>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td align="center" valign="bottom">
                                                        <div class="input-group col-lg-12">
                                                            <input id="expired_all" name="expired_all" class="form-control" type="date" placeholder="" size="3" />
                                                            <span class="input-group-btn">
                                                                <button type="submit" name="tampilkan" onclick="handleExpired(); return false" class="btn btn-success"><span class="fa fa-check"></span></button>
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <?php
                                            for ($i = 0; $i < $_SESSION['stok']; $i++) {
                                            ?>
                                                <tr>
                                                    <td align="center" bgcolor="#00FF00"><b><?php echo $i + 1; ?></b></td>
                                                    <td align="center"><input id="qrcode<?php echo $i ?>" name="qrcode[]" class="form-control" type="text" placeholder="" size="" /></td>
                                                    <td align="center"><input id="expired<?php echo $i ?>" name="tgl_expired[]" class="form-control" type="date" placeholder="" value="<?php echo $_SESSION['tgl_expired']; ?>" /></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="9" align="center"></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <center>
                                        <button name="simpan_akse" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Selesai & Simpan</button>
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

<script>
    let stok = parseInt(<?php echo $_SESSION['stok']; ?>)

    function handleBarcode() {
        let barcode = $('#no_barcode_all').val();
        for (let i = 0; i < stok; i++) {
            $('#qrcode' + i).val(barcode);
        }
    }

    function handleExpired() {
        let bath = $('#expired_all').val();
        for (let i = 0; i < stok; i++) {
            $('#expired' + i).val(bath);
        }
    }
</script>