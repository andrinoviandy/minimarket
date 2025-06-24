<?php
$query = mysqli_query($koneksi, "select a.*, b.*, b.id as id_supplier from pembelian a left join supplier b on b.id = a.supplier_id where a.id='" . $_GET['id'] . "'");
$data = mysqli_fetch_array($query);

if (isset($_POST['tambah_laporan'])) {
    $Result = mysqli_query($koneksi, "update barang_pesan_detail set qty=" . $_POST['qty2'] . ", harga_perunit=" . $_POST['harga_perunit2'] . ", diskon=" . $_POST['diskon2'] . ", harga_total=" . $_POST['total_harga2'] . " where id=" . $_POST['id_ubah'] . "");
    if ($Result) {
        mysqli_query($koneksi, "update barang_pesan set cost_byair=0, cost_cf=0 where id=$_GET[id]");
        echo "<script type='text/javascript'>
	alert('Berhasil Di Ubah ! Harap isi kembali Ongkir nya !');	window.location='index.php?page=tambah_po_alkes2&id=$_GET[id]';
		</script>";
    }
}

if (isset($_POST['simpan_barang'])) {
    $s = mysqli_query($koneksi, "update utang_piutang set nominal=" . $_POST['dalam_rupiah'] . " where no_faktur_no_po='" . $data['no_po_pesan'] . "'");
    $simpan = mysqli_query($koneksi, "update barang_pesan set total_price='" . $_POST['total_price'] . "', total_price_ppn='" . $_POST['total_price_ppn'] . "', cost_byair='" . $_POST['cost_byair'] . "', cost_cf='" . $_POST['cost_cf'] . "',nilai_tukar='" . $_POST['nilai_tukar'] . "' where id=$_GET[id]");
    if ($simpan and $s) {

        echo "<script type='text/javascript'>
	alert('Data Berhasil Di Simpan !');
	window.location='index.php?page=ubah_pembelian_alkes2&id=$_GET[id]'</script>";
    }
}

if (isset($_POST['simpan_tambah_aksesoris'])) {
    $simpan = mysqli_query($koneksi, "insert into pembelian_detail values('','" . $_GET['id'] . "','" . $_POST['id_akse'] . "','" . $_POST['qty'] . "','" . str_replace(".", "", $_POST['harga_perunit']) . "','" . $_POST['diskon'] . "','" . ($_POST['qty'] * intval(str_replace(".", "", $_POST['harga_perunit']))) - ($_POST['diskon'] / 100 * ($_POST['qty'] * intval(str_replace(".", "", $_POST['harga_perunit'])))) . "','')");
    if ($simpan) {
        $sum = mysqli_fetch_array(mysqli_query($koneksi, "select sum(total_harga) as total from pembelian_detail where pembelian_id = " . $_GET['id'] . ""));
        mysqli_query($koneksi, "update pembelian set total_harga=$sum[total], total_harga_ppn=$sum[total]+(ppn/100*$sum[total]) where id=$_GET[id]");
        echo "<script>
      Swal.fire({
        customClass: {
          confirmButton: 'bg-green',
          cancelButton: 'bg-white',
        },
        title: 'Data Berhasil Disimpan !',
        icon: 'success',
        confirmButtonText: 'OK',
      }).then(() => {
        window.location.href = '?page=detail_pembelian_produk&id=$_GET[id]';
      })
      </script>";
    } else {
        echo "<script>
      Swal.fire({
        customClass: {
          confirmButton: 'bg-red',
          cancelButton: 'bg-white',
        },
        title: 'Data Gagal Disimpan !',
        icon: 'success',
        confirmButtonText: 'OK',
      }).then(() => {
        window.location.href = '?page=detail_pembelian_produk&id=$_GET[id]';
      })
      </script>";
    }
}

