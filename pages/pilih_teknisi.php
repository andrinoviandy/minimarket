<?php
$data = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_teknisi where id=" . $_GET['id'] . ""));

if (isset($_GET['simpan_barang']) == 1) {
  $cek = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_teknisi_hash where akun_id=" . $_SESSION['id'] . ""));
  if ($cek != 0) {
    //$insert_pembeli=mysqli_query($koneksi, "insert into pembeli values('','".$_SESSION['pembeli']."','".$_SESSION['provinsi']."','".$_SESSION['kabupaten']."','".$_SESSION['kecamatan']."','".$_SESSION['kelurahan']."','".$_SESSION['alamat']."','".$_SESSION['kontak_rs']."')");

    $insert_pemakai = mysqli_query($koneksi, "insert into pemakai values('','" . $_SESSION['pemakai'] . "','" . $_SESSION['kontak1'] . "','" . $_SESSION['kontak2'] . "','" . $_SESSION['email'] . "')");

    //$pembeli=mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_pembeli from pembeli"));
    /*$id_pembeli=$_SESSION['pembeli'];
	$pemakai=mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_pemakai from pemakai"));
	$id_pemakai=$pemakai['id_pemakai'];
	//simpan barang dijual
	$total = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dijual_hash where akun_id=".$_SESSION['id'].""));
	*/
    $simpan1 = mysqli_query($koneksi, "insert into barang_teknisi values('','" . $_SESSION['tgl_spi'] . "','" . $_SESSION['no_spi'] . "')");

    $d1 = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_max from barang_teknisi"));
    $id_jual = $d1['id_max'];
    //simpan barang pesan detail
    $q2 = mysqli_query($koneksi, "select * from barang_teknisi_hash where akun_id=" . $_SESSION['id'] . "");
    while ($d2 = mysqli_fetch_array($q2)) {
      $simpan2 = mysqli_query($koneksi, "insert into barang_teknisi_detail values('','$id_jual','" . $d2['barang_dikirim_detail_id'] . "','0')");
      $up = mysqli_query($koneksi, "update barang_dikirim_detail set status_spi=1 where id=" . $d2['barang_dikirim_detail_id'] . "");
      //$up2=mysqli_query($koneksi, "update barang_gudang,barang_gudang_detail set stok_total=stok_total-1 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=".$d2['barang_gudang_detail_id']."");
    }
    if ($simpan1 and $simpan2) {
      mysqli_query($koneksi, "delete from barang_teknisi_hash where akun_id=" . $_SESSION['id'] . "");
      echo "<script>
            Swal.fire({
              customClass: {
                confirmButton: 'bg-green',
                cancelButton: 'bg-white',
              },
              title: 'Data Berhasil Disimpan',
              icon: 'success',
              confirmButtonText: 'OK',
            }).then(() => {
              window.location.href = '?page=spk_masuk';
            })
            </script>";
    }
  } else {
    echo "<script>
            Swal.fire({
              customClass: {
                confirmButton: 'bg-red',
                cancelButton: 'bg-white',
              },
              title: 'Data tidak boleh kosong , silakan tambah terlebih dahulu !',
              icon: 'error',
              confirmButtonText: 'OK',
            }).then(() => {
              window.location.href = '?page=tambah_spk_masuk2';
            })
            </script>";
  }
}
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Pilih Teknisi</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Pilih Teknisi</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success">
          <!-- /.chat -->
          <div class="box-footer">
            <div class="box-body">
              <div class="">
                <!--<a href="index.php?page=tambah_barang_masuk"><button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Barang</button></a>-->
                <div class="table-responsive">
                  <table width="100%" id="" class="table table-bordered">
                    <thead>
                      <tr>
                        <th width="" valign="bottom"><strong>Tgl SPI</strong></th>
                        <th width="" valign="bottom">No SPI</th>
                        <th width="" valign="bottom">Deskripsi</th>
                      </tr>
                    </thead>
                    <tr>
                      <td><?php echo date("d F Y", strtotime($data['tgl_spk'])); ?>
                      </td>
                      <td><?php echo $data['no_spk']; ?></td>
                      <td><?php echo $data['keterangan_spk']; ?></td>
                    </tr>
                  </table>
                </div>
                <br />
                <font align="left" size="+2">
                  Data</font>
                <button class="btn btn-success pull pull-right" data-toggle="modal" data-target="#modal-tambah"><span class="fa fa-plus"></span> Tambah</button>
                <br /><br />
                <div class="table-responsive">
                  <div id="table-teknisi"></div>
                </div>
                <center>
                  <br>
                  <!--<a href="index.php?page=tambah_spk_masuk2&simpan_barang=1"><button name="simpan_barang" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Simpan</button></a>&nbsp;&nbsp;--><a href="index.php?page=spk_masuk"><button name="batal" class="btn btn-success" type="submit"><span class="fa  fa-check"></span> Kembali Ke Halaman SPI</button></a>
                </center>
              </div>
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

