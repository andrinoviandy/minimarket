<?php

if (isset($_POST['tambah_laporan'])) {
  $Result = mysqli_query($koneksi, "insert into alat_uji_detail values('','" . $_POST['id_akse'] . "','" . $_POST['soft_version'] . "','" . $_POST['tgl_garansi_habis'] . "','" . $_POST['tgl_i'] . "','" . $_POST['lampiran_i'] . "','" . $_POST['tgl_f'] . "','" . $_POST['lampiran_f'] . "','" . $_POST['keterangan'] . "')");
  if ($Result) {
    mysqli_query($koneksi, "update barang_teknisi_detail set status_uji=1 where id=" . $_POST['id_akse'] . "");
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Data Berhasil Disimpan ',
      icon: 'success',
      confirmButtonText: 'OK',
    }).then(() => {
      window.location='index.php?page=simpan_tambah_uji&id=$_GET[id]';
    })
    </script>";
  }
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Instalasi & Uji Fungsi</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Instalasi &amp; Uji Fungsi</li>
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
                <!--<a href="index.php?page=tambah_barang_masuk"><button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Barang</button></a>-->
                <div class="table-responsive">
                  <table width="100%" id="" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th valign="bottom">Nama RS/Dinas/Klinik/dll</th>
                        <th valign="bottom">Alamat</th>
                        <th valign="bottom"><strong>Kontak RS/Dinas/dll</strong></th>
                      </tr>
                    </thead>
                    <tr>
                      <td><?php
                          $sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from pembeli where id=$_GET[id_rumkit]"));
                          echo $sel['nama_pembeli']; ?></td>
                      <td><?php echo $sel['jalan']; ?></td>
                      <td><?php echo $sel['kontak_rs']; ?></td>
                    </tr>
                  </table>
                </div>
                <br />
                <h3 align="center">
                  Detail Alkes
                </h3>
                <span class="pull pull-right">
                  <table>
                    <tr>
                      <td valign="top"><strong style="color:#F00">Keterangan</strong> : &nbsp;&nbsp;&nbsp;</td>
                      <td valign="top">1. </td>
                      <td valign="top">Jika <strong>Box</strong> Di <strong>Nama Alkes</strong> Berwarna <strong style="color:#F00">Merah</strong> , Itu menandakan<br />
                        barang telah dikembalikan karena mengalami kerusakan</td>
                    </tr>
                  </table>
                </span><br /><br /><br />
                <div class="pull pull-right">
                  <?php //include "include/getFilter.php"; 
                  ?>
                  <?php include "include/atur_halaman.php"; ?>
                </div>
                <?php include "include/header_pencarian.php"; ?>
                <div class="">
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
                <p align="left">&nbsp;</p>
                <br />

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

<div class="modal fade" id="modal-ubah">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ubah Instalasi & Uji Fungsi</h4>
      </div>
      <form id="formUbah" onsubmit="simpanUbah(); return false">
        <div class="modal-body">
          <input type="hidden" name="id_ubah" id="id_ubah" />
          <label>Soft. Version</label>
          <input name="soft_version" class="form-control" type="text" required placeholder="Soft. Version" id="s_v"><br />
          <label>Tgl Garansi</label>
          <input name="tgl_garansi" class="form-control" type="date" required placeholder="Tgl Garansi" id="tgl_g"><br />
          <label>Tgl Instalasi</label>
          <input name="tgl_i" class="form-control" type="date" required placeholder="Nama Aksesoris" id="t_i"><br />
          <label>Tgl Uji Fungsi</label>
          <input name="tgl_f" class="form-control" type="date" placeholder="Tipe" required id="t_f"><br />
          <label>Keterangan</label>
          <textarea name="keterangan" class="form-control" placeholder="" rows="3" id="ket"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="ubah_uji" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ubahinstalasi">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ubah Lampiran Instalasi</h4>
      </div>
      <form id="formData1" onsubmit="simpanInstalasi(); return false;">
        <div class="modal-body">
          <input type="hidden" name="id_i" id="id_i" />
          <input name="lampiran_i" type="file" class="form-control" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="ubahlampiran1" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ubahfungsi">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ubah Lampiran Uji Fungsi</h4>
      </div>
      <form id="formData2" onsubmit="simpanUjiFungsi(); return false;">
        <div class="modal-body">
          <input type="hidden" name="id_f" id="id_f" />
          <input name="lampiran_f" type="file" class="form-control" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="ubahlampiran2" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-instalasi">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Lampiran Instalasi</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <img width="100%" height="auto" id="gambarInstalasi" />
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

<div class="modal fade" id="modal-ujifungsi">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Lampiran Uji Fungsi</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <img id="gambarUjifungsi" width="100%" height="auto" />
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
  function simpanUbah() {
    var dataform = $('#formUbah')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "POST",
      url: "data/simpan-ubah-uji.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      cache: false,
      success: function(response) {
        if (response == 'S') {
          $('#modal-ubah').modal('hide');
          alertSimpan('S');
          loadMore(load_flag, key, status_b)
          dataform.reset();
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  function simpanInstalasi() {
    var dataform = $('#formData1')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "POST",
      url: "data/simpan-lampiran-instalasi.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      cache: false,
      success: function(response) {
        if (response == 'S') {
          $('#modal-ubahinstalasi').modal('hide');
          alertSimpan('S');
          loadMore(load_flag, key, status_b)
          dataform.reset();
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  function simpanUjiFungsi() {
    var dataform = $('#formData2')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "POST",
      url: "data/simpan-lampiran-ujifungsi.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      cache: false,
      success: function(response) {
        if (response == 'S') {
          $('#modal-ubahfungsi').modal('hide');
          alertSimpan('S');
          loadMore(load_flag, key, status_b)
          dataform.reset();
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  function modalInstalasi(lampiran) {
    $('#gambarInstalasi').attr('src', 'gambar_fi/instalasi/' + lampiran);
    $('#modal-instalasi').modal('show');
  }

  function modalUjifungsi(lampiran) {
    $('#gambarUjifungsi').attr('src', 'gambar_fi/fungsi/' + lampiran);
    $('#modal-ujifungsi').modal('show');
  }

  function lampiranInstalasi(id) {
    document.getElementById("id_i").value = id;
    $('#modal-ubahinstalasi').modal('show');
  }

  function lampiranUjiFungsi(id) {
    document.getElementById("id_f").value = id;
    $('#modal-ubahfungsi').modal('show');
  }

  function modalUbah(id, s, t_e, t_i, t_f, ket) {
    document.getElementById("id_ubah").value = id;
    document.getElementById("s_v").value = s;
    document.getElementById("tgl_g").value = t_e;
    document.getElementById("t_i").value = t_i;
    document.getElementById("t_f").value = t_f;
    document.getElementById("ket").value = ket;
    $('#modal-ubah').modal('show');
  }

  function hapus(id, id2) {
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
        $.post("data/hapus-ubah-uji.php", {
            id_hapus: id
          },
          function(data) {
            if (data == 'S') {
              alertHapus('S')
              loadMore(load_flag, key, status_b)
            }
            else if (data == 'TB') {
              alertCustom('F', 'Tidak Dapat Dihapus !', 'Sudah Ada Pelatihan')
            }
            else {
              alertHapus('F')
            }
          }
        );
      }
    })
  }
</script>