<?php
// if (isset($_POST['simpan_tambah_aksesoris'])) {
//   $simpan = mysqli_query($koneksi, "insert into aksesoris_alkes values('','" . $_GET['id'] . "','" . $_POST['id_akse'] . "','" . $_POST['qty'] . "')");
// }

if (isset($_GET['id_hapus'])) {
  $del = mysqli_query($koneksi, "delete from barang_gudang_detail_akse where id=" . $_GET['id_hapus'] . "");
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tambah Aksesoris Alkes</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Tambah Aksesoris Alkes</li>
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
              <div class="table-responsive">
                <!--<a href="index.php?page=tambah_barang_masuk"><button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Barang</button></a>-->

                <table width="100%" id="" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th valign="bottom"><strong>Nama Alkes</strong></th>
                      <th valign="bottom">NIE</th>
                      <th valign="bottom"><strong>Tipe</strong></th>
                      <th valign="bottom">Merk</th>
                      <th valign="bottom"><strong>Negara Asal</strong></th>
                      <th valign="bottom"><strong>Deskripsi Alat</strong></th>
                      <th valign="bottom">Stok</th>
                    </tr>
                  </thead>
                  <?php
                  $data = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_gudang where id=" . $_GET['id'] . ""));
                  ?>
                  <tr>
                    <td><?php echo $data['nama_brg']; ?>
                    </td>
                    <td><?php echo $data['nie_brg']; ?></td>
                    <td><?php echo $data['tipe_brg']; ?></td>
                    <td><?php echo $data['merk_brg']; ?></td>
                    <td><?php echo $data['negara_asal']; ?></td>
                    <td><?php echo $data['deskripsi_alat']; ?></td>
                    <td><?php echo $data['stok_total']; ?></td>
                  </tr>
                </table><br />
                <div class="pull pull-left">
                  <h3 align="left">
                    Rincian Aksesoris
                  </h3>
                </div>
                <div class="pull pull-right">
                  <button name="tambah" class="btn btn-success" type="submit" data-toggle="modal" data-target="#modal-tambah" onclick=""><span class="fa fa-plus"></span> Tambah</button>
                </div>
                <!--<font color="#FF0000">* Jika Ingin Menambah Data Aksesoris Yang Baru ! Klik Disini <a href="index.php?page=simpan_tambah_aksesoris&id=<?php echo $_GET['id']; ?>#openAkse"><small data-toggle="tooltip" title="Tambah Aksesoris Baru" class="label bg-blue">+ New Accessories</small></a></font>-->
                <br />
                <div id="tabel-akse" style="margin-top: 40px;"></div>
                <center><a href="index.php?page=barang_masuk"><button class="btn btn-success"><span class="fa fa-check"></span> Selesai & Kembali ke halaman Gudang 2 (Utama)</button></a></center>
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
<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center"><strong>Tambah Data</strong></h4>
      </div>
      <form method="post" id="form-tambah" enctype="multipart/form-data" onsubmit="simpanBarang(); return false;">
        <div class="modal-body">
          <label>Nama Aksesoris</label>
          <div id="nama_barang"></div>
          <br />
          <label>Tipe</label>
          <input id="tipe_brg" name="tipe_akse" class="form-control" readonly type="text" placeholder="Tipe" disabled="disabled" size="15" />
          <br />
          <label>Merk</label>
          <input id="merk_brg" name="merk_brg" class="form-control" type="text" readonly placeholder="Merk" disabled="disabled" size="15" />
          <br />
          <label>NIE</label>
          <input id="nie_brg" name="nie_brg" class="form-control" type="number" readonly placeholder="" />
          <br />
          <label>Qty</label>
          <input id="qty" name="qty" class="form-control" type="number" placeholder="" />
          <br />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="simpan_tambah_aksesoris" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<script>
  function simpanBarang() {
    $.post("data/simpan_rincian_aksesoris.php", {
        id: '<?php echo $_GET['id'] ?>',
        id_akse: $('#id_akse').val(),
        qty: $('#qty').val()
      },
      function(data) {
        // alert(data);
        if (data == 'S') {
          $('#modal-tambah').modal('hide');
          Swal.fire({
            customClass: {
              confirmButton: 'bg-green',
              cancelButton: 'bg-white',
            },
            title: 'Berhasil Disimpan',
            icon: 'success',
            confirmButtonText: 'OK',
          });
          // loading_akse();
          getDataBarang();
        } else if (data == 'SAMA') {
          $('#modal-tambah').modal('hide');
          Swal.fire({
            customClass: {
              confirmButton: 'bg-yellow',
              cancelButton: 'bg-white',
            },
            title: 'Barang sudah terdaftar / sudah ada !',
            icon: 'warning',
            confirmButtonText: 'OK',
          })
          // loading_akse();
          // getDataBarang();
        } else {
          $('#modal-tambah').modal('hide');
          Swal.fire({
            customClass: {
              confirmButton: 'bg-red',
              cancelButton: 'bg-white',
            },
            title: 'Gagal Disimpan',
            icon: 'error',
            confirmButtonText: 'OK',
          })
          // loading_akse();
          // getDataBarang();
        }
      }
    );
  }

  function getNamaBarang() {
    $.get("data/get_nama_akse.php",
      function(data) {
        $('#nama_barang').html(data);
      }
    );
  }

  function loading_akse() {
    $.get("include/getLoading.php", function(data) {
      $('#tabel-akse').html(data);
    });
  }

  async function getDataBarang() {
    await $.get("data/simpan_tambah_aksesoris.php", {id: '<?php echo $_GET['id'] ?>'},
      function(data) {
        $('#tabel-akse').html(data);
      }
    );
  }

  $(document).ready(function() {
    getNamaBarang();
    // loading_akse();
    getDataBarang();
  });
</script>