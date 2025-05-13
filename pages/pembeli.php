<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Pelanggan</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pelanggan</li>
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
                <a href="index.php?page=tambah_pembeli"><input type="submit" name="button" id="button" value="Tambah Pelanggan" class="btn btn-success" /></a>
                <div class="pull pull-right">
                  <?php //include "include/getFilter.php"; 
                  ?>
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