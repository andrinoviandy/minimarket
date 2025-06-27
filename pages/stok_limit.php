<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Stok Limit</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Stok Limit</li>
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
                                <div class="pull pull-left">
                                    <table align="center">
                                        <tr>
                                            <td>&nbsp; Masukkan Nilai Stok Limit Yang Ingin Dilihat &nbsp;</td>
                                            <td><input type="number" name="stok_limit" id="stok_limit" class="form-control" /></td>
                                            <td><button name="lihat" type="submit" class="btn btn-success" onclick="lihatData(); return false;">Lihat</button></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="pull pull-right">
                                    <?php //include "include/getFilter.php"; 
                                    ?>
                                    <?php include "include/atur_halaman.php"; ?>
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
            <?php //include "include/header_pencarian.php"; 
            ?>
            <div id="header_pencarian"></div>
            <section class="col-lg-12 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <!-- /.nav-tabs-custom -->

                <!-- Chat box -->
                <div class="box box-success">
                    <!-- /.chat -->
                    <div class="box-footer">
                        <div class="box-body">
                            <?php include "include/getInputSearch.php"; ?>
                            <div id="table" style="margin-top: 10px;"></div>
                            <section class="col-lg-12">
                                <center>
                                    <ul class="pagination" style="display: none;">
                                        <button class="btn btn-default" id="paging-1"><a><i class="fa fa-angle-double-left"></i></a></button>
                                        <button class="btn btn-default" id="paging-2"><a><i class="fa fa-angle-double-right"></i></a></button>
                                    </ul>
                                    <?php include "include/getInfoPagingData.php"; ?>
                                </center>
                            </section>
                        </div>
                    </div>
                </div>
                <!-- /.box (chat box) -->

                <!-- TO DO List -->
                <!-- /.box -->

                <!-- quick email widget -->
            </section>
            <!-- /.content -->
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->

            <!-- right col -->
        </div>
        <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="modal-detailbarang">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" align="center">Detail Produk</h4>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div id="modal-barang-pesan"></div>
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

<div class="modal fade" id="modal-riwayat">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" align="center">Riwayat Pembayaran</h4>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div id="data-riwayat"></div>
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

<div class="modal fade" id="modal-bayar-piutang">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" align="center">Bayar Piutang</h4>
            </div>
            <form method="post">
                <div class="modal-body">
                    <label>No Nota</label>
                    <input type="hidden" disabled name="id_penjualan" id="id_penjualan" class="form-control" />
                    <input type="text" disabled name="no_nota" id="no_nota" class="form-control" />
                    <br>
                    <label>No. Pembayaran</label>
                    <input type="text" id="no_pembayaran" name="no_pembayaran" readonly class="form-control" />
                    <br>
                    <label>Tanggal Pembayaran</label>
                    <input type="date" name="tgl_pembayaran" id="tgl_pembayaran" class="form-control" />
                    <br>
                    <label>Nominal Pembayaran</label>
                    <input type="text" name="nominal_pembayaran" id="nominal_pembayaran" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                    <br>
                    <label>Deskripsi</label>
                    <textarea rows="4" class="form-control" name="deskripsi" id="deskripsi"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success pull-right" onclick="simpanBayarPiutang(); return false;">Simpan Pembayaran</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-principle">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" align="center">Data Principle</h4>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div id="data-principle"></div>
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

<div class="modal fade" id="modal-pengiriman">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" align="center">Data Pengiriman</h4>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div id="data-pengiriman"></div>
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

