<?php
if (isset($_POST['kirim_barang'])) {
  $input = mysqli_query($koneksi, "update barang_gudang_detail_rusak set status_progress=" . $_POST['status'] . " where id=" . $_GET['id_ubah'] . "");

  if ($input) {
    echo "<script>
			window.location='index.php?page=tambah_progress_rusak_dalam&id_gudang_detail	=$_GET[id_gudang_detail]&id_ubah=$_GET[id_ubah]&id_gudang=$_GET[id_gudang]'
				</script>";
  }
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Progress Pengerjaan</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Detail Laporan Kerusakan</li>
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
                <a href="index.php?page=progress_rusak_dalam_detail&id_gudang=<?php echo $_GET['id_gudang']; ?>"><button class="btn btn-success">Kembali Ke Halaman Sebelumnya</button></a>
                <br /><br />
                <div class="table-responsive">
                  <table width="100%" id="" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th valign="top"><strong>Nama Alkes</strong></th>

                        <th valign="top"><strong>Merk</strong></th>
                        <th valign="top"><strong>Tipe</strong></th>
                        <th valign="top">No Seri/Nama Set</th>
                        <!--<th valign="top">NIE</th>
      <th valign="top">No. Bath</th>
      <th valign="top">No. Lot</th>-->
                        <th valign="top"><strong>Negara Asal</strong></th>

                        <th align="center" valign="top"><strong>Deskripsi Alat
                          </strong></th>
                        <th align="center" valign="top">Status Progress</th>
                        <th align="center" valign="top">Status Barang</th>

                      </tr>
                    </thead>
                    <?php

                    $query = mysqli_query($koneksi, "select *,barang_gudang.id as id_gudang from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and barang_gudang_detail.id=" . $_GET['id_gudang_detail'] . " and barang_gudang_detail_rusak.id=" . $_GET['id_ubah'] . "");
                    //$query = mysqli_query($koneksi, "select *,barang_gudang.id as idd from barang_gudang order by id ".$limiter['urut']." LIMIT ".$limiter['limiter']."");

                    $no = 0;
                    while ($data = mysqli_fetch_assoc($query)) {
                      $no++;
                    ?>
                      <tr>
                        <td>
                          <?php $jml = mysqli_num_rows(mysqli_query($koneksi, "select barang_gudang_detail_id from barang_dijual,barang_gudang,barang_gudang_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dijual.barang_gudang_detail_id and barang_gudang_id=" . $data['idd'] . ""));
                          if ($jml != 0) {
                          ?>
                            <a href="index.php?page=jual_barang&id_lihat_jual=<?php echo $data['idd']; ?>" data-toggle="tooltip" title="Lihat Proses Penjualan"><?php echo $data['nama_brg']; ?></a>
                            <span class="label label-primary pull-right"><?php echo $jml; ?></span>
                          <?php } else {
                            echo $data['nama_brg'];
                          } ?>
                        </td>

                        <td><?php echo $data['merk_brg']; ?></td>
                        <td><?php echo $data['tipe_brg']; ?></td>
                        <td><?php echo $data['no_seri_brg'] . " " . $data['nama_set']; ?></td>
                        <!--<td><?php echo $data['nie_brg']; ?></td>
    <td><?php echo $data['no_bath']; ?></td>
    <td><?php echo $data['no_lot']; ?></td>-->
                        <td><?php echo $data['negara_asal']; ?></td>
                        <td><?php echo $data['deskripsi_alat']; ?></td>
                        <td>
                          <?php if ($data['status_progress'] == 1) {
                            echo "SELESAI";
                          } else if ($data['status_progress'] == 0) {
                            echo "BELUM SELESAI";
                          } ?>
                        </td>
                        <td><?php if ($data['status_kerusakan'] == 1) {
                              echo "RUSAK";
                            } else if ($data['status_kerusakan'] == 2) {
                              echo "Dikembalikan ke pabrik";
                            } else {
                              echo "-";
                            } ?></td>
                      </tr>
                    <?php } ?>
                  </table>
                </div>

                <br />
                <h3 align="center">Detail Progress</h3>
                <br />
                <?php
                $da = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_gudang_detail_rusak where id=" . $_GET['id_ubah'] . ""));
                if ($da['status_progress'] == 0) { ?>
                  <!-- <a href="index.php?page=tambah_progress_rusak_dalam2&id_gudang_detail=<?php echo $_GET['id_gudang_detail']; ?>&id_ubah=<?php echo $_GET['id_ubah']; ?>&id_gudang=<?php echo $_GET['id_gudang']; ?>"><button class="btn btn-success"><span class="fa fa-plus"></span> &nbsp;Tambah</button></a> -->
                  <a href="#" data-toggle="modal" data-target="#modal-tambah"><button class="btn btn-success"><span class="fa fa-plus"></span> &nbsp;Tambah</button></a>
                <?php } ?>
                <a target="_blank" href="cetak_progress_belum_dijual.php?id_gudang_detail=<?php echo $_GET['id_gudang_detail']; ?>&id_ubah=<?php echo $_GET['id_ubah']; ?>&id_gudang=<?php echo $_GET['id_gudang']; ?>"><button class="btn btn-info"><span class="fa fa-print"></span> &nbsp;Cetak Progress</button></a>
                <a href="#" data-toggle="modal" data-target="#modal-status"><button class="pull pull-right btn btn-success"><span class="fa fa-edit"></span> &nbsp;Ubah Status Progress</button></a><br /><br />
                <div class="table-responsive">
                  <div id="data-progress"></div>
                </div>
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
<div class="modal fade" id="modal-status">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ubah Status Progress</h4>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <select id="input" name="status" class="form-control select2" style="width:100%">
            <?php if ($da['status_progress'] == 0) { ?>
              <option value="0">Belum Selesai</option>
              <option value="1">Sudah Selesai</option>
            <?php } else if ($da['status_progress'] == 1) { ?>
              <option value="1">Sudah Selesai</option>
              <option value="0">Belum Selesai</option>
            <?php } ?>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="kirim_barang" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan</button>
        </div>
      </form>
      <script type="text/javascript">
        <?php
        echo $jsArray;
        ?>

        function changeValue(id_akse) {
          document.getElementById('tipe_akse').value = dtBrg[id_akse].tipe_akse;
          document.getElementById('merk_akse').value = dtBrg[id_akse].merk_akse;
          document.getElementById('no_akse').value = dtBrg[id_akse].no_akse;

        };
      </script>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Tambah Progress</h4>
      </div>
      <form method="post" onsubmit="tambahProgress(); return false;" id="formTambah" enctype="multipart/form-data">
        <div class="modal-body">
          <input name="id_ubah" value="<?php echo $_GET['id_ubah'] ?>" type="hidden" />
          <label>Tanggal</label>
          <div class="input-group col-sm-1">
            <span class="input-group-addon"><span class="fa fa-calendar"></span></span><input name="tgl" class="form-control" placeholder="" type="date" required="required" autofocus="autofocus">
          </div><br />
          <label>Deskripsi Kerusakan</label>
          <textarea name="deskripsi_kerusakan" cols="" rows="4" class="form-control" required="required"></textarea>
          <br />
          <label>Deskripsi Perbaikan</label>
          <textarea name="deskripsi_perbaikan" cols="" rows="4" class="form-control" required="required"></textarea>
          <br />
          <label>Lampiran Photo/Video</label>
          <input name="lampiran" type="file" class="form-control" style="background-color:#CCC" />
          <br />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="kirim_barang" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function getDataProgress() {
    let id_ubah = '<?php echo $_GET['id_ubah']; ?>';
    loading2('#data-progress');
    $.get("data/data-progress-rusak-dalam.php", {
        id_ubah: id_ubah
      },
      function(data, textStatus, jqXHR) {
        $('#data-progress').html(data);
      }
    );
  }

  function tambahProgress() {
    showLoading(1)
    var dataform = $('#formTambah')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/tambah-progress-rusak-dalam.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        showLoading(0)
        if (response == 'S') {
          $('#modal-tambah').modal('hide');
          dataform.reset();
          getDataProgress();
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
      title: 'Anda Yakin Akan Menghapus Data Progress Ini ?',
      text: 'Data Akan Dihapus Secara Permanen',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        $.post("data/hapus-progress-rusak-dalam.php", {
            id_hapus: id
          },
          function(data, textStatus, jqXHR) {
            if (data == 'S') {
              alertHapus('S');
              getDataProgress();
            } else {
              alertHapus('F');
            }
          }
        );
      }
    })

  }

  $(document).ready(function() {
    getDataProgress();
  });
</script>