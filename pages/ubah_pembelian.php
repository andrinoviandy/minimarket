<?php
if (isset($_POST['batalkan'])) {
    $up = mysqli_query($koneksi, "update pembelian set status_po_batal=1, deskripsi_batal='" . $_POST['deskripsi'] . "' where id=" . $_GET['id'] . "");
    if ($up) {
        echo "<script>
      Swal.fire({
        customClass: {
          confirmButton: 'bg-green',
          cancelButton: 'bg-white',
        },
        title: 'PO Berhasil Dibatalkan ',
        icon: 'success',
        confirmButtonText: 'OK',
      }).then((result) => {
        window.location.href = '?page=pembelian';
      })
      </script>";
    } else {
        echo "<script>
      Swal.fire({
        customClass: {
          confirmButton: 'bg-red',
          cancelButton: 'bg-white',
        },
        title: 'PO Gagal Dibatalkan ',
        icon: 'error',
        confirmButtonText: 'OK',
      }).then((result) => {
        window.location.href = '?page=pembelian';
      })
      </script>";
    }
}

if (isset($_POST['simpan_ubah_baru'])) {
    $sel = mysqli_query($koneksi, "insert into supplier values('','" . $_POST['nama_princ'] . "','" . $_POST['alamat_princ'] . "','" . $_POST['telp_princ'] . "','" . $_POST['fax_princ'] . "','" . $_POST['attn_princ'] . "')");
    $max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_max from supplier"));
    $nilai_m = $max['id_max'];
    if ($sel) {
        $upd_brg_pesan = mysqli_query($koneksi, "update pembelian set supplier_id=$nilai_m where id=$_GET[id]");
        echo "<script type='text/javascript'>
		 window.location='index.php?page=ubah_pembelian&id=$_GET[id]'
		</script>";
    }
}
?>
<?php
if (isset($_POST['simpan_ubah_sudah_ada'])) {
    $upd_brg_pesan = mysqli_query($koneksi, "update pembelian set supplier_id=" . $_POST['id_akse'] . " where id=$_GET[id]");
    if ($upd_brg_pesan) {
        echo "<script type='text/javascript'>
		 window.location='index.php?page=ubah_pembelian&id=$_GET[id]'
		</script>";
    }
}
?>
<?php
$query = mysqli_query($koneksi, "select a.*, b.*, b.id as id_supplier from pembelian a left join supplier b on b.id = a.supplier_id where a.id='" . $_GET['id'] . "'");
$data = mysqli_fetch_array($query);

