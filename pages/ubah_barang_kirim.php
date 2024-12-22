<?php
$q1 = mysqli_fetch_array(mysqli_query($koneksi, "select *,barang_dikirim.id as idd from barang_dikirim,barang_dijual,pemakai where barang_dijual.id=barang_dikirim.barang_dijual_id and pemakai.id=barang_dijual.pemakai_id and barang_dikirim.id=" . $_GET['id'] . ""));
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Ubah Data Kirim Alkes</h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="index.php?page=kirim_barang">Alkes</a></li>
      <li class="active">Ubah Data Kirim Alkes</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) --><!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-5 connectedSortable">
        <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-warning"><!-- /.chat -->
          <div class="box-footer">
            <div class="box-header with-border">
              <h3 class="box-title">Ubah Data Kirim Alkes</h3>
            </div>
            <div class="box-body">
              <form method="post" onsubmit="ubahDataUmum(); return false;" id="formUbah">
                <input type="hidden" id="id" name="id" value="<?php echo $_GET['id'] ?>" />
                <label>Nama Paket</label>
                <input name="nama_paket" class="form-control" type="text" value="<?php echo $q1['nama_paket'] ?>"><br />
                <label>No Surat Jalan</label>
                <input name="no_sj" id="no_sj" class="form-control" type="hidden" value="<?php echo $q1['no_pengiriman'] ?>">
                <input name="no_pengiriman" class="form-control" type="text" value="<?php echo $q1['no_pengiriman'] ?>">
                <br />
                <label>Ekspedisi</label>
                <input name="ekspedisi" class="form-control" type="text" placeholder="" required value="<?php echo $q1['ekspedisi'] ?>"><br />
                <label>Tanggal Kirim</label>
                <input name="tgl_kirim" class="form-control" type="date" placeholder="" required value="<?php echo $q1['tgl_kirim'] ?>"><br />

                <label>Via Pengiriman</label>
                <input name="via_kirim" class="form-control" type="text" value="<?php echo $q1['via_pengiriman'] ?>">
                <br />

                <label>Estimasi Brg Sampai</label>
                <input name="estimasi" class="form-control" type="date" placeholder="" value="<?php echo $q1['estimasi_barang_sampai'] ?>"><br />
                <label>Biaya Jasa</label>
                <input name="biaya_jasa" class="form-control" type="text" value="<?php echo $q1['biaya_pengiriman'] ?>">
                <br />
                <label>Tanggal Sampai</label>
                <input name="tgl_sampai" class="form-control" type="date" placeholder="Pembeli" value="<?php echo $q1['tgl_sampai'] ?>"><br />
                <!--<label>Keterangan</label>
              <textarea name="ket_brg" class="form-control" type="text" rows="5" placeholder="Keterangan"><?php echo $q1['ket_brg'] ?></textarea><br />-->

                <button name="tambah_laporan" class="btn btn-warning" type="submit"><span class="fa fa-edit"></span> Simpan Perubahan</button>
                <br /><br />
              </form>
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

      <!-- Left col -->
      <section class="col-lg-4 connectedSortable">
        <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-warning"><!-- /.chat -->
          <div class="box-footer">
            <div class="box-header with-border">
              <h3 class="box-title">Ubah Data Pemakai</h3>
            </div>
            <div class="box-body">
              <form method="post" onsubmit="ubahDataPemakai(); return false;" id="formUbahPemakai">
                <input type="hidden" id="id_pemakai" name="id" value="<?php echo $q1['pemakai_id']; ?>" />
                <label>Nama Pemakai</label>
                <input name="nama_pemakai" class="form-control" type="text" value="<?php echo $q1['nama_pemakai'] ?>"><br />
                <label>Kontak 1</label>
                <input name="kontak1" class="form-control" type="text" value="<?php echo $q1['kontak1_pemakai'] ?>">
                <br />
                <label>Kontak 2</label>
                <input name="kontak2" class="form-control" type="text" placeholder="" required value="<?php echo $q1['kontak2_pemakai'] ?>"><br />
                <label>Email</label>
                <input name="email_pemakai" class="form-control" type="email" placeholder="" required value="<?php echo $q1['email_pemakai'] ?>"><br />
                <button name="simpan_pemakai" class="btn btn-warning" type="submit"><span class="fa fa-edit"></span> Simpan Perubahan</button>
                <br /><br />
              </form>
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

<script>
  function ubahDataUmum() {
    var dataform1 = $('#formUbah')[0];
    var data1 = new FormData(dataform1);
    $.ajax({
      type: "post",
      url: "data/ubah-data-umum-pengiriman.php",
      data: data1,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
          addRiwayat('UPDATE', 'barang_dikirim', <?php echo $_GET['id'] ?>, `Mengubah Data Umum Pengiriman Barang (NO_SJ : ${$('#no_sj').val()})`);
          alertSimpan('S')
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  function ubahDataPemakai() {
    var dataform2 = $('#formUbahPemakai')[0];
    var data2 = new FormData(dataform2);
    $.ajax({
      type: "post",
      url: "data/ubah-pemakai-pengiriman.php",
      data: data2,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
          addRiwayat('UPDATE', 'pemakai', $('#id_pemakai').val(), 'Mengubah Data Pemakai Pada Pengiriman Barang (NO_SJ : ' + $('#no_sj').val() + ')');
          alertSimpan('S')
        } else {
          alertSimpan('F')
        }
      }
    });
  }
</script>