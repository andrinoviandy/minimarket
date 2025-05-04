<?php
// if (isset($_POST['atur_jumlah'])) {
//   $up = mysqli_query($koneksi, "update limiter set jumlah_limit=" . $_POST['jumlah_limit'] . "");
//   if ($up) {
//     echo "<script>

// 		</script>";
//   }
// }
?>
<script>
  function atur_halaman(params) {
    jumlah_limit = parseInt(document.getElementById("jumlah_limit").value);
    $.post("atur_halaman.php", {
        jumlah_limit: params
      },
      function(data) {
        if (data == 'S') {
          $('#modal-atur').modal('hide');
          loading()
          loadMore(load_flag = 0, key = '', status_b);
        }
      }
    );
  }
</script>
<a data-toggle="tooltip" data-title="Jumlah Data Yang Ditampilkan Per Halaman"><button data-toggle="modal" data-target="#modal-atur" name="limit" class="btn btn-default" type="button"><span class="fa fa-cog"></span></button></a>
<div class="modal fade" id="modal-atur">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Jumlah Data Yang Ditampilkan Per Halaman</h4>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <select id="jumlah_limit" name="jumlah_limit" class="form-control select2" style="width:100%" required>
            <option value="">...</option>
            <?php
            $dd = mysqli_fetch_array(mysqli_query($koneksi, "select jumlah_limit from limiter"));
            ?>
            <option <?php if ($dd['jumlah_limit'] == 5) {
                      echo "selected";
                    } ?> value="5">5</option>
            <option <?php if ($dd['jumlah_limit'] == 10) {
                      echo "selected";
                    } ?> value="10">10</option>
            <option <?php if ($dd['jumlah_limit'] == 20) {
                      echo "selected";
                    } ?> value="20">20</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="button" name="atur_jumlah" class="btn btn-success" onclick="atur_halaman($('#jumlah_limit').val());">Simpan</button>
          <!--<button type="submit" name="print" class="btn btn-info">Print</button>-->
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>