if (isset($_GET['id_hapus'])) {
    $del = mysqli_query($koneksi, "delete from barang_pesan_detail where id=" . $_GET['id_hapus'] . "");
    mysqli_query($koneksi, "update barang_pesan set cost_byair=0, cost_cf=0 where id=$_GET[id]");
    echo "<script type='text/javascript'>
	alert('Harap isi kembali Ongkir nya !');	window.location='index.php?page=tambah_po_alkes2&id=$_GET[id]';
		</script>";
}
?>
<script type="text/javascript">
    // function sum() {
    //   var txtFirstNumberValue = document.getElementById('qty').value;
    //   var txtSecondNumberValue = document.getElementById('harga_perunit').value;
    //   var txtThirdNumberValue = document.getElementById('diskon').value;

    //   var result = parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue) - (parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue) * (parseFloat(txtThirdNumberValue) / 100));
    //   if (!isNaN(result)) {
    //     document.getElementById('total_harga').value = result;
    //   }
    // }

    function sum_total_keseluruhan() {
        var txtFirstNumberValue = document.getElementById('total_price_ppn').value;
        var txtSecondNumberValue = document.getElementById('cost_byair').value;
        var txtFourNumberValue = document.getElementById('nilai_tukar').value;
        var result = parseFloat(txtFirstNumberValue) + parseFloat(txtSecondNumberValue);
        var total_rupiah = parseFloat(result) * parseFloat(txtFourNumberValue);
        if (!isNaN(result)) {
            document.getElementById('cost_cf').value = result;
            document.getElementById('dalam_rupiah').value = total_rupiah;
            document.getElementById('nominal').value = total_rupiah;
        }
    }

    function sum_total_rupiah() {
        var txtFirstNumberValue = document.getElementById('nilai_tukar').value;
        var txtSecondNumberValue = document.getElementById('cost_cf').value;
        var result = parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue);
        if (!isNaN(result)) {
            document.getElementById('dalam_rupiah').value = result;
        }
    }
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Kelola Data Pembelian Produk</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Detail Pembelian</li>
            <li class="active">Kelola Data Pembelian Produk</li>
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

                                <div class="table-responsive no-padding">
                                    <table width="100%" id="" class="table table-bordered text-nowrap">
                                        <thead>
                                            <tr>
                                                <th valign="bottom"><strong>Tgl PO</strong></th>
                                                <th valign="bottom">No. PO</th>
                                                <th valign="bottom"><strong>Supplier</strong></th>
                                                <th valign="bottom">Alamat Supplier</th>
                                                <th valign="bottom"><strong>PPN</strong></th>
                                                <th valign="bottom"><strong>Cara_Pembayaran</strong></th>
                                                <th valign="bottom">Catatan</th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td><?php echo date("d F Y", strtotime($data['tgl_po_pesan'])); ?>
                                            </td>
                                            <td><?php echo $data['no_po_pesan']; ?></td>
                                            <td><?php echo $data['nama_supplier']; ?></td>
                                            <td><?php echo str_replace("\n", "<br>", $data['alamat_supplier']); ?></td>
                                            <td><?php echo $data['ppn'] . " %"; ?></td>
                                            <td><?php echo $data['cara_pembayaran']; ?></td>
                                            <td><?php echo $data['catatan']; ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <br />
                                <button class="btn btn-success pull pull-right" data-toggle="modal" data-target="#modal-tambahbarang"><span class="fa fa-plus"></span> Tambah Barang</button>
                                <br /><br />
                                <div id="data-barang-pesan"></div>
                                <center>
                                    <a href="index.php?page=ubah_pembelian&id=<?php echo $_GET['id']; ?>">
                                        <button name="simpan_barang" class="btn btn-warning" type="button"><span class="fa fa-arrow-left"></span> Kembali</button>
                                    </a>
                                </center>
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

