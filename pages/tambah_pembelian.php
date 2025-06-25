<?php
if (isset($_POST['simpan_rs'])) {
    $insert_princ = mysqli_query($koneksi, "insert into supplier values('','" . $_POST['nama_princ'] . "','" . $_POST['alamat_princ'] . "','" . $_POST['telp_princ'] . "','" . $_POST['fax_princ'] . "','" . $_POST['attn_princ'] . "')");
    if ($insert_princ) {
        echo "<script>history.back(-1)</script>";
    }
}

if (isset($_POST['tambah_aksesoris'])) {
    $jml = mysqli_num_rows(mysqli_query($koneksi, "select * from pembelian where no_po_pesan='" . $_POST['no_po'] . "'"));
    if ($jml == 0) {
        mysqli_query($koneksi, "delete from pembelian_detail_temp where akun_id=" . $_SESSION['id'] . "");
        $_SESSION['tgl_po'] = $_POST['tgl_po'];
        $_SESSION['no_po'] = $_POST['no_po'];
        $_SESSION['supplier_id'] = $_POST['id_akse'];
        $_SESSION['ppn'] = $_POST['ppn'];
        $_SESSION['cara_pembayaran'] = $_POST['cara_pembayaran'];
        $_SESSION['catatan'] = $_POST['catatan'];
        echo "<script type='text/javascript'>
	window.location='index.php?page=simpan_tambah_pembelian';
		</script>";
    } else {
        echo "<script>
      Swal.fire({
        customClass: {
          confirmButton: 'bg-warning',
          cancelButton: 'bg-white',
        },
        title: 'Ganti No PO !',
        text: 'Maaf No PO Sudah Ada',
        icon: 'warning',
        confirmButtonText: 'OK',
        allowOutsideClick: false
      }).then(() => {
        history.back();
      })
      </script>";
    }
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tambah Pembelian
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><a href="index.php?page=pembelian">Pembelian</a></li>
            <li class="active">Tambah Pembelian</li>
        </ol>
    </section>


    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) --><!-- /.row -->
        <!-- Main row -->
        <form method="post" enctype="multipart/form-data">
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-6 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

                    <!-- Chat box -->
                    <div class="box box-success"><!-- /.chat -->
                        <div class="box-footer">
                            <div class="box-header with-border">
                                <h3 class="box-title">Detail Pesanan</h3>
                            </div>
                            <div class="box-body">
                                Tanggal PO
                                <input name="tgl_po" class="form-control" type="date" placeholder="" required autofocus="autofocus"><br />
                                No PO
                                <input name="no_po" id="no_po" class="form-control" type="text" placeholder="No. PO" required readonly><br />
                                PPN
                                <input name="ppn" class="form-control" type="number" placeholder="PPN (Example : 10%)"><br />
                                Cara Pembayaran
                                <input name="cara_pembayaran" class="form-control" type="text" placeholder="Cara Pembayaran (COD/Tempo/Cash)"><br />
                                Catatan
                                <textarea name="catatan" class="form-control" placeholder="" rows="4"></textarea><br />
                                <br />
                            </div>
                        </div>
                    </div>
                    <!-- /.box (chat box) -->

                    <!-- TO DO List --><!-- /.box -->

                    <!-- quick email widget -->
                </section>
                <!-- /.Left col -->
                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-6 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

                    <!-- Chat box -->
                    <div class="box box-success"><!-- /.chat -->
                        <div class="box-footer">
                            <div class="box-header with-border">
                                <h3 class="box-title">Pilih Supplier</h3>
                            </div>
                            <div class="box-body">
                                Nama Supplier
                                <div class="input-group">
                                    <select name="id_akse" id="id_akse" required onchange="changeValue(this.value)" class="form-control select2" style="width:100%">
                                        <option value="">...</option>
                                        <?php
                                        $q = mysqli_query($koneksi, "select * from supplier order by nama_supplier ASC");
                                        $jsArray = "var dtBrg = new Array();
";
                                        while ($d = mysqli_fetch_array($q)) { ?>
                                            <option value="<?php echo $d['id']; ?>"><?php echo $d['nama_supplier']; ?></option>
                                        <?php
                                            $jsArray .= "dtBrg['" . $d['id'] . "'] = {alamat_princ:'" . addslashes(str_replace("<br>", "[Enter]", substr($d['alamat_supplier'], 0, 15))) . "............',
						telp_princ:'" . addslashes($d['telp_supplier']) . "',
						fax_princ:'" . addslashes($d['fax_supplier']) . "'
						};";
                                        } ?>

                                    </select>
                                    <span class="input-group-addon label-success" data-toggle="modal" data-target="#modal-tambahrs"><i class="fa fa-plus"></i></span>
                                </div>
                                <br />
                                Alamat Supplier
                                <textarea name="alamat_princ2" rows="4" disabled="disabled" class="form-control" id="alamat_princ2" placeholder=""></textarea><br />
                                Telp. Supplier
                                <input name="telp_princ2" type="text" disabled="disabled" class="form-control" id="telp_princ2" placeholder=""><br />
                                Fax. Supplier
                                <input name="fax_princ2" type="text" disabled="disabled" class="form-control" id="fax_princ2" placeholder=""><br />
                                <button name="tambah_aksesoris" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Next</button>
                                <br /><br />
                                <script type="text/javascript">
                                    <?php
                                    echo $jsArray;
                                    ?>

                                    function changeValue(id_akse) {
                                        document.getElementById('alamat_princ2').value = dtBrg[id_akse].alamat_princ;
                                        document.getElementById('telp_princ2').value = dtBrg[id_akse].telp_princ;
                                        document.getElementById('fax_princ2').value = dtBrg[id_akse].fax_princ;
                                        // document.getElementById('attn_princ2').value = dtBrg[id_akse].attn_princ;
                                    };
                                </script>

                            </div>
                        </div>
                    </div>
                    <!-- /.box (chat box) -->

                    <!-- TO DO List --><!-- /.box -->

                    <!-- quick email widget -->
                </section>
                <!-- right col -->
            </div>
        </form>

        <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="modal-tambahrs">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" align="center">Tambah Supplier Baru</h4>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <strong>Nama Supplier</strong>
                    <input name="nama_princ" class="form-control" type="text" placeholder=""><br />
                    <strong> Alamat Supplier</strong>
                    <textarea name="alamat_principle" class="form-control" placeholder="
" rows="6"></textarea>
                    <br />
                    <strong>Telp.</strong>
                    <input name="telp_princ" class="form-control" type="text" placeholder=""><br />
                    <strong>Fax.</strong>
                    <input name="fax_princ" class="form-control" type="text" placeholder=""><br />
                    <strong>Pemilik</strong>
                    <input name="attn_princ" class="form-control" type="text" placeholder=""><br />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="simpan_rs">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    function pad(num) {
        return num < 10 ? '0' + num : num;
    }

    function generateNoFaktur() {
        var now = new Date();
        var tahun = now.getFullYear();
        var bulan = pad(now.getMonth() + 1); // getMonth() dimulai dari 0
        var tanggal = pad(now.getDate());
        var jam = pad(now.getHours());
        var menit = pad(now.getMinutes());
        var detik = pad(now.getSeconds());

        var noFaktur = 'TRP-' + tahun + bulan + tanggal + '-' + jam + menit + detik;
        $('#no_po').val(noFaktur);
    }

    $(document).ready(function () {
        generateNoFaktur()
    });
</script>