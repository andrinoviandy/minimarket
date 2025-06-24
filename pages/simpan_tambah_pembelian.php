<script type="text/javascript">
    function sum() {
        var txtFirstNumberValue = document.getElementById('qty').value;
        var txtSecondNumberValue = document.getElementById('harga_perunit').value;
        var txtThirdNumberValue = document.getElementById('diskon').value;
        var result = parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue) - (parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue) * (parseFloat(txtThirdNumberValue) / 100));
        if (!isNaN(result)) {
            document.getElementById('total_harga').value = result;

        }
    }
</script>
<script type="text/javascript">
    function sum_total_keseluruhan() {
        var txtFirstNumberValue = document.getElementById('total_price_ppn').value;
        var txtSecondNumberValue = document.getElementById('cost_byair').value;
        var result = parseFloat(txtFirstNumberValue) + parseFloat(txtSecondNumberValue);
        if (!isNaN(result)) {
            document.getElementById('cost_cf').value = result;
            document.getElementById('nominall').value = result;
        }
    }
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Tambah Pembelian</h1>
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
                                    <table width="100%" id="" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th valign="bottom"><strong>Tgl PO</strong></th>
                                                <th valign="bottom">No. PO</th>
                                                <th valign="bottom"><strong>Nama Supplier</strong></th>
                                                <th valign="bottom">Alamat Supplier</th>
                                                <th valign="bottom"><strong>PPN</strong></th>
                                                <th valign="bottom"><strong>Cara Pembayaran</strong></th>
                                                <th valign="bottom">Catatan</th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td><?php echo date("d F Y", strtotime($_SESSION['tgl_po'])); ?>
                                            </td>
                                            <td><?php echo $_SESSION['no_po']; ?></td>
                                            <td><?php
                                                $sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from supplier where id=" . $_SESSION['supplier_id'] . ""));
                                                echo $sel['nama_supplier']; ?></td>
                                            <td><?php echo $sel['alamat_supplier'] . "<br>Telp : " . $sel['telp_suppplier'] . "<br>Fax : " . $sel['fax_supplier'] . "<br>Pemilik : " . $sel['attn_supplier']; ?></td>
                                            <td><?php echo $_SESSION['ppn']; ?></td>
                                            <td><?php echo $_SESSION['cara_pembayaran']; ?></td>
                                            <td><?php echo $_SESSION['catatan']; ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <h3 align="center">
                                    Data Produk
                                </h3>
                                <button class="btn btn-success pull pull-right" data-toggle="modal" data-target="#modal-tambahbarang"><span class="fa fa-plus"></span> Tambah Produk</button>
                                <br /><br />
                                <div class="table-responsive no-padding">
                                    <div id="data-barang"></div>
                                </div>
                                <center>
                                    <!-- <button data-toggle="modal" data-target="#modal-openutang" name="simpan_barang" class="btn btn-success" type="button"><span class="fa fa-check"></span> Simpan</button> -->
                                    <button onclick="simpanPembelian(); return false" name="simpan_barang" class="btn btn-success" type="button"><span class="fa fa-check"></span> Simpan</button>&nbsp;&nbsp;<a href="index.php?page=pembelian"><button name="batal" class="btn btn-success" type="button"><span class="fa  fa-times-circle"></span> Batal</button></a>
                                </center>

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

