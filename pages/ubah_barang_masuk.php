<?php
$query = mysqli_query($koneksi, "select * from barang_gudang where id='" . $_GET['id'] . "'");
$data = mysqli_fetch_array($query);

if (isset($_POST['pencarian'])) {
  if ($_POST['pilihan'] == 'tgl_po_pesan') {
    echo "<script>window.location='index.php?page=$_GET[page]&tgl_awal=$_POST[tgl_awal]&tgl_akhir=$_POST[tgl_akhir]&tampil=$_POST[tampil]'</script>";
  } else {
    echo "<script>window.location='index.php?page=$_GET[page]&pilihan=$_POST[pilihan]&kunci=$_POST[kata_kunci]&id=$_GET[id]'</script>";
  }
}

if (isset($_POST['simpan_perubahan'])) {
  if (isset($_SESSION['user_administrator']) or isset($_SESSION['user_admin_keuangan'])) {
    $Result = mysqli_query($koneksi, "update barang_gudang set nama_brg='" . $_POST['nama_barang'] . "', nie_brg='" . $_POST['nie_brg'] . "', merk_brg='" . $_POST['merk'] . "', tipe_brg='" . $_POST['tipe'] . "', negara_asal='" . $_POST['negara_asal'] . "', jenis_barang='" . $_POST['jenis_barang'] . "' ,deskripsi_alat='" . $_POST['deskripsi'] . "', harga_beli='" . str_replace(".", "", $_POST['harga_beli']) . "',harga_satuan='" . str_replace(".", "", $_POST['harga_satuan']) . "', satuan='" . $_POST['satuan'] . "', satuan_header='" . $_POST['satuan_header'] . "', jumlah_rincian_to_satuan='" . $_POST['jumlah_rincian_to_satuan'] . "', status_cek='" . $_POST['status_cek'] . "' where id=" . $_GET['id'] . "");
  } else {
    $Result = mysqli_query($koneksi, "update barang_gudang set nama_brg='" . $_POST['nama_barang'] . "', nie_brg='" . $_POST['nie_brg'] . "', merk_brg='" . $_POST['merk'] . "', tipe_brg='" . $_POST['tipe'] . "', negara_asal='" . $_POST['negara_asal'] . "', jenis_barang='" . $_POST['jenis_barang'] . "' , deskripsi_alat='" . $_POST['deskripsi'] . "',satuan='" . $_POST['satuan'] . "',satuan_header='" . $_POST['satuan_header'] . "', jumlah_rincian_to_satuan='" . $_POST['jumlah_rincian_to_satuan'] . "', status_cek='" . $_POST['status_cek'] . "' where id=" . $_GET['id'] . "");
  }
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
        window.location.href = '?page=ubah_barang_masuk&id=$_GET[id]';
      })
      </script>";
  }
}
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Alkes Masuk / Data Gudang</h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="index.php?page=barang_masuk">Alkes Masuk</a></li>
      <li class="active">Ubah Data Alkes</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-4 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success">
          <!-- /.chat -->
          <div class="box-footer">
            <div class="box-header with-border">
              <h3 class="box-title">Ubah Data Alkes</h3>
            </div>
            <div class="box-body"><br />
              <form method="post">

                <label>Nama Alkes</label>
                <input name="nama_barang" class="form-control" placeholder="Nama Barang" type="text" value="<?php echo $data['nama_brg']; ?>"><br />
                <label>NIE Alkes</label>
                <input name="nie_brg" class="form-control" placeholder="NIE Barang" type="text" value="<?php echo $data['nie_brg']; ?>"><br />

                <label>Merk</label>
                <input name="merk" class="form-control" type="text" placeholder="Merk" value="<?php echo $data['merk_brg']; ?>"><br />

                <label>Tipe</label>
                <input name="tipe" class="form-control" type="text" placeholder="Tipe" value="<?php echo $data['tipe_brg']; ?>"><br />

                <label>Negara Asal</label>
                <input name="negara_asal" class="form-control" type="text" placeholder="Kepemilikan" value="<?php echo $data['negara_asal']; ?>"><br />
                <label>Jenis Barang</label>
                <select name="jenis_barang" class="form-control select2" required style="width:100%">
                  <option value="">-- Pilih Jenis Barang --</option>
                  <option <?php if ($data['jenis_barang'] == 1) {
                            echo "selected";
                          } ?> value="1">E-Katalog</option>
                  <option <?php if ($data['jenis_barang'] == 0) {
                            echo "selected";
                          } ?> value="0">Bukan E-Katalog</option>
                </select>
                <br />
                <br />
                <label>Deskripsi Alat</label>
                <textarea name="deskripsi" class="form-control" type="text" rows="5" placeholder="Deskripsi Alat" required><?php echo $data['deskripsi_alat']; ?></textarea><br />
                <?php if (isset($_SESSION['user_administrator']) or isset($_SESSION['user_admin_keuangan'])) { ?>
                  <label>Harga Beli</label>
                  <input name="harga_beli" class="form-control" type="text" placeholder="Harga Beli" value="<?php echo number_format($data['harga_beli'], 0, ',', '.'); ?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"><br />
                  <label>Harga Jual</label>
                  <input name="harga_satuan" class="form-control" type="text" placeholder="Harga Satuan" value="<?php echo number_format($data['harga_satuan'], 0, ',', '.'); ?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"><br />
                <?php } ?>
                <label>Satuan (Detail)</label>
                <input name="satuan" class="form-control" type="text" placeholder="Satuan" value="<?php echo $data['satuan']; ?>"><br />
                <div class="well">
                <font style="color: red;">* Abaikan/Kosongkan Jika Tidak Memiliki Jenis Satuan Lain</font>
                <br>
                <label>Satuan (Header)</label>
                <input name="satuan_header" class="form-control" type="text" placeholder="Satuan Header" value="<?php echo $data['satuan_header']; ?>"><br />
                <label>Jumlah Per Satuan (Detail) Untuk Mencapat 1 Satuan (Header)</label>
                <input name="jumlah_rincian_to_satuan" class="form-control" type="number" placeholder="Jumlah" value="<?php echo $data['jumlah_rincian_to_satuan']; ?>"><br />
                </div>
                <!--<label>Kode Barcode</label>
              <input name="kode_barcode" class="form-control" type="text" placeholder="Hanya Angka" value="<?php echo $data['kode_barcode']; ?>"><br />-->
                <label>Status Pengecekan</label>
                <select name="status_cek" class="form-control select2" style="width:100%">
                  <?php if ($data['status_cek'] == 0) { ?>
                    <option value="0">Belum Di Cek</option>
                    <option value="1">Sudah Di Cek</option>
                  <?php } else { ?>
                    <option value="1">Sudah Di Cek</option>
                    <option value="0">Belum Di Cek</option>
                  <?php } ?>
                </select>
                <br />
                <br />
                <button name="simpan_perubahan" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan Perubahan</button>
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

      <section class="col-lg-8 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success">
          <!-- /.chat -->
          <div class="box-footer">
            <div class="box-header with-border">
              <div class="pull pull-left">
                <h3 class="box-title">Detail Data Alkes</h3>
              </div>
              <div class="pull pull-right">
                <div id="detail-data-alkes"></div>
              </div>
              <!--<a href="cetak_barcode_no_seri.php?id=<?php echo $_GET['id']; ?>&pilihan=tersedia" class="pull pull-right" target="_blank"><button name="barcode" class="btn btn-danger"><span class="fa fa-barcode"></span> Generate QRCode</button></a>-->
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-lg-12">
                  <?php if (isset($_SESSION['pass_admin_gudang']) or isset($_SESSION['pass_administrator'])) { ?>
                    <br />
                    <a href="index.php?page=simpan_tambah_barang_masuk5&id=<?php echo $_GET['id']; ?>"><button name="tambah_detail" class="btn btn-success" type="submit"><span class="fa fa-edit"></span> Tambah Stok</button></a>&nbsp;&nbsp;
                    <!-- <a href="index.php?page=ubah_barang_masuk_terjual&id=<?php echo $_GET['id']; ?>"><button name="tambah_detail" class="btn btn-warning" type="button"> Stok Terjual</button></a>
                    <a href="index.php?page=ubah_barang_masuk_rusak&id=<?php echo $_GET['id']; ?>"><button name="tambah_detail" class="btn btn-warning" type="button"> Stok Rusak</button></a>
                    <a href="index.php?page=ubah_barang_masuk_tidak_layak&id=<?php echo $_GET['id']; ?>"><button name="tambah_detail" class="btn btn-warning" type="button"> Stok Tidak Layak Jual</button></a> -->
                  <?php } ?>
                  <div class="pull pull-right">
                    <?php //include "include/getFilter.php"; 
                    ?>
                    <?php include "include/atur_halaman.php"; ?>
                  </div>
                </div>
                <div class="col-lg-12">
                  <hr>
                </div>
                <div class="col-lg-12">
                  <?php include "include/getInputSearch.php"; ?>
                  <div id="table" style="margin-top: 10px;"></div>
                  <section class="col-lg-12">
                    <center>
                      <ul class="pagination">
                        <button class="btn btn-default" id="paging-1"><a><i class="fa fa-angle-double-left"></i></a></button>
                        <button class="btn btn-default" id="paging-2"><a><i class="fa fa-angle-double-right"></i></a></button>
                      </ul>
                      <?php include "include/getInfoPagingData.php"; ?>
                    </center>
                  </section>
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

