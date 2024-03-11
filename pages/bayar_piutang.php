<?php
$data = mysqli_fetch_array(mysqli_query($koneksi, "select *,utang_piutang.id as idd from utang_piutang where utang_piutang.id=$_GET[id]"));
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><span class="active">Piutang Dibayar</span></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Piutang</li>
      <li class="active">Piutang Dibayar</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) --><!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <section class="col-lg-3 connectedSortable">
        <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success"><!-- /.chat -->
          <div class="box-footer">
            <div class="box-body">
              <a href="index.php?page=piutang"><button name="tambah_header" class="btn btn-success" type="button"> Kembali </button></a>
              <center>
                <h4 class="box-title">Pembayaran</h4>
              </center>
              <script type="text/javascript">
                function yesnoCheck() {
                  if (document.getElementById('yesCheck').checked) {
                    document.getElementById('ifYes').style.display = 'block';
                  } else document.getElementById('ifYes').style.display = 'none';
                }
              </script>
              <form method="post" id="formData" enctype="multipart/form-data" onsubmit="tambahPembayaran(); return false;">
                <input name="id" value="<?php echo $_GET['id']; ?>" type="hidden">
                <label>Tanggal</label>
                <input name="tgl_input" class="form-control" type="date" placeholder="" required="required" value="<?php echo date('Y-m-d'); ?>"><br />
                <?php
                if ($data['jatuh_tempo'] == 0000 - 00 - 00) {
                  $ac = "checked";
                  $n = "none";
                } else {
                  $ac2 = "checked";
                  $n = "";
                }
                ?>

                <label>Nominal</label>
                <input name="nominal" class="form-control" type="text" placeholder="" required="required" value="" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"><br />
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" required="required"></textarea>
                <br />

                <label>Akun</label>
                <select name="akun" id="akun" class="form-control select2" required style="width:100%">
                  <option value="">-- Pilih --</option>
                  <?php
                  $q = mysqli_query($koneksi, "select * from buku_kas order by no_akun ASC");
                  while ($d = mysqli_fetch_array($q)) {
                  ?>
                    <option value="<?php echo $d['id']; ?>"><?php echo $d['no_akun'] . " | &nbsp;&nbsp;" . $d['nama_akun']; ?></option>
                  <?php } ?>
                </select><br /><br />

                <button name="tambah_header" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan </button>
              </form>

            </div>
          </div>
        </div>
        <!-- /.box (chat box) -->

        <!-- TO DO List --><!-- /.box -->

        <!-- quick email widget -->
      </section>
      <!-- Left col -->
      <section class="col-lg-9 connectedSortable">
        <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success"><!-- /.chat -->
          <div class="box-footer">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Piutang</h3>
            </div>
            <div class="box-body">
              <div id="header-piutang"></div>
              <h4 class="box-title" align="center">Riwayat Pembayaran</h4>
              <div id="riwayat-pembayaran"></div>
              <script type="text/javascript">
                function yesnoCheck() {
                  if (document.getElementById('yesCheck').checked) {
                    document.getElementById('ifYes').style.display = 'block';
                  } else document.getElementById('ifYes').style.display = 'none';
                }
              </script><br /><br />
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
<?php

?>
<!-- <div id="openUbah" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Ubah Riwayat Pembayaran</h3>

    <form method="post">
      <label>Tanggal</label>
      <input name="tgl_input2" class="form-control" type="date" placeholder="" required="required" value="<?php echo $da['tgl_bayar']; ?>"><br />
      <label>Nominal</label>
      <input name="nominal2" class="form-control" type="text" placeholder="" required="required" value="<?php echo $da['nominal']; ?>"><br />
      <label>Deskripsi</label>
      <textarea name="deskripsi2" class="form-control" rows="4" required="required"><?php echo $da['deskripsi']; ?></textarea>
      <br />

      <label>Akun</label>
      <select name="akun2" id="akun2" class="form-control" required>
        <option value="">-- Pilih --</option>
        <?php
        $q = mysqli_query($koneksi, "select * from buku_kas order by no_akun ASC");
        while ($d = mysqli_fetch_array($q)) {
        ?>
          <option <?php if ($da['id_coa'] == $d['id']) {
                    echo "selected";
                  } ?> value="<?php echo $d['id']; ?>"><?php echo $d['no_akun'] . " | &nbsp;&nbsp;" . $d['nama_akun']; ?></option>
        <?php } ?>
      </select><br />

      <button name="ubah_riwayat" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan </button>
    </form>

  </div>
