<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Tambah Penjualan</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Tambah Penjualan</li>
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
                            <div class="row col-lg-12">
                                <div class="input-group pull pull-left col-lg-3">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4">No.Nota/Faktur</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="no_nota" readonly class="form-control" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4">Pelanggan</label>
                                            <div class="col-sm-8">
                                                <table>
                                                    <tr>
                                                        <td><input type="text" id="pelanggan_id" class="form-control" value="" /></td>
                                                        <td><button class="btn btn-info" onclick="modalPelanggan()"><span class="fa fa-search"></span></button></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- <button name="tambah_laporan" class="btn btn-success" style="margin-right: 10px;" type="button" onclick="modalDeposit(); return false"><span class="fa fa-plus"></span>&nbsp; Tambah Deposit</button> -->
                                </div>
                                <div class="pull pull-right">
                                    <div class="text-right">
                                        <font style="font-size: 20px;" class="text-right">Grand Total</font>
                                    </div>
                                    <div class="text-right text-green">
                                        <font style="font-size: 50px; font-family:Arial, Helvetica, sans-serif; font-weight:bolder" class="text-right">
                                            <div id="grand_total"></div>
                                        </font>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table>
                                        <tr>
                                            <td></td>
                                            <td style="padding-left: 20px; padding-right: 20px; font-weight: bold">Barcode</td>
                                            <td style="padding-left: 20px; padding-right: 20px; font-weight: bold">Nama Produk</td>
                                            <td style="padding-left: 20px; padding-right: 20px; font-weight: bold">Jumlah Order</td>
                                            <td style="padding-left: 20px; padding-right: 20px; font-weight: bold">Harga Satuan</td>
                                            <td style="padding-left: 20px; padding-right: 20px; font-weight: bold">Total</td>
                                        </tr>
                                        <tr>
                                            <td><button class="btn btn-info" onclick="modalProduk()"><span class="fa fa-search"></span></button></td>
                                            <td style="padding-left: 20px; padding-right: 20px"><input type="text" id="barcode" class="form-control" /></td>
                                            <td style="padding-left: 20px; padding-right: 20px">
                                                <input type="hidden" readonly id="produk_id" class="form-control" />
                                                <input type="text" readonly id="nama_produk" class="form-control" />
                                            </td>
                                            <td style="padding-left: 20px; padding-right: 20px; width: 150px"><input type="text" id="jumlah_order" class="form-control" /></td>
                                            <td style="padding-left: 20px; padding-right: 20px">
                                                <input type="hidden" id="harga_beli" class="form-control" />
                                                <input type="text" readonly id="harga_satuan" class="form-control" />
                                            </td>
                                            <td style="padding-left: 20px; padding-right: 20px"><input type="text" readonly id="total_harga" class="form-control" /></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box (chat box) -->

                <!-- TO DO List --><!-- /.box -->

                <!-- quick email widget -->
            </section>
            <?php include "include/header_pencarian.php"; ?>
            <section class="content">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active" onclick="getDataTab1(); return false;" id="tab1"><a href="#fa-icons" data-toggle="tab">Data Produk</a></li>
                                <li onclick="getDataTab2(); return false;" id="tab2"><a href="#fa-icons" data-toggle="tab">Draft Transaksi</a></li>
                            </ul>
                            <div class="tab-content">
                                <!-- Font Awesome Icons -->
                                <div class="tab-pane active" id="fa-icons">
                                    <?php //include "include/getFilter.php"; 
                                    ?>
                                    <?php include "include/atur_halaman.php"; ?>
                                    <?php include "include/getInputSearch.php"; ?>
                                    <div id="table" style="margin-top: 10px; height: 230px; overflow-y: scroll; overflow-x: hidden;"></div>
                                </div>
                                <!-- /#fa-icons -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                    <div class="col-lg-4">
                        <div class="box box-body">
                            <table class="table">
                                <tr>
                                    <td style="font-weight: bold; font-size: 18px">Sub Total</td>
                                    <td style="font-weight: bold; font-size: 18px; color: green" align="right"><input id="nilai_grand_total" type="hidden" name="nilai_grand_total">
                                        <div id="sub_total"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; font-size: 18px">Diskon</td>
                                    <td align="right">
                                        <table>
                                            <tr>
                                                <td width="100px"><input type="number" class="form-control" placeholder="(%)" id="persenDiskon" onkeyup="perbaruiHarga(); return false;" onchange="perbaruiHarga(); return false;"></td>
                                                <td>
                                                    <input type="hidden" class="form-control" placeholder="Nilai Diskon" id="nilai_diskon">
                                                    <input type="text" class="form-control" placeholder="Nilai Diskon" id="nilai_rupiah_diskon">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; font-size: 18px">Grand Total</td>
                                    <td style="font-weight: bold; font-size: 24px; color: green" align="right">
                                        <input id="nilai_kalkulasi_grand_total" type="hidden" name="nilai_kalkulasi_grand_total">
                                        <div id="kalkulasi_grand_total"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; font-size: 18px">Bayar</td>
                                    <td style="font-weight: bold; font-size: 18px" align="right" onclick="modalBayar()"><button class="btn btn-success"><span class="fa fa-check"></span> Bayar</button></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->

            <!-- right col -->
        </div>
        <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="modal-bayar" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pembayaran</h4>
            </div>
            <!-- <form method="post" onsubmit="simpanDeposit(); return false;" id="formPinjam"> -->
            <div class="modal-body">
                <table width="100%">
                    <tr>
                        <td width="30%" height="200px" align="center" style="background-color: gray;">
                            <div id="foto_profil">
                                <span class="fa fa-user" style="font-size: 100px;"></span>
                            </div>
                        </td>
                        <td valign="top" align="right">
                            <table>
                                <tr>
                                    <td style="font-size: 20px; padding: 10px">Kode</td>
                                    <td style="font-size: 20px; padding: 10px">:</td>
                                    <td style="font-size: 20px; padding: 10px"><input type="text" class="form-control" id="kode_siswa" placeholder="Barcode Kartu Siswa / Guru" /><input type="hidden" id="id_siswa" /><input type="hidden" id="kategori_siswa" /></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 20px; padding: 10px">Nama</td>
                                    <td style="font-size: 20px; padding: 10px">:</td>
                                    <td style="font-size: 20px; padding: 10px">
                                        <div id="nama_siswa">..........</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 20px; padding: 10px">Whatsapp</td>
                                    <td style="font-size: 20px; padding: 10px">:</td>
                                    <td style="font-size: 20px; padding: 10px">
                                        <div id="wa_siswa">..........</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 20px; padding: 10px">Saldo</td>
                                    <td style="font-size: 20px; padding: 10px">:</td>
                                    <td style="font-size: 20px; padding: 10px">
                                        <div id="saldo_siswa">..........</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 20px; padding: 10px">PIN Transaksi</td>
                                    <td style="font-size: 20px; padding: 10px">:</td>
                                    <td style="font-size: 20px; padding: 10px">
                                        <button class="btn btn-warning" id="btnPIN" disabled onclick="modalPIN(); return false;">Masukkan PIN</button>
                                        <div id="valid-pin" class="text-greeen"></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" name="simpan" disabled="disabled" id="btnDraft" onclick="simpanDraft(); return false;"><span class="fa fa-envelope-o"></span> Draft</button>
                <button type="button" class="btn btn-success" name="simpan" disabled="disabled" id="btnSubmit" onclick="simpanPembayaran(); return false;"><span class="fa fa-save"></span> Simpan</button>
            </div>
            <!-- </form> -->
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-pin" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="width: 350px;">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Masukan PIN Anda</h4>
            </div>
            <!-- <form method="post" onsubmit="simpanDeposit(); return false;" id="formPinjam"> -->
            <div class="modal-body">
                <center>
                    <table width="100%">
                        <tr>
                            <td>
                                <input style="font-size: 30px; width: 50px; height: 50px; text-align:center" type="text" class="form-control pin-input" maxlength="1" id="angka-1" readonly/>
                            </td>
                            <td>
                                <input style="font-size: 30px; width: 50px; height: 50px; text-align:center" type="text" class="form-control pin-input" maxlength="1" id="angka-2" readonly/>
                            </td>
                            <td>
                                <input style="font-size: 30px; width: 50px; height: 50px; text-align:center" type="text" class="form-control pin-input" maxlength="1" id="angka-3" readonly/>
                            </td>
                            <td>
                                <input style="font-size: 30px; width: 50px; height: 50px; text-align:center" type="text" class="form-control pin-input" maxlength="1" id="angka-4" readonly/>
                            </td>
                            <td>
                                <input style="font-size: 30px; width: 50px; height: 50px; text-align:center" type="text" class="form-control pin-input" maxlength="1" id="angka-5" readonly/>
                            </td>
                            <td>
                                <input style="font-size: 30px; width: 50px; height: 50px; text-align:center" type="text" class="form-control pin-input" maxlength="1" id="angka-6" readonly/>
                            </td>
                        </tr>
                    </table>
                </center>
                <hr />
                <center>
                    <table>
                        <tr>
                            <td style="padding-left: 15px; padding-right: 15px; padding-bottom:15px"><button class="btn btn-default" style="padding:20px; padding-left:30px; padding-right:30px; font-size: 30px; font-weight: bold;" onclick="clickPIN(1); return false;">1</button></td>
                            <td style="padding-left: 15px; padding-right: 15px; padding-bottom:15px"><button class="btn btn-default" style="padding:20px; padding-left:30px; padding-right:30px; font-size: 30px; font-weight: bold;" onclick="clickPIN(2); return false;">2</button></td>
                            <td style="padding-left: 15px; padding-right: 15px; padding-bottom:15px"><button class="btn btn-default" style="padding:20px; padding-left:30px; padding-right:30px; font-size: 30px; font-weight: bold;" onclick="clickPIN(3); return false;">3</button></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 15px; padding-right: 15px; padding-bottom:15px"><button class="btn btn-default" style="padding:20px; padding-left:30px; padding-right:30px; font-size: 30px; font-weight: bold;" onclick="clickPIN(4); return false;">4</button></td>
                            <td style="padding-left: 15px; padding-right: 15px; padding-bottom:15px"><button class="btn btn-default" style="padding:20px; padding-left:30px; padding-right:30px; font-size: 30px; font-weight: bold;" onclick="clickPIN(5); return false;">5</button></td>
                            <td style="padding-left: 15px; padding-right: 15px; padding-bottom:15px"><button class="btn btn-default" style="padding:20px; padding-left:30px; padding-right:30px; font-size: 30px; font-weight: bold;" onclick="clickPIN(6); return false;">6</button></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 15px; padding-right: 15px; padding-bottom:15px"><button class="btn btn-default" style="padding:20px; padding-left:30px; padding-right:30px; font-size: 30px; font-weight: bold;" onclick="clickPIN(7); return false;">7</button></td>
                            <td style="padding-left: 15px; padding-right: 15px; padding-bottom:15px"><button class="btn btn-default" style="padding:20px; padding-left:30px; padding-right:30px; font-size: 30px; font-weight: bold;" onclick="clickPIN(8); return false;">8</button></td>
                            <td style="padding-left: 15px; padding-right: 15px; padding-bottom:15px"><button class="btn btn-default" style="padding:20px; padding-left:30px; padding-right:30px; font-size: 30px; font-weight: bold;" onclick="clickPIN(9); return false;">9</button></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 15px; padding-right: 15px; padding-bottom:15px"><button class="btn btn-danger" style="width: 100%; padding: 20px; font-size: 30px; font-weight: bold;" onclick="deletePIN(); return false;"><span class="fa fa-trash"></span></button></td>
                            <td style="padding-left: 15px; padding-right: 15px; padding-bottom:15px"><button class="btn btn-default" style="padding:20px; padding-left:30px; padding-right:30px; font-size: 30px; font-weight: bold;" onclick="clickPIN(0); return false;">0</button></td>
                            <td style="padding-left: 15px; padding-right: 15px; padding-bottom:15px"><button class="btn btn-success" style="width: 100%; padding: 20px; font-size: 30px; font-weight: bold;" id="btnPinOK" disabled onclick="pinOK(); return false;"><span class="fa fa-check"></span></button></td>
                        </tr>
                    </table>
                </center>
            </div>
            <!-- </form> -->
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-produk">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pilih Produk</h4>
            </div>
            <div class="modal-body">
                <div id="data-produk"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    let start_produk = 0;

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }

    function formatRupiahTanpaRp(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka).replace(/^Rp\s?/, '');
    }

    function reloadProduk(keyword = '') {
        $.get("data/modal-produk.php", {
                start: start_produk,
                limit: 10,
                keyword: keyword
            },
            function(data, textStatus, jqXHR) {
                $('#data-produk').html(data);
            }
        );
    }

    function handleSearch(value) {
        start_produk = 0;
        reloadProduk(value);
    }

    async function modalProduk() {
        await reloadProduk()
        $('#modal-produk').modal('show');
    }

    async function prev() {
        if (start_produk > 0) {
            start_produk = start_produk - 10;
            reloadProduk()
        } else {
            $('#produk-1').css('disabled', 'disabled')
        }
    }

    async function next() {
        // if (start_produk > 0) {
        start_produk = start_produk + 10;
        reloadProduk()
        $('#produk-1').css('disabled', '')
        // }
    }

    function kosongkanFormBayar() {
        $('#kode_siswa').html('')
        $('#id_siswa').html('')
        $('#kategori_siswa').html('')
        $('#nama_siswa').html('.............')
        $('#wa_siswa').html('.............')
        $('#saldo_siswa').html(`.............`)
        $('#btnSubmit').prop('disabled', true)
        $('#btnDraft').prop('disabled', true)
        $('#foto_profil').html(`<span class="fa fa-user" style="font-size: 100px;"></span>`)
    }

    function modalBayar() {
        kosongkanFormBayar()

        $('#modal-bayar').off('shown.bs.modal').on('shown.bs.modal', function() {
            const input = $('#kode_siswa');
            input.val('')
            input.focus();
        });

        // Paksa fokus kembali saat blur
        // input.off('blur').on('blur', function() {
        //     setTimeout(function() {
        //         if ($('#modal-bayar').hasClass('in')) {
        //             input.focus();
        //         }
        //     }, 100);
        // });

        $('#modal-bayar').modal('show');
    }

    $('#modal-bayar').on('shown.bs.modal', function() {
        $('#kode_siswa').focus();
    });

    async function cekSaldoSiswa(value) {
        if (value !== '') {
            await $.get("data/cek-saldo-siswa.php", {
                    kode: value
                },
                function(data) {
                    const obj = JSON.parse(data)
                    if (obj) {
                        $('#nama_siswa').html(obj?.nama)
                        $('#id_siswa').val(obj?.id)
                        $('#kategori_siswa').val(obj?.kategori)
                        $('#wa_siswa').html(obj?.whatsapp)
                        let grand_total = parseInt($('#nilai_kalkulasi_grand_total').val())
                        if (grand_total <= parseInt(obj?.saldo)) {
                            $('#saldo_siswa').html(`<badge class="badge btn-success" style="font-size: 20px">Cukup</badge>`)
                            $('#btnDraft').prop('disabled', false)
                            $('#btnPIN').prop('disabled', false)
                        } else {
                            $('#saldo_siswa').html(`<badge class="badge btn-danger" style="font-size: 20px">Tidak Cukup</badge>`)
                            $('#btnDraft').prop('disabled', false)
                            $('#btnPIN').prop('disabled', true)
                        }
                        $('#foto_profil').html(`<img src="../kantin/assets/client/foto/${obj?.foto}" width="100%" height="100%"/>`)
                        Swal.close();
                    } else {
                        alertCustom('I', 'Data Tidak Ditemukan !', '')
                        kosongkanFormBayar()
                        $('#kode_siswa').focus().select();
                    }
                }
            );
        } else {
            await alertCustom('I', 'Barcode Kartu Tidak Boleh Kosong !', '')
            $('#kode_siswa').focus().select();
        }
    }

    $('#kode_siswa').on('keypress', function(e) {
        if (e.which == 13) { // 13 = Enter key            
            e.preventDefault(); // Hindari form submit jika ada
            cekSaldoSiswa(this.value); // Panggil fungsi cekProduk
        }
    });

    function perbaruiHarga() {
        $.get("data/harga-jual-produk.php", {
                status: status_penjualan
            },
            function(data) {
                const obj = JSON.parse(data)
                $('#sub_total').html(formatRupiah(obj?.total_harga))
                // diskon
                let persenDiskon = $('#persenDiskon').val()
                let nilai_diskon = obj?.total_harga * persenDiskon / 100
                $('#nilai_diskon').val(nilai_diskon)
                $('#nilai_rupiah_diskon').val(formatRupiahTanpaRp(nilai_diskon))
                // nilai kalkulasi grand total
                let nilai_kalkulasi = obj?.total_harga - nilai_diskon
                $('#nilai_kalkulasi_grand_total').val(nilai_kalkulasi)
                $('#kalkulasi_grand_total').html(formatRupiah(nilai_kalkulasi))

                $('#nilai_grand_total').val(nilai_kalkulasi)
                $('#grand_total').html(formatRupiah(nilai_kalkulasi))
            }
        );
    }

    async function hapus(id) {
        const confirm = await alertConfirm('Apakah Anda Yakin Menghapus Data Ini ?', 'Data Tidak Dapat Dikembalikan')
        if (confirm) {
            $.post("data/hapus-jual-produk.php", {
                    id: id
                },
                function(data, textStatus, jqXHR) {
                    if (data == 'S') {
                        alertHapus('S')
                        loadMore(load_flag, key, status_b);
                    } else {
                        alertHapus('F')
                    }
                    perbaruiHarga()
                }
            );
        }
    }

    async function modalPIN() {
        // $('#modal-pin').off('shown.bs.modal').on('shown.bs.modal', function() {
            // const input = $('#angka-1');
            // input.val('')
            // input.focus();
        // });
        for (let i = 1; i <= 6; i++) {
            $(`#angka-${i}`).val('');
        }
        $('#modal-pin').modal('show');
    }

    function clickPIN(params) {
        for (let i = 1; i <= 6; i++) {
        let input = $(`#angka-${i}`);
            if (i == 6) {
                $('#btnPinOK').prop('disabled',false)
            }
            if (input.val() === '') {
                input.val(params).focus();
                break;
            }
        }
    }

    function deletePIN() {
        for (let i = 6; i >= 1; i--) {
        let input = $(`#angka-${i}`);
        $('#btnPinOK').prop('disabled',true)
        if (input.val() != '') {
            input.val('');
            $(`#angka-${i-1}`).focus().select()
            break;
            }
        }
    }

    function deleteAllPIN() {
        $('#btnPinOK').prop('disabled',true)
        for (let i = 1; i <= 6; i++) {
            let input = $(`#angka-${i}`);
            input.val('');
        }
        $(`#angka-1`).focus().select()
    }

    async function hashPIN(pin) {
        const encoder = new TextEncoder();
        const data = encoder.encode(pin);
        const hashBuffer = await crypto.subtle.digest('SHA-256', data);
        const hashArray = Array.from(new Uint8Array(hashBuffer));
        const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
        return hashHex;
    }
    
    async function pinOK() {
        showLoading2(1)
        let gabung_pin = '';
        for (let i = 1; i <= 6; i++) {
            gabung_pin = gabung_pin + $(`#angka-${i}`).val() 
        }
        const payload = {
            id_siswa: parseInt($('#id_siswa').val()),
            kategori: $('#kategori_siswa').val(),
            pin: await hashPIN(gabung_pin),
        }
        await $.get("data/cek-pin-siswa.php", 
                    payload
                ,
                function(data) {
                    showLoading(2)
                    if (data == 'S') {
                        $('#valid-pin').html('<font style="color: green; font-weight: bold">PIN VALID</font>')
                        $('#modal-pin').modal('hide')
                        $('#btnSubmit').prop('disabled', false)
                    } else {
                        alertCustom('F', 'PIN Tidak Cocok !', 'Dicoba Kembali')
                        deleteAllPIN()
                    }
                }
            );
    }

    async function getDataTab1() {
        $('.nav-tabs li').removeClass('active');
        $('#tab1').addClass('active');
        loading2('#table')
        status_penjualan = 0
        await loadMore(load_flag, key)
    }

    async function getDataTab2() {
        loading2('#table')
        status_penjualan = 1
        await loadMore(load_flag, key)
    }

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

        var noFaktur = 'TRX-' + tahun + bulan + tanggal + '-' + jam + menit + detik;
        $('#no_nota').val(noFaktur);
    }

    function kosongkan() {
        $('#barcode').val('');
        $('#produk_id').val('');
        $('#nama_produk').val('');
        $('#jumlah_order').val('');
        $('#harga_satuan').val('');
        $('#harga_beli').val('');
        $('#harga_total').val('');
    }

    async function simpanJualProduk() {
        const payload = {
            no_nota: $('#no_nota').val(),
            produk_id: $('#produk_id').val(),
            jumlah_order: $('#jumlah_order').val(),
            harga_beli: $('#harga_beli').val(),
        }
        let count;
        await $.post("data/simpan-jual-produk.php", payload,
            function(data, textStatus, jqXHR) {
                if (data == 'S') {
                    count = 1
                } else {
                    count = 0
                }
            }
        );
        if (count == 1) {
            await kosongkan()
            $('#barcode').focus();
        } else {
            await alertCustom('F', 'Gagal Disimpan !', '')
            $('#barcode').focus().select();
        }
        loadMore(load_flag, key)
        perbaruiHarga()
    }

    async function cekProduk(value) {
        if (value !== '') {
            let count;
            await $.get("data/cek-produk.php", {
                    qrcode: value
                },
                function(data) {
                    const obj = JSON.parse(data)
                    if (obj && obj.length > 0) {
                        $('#produk_id').val(obj[0]?.produk_id);
                        $('#nama_produk').val(obj[0]?.nama_produk);
                        $('#harga_beli').val(obj[0]?.harga_beli);
                        $('#harga_satuan').val(formatRupiah(obj[0]?.harga_beli));
                        $('#jumlah_order').val(1);
                        $('#total_harga').val(formatRupiah(1 * obj[0]?.harga_beli));
                        count = 1;
                    } else {
                        count = 0
                    }
                }
            );
            if (count == 1) {
                $('#jumlah_order').focus().select();
            } else {
                await alertCustom('I', 'Produk Tidak Ditemukan !', '')
                $('#barcode').focus().select();
            }
        } else {
            await alertCustom('I', 'Barcode Tidak Boleh Kosong !', '')
            $('#barcode').focus().select();
        }
    }

    async function pilihProduk(id, harga) {
        const payload = {
            produk_id: id,
            jumlah_order: 1,
            harga_beli: parseInt(harga),
        }
        let count;
        await $.post("data/simpan-jual-produk.php", payload,
            function(data, textStatus, jqXHR) {
                if (data == 'S') {
                    count = 1
                } else {
                    count = 0
                }
            }
        );
        if (count == 1) {
            $('#modal-produk').modal('hide');
            await kosongkan()
            $('#barcode').focus();
        } else {
            $('#modal-produk').modal('hide');
            await alertCustom('F', 'Gagal Disimpan !', '')
            $('#barcode').focus().select();
        }
        loadMore(load_flag, key)
        perbaruiHarga()
    }

    $('#barcode').on('keypress', function(e) {
        if (e.which == 13) { // 13 = Enter key
            e.preventDefault(); // Hindari form submit jika ada
            cekProduk(this.value); // Panggil fungsi cekProduk
        }
    });

    $('#jumlah_order').on('keypress', function(e) {
        if (e.which == 13) { // 13 = Enter key
            e.preventDefault(); // Hindari form submit jika ada
            simpanJualProduk(this.value); // Panggil fungsi cekProduk
        }
    });

    async function simpanDraft() {
        const confirm = await alertConfirm('Apakah Anda Yakin Draft Transaksi Ini ?', 'Klik Ya Untuk Lanjut', 'bg-blue-sky');
        if (confirm) {
            const payload = {
                no_nota: $('#no_nota').val(),
                id_siswa: parseInt($('#id_siswa').val()),
                kategori: $('#kategori_siswa').val(),
                diskon_jual: $('#nilai_diskon').val(),
                total_harga: $('#nilai_kalkulasi_grand_total').val(),
                status: 1,
            }
            $.post("data/simpan-penjualan-produk.php", payload,
                function(data, textStatus, jqXHR) {
                    if (data == 'S') {
                        $('#modal-bayar').modal('hide')
                        alertSimpan('S')
                        kosongkan()
                        kosongkanFormBayar()
                        perbaruiHarga()
                        generateNoFaktur();
                        $('#barcode').focus();
                        loadMore(load_flag, key, status_b);
                    } else {
                        alertSimpan('F')
                    }
                    getDataTab1()
                }
            );
        }
    }

    async function simpanPembayaran() {
        const confirm = await alertConfirm('Apakah Anda Yakin Menyimpan Transaksi Ini ?', 'Klik Ya Untuk Lanjut', 'bg-green');
        if (confirm) {
            const payload = {
                no_nota: $('#no_nota').val(),
                id_siswa: parseInt($('#id_siswa').val()),
                kategori: $('#kategori_siswa').val(),
                diskon_jual: $('#nilai_diskon').val(),
                total_harga: $('#nilai_kalkulasi_grand_total').val(),
                status: 2,
            }
            $.post("data/simpan-penjualan-produk.php", payload,
                function(data, textStatus, jqXHR) {
                    if (data == 'S') {
                        $('#modal-bayar').modal('hide')
                        alertSimpan('S')
                        kosongkan()
                        kosongkanFormBayar()
                        perbaruiHarga()
                        generateNoFaktur();
                        $('#barcode').focus();
                        loadMore(load_flag, key, status_b);
                    } else {
                        alertSimpan('F')
                    }
                    getDataTab1()
                }
            );
        }
    }

    async function openTransaksi(id, no_nota) {
        const confirm = await alertConfirm('Apakah Anda Yakin Membuka Draft Transaksi Ini ?', 'Klik Ya Untuk Lanjut', 'bg-green');
        if (confirm) {
            const payload = {
                id_jual: id,
            }
            $.post("data/open-penjualan-produk.php", payload,
                function(data, textStatus, jqXHR) {
                    if (data == 'S') {
                        $('#no_nota').val(no_nota)
                        alertCustom('S', 'Draft Berhasil Dibuka !')
                        getDataTab1()
                        kosongkan()
                        kosongkanFormBayar()
                        perbaruiHarga()
                        $('#barcode').focus();
                        loadMore(load_flag, key, status_b);
                    } else {
                        alertCustom('F', 'Draft Gagal Dibuka !')
                    }
                }
            );
        }
    }

    $(document).on('click', function(e) {
        // Jika yang diklik BUKAN input atau textarea
        if (!$(e.target).is('input, textarea')) {
            if ($('#modal-bayar').hasClass('in')) {
                $('#kode_siswa').focus();
            } else {
                $('#barcode').focus().select();
            }
        }
    });

    $(document).ready(function() {
        $('#atur_halaman').hide();
        status_penjualan = 0;
        loadMore(load_flag, key)
        perbaruiHarga()
        generateNoFaktur();
        $('#barcode').focus();
    });
</script>