<?php
if (isset($_POST['tambah_detail'])) {
  $tmbh = mysqli_query($koneksi, "insert into barang_gudang_detail values('','" . $_GET['id'] . "','" . $_POST['no_bath_t'] . "','" . $_POST['no_lot_t'] . "','" . $_POST['no_seri_t'] . "','0')");
  if ($tmbh) {
    mysqli_query($koneksi, "update barang_gudang set stok=stok+1 where id=" . $_GET['id'] . "");
    echo "<script type='text/javascript'>
		  window.location='index.php?page=ubah_barang_masuk&id=$_GET[id]'
		</script>";
  }
}
?>
<div id="open_tambah_detail" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <br />
    <form method="post">

      <label>No. Bath</label>
      <input name="no_bath_t" class="form-control" type="text" placeholder="" value=""><br />
      <label>No. Lot</label>
      <input name="no_lot_t" class="form-control" type="text" placeholder="" value=""><br />
      <label>No. Seri</label>
      <input name="no_seri_t" class="form-control" type="text" placeholder="" value=""><br />
      <input id="buttonn" name="tambah_detail" type="submit" value="Tambah" />
    </form>
  </div>
</div>

<div class="modal fade" id="modal-pencarian">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pencarian</h4>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <select class="form-control select2" name="pilihan" required style="width:100%">
            <option value="">...</option>
            <option value="no_po_gudang">Berdasarkan Nomor PO</option>
            <option value="no_bath">Berdasarkan Nomor Bath</option>
            <option value="no_lot">Berdasarkan Nomor Lot</option>
            <option value="no_seri_brg">Berdasarkan No Seri</option>
          </select>
          <br /><br />
          <input type="text" class="form-control" name="kata_kunci" placeholder="Kata Kunci" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="pencarian">Cari</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ubah-item">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Ubah Data Barang</h4>
      </div>
      <div id="modal-data-item"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ubah-barcode">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Buat QRCode
        </h4>
      </div>
      <div id="modal-data-barcode"></div>
    </div>

  </div>