<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Tambah Data</h4>
      </div>
      <form id="formTambah" onsubmit="simpanTambah(); return false;">
        <div class="modal-body">
          <input type="hidden" id="id" name="id" value="<?php echo $_GET['id']; ?>">
          <label>Nama Alkes</label>
          <select name="id_brg" id="id_brg" class="form-control select2" required style="width:100%">
            <option value="">...</option>
            <option value="all">SEMUA NYA</option>
            <?php
            $q = mysqli_query($koneksi, "select *,barang_gudang.id as idd from barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang,barang_gudang_detail,barang_teknisi,barang_teknisi_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=" . $_GET['id'] . " group by nama_brg order by barang_dikirim.no_po_jual ASC");
            $jsArray = "var dtBrg = new Array();
            ";
            while ($d = mysqli_fetch_array($q)) { ?>
              <option value="<?php echo $d['idd']; ?>"><?php echo $d['nama_brg'] . " / " . $d['tipe_brg']; ?></option>
            <?php
              $jsArray .= "dtBrg['" . $d['idd'] . "'] = {tgl_kirim:'" . addslashes($d['tgl_kirim']) . "',
						nama_pembeli:'" . addslashes($d['nama_pembeli']) . "',
						nama_paket:'" . addslashes($d['nama_paket']) . "'
						};";
            } ?>
          </select>
          <br><br>
          <label>Teknisi</label>
          <select name="id_teknisi" id="id_teknisi" class="form-control select2" required style="width:100%">
            <option value="">...</option>
            <?php
            $q_seri = mysqli_query($koneksi, "select * from tb_teknisi order by nama_teknisi ASC");
            while ($d_seri = mysqli_fetch_array($q_seri)) {
            ?>
              <option value="<?php echo $d_seri['id']; ?>">
                <?php echo $d_seri['nama_teknisi'] . " / Bidang : " . $d_seri['bidang']; ?></option>
            <?php } ?>
          </select>
          <br><br>
          <label>Estimasi</label>
          <input type="date" name="estimasi" id="" class="form-control" required="required" />
          <br>
          <label>Tanggal Berangkat</label>
          <input type="date" name="tgl_berangkat" id="" class="form-control" />
          <br>
          <label>Deskripsi</label>
          <input type="text" class="form-control" name="deskripsi" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="simpan_tambah_aksesoris">Simpan</button>
        </div>
      </form>
      <script type="text/javascript">
        <?php
        echo $jsArray;
        ?>

        function changeValue(id_akse) {
          document.getElementById('tgl_kirim').value = dtBrg[id_akse].tgl_kirim;
          document.getElementById('rs').value = dtBrg[id_akse].nama_pembeli;
          document.getElementById('nama_paket').value = dtBrg[id_akse].nama_paket;
        };
      </script>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ubah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ubah Data</h4>
      </div>
      <form id="formUbah" onsubmit="simpanUbah(); return false">
        <div class="modal-body">
          <div id="data-ubah"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button class="btn btn-success" name="simpan_teknisi" type="submit">Simpan Perubahan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function getData() {
    $.get("data/data-pilih-teknisi.php", {
        id: <?php echo $_GET['id'] ?>
      },
      function(data) {
        $('#table-teknisi').html(data);
      }
    );
  }

  function modalUbah(id) {
    $.get("data/data-ubah-pilih-teknisi.php", {
      id:id
    },
      function (data) {
        $('#data-ubah').html(data);
        $('#modal-ubah').modal('show')
      }
    );
  }

  function simpanTambah() {
    var dataform = $('#formTambah')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "POST",
      url: "data/simpan-pilih-teknisi.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      cache: false,
      success: function(response) {
        if (response == 'S') {
          $('#modal-tambah').modal('hide');
          alertSimpan('S');
          getData();
          dataform.reset();
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  function simpanUbah() {
    var dataform = $('#formUbah')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "POST",
      url: "data/ubah-pilih-teknisi.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      cache: false,
      success: function(response) {
        if (response == 'S') {
          $('#modal-ubah').modal('hide');
          alertSimpan('S');
          getData();
          dataform.reset();
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  function hapus(id, id_hapus) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Akan Menghapus Data Ini ?',
      text: 'Data Akan Dihapus Secara Permanen',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        $.post("data/hapus-pilih-teknisi.php", {
            id_hapus: id_hapus,
            id: id
          },
          function(data) {
            if (data == 'S') {
              alertHapus('S');
              getData();
            } else if (data == 'TB') {
              alertCustom('F', 'Data Tidak Dapat Dihapus !', 'Sudah Dilakukan Instalasi & Uji Fungsi');
              getData();
            } else {
              alertHapus('F')
            }
          }
        );
      }
    })
  }

  function pulihkan(id) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Akan Memulihkan Data PO Ini ?',
      text: 'Data Akan Di Buka Kembali',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Pulihkan',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '?page=' + getVars("page").replace('#', '') + '&id_pulih=' + id;
      }
    })
  }

  $(document).ready(function() {
    getData();
  });
</script>