<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Pengiriman Alkes</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Pengiriman Alkes</li>
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
            <div class="box-body">
              <div class="">
                <div class="table-responsive">
                  <table width="100%" id="" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th valign="bottom"><strong>No. PO </strong></th>
                        <th valign="bottom"><strong>Nama Paket</strong></th>
                        <td align="center" valign="bottom"><strong>No. Surat Jalan</strong></td>
                        <td align="center" valign="bottom"><strong>Ekspedisi</strong></td>
                        <td align="center" valign="bottom"><strong>Tanggal Pengiriman</strong></td>
                        <td align="center" valign="bottom"><strong>Via Pengiriman</strong></td>
                        <td align="center" valign="bottom"><strong>Estimasi Brg Sampai</strong></td>
                        <td align="center" valign="bottom"><strong>Biaya Jasa</strong></td>
                      </tr>
                      <tr>
                        <th valign="bottom"><?php echo $_SESSION['no_po']; ?></th>
                        <th valign="bottom"><?php echo $_SESSION['nama_paket']; ?></th>
                        <td align="center" valign="bottom"><?php echo $_SESSION['no_pengiriman']; ?></td>
                        <td align="center" valign="bottom"><?php echo $_SESSION['ekspedisi']; ?></td>
                        <td align="center" valign="bottom"><?php echo date("d-m-Y", strtotime($_SESSION['tgl_pengiriman'])); ?></td>
                        <td align="center" valign="bottom"><?php echo $_SESSION['via_pengiriman']; ?></td>
                        <td align="center" valign="bottom"><?php
                                                            if ($_SESSION['estimasi'] != 0000 - 00 - 00) {
                                                              echo date("d-m-Y", strtotime($_SESSION['estimasi']));
                                                            } ?></td>
                        <td align="center" valign="bottom"><?php echo number_format($_SESSION['biaya_kirim'], 2, ',', '.'); ?></td>
                      </tr>
                    </thead>
                    <?php

                    $no = 0;
                    $q_akse = mysqli_query($koneksi, "select *,barang_dijual_detail.id as idd from barang_dijual_detail,barang_gudang_detail,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dijual_detail.barang_gudang_detail_id and barang_dijual_detail.barang_dijual_id=" . $_GET['id'] . "");
                    $jm = mysqli_num_rows($q_akse);
                    if ($jm != 0) {
                      while ($data_akse = mysqli_fetch_array($q_akse)) {
                        $no++;
                    ?>
                    <?php }
                    } ?>
                  </table>
                </div>
                <h4>Detail Barang</h4>
                <div class="table-responsive">
                  <div id="data-detail-kirim"></div>
                </div>
                <!--<a href="index.php?page=tambah_barang_masuk"><button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Barang</button></a>-->
                <br /><br />
                <center>
                  <h4>
                    Pilih No Seri Yang Akan Dikirim
                  </h4>
                </center>

                <div class="box box-body">
                  <!--<font color="#FF0000">* Jika Ingin Menambah Data Aksesoris Yang Baru ! Klik Disini <a href="index.php?page=simpan_tambah_aksesoris&id=<?php //echo $_GET['id']; 
                                                                                                                                                            ?>#openAkse"><small data-toggle="tooltip" title="Tambah Aksesoris Baru" class="label bg-blue">+ New Accessories</small></a></font>-->
                  <button name="tambah_laporan" class="btn btn-success pull pull-left pull-top" type="button" data-toggle="modal" data-target="#modal-pilihnoseri"><span class="fa fa-plus"></span> Pilih/Tambah No Seri </button>
                  <br /><br /><br />
                  <div class="table-responsive">
                    <div id="data-barang"></div>
                  </div>
                </div>
                <center>
                  <!-- <a href="index.php?page=pilih_no_seri&id=<?php echo $_GET['id']; ?>&simpan_barang=1"> -->
                  <button onclick="simpanFix();" name="simpan_barang" class="btn btn-success" type="button"><span class="fa fa-check"></span> Simpan</button>
                  <!-- </a> -->
                </center>
                <!--
                <center><a href="index.php?page=simpan_jual_alkes2&simpan_barang=1"><button name="simpan_barang" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Simpan</button></a>&nbsp;&nbsp;<a href="index.php?page=jual_barang"><button name="batal" class="btn btn-success" type="submit"><span class="fa  fa-times-circle"></span> Batal</button></a></center>
                -->
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

