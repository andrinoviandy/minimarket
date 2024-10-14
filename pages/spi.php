<?php
if (isset($_POST['tambah_spk_masuk'])) {
  echo "<script type='text/javascript'>
		window.location='index.php?page=tambah_spk_masuk2';
		</script>";
  $_SESSION['tgl_spi'] = $_POST['tgl_spk'];
  $_SESSION['no_spi'] = $_POST['no_spk'];
  $_SESSION['keterangan'] = $_POST['keterangan'];
  mysqli_query($koneksi, "delete from barang_teknisi_hash where akun_id=" . $_SESSION['id'] . "");
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Surat Perintah Instalasi</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Surat Perintah Instalasi</li>
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
                <?php if (!isset($_SESSION['id_b'])) { ?>
                  <!-- <a href="index.php?page=tambah_spk_masuk"> -->
                  <button data-toggle="modal" data-target="#modal-tambah-spi" name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah </button>
                  <!-- </a> -->
                <?php } ?>
                <span class="pull pull-right">
                  <table>
                    <tr>
                      <td valign="top"><strong style="color:#F00">Keterangan</strong> : &nbsp;&nbsp;&nbsp;</td>
                      <td valign="top">1. </td>
                      <td valign="top">Jika <strong>Box</strong> Di <strong>Nama Alkes</strong> Berwarna <strong style="color:#F00">Merah</strong> , Itu menandakan<br />
                        barang telah dikembalikan karena mengalami kerusakan</td>
                    </tr>
                  </table>
                </span>
                <br /><br />
                <div class="pull pull-right">
                  <?php include "include/getFilter.php"; ?>
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
      <?php include "include/header_pencarian.php"; ?>
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
      <?php if ($jml != 0) { ?>
        <section class="col-lg-12">
          <center>
            <ul class="pagination btn-success">
              <?php
              include "paging_awal.php";
              ?>
              <?php
              $query12 = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
              list($surat_masuk) = mysqli_fetch_array($query12);
              //pagging
              $limit = $surat_masuk;
              if (isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
                $queryy = mysqli_query($koneksi, "select *,barang_teknisi.id as idd from barang_dikirim,barang_teknisi,barang_teknisi_detail,barang_dikirim_detail,barang_gudang,barang_gudang_detail,barang_dijual,barang_dijual_qty,pembeli where barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and tgl_spk between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_teknisi.id order by tgl_spk DESC,no_spk DESC");
              } elseif (isset($_GET['kunci']) and isset($_GET['pilihan'])) {
                $queryy = mysqli_query($koneksi, "select *,barang_teknisi.id as idd from barang_dikirim,barang_teknisi,barang_teknisi_detail,barang_dikirim_detail,barang_gudang,barang_gudang_detail,barang_dijual,barang_dijual_qty,pembeli where barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and $_GET[pilihan] like '%$_GET[kunci]%' group by barang_teknisi.id order by tgl_spk DESC,no_spk DESC");
              } else {
                $queryy = mysqli_query($koneksi, "select *,barang_teknisi.id as idd from barang_teknisi order by tgl_spk DESC,no_spk DESC");
              }
              $cdata = mysqli_num_rows($queryy);
              $j = ceil($cdata / $limit);
              if ($j > 10) {
                include "paging_lebih_dari_10.php";
              }
              //< 10 Halaman
              else {
                include "paging_kurang_dari_10.php";
              }
              ?>
              <?php
              include "paging_akhir.php";
              ?>
            </ul>
          </center>
          <?php
          include "paging_informasi.php";
          ?>

        </section>
      <?php } ?>
      <!-- /.content -->
      <?php include "atur_halaman.php"; ?>
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
$d_t = mysqli_fetch_array(mysqli_query($koneksi, "select * from tb_teknisi where id=$_GET[id_tek]"));
?>
<div id="open_teknisi" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Detail Teknisi</h3>
    <form method="post">
      <strong>Nama</strong>
      <input id="input" type="text" readonly="readonly" value="<?php echo $d_t['nama_teknisi']; ?>" />
      <strong>Kompetensi</strong>
      <input id="input" type="text" readonly="readonly" value="<?php echo $d_t['bidang']; ?>" />
      <strong>No HP</strong>
      <input id="input" type="text" readonly="readonly" value="<?php echo $d_t['no_hp']; ?>" />
      <strong>No STR</strong>
      <input id="input" type="text" readonly="readonly" value="<?php echo $d_t['no_str']; ?>" />
      <table width="100%">
        <tr>
          <td align="center"><strong>Ijazah</strong></td>
          <td align="center"><strong>Sertifikat</strong></td>
        </tr>
        <tr>
          <td align="center"><a href="ijazah_teknisi/<?php echo $d_t['ijazah']; ?>" target="_blank"><img src="ijazah_teknisi/<?php echo $d_t['ijazah']; ?>" width="50px" /></a></td>
          <td align="center"><a href="ijazah_teknisi/sertifikat/<?php echo $d_t['sertifikat']; ?>" target="_blank"><img src="ijazah_teknisi/sertifikat/<?php echo $d_t['sertifikat']; ?>" width="50px" /></a></td>
        </tr>
      </table>

    </form>
  </div>
</div>

<div id="openUji" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Uji Fungsi & Instalasi</h3>
    <form method="post">
      <input name="nama_teknisi" id="input" type="text" required placeholder="Nama Teknisi"><br />

      <input name="bidang" id="input" type="text" placeholder="Bidang" required><br />
      <input name="no_str" id="input" placeholder="No STR" required><br />
      <input name="no_hp" id="input" type="text" placeholder="No HP" required><br />
      <input name="username" id="input" type="text" placeholder="Username" required><br />
      <input name="password" id="input" type="password" placeholder="Password" required><br />
      Ijazah
      <input name="ijazah" style="background-color:#FFF" id="input" type="file" /><br />
      Sertifikat
      <input name="sertifikat" id="input" type="file" style="background-color:#FFF" /><br />
      <button id="buttonn" name="tambahteknisibaru" type="submit">Jual Alkes</button>
    </form>
  </div>
</div>

<div class="modal fade" id="modal-pencarian">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <script type="text/javascript">
          function yesnoCheck() {
            if (document.getElementById('yesCheck').value == 'tgl_spk') {
              document.getElementById('ifYes').style.display = 'block';
              document.getElementById('kata_kunci').style.display = 'none';
            } else {
              document.getElementById('ifYes').style.display = 'none';
              document.getElementById('kata_kunci').style.display = 'block';
            }
          }
        </script>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pencarian</h4>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <select class="form-control select2" name="pilihan" required style="width:100%" onchange="javascript:yesnoCheck();" id="yesCheck">
            <option value="">...</option>
            <option value="tgl_spk">Berdasarkan Rentang Tanggal SPI</option>
            <option value="no_spk">Berdasarkan Nomor SPI</option>
            <option value="no_pengiriman">Berdasarkan Nomor Surat Jalan</option>
            <option value="barang_dijual.no_po_jual">Berdasarkan Nomor PO</option>
            <option value="nama_pembeli">Berdasarkan RS/Dinas/Puskesmas/Dll</option>
            <option value="nama_brg">Berdasarkan Nama Barang</option>
            <option value="tipe_brg">Berdasarkan Tipe Barang</option>
            <option value="no_seri_brg">Berdasarkan No Seri Barang</option>
          </select>
          <br /><br />
          <div id="kata_kunci" style="display:block">
            <input type="text" class="form-control" name="kata_kunci" placeholder="Kata Kunci" />
          </div>
          <div id="ifYes" style="display:none">
            <label>Dari Tanggal</label>
            <input name="tgl1" type="date" class="form-control" placeholder="" value=""><br />
            <label>Sampai Tanggal</label>
            <input name="tgl2" type="date" class="form-control" placeholder="" value="">
          </div>
          <br />
          <select name="tampil" class="form-control select2" style="width:100%">
            <option value="">...</option>
            <option value="1">Tampilkan Detail Barang</option>
            <option value="0">Jangan Tampilkan Detail Barang</option>
          </select>
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

<div class="modal fade" id="modal-cetak-spi">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cetak Surat Perintah Instalasi</h4>
      </div>
      <div class="modal-body">
        <a target="_blank" id="cetak1" class="btn btn-app"><i class="fa fa-print"></i> Print</a>
        <a class="btn btn-app" id="cetak2"><i class="fa fa-file-word-o"></i> Word</a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-tambah-spi">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Tambah SPI</h4>
      </div>
      <form id="frm-mhs" name="example_form" action="" method="POST" data-validate="parsley" enctype="multipart/form-data" >
        <div class="modal-body">
          <div class="form-group">
            <label>Tanggal SPI</label>
            <input name="tgl_spk" type="date" class="form-control" autofocus="autofocus" required="required" />
          </div>
          <div class="form-group">
            <label>Nomor SPI</label>
            <input name="no_spk" type="text" class="form-control" required="required" />
          </div>
          <div class="form-group">
            <label>Deskripsi</label>
            <input name="keterangan" type="text" class="form-control" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" name="tambah_spk_masuk" class="btn btn-success pull-right">Next</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ubah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ubah SPI</h4>
      </div>
      <div id="modal-ubah-spi"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function modal_ubah(id) {
    $.get("data/modal-ubah-spi.php", {
        id: id
      },
      function(data) {
        $('#modal-ubah-spi').html(data)
        $('#modal-ubah').modal('show');
      }
    );
  }

  function modal_cetak_spi(id, id_kirim) {
    $('#cetak1').prop('href', 'cetak_surat_perintah_instalasi.php?id=' + id + '&id_kirim=' + id_kirim)
    $('#cetak2').prop('href', 'cetak_surat_perintah_instalasi_word.php?id=' + id + '&id_kirim=' + id_kirim)
    $('#modal-cetak-spi').modal('show');
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
        $.get("data/hapus_spi.php", {
            id_hapus: id
          },
          function(data) {
            if (data == 'S') {
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
</script>