</div> -->
<script src="jquery-1.10.2.min.js"></script>
<script src="jquery.chained.min.js"></script>
<script>
  $("#jenis_akun").chained("#akun");
  $("#jenis_akun2").chained("#akun2");
</script>

<div class="modal fade" id="modal-detailpiutang<?php echo $data['idd']; ?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Detail Barang</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <p align="justify">

            <?php
            $q2 = mysqli_query($koneksi, "select *,barang_dijual_qty.id as id_det_jual from barang_dijual_qty,barang_dijual,barang_gudang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.no_po_jual='" . $data['no_faktur_no_po'] . "' and status_deal=1");
            $n = 0;
            while ($d1 = mysqli_fetch_array($q2)) {
              $n++;
            ?>
              <?php echo $n . ". " . $d1['nama_brg'] . "     |    "; ?></td>
              <?php echo $d1['tipe_brg'] . "  |  " ?></td>
              <?php echo $d1['qty_jual']; ?>
              <hr />
            <?php } ?>

          </p>
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

<div class="modal fade" id="modal-detail<?php echo $data['idd']; ?>">
  <div class="modal-header">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Detail Piutang</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

            <!-- Chat box -->
            <div class="box box-warning"><!-- /.chat -->
              <div class="box-footer">
                <div class="box-body">
                  <div class="">
                    <div id="data-umum"></div>
                    <br />

                    <div id="data-detail"></div>

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
          <!-- right col -->
        </div>
      </div>
      <div class="modal-footer">
        <center><button type="button" class="btn btn-warning" data-dismiss="modal">Close</button></center>

      </div>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalUbah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ubah Pembayaran</h4>
      </div>
      <form method="post" onsubmit="ubahPembayaran(); return false;" id="formUbah">
        <div class="modal-body">
          <div id="modal-ubah"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="ubah_riwayat" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan </button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function getDataUmum(id) {
    $.get("data/jual_data_umum.php", {
        id: id
      },
      function(data) {
        $('#data-umum').html(data);
      }
    );
  }

  function getDataDetail(id, dpp) {
    let url = '';
    if (dpp == 1) {
      url = "data/detail_piutang.php";
    } else {
      url = "data/detail_piutang_no_dpp.php";
    }
    $.get(url, {
        id: id
      },
      function(data) {
        $('#data-detail').html(data);
      }
    );
  }

  function loading() {
    $.get("include/getLoading.php", function(data) {
      $('#riwayat-pembayaran').html(data);
    });
  }

  function modalUbah(id, id_ubah) {
    $('#modalUbah').modal('show');
    $.get("data/modal-ubah-piutang.php", {
        id: id,
        id_ubah: id_ubah
      },
      function(data) {
        $('#modal-ubah').html(data);
      }
    );
  }

  function getHeader() {
    $.get("data/header-piutang.php", {
        id: '<?php echo $_GET['id']; ?>'
      },
      function(data) {
        $('#header-piutang').html(data);
      }
    );
  }

  function getRiwayat() {
    loading();
    $.get("data/riwayat-pembayaran-piutang.php", {
        id: '<?php echo $_GET['id']; ?>'
      },
      function(data) {
        $('#riwayat-pembayaran').html(data);
      }
    );
  }

  function hapus(id_hapus) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Akan Menghapus Transaksi Ini ?',
      text: 'Data Akan Dihapus Secara Permanen',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        $.post("data/hapus-pembayaran-piutang.php", {
            id: '<?php echo $_GET['id'] ?>',
            id_hapus: id_hapus
          },
          function(data) {
            if (data == 'S') {
              getRiwayat();
              getHeader();
              alertHapus('S')
            } else {
              alertHapus('F')
            }
          }
        );
      }
    })
  }

  function ubahPembayaran() {
    var dataform = $('#formUbah')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/ubah-pembayaran-piutang.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
          $('#modalUbah').modal('hide');
          dataform.reset();
          getRiwayat();
          getHeader();
          alertSimpan('S')
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  function tambahPembayaran() {
    var dataform = $('#formData')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/simpan-pembayaran-piutang.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
          dataform.reset();
          getRiwayat();
          getHeader();
          alertSimpan('S')
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  $(document).ready(function() {
    getHeader();
    getRiwayat();
  });
</script>