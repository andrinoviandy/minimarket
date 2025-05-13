<?php
if (isset($_GET['id_hapus'])) {
  $del2 = mysqli_query($koneksi, "delete from supplier where id=" . $_GET['id_hapus'] . "");
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Supplier / Pemasok</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Supplier / Pemasok</li>
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
              <a href="index.php?page=tambah_pemasok"><input type="submit" name="button" id="button" value="Tambah Supplier" class="btn btn-success" /></a>
              <br /><br />
              <div class="table-responsive">
                <table width="100%" id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th align="center" valign="top">No</th>
                      <th valign="top">Nama Supplier</th>
                      <th valign="top"><strong>Alamat</strong></th>
                      <th valign="top">Telp</th>
                      <th valign="top">Fax</th>
                      <th width="16%" align="center" valign="top">Pemilik</th>
                    </tr>
                  </thead>
                  <?php

                  // membuka file JSON
                  include("include/API.php");
                  $file = file_get_contents($API . "json/pemasok.php");
                  $json = json_decode($file, true);
                  $jml = count($json);
                  for ($i = 0; $i < $jml; $i++) {
                    //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
                    //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
                    #C33 
                  ?>

                    <tr>
                      <td align="center" valign="center"><?php echo $i + 1; ?></td>
                      <td valign="center"><?php echo $json[$i]['nama_supplier']; ?></td>
                      <td><?php echo $json[$i]['alamat_suppplier']; ?></td>

                      <td>
                        <?php echo $json[$i]['telp_supplier'];  ?></td>
                      <td><?php echo $json[$i]['fax_supplier'];  ?></td>
                      <td><?php echo $json[$i]['attn_supplier'];  ?></td>
                    </tr>
                  <?php } ?>
                </table>
              </div>
              <br />

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
    <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>