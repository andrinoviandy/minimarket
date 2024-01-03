<?php
if (isset($_POST['tampilkan'])) {
  echo "<script type='text/javascript'>
	window.location='index.php?page=kirim_barang&thn=" . $_POST['tahun'] . "'</script>";
}

if (isset($_POST['kirim_pengganti'])) {
  $_SESSION['nama_paket'] = $_POST['nama_paket'];
  $_SESSION['no_pengiriman'] = $_POST['no_peng'];
  $_SESSION['ekspedisi'] = $_POST['ekspedisi'];
  $_SESSION['tgl_pengiriman'] = $_POST['tgl_kirim'];
  $_SESSION['via_pengiriman'] = $_POST['via_kirim'];
  $_SESSION['estimasi'] = $_POST['estimasi_brg_sampai'];
  $_SESSION['biaya_kirim'] = $_POST['biaya_kirim'];
  $_SESSION['no_po'] = $_POST['no_po'];

  echo "<script type='text/javascript'>
		window.location='index.php?page=pilih_no_seri_pengganti';
		</script>";
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Data Alkes Terkirim
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Kirim Alkes</li>
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
        <div class="box box-body">
          <button class="btn btn-success" data-toggle="modal" data-target="#kirim-barang-pengganti"><i class="fa fa-calendar"></i> Kirim Barang Pengganti</button>
          <div class="pull pull-right">
            <table>
              <tr>
                <td><strong style="color:#F00">Keterangan</strong> : &nbsp;&nbsp;&nbsp;</td>
                <td valign="top">1. </td>
                <td valign="top"><strong style="color:#F00">Tanggal Sampai</strong> wajib diisi , untuk pembuatan SPI </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td valign="top">2. </td>
                <td>Jika <strong>Box</strong> Di <strong>Nama Alkes</strong> Berwarna <strong style="color:#F00">Merah</strong> , Itu menandakan<br />
                  barang telah dikembalikan karena mengalami kerusakan</td>
              </tr>
            </table>
          </div>
          <br /><br /><br />
          <div class="col-lg-6">
            <div class="pull pull-left">
              <form method="post" class="form-group">
                <div class="input-group col-lg-6">
                  <select class="form-control select2" name="tahun" id="tahun">
                    <option <?php if (isset($_GET['thn']) == 'all' or isset($_GET['pilihan'])) {
                              echo "selected";
                            } ?> value="all">Semua</option>
                    <?php
                    $q99 = mysqli_query($koneksi, "select year(tgl_kirim) as thn, max(year(tgl_kirim)) OVER() as maks_thn from barang_dikirim group by year(tgl_kirim) order by year(tgl_kirim) ASC");
                    $jm_99 = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM `barang_dikirim` WHERE year(tgl_kirim) = year(NOW())"));
                    $dd = mysqli_fetch_array($q99);
                    while ($d = mysqli_fetch_array($q99)) {
                    ?>
                      <option <?php
                              if (isset($_GET['thn'])) {
                                if ($_GET['thn'] != 'all') {
                                  if ($_GET['thn'] == $d['thn']) {
                                    echo "selected";
                                  }
                                }
                              } else {
                                if (!isset($_GET['pilihan'])) {
                                  if (date('Y') == $d['thn']) {
                                    echo "selected";
                                  }
                                }
                              }
                              ?> value="<?php echo $d['thn']; ?>"><?php echo $d['thn']; ?></option>
                    <?php } ?>
                    <?php for ($i = (intval($dd['maks_thn']) + 1); $i <= intval(date('Y')); $i++) { ?>
                      <option <?php
                              if (isset($_GET['thn'])) {
                                if ($_GET['thn'] != 'all') {
                                  if ($_GET['thn'] == $i) {
                                    echo "selected";
                                  }
                                }
                              } else {
                                if (!isset($_GET['pilihan'])) {
                                  if (date('Y') == $i) {
                                    echo "selected";
                                  }
                                }
                              }
                              ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php } ?>
                    <!-- <?php if ($jm_99['jml'] <= 0) { ?>
                      <option <?php if (!isset($_GET['thn'])) {
                                echo "selected";
                              } ?>><?php echo date('Y') ?></option>
                    <?php } ?> -->
                  </select>

                  <span class="input-group-btn">
                    <button type="submit" name="tampilkan" class="btn btn-warning">Tampilkan Barang</button>
                  </span>

                </div>
              </form>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="pull pull-right">
              <?php include "include/getFilter.php"; ?>
              <?php include "include/atur_halaman.php"; ?>
            </div>
          </div>
        </div>

      </section>
      <?php include "include/header_pencarian.php"; ?>
      <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-warning">
          <!-- /.chat -->
          <div class="box-footer">
            <div class="box-body">
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

<div class="modal fade" id="kirim-barang-pengganti">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Kirim Barang Pengganti</h4>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <label>Pilih No PO / No Surat Jalan</label>
          <select class="form-control select2" id="pilihan" name="no_po" required style="width:100%">
            <option value="">...</option>
            <?php
            $q_no_po = mysqli_query($koneksi, "select *,barang_dikirim.id as idd from barang_dikirim,barang_dikirim_detail where barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and status_batal=1 group by no_pengiriman order by no_po_jual ASC");

            while ($data = mysqli_fetch_array($q_no_po)) { ?>
              <option value="<?php echo $data['idd'] ?>"><?php echo $data['no_po_jual'] . " @ " . $data['no_pengiriman'] ?></option>
            <?php } ?>
          </select>
          <br /><br />
          <label>Nama Paket</label>
          <input type="text" class="form-control" placeholder="" name="nama_paket" required>
          <br />
          <label>No. Surat Jalan</label>
          <input id="input" type="text" placeholder="" name="no_peng" required class="form-control">
          <br /><br />
          <label>Ekspedisi</label>
          <input id="input" type="text" placeholder="" name="ekspedisi" required class="form-control">
          <br /><br />
          <label>Tanggal Pengiriman</label>
          <input id="input" type="date" placeholder="" name="tgl_kirim" required class="form-control">
          <br /><br />
          <label>Via Pengiriman</label>
          <input id="input" type="text" placeholder="" name="via_kirim" required class="form-control">
          <br /><br />
          <label>Estimasi Barang Sampai</label>
          <input id="input" type="date" placeholder="" name="estimasi_brg_sampai" class="form-control">
          <br /><br />
          <label>Biaya Jasa</label>
          <input id="input" type="text" placeholder="" name="biaya_kirim" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="kirim_pengganti">Next</button>
        </div>
      </form>
      <script type="text/javascript">
        <?php
        echo $jsArray;
        ?>

        function changeValue(pilihan) {
          document.getElementById('nama_paket').value = dtBrg[pilihan].nama_paket;
        };
      </script>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-status">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Tanggal Sampai</h4>
      </div>
      <form method="post" enctype="multipart/form-data" onsubmit="simpanSampai(); return false;">
        <div class="modal-body">
          <p align="justify">
            <input type="hidden" name="id_status" id="id_status" />
            <input type="date" class="form-control" name="tgl_sampai" required id="tgl_sampai">
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button class="btn btn-success" name="sampai_barang" type="submit">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-alamat2">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Input Alamat Ke-2</h4>
      </div>
      <form method="post" enctype="multipart/form-data" onsubmit="simpanAlamat2(); return false;">
        <div class="modal-body">
          <input type="hidden" name="idd" id="id_tujuan" />
          <label>Alamat Lengkap , Pisahkan Dengan Enter Untuk Baris Berikutnya</label>
          <div id="alamat2"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button class="btn btn-primary" type="submit">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-detailbarang">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Detail Barang</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <div id="data-detailbarang"></div>
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

<script>
  function simpanSampai() {
    $.post("data/simpan-sampai.php", {
        id: $('#id_status').val(),
        tgl_sampai: $('#tgl_sampai').val(),
      },
      function(data) {
        if (data == 'S') {
          $('#modal-status').modal('hide');
          alertSimpan('S');
          loading()
          loadMore(load_flag, key, status_b)
        } else if (data == 'SD') {
          alertCustome('F', 'Data Tidak Dapat Dihapus !', 'Data Sedang Digunakan');
        } else {
          alertSimpan('F');
        }
      }
    );
  }

  function simpanAlamat2() {
    $.post("data/simpan-alamat2-kirim.php", {
        id: $('#id_tujuan').val(),
        alamat: $('#alamat22').val(),
      },
      function(data) {
        if (data == 'S') {
          $('#modal-alamat2').modal('hide');
          alertSimpan('S');
          loading()
          loadMore(load_flag, key, status_b)
        } else {
          alertSimpan('F');
        }
      }
    );
  }

  function modalBarang(id) {
    $.get("data/modal-detailbarang.php", {
        id: id
      },
      function(data) {
        $('#data-detailbarang').html(data);
        $('#modal-detailbarang').modal('show');
      }
    );
  }

  // /(?:\r\n|\r|\n)/g
  function modalTujuan(id, alamat) {
    document.getElementById("id_tujuan").value = id
    document.getElementById("alamat2").innerHTML = '<textarea class="form-control" rows="8" name="alamat2" id="alamat22">' + alamat.replaceAll('<br>', '\n') + '</textarea>';
    $('#modal-alamat2').modal('show');
  }

  function sudahSampai(id, tgl) {
    // console.log('Klikkk');
    document.getElementById("id_status").value = id
    document.getElementById("tgl_sampai").value = tgl;
    $('#modal-status').modal('show');
  }

  function batalSampai(id) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Akan Membatalkan Status Sampai Barang',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Yakin',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        $.post("data/batal-sampai.php", {
            id: id
          },
          function(data) {
            if (data == 'S') {
              alertSimpan('S');
              loading()
              loadMore(load_flag, key, status_b)
            } else {
              alertSimpan('F');
            }
          }
        );
      }
    })
  }

  function hapus(id) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Akan Menghapus Data Ini ?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        $.post("data/hapus-kirim-barang.php", {
            id_hapus: id
          },
          function(data) {
            if (data == 'S') {
              alertHapus('S');
              loading()
              loadMore(load_flag, key, status_b)
            } else {
              alertHapus('F');
            }
          }
        );
      }
    })
  }
</script>