<div class="modal fade" id="modal-tambahbarang">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" align="center">Tambah Barang</h4>
            </div>
            <form id="formTambah" method="post" onsubmit="tambahData(); return false;">
                <div class="modal-body">
                    <input name="id" type="hidden" value="<?php echo $_GET['id'] ?>">
                    <label>Produk</label>
                    <select name="id_akse" id="id_akse" class="form-control select2" autofocus="autofocus" required style="width:100%">
                        <option value="">...</option>
                        <?php
                        $q = mysqli_query($koneksi, "select * from produk a left join kategori_produk b on b.id = a.kategori_produk_id order by a.nama_produk ASC");
                        while ($d = mysqli_fetch_array($q)) { ?>
                            <option value="<?php echo $d['id']; ?>"><?php echo $d['nama_produk'] . " - " . $d['kategori']; ?></option>
                        <?php } ?>

                    </select><br /><br />
                    <label>Kuantitas</label>
                    <input id="qty" required="required" name="qty" class="form-control" type="text" placeholder="Qty" size="2" />
                    <br />
                    <label>Harga Beli /Satuan</label>
                    <input id="harga_perunit" name="harga_perunit" class="form-control" type="text" required="required" size="10" placeholder="Harga Perunit" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                    <br />
                    <label>Diskon (%)</label>
                    <input id="diskon" name="diskon" class="form-control" type="number" placeholder="Diskon" required="required" size="5" />
                    <br />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button name="simpan_tambah_aksesoris" class="btn btn-success" type="submit">
                        <span class="fa fa-plus"></span> Simpan
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ubahbarang">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" align="center">Ubah Barang</h4>
            </div>
            <form id="formUbah" method="post" onsubmit="ubahData(); return false;">
                <div class="modal-body">
                    <input id="id" name="id" type="hidden" value="<?php echo $_GET['id'] ?>">
                    <input type="hidden" name="id_ubah" id="id_ubah" />
                    <label>Qty</label>
                    <input name="qty2" id="qty2" class="form-control" type="text" required placeholder="" value="<?php echo $data_akse['qty']; ?>" autofocus>
                    <br />
                    <label>Harga Beli /Satuan</label>
                    <input name="harga_perunit2" id="harga_perunit2" class="form-control" type="text" required onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="">
                    <br />
                    <label>Diskon (%)</label>
                    <input name="diskon2" id="diskon2" class="form-control" type="text" required placeholder="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    function dataBarang() {
        $.get("data/kelola-pembelian-produk.php", {
                id: <?php echo $_GET['id']; ?>
            },
            function(data) {
                $('#data-barang-pesan').html(data);
            }
        );
    }

    function modalUbah(id, qty, harga, diskon) {
        $('#id_ubah').val(id);
        $('#qty2').val(qty);
        $('#harga_perunit2').val(harga);
        $('#diskon2').val(diskon);
        $('#modal-ubahbarang').modal('show');
    }

    function simpanData() {
        showLoading(1);
        $.post("data/simpan-barang-kelola.php", {
                id: $('#id_simpan').val(),
                dalam_rupiah: $('#dalam_rupiah').val(),
                total_price: $('#total_price').val(),
                total_price_ppn: $('#total_price_ppn').val(),
                cost_byair: $('#cost_byair').val(),
                cost_cf: $('#cost_cf').val(),
                nilai_tukar: $('#nilai_tukar').val()
            },
            function(data) {
                showLoading(0);
                if (data == 'S') {
                    Swal.fire({
                        customClass: {
                            confirmButton: 'bg-green',
                            cancelButton: 'bg-white',
                        },
                        title: 'Berhasil Di Simpan !',
                        text: 'Data Sukses Disimpan',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'Ok',
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php?page=ubah_pembelian_alkes2&id=<?php echo $_GET['id'] ?>';
                        }
                    })
                } else {
                    alertSimpan('F')
                }
            }
        );
    }

    function tambahData() {
        var dataform = $('#formTambah')[0];
        var data = new FormData(dataform);
        $.ajax({
            type: "post",
            url: "data/tambah-produk-kelola.php",
            data: data,
            enctype: "multipart/form-data",
            contentType: false,
            processData: false,
            success: function(response) {
                if (response == 'S') {
                    $('#modal-tambahbarang').modal('hide');
                    dataform.reset();
                    dataBarang();
                    alertSimpan('S')
                } else {
                    alertSimpan('F')
                }
            }
        });
    }

    function ubahData(id) {
        var dataform = $('#formUbah')[0];
        var data = new FormData(dataform);
        $.ajax({
            type: "post",
            url: "data/ubah-produk-kelola.php",
            data: data,
            enctype: "multipart/form-data",
            contentType: false,
            processData: false,
            success: function(response) {
                if (response == 'S') {
                    $('#modal-ubahbarang').modal('hide');
                    dataform.reset();
                    dataBarang();
                    alertSimpan('S')
                } else {
                    alertSimpan('F')
                }
            }
        });
    }

    function hapusData(id) {
        Swal.fire({
            customClass: {
                confirmButton: 'bg-red',
                cancelButton: 'bg-white',
            },
            title: 'Yakin Akan Menghapus Item Ini ? ?',
            text: 'Data Akan Dihapus Secara Permanen',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya , Hapus',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("data/hapus-produk-kelola.php", {
                        id_hapus: id,
                        id: <?php echo $_GET['id']; ?>
                    },
                    function(data) {
                        if (data == 'S') {
                            dataBarang();
                            alertHapus('S');
                        } else {
                            alertHapus('F');
                        }
                    }
                );
            }
        })
    }

    $(document).ready(function() {
        dataBarang();
    });
</script>