</div>

<div class="modal fade" id="modal-cetak-barcode">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Jumlah QRCode Yang Ingin Di Cetak
        </h4>
      </div>
      <form method="post" action="cetak_barcode_jenis.php" target="_blank">
        <div class="modal-body">
          <p align="justify">
            <!--<input type="hidden" name="kode_barcode" value="<?php //echo "(" . $json[$i]['nama_brg'] . ")(" . $json[$i]['tipe_brg'] . ")(" . $json[$i]['merk_brg'] . ")(" . $json[$i]['no_po_gudang'] . ")(" . date_format("d/m/Y", strtotime($json[$i]['tgl_po_gudang'])) . ")(" . $json[$i]['no_seri_brg'] . ")(" . ($i + 1) . " of " . $jml . ")"; 
                                                                ?>"/>-->
            <input type="hidden" id="kode_barcode" name="kode_barcode" />
            <input type="hidden" id="nie_brg_cetak" name="nie_brg" />
            <input type="hidden" id="no_seri_cetak" name="no_seri" />
            <input type="number" id="jml_cetak" name="jml" class="form-control" placeholder="Jumlah QRCode Yang Ingin Di Cetak" />
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger" name="print_barcode"><i class="fa fa-print"></i> Print</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function ubahBarcode() {
    $.post("data/simpan_ubah_barcode.php", {
        id_ubah: $('#idd').val(),
        qrcode: $('#qrcode').val()
      },
      function(data) {
        if (data == 'S') {
          alertSimpan('S');
          $('#modal-ubah-barcode').modal('hide');
          loading();
          loadMore(load_flag, key, status_b)
        } else {
          alertSimpan('F');
          $('#modal-ubah-barcode').modal('hide');
        }
      }
    );
  }

  function ubahItem() {
    var dataform = $('#formUbah')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/simpan_ubah_item.php",
      data: data,
      enctype: 'multipart/form-data',
      processData: false,
      contentType: false,
      cache: false,
      success: function (response) {
        if (response == 'S') {
          alertSimpan('S');
          $('#modal-ubah-item').modal('hide');
          loading();
          loadMore(load_flag, key, status_b)
        } else if (response == 'SA') {
          alertCustom('F', 'Tidak Dapat Dilanjutkan', 'No Seri Sudah Terdaftar !');
        } else {
          alertSimpan('F');
          $('#modal-ubah-item').modal('hide');
        }
      }
    });
  }

  function modalUbahItem(id_ubah) {
    $.get("data/modal-ubah-item.php", {
        id: id_ubah
      },
      function(data) {
        $('#modal-data-item').html(data);
        $('#modal-ubah-item').modal('show');
      }
    );
  }

  function modalUbahBarcode(id_ubah) {
    $.get("data/modal-ubah-barcode.php", {
        id: id_ubah
      },
      function(data) {
        $('#modal-data-barcode').html(data);
        $('#modal-ubah-barcode').modal('show');
      }
    );
  }

  function modalCetakBarcode(id_ubah) {
    $.get("data/modal-cetak-barcode.php", {
        id: id_ubah
      },
      function(data) {
        var dt = JSON.parse(data);
        $('#kode_barcode').val(dt.qrcode);
        $('#nie_brg_cetak').val(dt.nie_brg);
        $('#no_seri_cetak').val(dt.no_seri_brg);
        $('#modal-cetak-barcode').modal('show');
      }
    );
  }

  function hapus(id_hapus, id_po) {
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
        $.post("data/hapus_ubah_item.php", {
            id_hapus: id_hapus,
            id_po: id_po,
            id: '<?php echo $_GET['id'] ?>'
          },
          function(data) {
            if (data == 'S') {
              alertHapus('S')
              dataStok();
              loading();
              loadMore(load_flag, key, status_b)
            } else if (data == 'F') {
              alertHapus('F')
            } else {
              alertCustom('F', 'Data Tidak Dapat Dihapus !', 'Data Sedang Digunakan');
            }
          }
        );
      }
    })
  }

  function dataStok() {
    $.get("data/detail-data-alkes.php", {
        id: '<?php echo $_GET['id']; ?>'
      },
      function(data) {
        $('#detail-data-alkes').html(data);
      }
    );
  }

  $(document).ready(function() {
    dataStok();
  });
</script>