if (isset($_POST['simpan_perubahan'])) {
    $ppn = $_POST['ppn'] / 100;
    // $sel = mysqli_fetch_array(mysqli_query($koneksi, "select no_po_pesan from barang_pesan where id = " . $_GET['id'] . ""));
    // $up_uang = mysqli_query($koneksi, "update utang_piutang set no_faktur_no_po='" . $_POST['no_po'] . "' where no_faktur_no_po='" . $data['no_po_pesan'] . "'");
    $Result = mysqli_query($koneksi, "update pembelian set tgl_po_pesan='" . $_POST['tgl_po'] . "',no_po_pesan='" . $_POST['no_po'] . "',ppn='" . $_POST['ppn'] . "',cara_pembayaran='" . $_POST['cara_pembayaran'] . "', catatan='" . $_POST['catatan'] . "', total_harga_ppn = total_harga + (total_harga*" . $_POST['ppn'] . "/100) where id=" . $_GET['id'] . "");
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
        window.location.href = '?page=ubah_pembelian&id=$_GET[id]';
      })
      </script>";
    }
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Detail Pembelian</h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><a href="index.php?page=barang_masuk">Pembelian</a></li>
            <li class="active">Detail Pembelian</li>
        </ol>
    </section>


    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->


            <section class="col-lg-12 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <!-- /.nav-tabs-custom -->

                <!-- Chat box -->
                <div class="box box-success">
                    <!-- /.chat -->
                    <div class="box-footer">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detail Alkes</h3>
                        </div>
                        <div class="box-body">
                            <a href="index.php?page=detail_pembelian_produk&id=<?php echo $_GET['id']; ?>">
                                <button class="btn btn-success"><span class="fa fa-edit"></span> &nbsp;Kelola</button>
                            </a>
                            <?php if ($data['status_lunas'] !== 1) { ?>
                            <a href="#" data-toggle="modal" data-target="#modal-batalpo2"><button data-toggle="" title="Batalkan PO" class="btn btn-danger"><i class="fa fa-close"></i> Batalkan PO</button></a>
                            <?php } ?>
                            <strong class="pull pull-right">
                                <table>
                                    <tr>
                                        <td align="left"><strong>Total Harga</strong></td>
                                        <td align="center">&nbsp;&nbsp;:&nbsp;</td>
                                        <td><?php echo "<font style='font-size:20px'>" . $data['simbol'] . " <span class='pull pull-right'>" . number_format($data['total_harga'], 0, ',', '.') . "</span></font>"; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><strong>PPN</strong></td>
                                        <td align="center">:</td>
                                        <td><?php echo "<font style='font-size:20px'>" . $data['simbol'] . " <span class='pull pull-right'>" . number_format($data['total_harga'] * $data['ppn'] / 100, 0, ',', '.') . "</span></font>"; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><strong>Total Harga + PPN</strong></td>
                                        <td align="center">:</td>
                                        <td><?php echo "<font style='font-size:20px'>" . $data['simbol'] . " <span class='pull pull-right'>" . number_format($data['total_harga_ppn'], 0, ',', '.') . "</span></font>"; ?></td>
                                    </tr>
                                </table>
                            </strong>
                            <br /><br /><br /><br /><br /><br />
                            <div id="data-barang-pesan"></div>
                        </div>
                    </div>
                </div>
                <!-- /.box (chat box) -->

                <!-- TO DO List -->
                <!-- /.box -->

                <!-- quick email widget -->
            </section>
            <section class="col-lg-6 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <!-- /.nav-tabs-custom -->

                <!-- Chat box -->
                <div class="box box-success">
                    <!-- /.chat -->
                    <div class="box-footer">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data Umum</h3>
                        </div>
                        <div class="box-body">
                            <form method="post">
                                <label>Tgl PO</label>
                                <input name="tgl_po" class="form-control" placeholder="Nama Barang" type="date" value="<?php echo $data['tgl_po_pesan']; ?>"><br />
                                <label>No PO </label><input name="no_po" class="form-control" placeholder="No PO" type="text" value="<?php echo $data['no_po_pesan']; ?>"><br />

                                <label>PPN (%)</label>
                                <input name="ppn" class="form-control" type="number" placeholder="PPN (Example :10%)" value="<?php echo $data['ppn']; ?>"><br />

                                <label>Cara Pembayaran</label><input name="cara_pembayaran" class="form-control" type="text" placeholder="Cara Pembayaran" value="<?php echo $data['cara_pembayaran']; ?>"><br />
                                <label>Catatan</label>
                                <textarea name="catatan" class="form-control" placeholder="Note" rows="4"><?php echo $data['catatan']; ?></textarea><br />
                                <button name="simpan_perubahan" class="btn btn-success" type="submit"><span class="fa fa-edit"></span> Simpan Perubahan</button>
                                <br /><br />
                            </form>
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
            <section class="col-lg-6 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <!-- /.nav-tabs-custom -->

                <!-- Chat box -->
                <div class="box box-success">
                    <!-- /.chat -->
                    <div class="box-footer">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data Supplier</h3>
                        </div>
                        <div class="box-body">
                            <label>Nama Supplier</label><input name="" type="text" disabled="disabled" class="form-control" placeholder="Nama Principle" value="<?php echo $data['nama_supplier']; ?>"><br />

                            <label>Alamat Supplier</label>
                            <textarea name="" rows="6" disabled="disabled" class="form-control" placeholder=""><?php echo str_replace("<br>", "\n", $data['alamat_supplier']); ?></textarea><br />

                            <label>Telp. Supplier</label>
                            <input name="" type="text" disabled="disabled" class="form-control" placeholder="PPN (Example :10%)" value="<?php echo $data['telp_supplier']; ?>"><br />

                            Fax. Supplier
                            <label></label><input name="" type="text" disabled="disabled" class="form-control" placeholder="Cara Pembayaran" value="<?php echo $data['fax_supplier']; ?>"><br />
                            Pemilik
                            <input name="" type="text" disabled="disabled" class="form-control" placeholder="Jalur Pengiriman" value="<?php echo $data['attn_supplier']; ?>"><br />

                            <button name="ubah_baru" class="btn btn-success" type="button" data-toggle="modal" data-target="#modal-principlebaru"><span class="fa fa-edit"></span> Ubah Dengan Data Yang Baru</button>
                            <button name="ubah_sudah_ada" class="btn btn-success pull pull-right" type="button" data-toggle="modal" data-target="#modal-principleada"><span class="fa fa-edit"></span> Ubah Dengan Data Yang Sudah Ada</button>
                            <br /><br />

                        </div>
                    </div>
                </div>
                <!-- /.box (chat box) -->

                <!-- TO DO List -->
                <!-- /.box -->

                <!-- quick email widget -->
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
</div>
<div class="modal fade" id="modal-principlebaru">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" align="center">Supplier Baru</h4>
            </div>
            <form method="post">
                <div class="modal-body">
                    <label>Nama Supplier</label><input name="nama_princ" type="text" class="form-control" placeholder="" value="">

                    <label>Alamat Supplier</label>
                    <textarea name="alamat_princ" rows="6" class="form-control" placeholder=""></textarea>

                    <label>Telp. Supplier</label>
                    <input name="telp_princ" type="text" class="form-control" placeholder="" value="">

                    <label>Fax. Supplier</label>
                    <input name="fax_princ" type="text" class="form-control" placeholder="" value="">
                    <label>Pemilik</label>
                    <input name="attn_princ" type="text" class="form-control" placeholder="" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button name="simpan_ubah_baru" type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-principleada">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" align="center">Ubah Supplier Dengan Yang Sudah Ada</h4>
            </div>
            <form method="post">
                <div class="modal-body">
                    <label>Pilih Supplier</label>
                    <select name="id_akse" id="id_akse" class="form-control select2" required style="width:100%">

                        <?php
                        $q = mysqli_query($koneksi, "select * from supplier order by nama_supplier ASC");
                        $jsArray = "var dtBrg = new Array();
