<?php
$query = mysqli_query($koneksi, "select * from pembeli where nama_pembeli='" . $_GET['nama_pembeli'] . "'");
$data = mysqli_fetch_array($query);
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Ubah Pelanggan</h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="index.php?page=barang_masuk">Pelanggan</a></li>
      <li class="active">Ubah Pelanggan</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) --><!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-7 connectedSortable">
        <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success"><!-- /.chat -->
          <div class="box-footer">
            <div class="box-header with-border">
              <h3 class="box-title">Ubah Pembeli</h3>
            </div>
            <div class="box-body">
              <form method="post" onsubmit="ubahDataPembeli(); return false;" id="formUbah">
                <input name="nama_awal" type="hidden" value="<?php echo $data['nama_pembeli']; ?>">
                <label>Nama Pembeli</label>
                <input name="nama_pembeli" class="form-control" placeholder="" type="text" value="<?php echo $data['nama_pembeli']; ?>"><br />

                <strong>Provinsi</strong>
                <select class="form-control" name="provinsi" id="provinsi" required>
                  <option value="">-- Pilih Provinsi --</option>
                  <?php $q1 = mysqli_query($koneksi, "select * from alamat_provinsi order by nama_provinsi ASC");
                  while ($row1 = mysqli_fetch_array($q1)) {
                  ?>
                    <option <?php if ($data['provinsi_id'] == $row1['id']) {
                              echo "selected";
                            } ?> value="<?php echo $row1['id']; ?>"><?php echo $row1['nama_provinsi']; ?></option>
                  <?php
                  } ?>
                </select>
                <br />

                <strong>Kabupaten</strong>
                <select class="form-control" name="kabupaten" id="kabupaten" required>
                  <option value="">-- Pilih Kabupaten/Kota --</option>
                  <?php $q2 = mysqli_query($koneksi, "select *,alamat_kabupaten.id as idd from alamat_kabupaten INNER JOIN alamat_provinsi ON alamat_provinsi.id=alamat_kabupaten.provinsi_id order by nama_kabupaten ASC");
                  while ($row2 = mysqli_fetch_array($q2)) {
                  ?>
                    <option <?php if ($data['kabupaten_id'] == $row2['idd']) {
                              echo "selected";
                            } ?> id="kabupaten" class="<?php echo $row2['provinsi_id']; ?>" value="<?php echo $row2['idd']; ?>"><?php echo $row2['nama_kabupaten']; ?></option>
                  <?php } ?>
                </select>
                <br />

                <strong>Kecamatan</strong>
                <select class="form-control" name="kecamatan" id="kecamatan" required>
                  <option value="">-- Pilih Kecamatan --</option>
                  <?php $q3 = mysqli_query($koneksi, "select *,alamat_kecamatan.id as idd from alamat_kecamatan INNER JOIN alamat_kabupaten ON alamat_kabupaten.id=alamat_kecamatan.kabupaten_id order by nama_kecamatan ASC");
                  while ($row3 = mysqli_fetch_array($q3)) {
                  ?>
                    <option <?php if ($data['kecamatan_id'] == $row3['idd']) {
                              echo "selected";
                            } ?> id="kecamatan" class="<?php echo $row3['kabupaten_id']; ?>" value="<?php echo $row3['idd']; ?>"><?php echo $row3['nama_kecamatan']; ?></option>
                  <?php } ?>
                </select>
                <br />

                <strong>Kelurahan</strong>
                <input name="kelurahan_id" class="form-control" type="text" placeholder="" value="<?php echo $data['kelurahan_id']; ?>"><br />


                <strong>Jalan</strong>
                <textarea name="jalan" class="form-control" type="text" rows="5" placeholder="" required><?php echo $data['jalan']; ?></textarea><br />

                <strong>Kontak</strong>
                <input name="kontak" class="form-control" type="text" placeholder="" value="<?php echo $data['kontak_rs']; ?>"><br />
                <button name="simpan_perubahan" class="btn btn-success" type="submit"><span class="fa fa-edit"></span> Simpan Perubahan</button>
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
  function ubahDataPembeli() {
    var dataform1 = $('#formUbah')[0];
    var data = new FormData(dataform1);
    $.ajax({
      type: "post",
      url: "data/ubah-data-pembeli.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
          let id_pembeli = '<?php echo $data['id'] ?>';
          let nama_awal = '<?php echo $data['nama_pembeli'] ?>';
          addRiwayat('UPDATE', 'pembeli', id_pembeli, `Mengubah Data Pembeli (Nama Pembeli : ${nama_awal})`);
          alertSimpan('S')
        } else {
          alertSimpan('F')
        }
      }
    });
  }
</script>