<div class="modal fade" id="modal-cetak">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <center>Cetak Rekapan Pembelian Barang</center>
                </h4>
            </div>
            <form method="post" enctype="multipart/form-data" onsubmit="cetakRekapan(); return false;">
                <div class="modal-body">
                    <label>Dari Tanggal</label>
                    <input name="tgl1" id="tglRekap1" type="date" class="form-control" required placeholder="" value=""><br />
                    <label>Sampai Tanggal</label>
                    <input name="tgl2" id="tglRekap2" type="date" class="form-control" required placeholder="" value=""><br />
                    <label>Jenis PO</label>
                    <input disabled class="form-control" value="Dalam Negeri">
                    <!-- <label>Filter Berdasarkan</label>
          <select class="form-control select2" id="filterRekap" onchange="filterCetak(this.value)" style="width:100%" name="filter">
            <option value="0">...</option>
            <option value="1">Nama Principle</option>
            <option value="2">Provinsi/Kabupaten/Kecamatan</option>
          </select>
          <br><br>
          <div id="filterData"></div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info" name="cetak"><i class="fa fa-print"></i> Cetak</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    let stok_limit;
    function cetakRekapan() {
        var tgl1 = $('#tglRekap1').val();
        var tgl2 = $('#tglRekap2').val();
        var filter = $('#filterRekap').val();
        var pembeli = $('#pembeli').val();
        var provinsi = $('#provinsi1').val();
        var kabupaten = $('#kabupaten1').val();
        var kecamatan = $('#kecamatan1').val();
        // $.post("cetak_laporan_penjualan_alkes.php",
        //   function(data) {
        window.location.href = 'cetak_laporan_pembelian_alkes.php?tgl1=' + tgl1 + '&tgl2=' + tgl2 + '&jenis_po=1';

        //   }
        // );
    }

    function modalPrinciple(id) {
        $.get("data/modal-principle.php", {
                id: id
            },
            function(data) {
                $('#data-principle').html(data);
                $('#modal-principle').modal('show');
            }
        );
    }

    function modalPengiriman(id) {
        $.get("data/modal-pengiriman.php", {
                id: id
            },
            function(data) {
                $('#data-pengiriman').html(data);
                $('#modal-pengiriman').modal('show')
            }
        );
    }

    function modalBarang(id) {
        $.get("data/modal-penjualan-produk.php", {
                id: id
            },
            function(data) {
                $('#modal-barang-pesan').html(data);
                $('#modal-detailbarang').modal('show')
            }
        );
    }

    function modalRiwayat(id) {
        $.get("data/modal-riwayat-pembayaran.php", {
                id: id
            },
            function(data) {
                $('#data-riwayat').html(data);
                $('#modal-riwayat').modal('show')
            }
        );
    }

    function pad(num) {
        return num < 10 ? '0' + num : num;
    }

    async function modalBayarPiutang(id, no_nota) {
        var now = new Date();
        var tahun = now.getFullYear();
        var bulan = pad(now.getMonth() + 1); // getMonth() dimulai dari 0
        var tanggal = pad(now.getDate());
        var jam = pad(now.getHours());
        var menit = pad(now.getMinutes());
        var detik = pad(now.getSeconds());

        var noFaktur = 'PTG-' + tahun + bulan + tanggal + '-' + jam + menit + detik;

        $('#id_penjualan').val(id),
            $('#no_nota').val(no_nota),
            $('#no_pembayaran').val(noFaktur)

        $('#modal-bayar-piutang').modal('show');
        // await $.get("data/data-bayar-piutang.php", {
        //     id: id,
        //     no_nota: no_nota,
        //     no_pembayaran: noFaktur
        //   },
        //   function(data) {
        //     $('#data-bayar-piutang').html(data);
        //   }
        // );
    }

    function simpanBayarPiutang() {
        const payload = {
            id: $('#id_penjualan').val(),
            nomor: $('#no_pembayaran').val(),
            tgl: $('#tgl_pembayaran').val(),
            nominal: $('#nominal_pembayaran').val(),
            deskripsi: $('#deskripsi').val()
        }
        $.post("data/simpan-bayar-piutang.php", payload,
            function(data) {
                if (data == 'S') {
                    $('#modal-bayar-piutang').modal('hide')
                    loadMore(load_flag, key, status_b);
                    alertSimpan('S');
                } else {
                    alertSimpan('F');
                }
            }
        );
    }

    function hapus(id) {
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
                $.post("data/hapus-penjualan.php", {
                        id_hapus: id
                    },
                    function(data) {
                        if (data == 'S') {
                            addRiwayat('DELETE', 'penjualan', id, 'Menghapus Data Penjualan')
                            alertHapus('S');
                            loadMore(load_flag, key, status_b);
                        } else {
                            alertHapus('F');
                        }
                    }
                );
            }
        })
    }

    function pulihkan(id) {
        Swal.fire({
            customClass: {
                confirmButton: 'bg-green',
                cancelButton: 'bg-white',
            },
            title: 'Anda Yakin Akan Memulihkan Data PO Ini ?',
            text: 'Data Akan Di Buka Kembali',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya , Pulihkan',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("data/pulihkan-batal-pembelian.php", {
                        id_pulih: id
                    },
                    function(data) {
                        if (data == 'S') {
                            alertCustom('S', 'Berhasil Dipulihkan !', '');
                            loadMore(load_flag, key, status_b);
                        } else {
                            alertCustom('F', 'Gagal Dipulihkan !', '');
                        }
                    }
                );
            }
        })
    }

    function lihatData() {
        showLoading2(1);
        setTimeout(() => {
            showLoading2(0);
            stok_limit = $('#stok_limit').val()
            loadMore(load_flag, key, status_b);
        }, 1000);
    }
</script>