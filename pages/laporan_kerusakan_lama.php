<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Laporan Kerusakan
      dari <u><?php $da = mysqli_fetch_array(mysqli_query($koneksi, "select *,pembeli.id as idd from pembeli,alamat_provinsi,alamat_kecamatan,alamat_kabupaten where alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and pembeli.id=$_GET[id]"));
              echo $da['nama_pembeli']; ?></u></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Laporan Kerusakan</li>
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

                <!--
              <form method="post" class="">
              <div class="input-group input-group-md col-xs-4 pull pull-right">
                <input type="text" name="cari" placeholder="Keyword....." class="form-control">
                    <span class="input-group-btn">
                      <button type="submit" name="button_cari" class="btn btn-info btn-flat"><i class="fa fa-search"></i> Cari </button>
                    </span>
              </div>
              </form>
              -->
                <div class="table-responsive no-padding">
                  <table width="100%" id="" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th valign="bottom">Nama Instansi</th>
                        <th valign="bottom">Alamat</th>
                        <th valign="bottom"><strong>Kontak</strong></th>
                      </tr>
                    </thead>
                    <tr>
                      <td><?php echo $da['nama_pembeli']; ?></td>
                      <td><?php echo $da['jalan'] . ", " . $da['kelurahan_id'] . ", " . $da['nama_kecamatan'] . ", " . $da['nama_kabupaten'] . ", " . $da['nama_provinsi']; ?></td>
                      <td><?php echo $da['kontak_rs']; ?></td>
                    </tr>
                  </table>
                </div>
                <br />
                <div class="pull pull-right">
                  <?php //include "include/getFilter.php"; 
                  ?>
                  <?php include "include/atur_halaman.php"; ?>
                </div>

                <?php include "include/header_pencarian.php"; ?>
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
<div class="modal fade" id="modal-pilih">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Pilih No Seri dan Teknisi</h4>
      </div>
      <div id="data-modal-pilih"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-view">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Detail</h4>
      </div>
      <div class="modal-body">
        <div id="data-modal-view"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function pilihNoSeri(id) {
    var dataform1 = $('#formPilih')[0];
    var data1 = new FormData(dataform1);
    $.ajax({
      type: "post",
      url: "data/simpan-no-seri-teknisi-kerusakan-lama.php",
      data: data1,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
          // addRiwayat('INSERT', 'tb_laporan_kerusakan_detail', <?php echo $_GET['id'] ?>, `Mengubah Data Umum Pengiriman Barang (NO_SJ : ${$('#no_sj').val()})`);
          loadMore(load_flag, key, status_b)
          $('#modal-pilih').modal('hide');
          alertSimpan('S')
        } else if (response == 'SA') {
          alertCustom('W', 'Gagal !', 'Data Ini Sudah Tersimpan');
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  async function showModal(id_lapor) {
    $('#modal-pilih').modal('show');
    await $.get("data/form-modal-pilih-kerusakan-lama.php", {
        id: <?php echo $_GET['id'] ?>,
        id_lapor: id_lapor
      },
      function(data, textStatus, jqXHR) {
        $('#data-modal-pilih').html(data);
      }
    );
  }

  async function showDetail(id_lapor) {
    loading2('#data-modal-view')
    $('#modal-view').modal('show');
    await $.get("data/modal-view-kerusakan-lama.php", {
        id: id_lapor
      },
      function(data) {
        $('#data-modal-view').html(data);
      }
    );
    // alertCustom('W', 'Pemberitahuan !', 'Fitur View ini akan menampilkan no seri alat, dan fitur ini masih dalam proses pengembangan , Silakan Lihat di Menu "Teknisi Yang Menangani" dulu ya ! Isinya 100% sama ! Menunya tepat dibawah menu ini ya . Terima Kasih')
  }
</script>