<div class="modal fade" id="modal-pilihnoseri">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Pilih/Tambah No Seri</h4>
      </div>
      <form method="post" enctype="multipart/form-data" onsubmit="simpanData(); return false;" id="form-no_seri">
        <div class="modal-body">
          <label>Nama Barang</label>
          <select name="id_akse" id="id_akse" class="form-control select2" style="width:100%;" required onchange="ambilDataNoSeri(this.value);">
            <option id="reset" value="">...</option>
            <?php
            $q = mysqli_query($koneksi, "select kategori_brg, nama_brg, tipe_brg, merk_brg,barang_gudang.id as idd, barang_dijual_qty.id as id_qty from barang_gudang,barang_dijual_qty where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual_id=" . $_GET['id'] . " group by barang_dijual_qty.id order by nama_brg ASC");
            while ($d = mysqli_fetch_array($q)) { ?>
              <option value="<?php echo $d['kategori_brg'] . "-" . $d['idd'] . "-" . $d['id_qty']; ?>"><?php echo $d['nama_brg'] . " - " . $d['tipe_brg']; ?>
              </option>
            <?php } ?>
          </select>
          <br /><br />
          <div class="well">
            <div id="isi_no_seri"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="testing" id="simpanNoSeri">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ubahnoseri">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ubah No Seri</h4>
      </div>
      <form method="post" enctype="multipart/form-data" onsubmit="UbahNoSeri(); return false;">
        <div class="modal-body">
          <div id="ubah_no_seri"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="testing2">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function UbahNoSeri() {
    let id_ubah = $('#id_ubah_ns').val();
    let no_seri = $('#no_seri_ubah').val();
    $.post("data/ubah-noseri-kirim.php", {
        id: id_ubah,
        no_seri: no_seri
      },
      function(data) {
        if (data == 'S') {
        $('#modal-ubahnoseri').modal('hide');
          getDataBarang();
          alertCustom('S', 'Perubahan Berhasil Disimpan !', '');
        } else {
          alertCustom('F', 'Perubahan Gagal Disimpan !', '');
        }
      }
    );
  }

  function modalUbahNoSeri(id_hash, id_gudang) {
    $.get("data/isi_no_seri.php", {
        id_ubah: id_hash,
        id_gudang: id_gudang
      },
      function(data) {
        $('#ubah_no_seri').html(data);
        $('#modal-ubahnoseri').modal('show');
      }
    );
  }

  function simpanFix() {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Data Sudah Benar ?',
      text: 'Data Akan Disimpan',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Yakin',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        showLoading(1);
        let no_sj = '<?php echo $_SESSION['no_pengiriman'] ?>';
        $.post("data/simpan_kirim.php", {
            id: '<?php echo $_GET['id']; ?>'
          },
          function(data) {
            if (data === 'S') {
              addRiwayat('INSERT', 'barang_dikirim', <?php echo $_GET['id']; ?>, 'Menyimpan Data Pengiriman Barang (ID_KIRIM : ' + <?php echo $_GET['id']; ?> + ', NO_SJ : ' + no_sj + ')');
              showLoading(0);
              Swal.fire({
                customClass: {
                  confirmButton: 'bg-green',
                },
                title: 'Data Berhasil Disimpan !',
                text: '',
                icon: 'success',
                showCancelButton: false,
                confirmButtonText: 'OK',
                allowOutsideClick: false
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location = 'index.php?page=kirim_barang';
                }
              })
            } else if (data === 'K') {
              showLoading(0);
              alertCustom('F', 'Data Masih Kosong !', 'Lengkapi Data Yang Ingin Dikirim')
            } else {
              showLoading(0);
              alertCustom('F', 'Data Gagal Disimpan !', 'Pastikan Data Sudah Terisi Semua Dan Tolong Hindari Penggunaan Tanda Petik Dalam Penginputan');
            }
          }
        );
      }
    })
  }

  function cekJumlahKirimAkse() {
    var sisaKirim = parseInt($('#sisa_kirim').val());
    var jmlKirim = parseInt($('#jumlah_kirim').val());
    if (jmlKirim > sisaKirim) {
      alertCustom('F', 'Tidak Dapat Dilanjutkan !', 'Jumlah Kirim Tidak Dapat Melebihi Sisa Kirim');
      $('#jumlah_kirim').val('');
    }
  }

  function metodePilihAkse() {
    var check1 = $('#manual').prop('checked');
    var check2 = $('#otomatis').prop('checked');
    if (check1 === true) {
      $('#Ifmanual').show();
      $('#Ifotomatis').hide();
      $('#no_seri').prop('required', true);
      $('#jumlah_kirim').prop('required', false);
    }
    if (check2 === true) {
      $('#Ifmanual').hide();
      $('#Ifotomatis').show();
      $('#no_seri').prop('required', false);
      $('#jumlah_kirim').prop('required', true);

    }
  }

  function hitungJumlahAkse(id) {
    var sisaKirim = parseInt($('#sisa_kirim').val());
    let data = $('#no_seri').val();
    // let index = data.length - 1;
    // $.get("data/cek_no_seri.php", {
    //     id: id
    //   },
    //   function(data) {
    //     if (data == 'Y') {
    //       alertCustom('W', 'Expired < 6 Bulan !', 'Anda Tetap Dapat Memilih No Seri Ini');
    //     }
    //   }
    // );
    // var mySelect = $('#no_seri').select2();
    // var unselectedOptions = $('#no_seri').children('option:not(:selected)');

    if (data.length == sisaKirim) {
      alertCustom('S', 'Sesuai !', 'Jumlah No Seri Sudah Sesuai Dengan Sisa Kirim');
      // unselectedOptions.prop('disabled', true);
      // mySelect.select2();
      $('#simpanNoSeri').prop('disabled', false)
    } else if (data.length > sisaKirim) {
      alertCustom('F', 'Tidak Sesuai !', 'Jumlah No Seri Tidak Sesuai Dengan Sisa Kirim (Tidak Bisa Simpan)');
      $('#simpanNoSeri').prop('disabled', true)
    } else {
      // unselectedOptions.prop('disabled', false);
      // mySelect.select2();
    }
  }

  function simpanData() {
    var dt = ($('#id_akse').val()).split("-");
    var id_gudang = dt[1];
    var id_qty = dt[2];
    var kategori = $('#kategori_brg').val();
    var no_seri = $('#no_seri').val();
    var jumlah_kirim = $('#jumlah_kirim').val();
    var check1 = $('#manual').prop('checked');
    var check2 = $('#terlama').prop('checked');
    var metode_no_seri = check1 === true ? 'manual' : 'otomatis';
    var metode_rincian_no_seri = check2 === true ? 'asc' : 'desc';
    var mySelect = $('#id_akse').select2();
    showLoading(1);
    if (kategori == 'Set') {
      let data = parseInt($('#jumlah_kirim').val());
      $.post("data/simpan_kirim_set.php", {
          kategori: 'Set',
          id_gudang: id_gudang,
          id_qty: id_qty,
          data: data,
          metode2: metode_rincian_no_seri
        },
        function(data) {
          showLoading(0);
          if (data == 'S') {
            $('#modal-pilihnoseri').modal('hide');
            mySelect.val("").trigger('change');
            ambilDataNoSeri("");
            getDataBarang();
            getDataKirim()
            alertSimpan('S');
          } else {
            var cek = data.split('&');
            if (cek[0]) {
              if (cek[0] == 'DEL') {
                alertCustom('F', 'Stok Barang\n' + cek[1] + '\nTidak Mencukupi !', '' + cek[2] + ', ' + cek[3]);
              }
            } else {
              alertSimpan('F')
            }
          }
        }
      );
    } else if (kategori == 'Satuan') {
      let data = check1 === true ? $('#no_seri').val() : parseInt($('#jumlah_kirim').val());
      $.post("data/simpan_kirim_satuan.php", {
          kategori: 'Satuan',
          id_gudang: id_gudang,
          id_qty: id_qty,
          metode1: metode_no_seri,
          data: data,
          jml_aksesoris: $("#jumlah_aksesoris").val(),
          metode2: metode_rincian_no_seri
        },
        function(data) {
          showLoading(0);
          if (data == 'S') {
            $('#modal-pilihnoseri').modal('hide');
            mySelect.val("").trigger('change');
            ambilDataNoSeri("");
            getDataBarang();
            getDataKirim()
            alertSimpan('S');
          } else if (data == 'SA') {
            alertCustom('F', 'Perbaiki Data !', 'Ada No Seri Yang Sudah Ditambahkan Sebelumnya')
          } else if (data == 'F') {
            alertSimpan('F')
          } else {
            var cek = data.split('&');
            if (cek[0]) {
              if (cek[0] == 'DEL') {
                alertCustom('F', 'Stok Aksesoris\n' + cek[1] + '\nTidak Mencukupi !', '' + cek[2] + ', ' + cek[3]);
              } else {
                alertCustom('F', 'Stok Barang\n' + cek[1] + '\nTidak Mencukupi !', '' + cek[2] + ', ' + cek[3]);
              }
            } else {
              alertSimpan('F')
            }
          }
        }
      );
    } else if (kategori == 'Aksesoris') {
      showLoading(0);
      let data = check1 === true ? $('#no_seri').val() : $('#jumlah_kirim').val();
      $.post("data/simpan_kirim_aksesoris.php", {
          kategori: 'Aksesoris',
          id_gudang: id_gudang,
          id_qty: id_qty,
          metode1: metode_no_seri,
          data: data
        },
        function(data) {
          if (data == 'S') {
            $('#modal-pilihnoseri').modal('hide');
            mySelect.val("").trigger('change');
            ambilDataNoSeri("");
            getDataBarang();
            getDataKirim()
            alertSimpan('S');
          } else if (data == 'SA') {
            alertCustom('F', 'Perbaiki Data No Seri !', 'Ada No Seri Yang Sudah Tersimpan Sebelumnya')
          } else {
            var cek = data.split('&');
            if (cek[0]) {
              if (cek[0] == 'TC') {
                alertCustom('F', 'Stok Tersedia Tidak Mencukupi !', '' + cek[1] + ', ' + cek[2])
              }
            } else {
              alertSimpan('F')
            }
          }
        }
      );
    } else {
      showLoading(0);
      alertCustom('F', 'Gagal Simpan !', 'Kategori Tidak Ditemukan')
    }
  }

  function loading_no_seri() {
    $.get("include/getLoading.php", function(data) {
      $('#isi_no_seri').html(data);
    });
  }

  function ambilDataNoSeri(param) {
    loading2('#isi_no_seri');
    var kategori = param.split("-");
    var id_gudang = kategori[1];
    var id_qty = kategori[2];
    $('#simpanNoSeri').prop('disabled', false)
    if (kategori[0] == 'Set') {
      $.get("data/isi_no_seri_set.php", {
          idd: id_gudang,
          id_qty: id_qty,
          kategori: 'Set'
        },
        function(data) {
          $('#isi_no_seri').html(data);
        }
      );
    } else if (kategori[0] == 'Satuan') {
      $.get("data/isi_no_seri_satuan.php", {
          idd: id_gudang,
          id_qty: id_qty,
          kategori: 'Satuan'
        },
        function(data) {
          $('#isi_no_seri').html(data);
        }
      );
    } else if (kategori[0] == 'Aksesoris') {
      $.get("data/isi_no_seri_akse.php", {
          idd: id_gudang,
          id_qty: id_qty,
          kategori: 'Aksesoris'
        },
        function(data) {
          $('#isi_no_seri').html(data);
        }
      );
    } else {
      $('#isi_no_seri').html('<center>Silakan Pilih Nama Barang !</center>');
    }
  }

  function loading_data(id) {
    $.get("include/getLoading.php", function(data) {
      $(id).html(data);
    });
  }

  function getDataBarang() {
    $.get("data/data_barang_kirim.php",
      function(data) {
        $('#data-barang').html(data);
      }
    );
  }

  function getDataKirim() {
    // loading2('#data-detail-kirim');
    $.get("data/data_detail_kirim.php", {
        id: '<?php echo $_GET['id']; ?>'
      },
      function(data) {
        $('#data-detail-kirim').html(data);
      }
    );
  }

  function hapus(id, id_hapus) {
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
        $.post("data/hapus_data_kirim.php", {
            id_hapus: id_hapus
          },
          function(data) {
            if (data == 'S') {
              alertHapus('S');
              getDataBarang();
              getDataKirim()
            } else {
              alertHapus('F');
            }
          }
        );
      }
    })
  }

  $(document).ready(function() {
    // loading_data('#data-barang');
    getDataKirim();
    getDataBarang();
    $('#isi_no_seri').html('<center>Silakan Pilih Nama Barang !</center>');
  });
</script>