";
                        while ($d = mysqli_fetch_array($q)) { ?>
                            <option value="<?php echo $d['id']; ?>" <?php if ($d['id'] == $data['id_supplier']) {
                                                                        echo "selected";
                                                                    } ?>><?php echo $d['nama_supplier']; ?></option>
                        <?php
                            $jsArray .= "dtBrg['" . $d['id'] . "'] = {alamat_princ:'" . substr($d['alamat_supplier'], 0, 40) . "..............',
						telp_princ:'" . addslashes($d['telp_supplier']) . "',
						fax_princ:'" . addslashes($d['fax_supplier']) . "',
						attn_princ:'" . addslashes($d['attn_supplier']) . "'
						};";
                        } ?>

                    </select>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button name="simpan_ubah_sudah_ada" type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-batalpo2<?php echo $json[$i]['idd']; ?>">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pembatalan Pembelian</h4>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" name="id_batal" value="<?php echo $json[$i]['idd'] ?>" />
                    <label>Alasan</label>
                    <textarea class="form-control" rows="4" name="deskripsi" style="width:100%"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button name="batalkan" type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    function dataBarang() {
        $.get("data/data-produk-pembelian.php", {
                id: <?php echo $_GET['id']; ?>
            },
            function(data) {
                $('#data-barang-pesan').html(data);
            }
        );
    }

    $(document).ready(function() {
        dataBarang();
    });
</script>