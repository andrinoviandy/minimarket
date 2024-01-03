<?php
if (isset($_POST['lihat'])) {
  echo "<script>	window.location='index.php?page=penyebaran_alkes&provinsi=$_POST[provinsi]&kabupaten=$_POST[kabupaten]&kecamatan=$_POST[kecamatan]'
	</script>";
}
if (isset($_POST['cetak'])) {
  echo "<script>
  window.location='cetak_penyebaran_alkes.php?provinsi=$_POST[provinsi]&kabupaten=$_POST[kabupaten]&kecamatan=$_POST[kecamatan]';
	history.back();
	</script>";
}
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Penyebaran Alkes
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Penyebaran Alkes</li>
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
                <div class="pull pull-left col-lg-8">
                  <form method="post" action="cetak_penyebaran_alkes.php" enctype="multipart/form-data">
                    <div class="col-lg-4 no-padding">
                      <div class="">
                        <select class="form-control select2" required name="provinsi" id="provinsi" style="width: 100%;" onchange="pilihProvinsi(this.value)">
                          <option value="">Pilih Provinsi</option>
                          <?php $q1 = mysqli_query($koneksi, "select * from alamat_provinsi order by nama_provinsi ASC");
                          while ($row1 = mysqli_fetch_array($q1)) {
                          ?>
                            <option value="<?php echo $row1['id']; ?>"><?php echo $row1['nama_provinsi']; ?></option>
                          <?php
                          } ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-lg-3 no-padding">
                      <select class="form-control select2" name="kabupaten" id="kabupaten" style="width: 100%;" onchange="pilihKabupaten(this.value)">
                      </select>
                    </div>
                    <div class="col-lg-3 no-padding">
                      <select class="form-control select2" name="kecamatan" id="kecamatan" style="width: 100%;">
                      </select>
                    </div>
                    <div class="col-lg-1 no-padding">
                      <button class="btn btn-success" type="submit" name="cetak"><span class="fa fa-print"></span> Cetak Excel</button>
                    </div>
                  </form>
                  <script>
                    var provinsi = document.getElementById("provinsi");
                    var kabupaten = document.getElementById("kabupaten");
                    var kecamatan = document.getElementById("kecamatan");

                    kabupaten.disabled = true;
                    kecamatan.disabled = true;

                    function pilihProvinsi(id) {
                      kabupaten.disabled = false;
                      const xhr = new XMLHttpRequest()
                      xhr.onreadystatechange = () => {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                          kabupaten.innerHTML = xhr.responseText
                        }
                      }
                      xhr.open('GET', "data/kabupaten.php?provinsi_id=" + id, true)
                      xhr.send()
                    }

                    function pilihKabupaten(id) {
                      kecamatan.disabled = false
                      const xhr = new XMLHttpRequest()
                      xhr.onreadystatechange = () => {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                          kecamatan.innerHTML = xhr.responseText
                        }
                      }
                      xhr.open('GET', "data/kecamatan.php?kabupaten_id=" + id, true)
                      xhr.send()
                    }
                  </script>
                </div>
                <div class="col-lg-4">
                  <div class="pull pull-right">
                    <?php include "include/getFilter.php"; ?>
                    <?php include "include/atur_halaman.php"; ?>
                  </div>
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
        <div class="box box-default">
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