<div class="modal fade" id="modal-openutang">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" align="center">Hutang Baru</h4>
            </div>
            <form method="post" id="formFix" enctype="multipart/form-data" onsubmit="simpanFix(); return false;">
                <div class="modal-body">
                    <script type="text/javascript">
                        function yesnoCheck() {
                            if (document.getElementById('yesCheck').checked) {
                                document.getElementById('ifYes').style.display = 'block';
                            } else document.getElementById('ifYes').style.display = 'none';
                        }
                    </script>

                    <label>No PO</label>
                    <input name="no_faktur" class="form-control" type="text" placeholder="" disabled="disabled" value="<?php echo $_SESSION['no_po']; ?>"><br />
                    <label>Tanggal</label>
                    <input name="tgl_input" class="form-control" type="date" placeholder="" required="required" value="<?php echo $_SESSION['tgl_po']; ?>"><br />
                    <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="noCheck" style="height:20px; width:20px" checked="checked"><label>Tidak Ada Jatuh Tempo</label><br /><input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="yesCheck" style="height:20px; width:20px"><label>Jatuh Tempo</label>
                    <br />
                    <div id="ifYes" style="display:none">
                        <label>Tanggal Jatuh Tempo</label>
                        <input name="jatuh_tempo" type="date" class="form-control" placeholder="" value=""><br />
                    </div>

                    <label>Nominal</label>
                    <input id="nominall" name="nominal" class="form-control" type="text" placeholder="Dalam Rupiah" value="<?php echo number_format(($total['total']) + (($total['total']) * floatval($_SESSION['ppn']) / 100), 0, ',', ''); ?>"><br />
                    <label>Klien</label>
                    <input name="klien" class="form-control" type="text" placeholder="" value="<?php echo $sel['nama_principle'];  ?>" required="required"><br />
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <?php if (isset($_SESSION['user_administrator']) or isset($_SESSION['adminpodalam'])) { ?><button name="tambah_header" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Simpan</button><?php } ?>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-tambahbarang">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" align="center">Tambah Produk</h4>
            </div>
            <form id="formData" onsubmit="simpanHash(); return false;">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Produk</label>
                        <select name="id_akse" id="id_akse" class="form-control select2" autofocus="autofocus" required style="width:100%">
                            <option value="">...</option>
                            <?php
                            $q = mysqli_query($koneksi, "select * from produk a left join kategori_produk b on b.id = a.kategori_produk_id order by a.nama_produk ASC");
                            while ($d = mysqli_fetch_array($q)) { ?>
                                <option value="<?php echo $d['id']; ?>"><?php echo $d['nama_produk'] . " - " . $d['kategori']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kuantitas</label>
                        <input id="qty" required="required" name="qty" class="form-control" type="text" placeholder="Qty" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" size="2" />
                    </div>
                    <div class="form-group">
                        <label>Harga Beli /Satuan</label>
                        <input id="harga_beli" name="harga_beli" class="form-control" type="text" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required="required" size="10" placeholder="Harga Perunit" />
                    </div>
                    <div class="form-group">
                        <label>Diskon</label>
                        <input id="diskon" name="diskon" class="form-control" type="number" placeholder="Diskon" required="required" size="5" />
                    </div>
                    <div class="form-group">
                        <label>Total Harga</label>
                        <input id="total_harga" name="total_harga" class="form-control" type="text" placeholder="Automatis" readonly="readonly" size="10" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button name="simpan_tambah_aksesoris2" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    function loadingg(param) {
        $.get("include/getLoading.php", function(data) {
            $(param).html(data);
        });
    }

    async function simpanPembelian() {
        showLoading(1)
        await $.post("data/simpan-pembelian.php", {},
            function(data, textStatus, jqXHR) {
                showLoading(0)
                if (data === 'S') {
                    Swal.fire({
                        customClass: {
                            confirmButton: 'bg-green',
                            cancelButton: 'bg-white',
                        },
                        title: 'Pembelian Berhasil Disimpan !',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php?page=pembelian'
                        }
                    })
                } else if (data === 'K') {
                    alertCustom('W', 'Gagal Disimpan !', 'Data Produk Wajib Diisi')
                } else {
                    alertSimpan('F')
                }
            }
        );
    }

    function simpanFix() {
        showLoading(1)
        var dataform = $('#formFix')[0];
        var data = new FormData(dataform);
        $.ajax({
            type: "post",
            url: "data/simpan-barang-pesan.php",
            data: data,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            success: function(response) {
                if (response == 'S') {
                    showLoading(0)
                    Swal.fire({
                        customClass: {
                            confirmButton: 'bg-green',
                            cancelButton: 'bg-white',
                        },
                        title: 'Berhasil Disimpan !',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php?page=pembelian_alkes'
                        }
                    })

                } else {
                    alertSimpan('F')
                }
            }
        });
    }

    function simpanHash() {
        var dataform = $('#formData')[0];
        var data = new FormData(dataform);
        $.ajax({
            type: "post",
            url: "data/simpan-pembelian-produk-temp.php",
            data: data,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            success: function(response) {
                if (response == 'S') {
                    $('#modal-tambahbarang').modal('hide')
                    $('#formData')[0].reset();
                    getData()
                    alertSimpan('S')
                } else {
                    alertSimpan('F')
                }
            }
        });
    }

    function hapus(id) {
        Swal.fire({
            customClass: {
                confirmButton: 'bg-red',
                cancelButton: 'bg-white',
            },
            title: 'Anda Yakin Akan Menghapus Item Ini ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya , Hapus',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("data/hapus-data-pembelian-produk-temp.php", {
                        id_hapus: id
                    },
                    function(data) {
                        if (data == 'S') {
                            getData();
                            alertHapus('S');
                        } else {
                            alertHapus('F')
                        }
                    }
                );
            }
        })
    }

    function getData() {
        $.get("data/data-pembelian-produk.php",
            function(data) {
                $('#data-barang').html(data);
            }
        );
    }

    $(document).ready(function() {
        getData();
    });
</script>