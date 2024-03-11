<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Beranda

    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Beranda</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <?php
    if (isset($_SESSION['user_administrator'])) {
    ?>
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php
                  $data1 = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_gudang"));
                  $data1_1 = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_gudang_detail"));
                  if ($data1['jml'] == 0) {
                    echo "0";
                  } else {
                    echo $data1['jml'] . "/<font style='font-size:16px'>" . $data1_1['jml'] . "</font>";
                  }
                  ?></h3>

              <p>Jenis Alkes / Jumlah Alkes</p>
            </div>
            <div class="icon">
              <i class="fa fa-cubes"></i>
            </div>
            <a href="index.php?page=barang_masuk" class="small-box-footer">Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php
                  $data2 = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_dikirim_detail"));
                  if ($data2['jml'] == 0) {
                    echo "0";
                  } else {
                    echo $data2['jml'];
                  }
                  ?></h3>

              <p>Penjualan Alkes</p>
            </div>
            <div class="icon">
              <i class="fa fa-sign-out"></i>
            </div>
            <a href="index.php?page=jual_barang" class="small-box-footer">Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3><?php
                  $data5 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty) as totall from barang_pesan_detail,barang_pesan where barang_pesan.id=barang_pesan_detail.barang_pesan_id and jenis_po='Dalam Negeri'"));
                  if ($data5['totall'] == 0) {
                    echo "0";
                  } else {
                    echo $data5['totall'];
                  }
                  ?></h3>

              <p>Pembelian Alkes Dalam Negeri</p>
            </div>
            <div class="icon">
              <i class="fa fa-sign-in"></i>
            </div>
            <a href="index.php?page=pembelian_alkes" class="small-box-footer">Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php
                  $data6 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty) as totall from barang_pesan_detail,barang_pesan where barang_pesan.id=barang_pesan_detail.barang_pesan_id and jenis_po='Luar Negeri'"));
                  if ($data6['totall'] == 0) {
                    echo "0";
                  } else {
                    echo $data6['totall'];
                  }
                  ?></h3>
              <p>Pembelian Alkes Luar Negeri</p>
            </div>
            <div class="icon">
              <i class="fa fa-sign-in"></i>
            </div>
            <a href="index.php?page=pembelian_alkes2" class="small-box-footer">Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Transaksi Penjualan</h3>
              <div class="box-tools pull-right">
                <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button> -->
                <button class="btn btn-sm btn-primary" onclick="modalFilterPenjualan()"><i class="fa fa-cog"></i> Filter</button>
              </div>
            </div>
            <div class="box-header no-padding">
              <div class="row">
                <center>
                  <span id="label-penjualan">Semua Data</span>
                  <span id="lbl-provinsi"></span>
                  <span id="lbl-kabupaten"></span>
                  <span id="lbl-kecamatan"></span>
                  <span id="lbl-tahun"></span>
                </center>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="areaChart" style="height:250px;"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Transaksi Pembelian</h3>

              <div class="box-tools pull-right">
                <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button> -->
                <button class="btn btn-sm btn-primary" onclick="modalFilterPembelian()"><i class="fa fa-cog"></i> Filter</button>
              </div>
            </div>
            <div class="box-header no-padding">
              <center>
                <div id="label-pembelian"><?php echo date('Y'); ?></div>
              </center>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="barChart" style="height:250px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php
                  $data3 = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_gudang_detail_rusak"));
                  echo $data3['jml'];
                  ?></h3>
              <p>Alkes Rusak Belum Terjual</p>
            </div>
            <div class="icon">
              <i class="fa fa-remove"></i>
            </div>
            <a href="index.php?page=barang_rusak" class="small-box-footer">Info<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php
                  $data4 = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(DISTINCT nama_pembeli) as jml from pembeli"));
                  echo $data4['jml'];
                  ?></h3>

              <p>Jumlah Customer</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="index.php?page=akun_user" class="small-box-footer">Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-light-blue">
            <div class="inner">
              <h3><?php
                  $data7 = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_kembali_detail"));
                  echo $data7['jml'];
                  ?></h3>

              <p>Alkes Rusak Sudah Terjual</p>
            </div>
            <div class="icon">
              <i class="fa fa-remove"></i>
            </div>
            <a href="index.php?page=barang_kembali_teknisi" class="small-box-footer">Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-gray">
            <div class="inner">
              <h3><?php
                  echo "-"; //$data8 = mysqli_num_rows(mysqli_query($koneksi, "select * from pembeli group by nama_pembeli"));
                  //echo $data8;
                  ?></h3>
              <p>Pengembalian Alkes</p>
            </div>
            <div class="icon">
              <i class="fa fa-download"></i>
            </div>
            <a href="#" class="small-box-footer">Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
    <?php } ?>
    <?php if (!isset($_SESSION['user_administrator'])) { ?>
      <div class="row">
        <div class="col-lg-3 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php
                  $data3 = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_gudang_detail_rusak"));
                  echo $data3['jml'];
                  ?></h3>
              <p>Alkes Rusak Belum Terjual</p>
            </div>
            <div class="icon">
              <i class="fa fa-remove"></i>
            </div>
            <a href="index.php?page=barang_rusak" class="small-box-footer">Info<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php
                  $data4 = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(DISTINCT nama_pembeli) as jml from pembeli"));
                  echo $data4['jml'];
                  ?></h3>

              <p>Jumlah Customer</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="index.php?page=akun_user" class="small-box-footer">Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-light-blue">
            <div class="inner">
              <h3><?php
                  $data7 = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_kembali_detail"));
                  echo $data7['jml'];
                  ?></h3>

              <p>Alkes Rusak Sudah Terjual</p>
            </div>
            <div class="icon">
              <i class="fa fa-remove"></i>
            </div>
            <a href="index.php?page=barang_kembali_teknisi" class="small-box-footer">Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-gray">
            <div class="inner">
              <h3><?php
                  echo "-"; //$data8 = mysqli_num_rows(mysqli_query($koneksi, "select * from pembeli group by nama_pembeli"));
                  //echo $data8;
                  ?></h3>
              <p>Pengembalian Alkes</p>
            </div>
            <div class="icon">
              <i class="fa fa-download"></i>
            </div>
            <a href="#" class="small-box-footer">Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Transaksi Penjualan</h3>
              <div class="box-tools pull-right">
                <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button> -->
                <button class="btn btn-sm btn-primary" onclick="modalFilterPenjualan()"><i class="fa fa-cog"></i> Filter</button>
              </div>
            </div>
            <div class="box-header no-padding">
              <div class="row">
                <center>
                  <span id="label-penjualan">Semua Data</span>
                  <span id="lbl-provinsi"></span>
                  <span id="lbl-kabupaten"></span>
                  <span id="lbl-kecamatan"></span>
                  <span id="lbl-tahun"></span>
                </center>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="areaChart" style="height:250px;"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Transaksi Pembelian</h3>

              <div class="box-tools pull-right">
                <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button> -->
                <button class="btn btn-sm btn-primary" onclick="modalFilterPembelian()"><i class="fa fa-cog"></i> Filter</button>
              </div>
            </div>
            <div class="box-header no-padding">
              <center>
                <div id="label-pembelian"><?php echo date('Y'); ?></div>
              </center>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="barChart" style="height:250px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
    <?php
    }
    ?>
    <!-- /.row -->
    <!-- Main row -->
    <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>
<div class="modal fade" id="modal-beranda" data-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content" style="background-image: url(img/beranda.png); background-position: center; background-repeat: no-repeat; background-size: contain; ">
      <div class="modal-header">
        <h4 class="modal-title"><i class=""></i> </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <h2 align="center">Selamat Datang<br>Sistem Informasi Manajemen Alat Kesehatan<br>PT Cipta Varia Kharisma Utama</h2>
        <br>
        <h4 align="justify">
          <center>
            Saat ini Anda login mengunakan Akun :
            <table style="width: 50%; margin-top: 20px; margin-bottom: 20px">
              <tr>
                <td style="padding: 5px;">Nama</td>
                <td style="padding: 5px;">:</td>
                <td style="padding: 5px;"><?php echo $_SESSION['nama'] ?></td>
              </tr>
              <tr>
                <td style="padding: 5px;">Username</td>
                <td style="padding: 5px;">:</td>
                <td style="padding: 5px;"><?php echo $_SESSION['user'] ?></td>
              </tr>
              <tr>
                <td style="padding: 5px;">Password</td>
                <td style="padding: 5px;">:</td>
                <td style="padding: 5px;">(Encrypted)</td>
              </tr>
              <tr>
                <td style="padding: 5px;">Waktu Login</td>
                <td style="padding: 5px;">:</td>
                <td style="padding: 5px;"><?php echo $_SESSION['waktu_login'] ?></td>
              </tr>
            </table>
          </center>
          <center>
            Terima kasih atas perhatiannya.
          </center>
        </h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-filter-penjualan">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class=""></i> Filter Grafik Penjualan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <form method="post" id="formJual" enctype="multipart/form-data" onsubmit="areaChart(); return false;">
        <div class="modal-body">
          <div id="data-modal-jual"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="sasdas" class="btn btn-primary pull-right" type="submit"><span class="fa fa-cog"></span> Filter</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-filter-pembelian">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class=""></i> Filter Grafik Pembelian</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <form method="post" id="formBeli" enctype="multipart/form-data" onsubmit="barChart(); return false;">
        <div class="modal-body">
          <div id="data-modal-beli"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="sasdas" class="btn btn-primary pull-right" type="submit"><span class="fa fa-cog"></span> Filter</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<script>
  function ucwords(str) {
    // Memisahkan string menjadi array kata
    let words = str.toLowerCase().split(' ');

    // Mengonversi huruf pertama setiap kata menjadi kapital
    for (let i = 0; i < words.length; i++) {
      words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
    }

    // Menggabungkan kembali array kata menjadi sebuah string
    return words.join(' ');
  }

  function modalFilterPenjualan() {
    $.get("data/modal-filter-penjualan.php",
      function(data) {
        $('#data-modal-jual').html(data);
      }
    );
    $('#modal-filter-penjualan').modal('show')
  }

  function modalFilterPembelian() {
    $.get("data/modal-filter-pembelian.php",
      function(data) {
        $('#data-modal-beli').html(data);
      }
    );
    $('#modal-filter-pembelian').modal('show')
  }

  function loadingLine() {
    $.get("include/getLoading.php", function(data) {
      $('#areaChart').html(data);
    });
  }

  function getParam(p, ka, ke, th) {
    if (id != 'all') {
      $.get("data/get-provinsi", {
          id: id
        },
        function(data) {
          prov = data
        }
      );
    }
  }

  function getProvinsi(id) {
    $.get("data/getProvinsi.php", {
        id: id
      },
      function(data) {
        $('#lbl-provinsi').html(ucwords(data));
      }
    );
  }

  function getKabupaten(id) {
    $.get("data/getKabupaten.php", {
        id: id
      },
      function(data) {
        $('#lbl-kabupaten').html(ucwords(data));
      }
    );
  }

  function getKecamatan(id) {
    $.get("data/getKecamatan.php", {
        id: id
      },
      function(data) {
        $('#lbl-kecamatan').html(ucwords(data));
      }
    );
  }

  async function areaChart() {
    loadingLine();
    // memanggil nama provinsi
    let prov = $('#provinsi1').val();
    let kab = $('#kabupaten1').val();
    let kec = $('#kecamatan1').val();
    let thn = $('#tahun_now1').val();
    if (prov && prov !== 'all') {
      $('#label-penjualan').html('');
      getProvinsi(prov);
    }
    if (kab && kab !== 'all') {
      getKabupaten(kab);
    }
    if (kec && kec != 'all') {
      getKecamatan(kec);
    }
    if (thn) {
      $('#lbl-tahun').html('Tahun ' + thn)
    } else {
      $('#lbl-tahun').html(new Date().getFullYear())
    }
    //--------------
    //- AREA CHART -
    //--------------
    let dataa;
    // Get context with jQuery - using jQuery's .get() method.
    await $.get("http://173.212.225.28/ALKES_2/json/beranda_penjualan.php", {
        // await $.get("http://localhost/ALKES_2/json/beranda_penjualan.php", {
        // tahun: tahun
        provinsi: $('#provinsi1').val() != undefined ? $('#provinsi1').val() : 'all',
        kabupaten: $('#kabupaten1').val(),
        kecamatan: $('#kecamatan1').val(),
        tahun: $('#tahun_now1').val() != undefined ? $('#tahun_now1').val() : new Date().getFullYear(),
      },
      function(data) {
        var dt = data.replace('[', '');
        var dt2 = dt.replace(']', '');
        dataa = dt2.split(',');
      }
    );
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart = new Chart(areaChartCanvas)

    var areaChartData = {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
      datasets: [{
        fillColor: 'rgba(60,141,188,0.9)',
        strokeColor: 'rgba(60,141,188,0.8)',
        pointColor: '#3b8bba',
        pointStrokeColor: 'rgba(60,141,188,1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        // data: [28, 48, 40, 19, 86, 27, 90, 40, 19, 86, 27, 90]
        data: dataa,
      }]
    }

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - Whether the line is curved between points
      // bezierCurve: true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension: 0.3,
      //Boolean - Whether to show a dot for each point
      // pointDot: true,
      //Number - Radius of each point dot in pixels
      pointDotRadius: 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth: 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius: 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke: true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth: 2,
      //String - A legend template
      legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: false
    }
    //Create the line chart
    areaChartOptions.datasetFill = true
    areaChart.Line(areaChartData, areaChartOptions)

    $('#modal-filter-penjualan').modal('hide')
  }

  function loadingBar() {
    $.get("include/getLoading.php", function(data) {
      $('#barChart').html(data);
    });
  }

  async function barChart() {
    loadingBar();
    $('#label-pembelian').html($('#tahun_now2').val());
    //-------------
    //- BAR CHART -
    //-------------
    let dataa;
    await $.get("http://173.212.225.28/ALKES_2/json/beranda_pembelian.php", {
        // await $.get("http://localhost/ALKES_2/json/beranda_pembelian.php", {
        // provinsi: $('#provinsi2').val(),
        // kabupaten: $('#kabupaten2').val(),
        // kecamatan: $('#kecamatan2').val(),
        tahun: $('#tahun_now2').val() != undefined ? $('#tahun_now2').val() : new Date().getFullYear(),
      },
      function(data) {
        var dt = data.replace('[', '');
        var dt2 = dt.replace(']', '');
        dataa = dt2.split(',');
      }
    );
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChart = new Chart(barChartCanvas)
    var barChartData = {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
      datasets: [{
        label: 'Digital Goods',
        fillColor: 'rgba(60,141,188,0.9)',
        strokeColor: 'rgba(60,141,188,0.8)',
        pointColor: '#3b8bba',
        pointStrokeColor: 'rgba(60,141,188,1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        // data: [28, 48, 40, 19, 86, 27, 90, 40, 19, 86, 27, 90]
        data: dataa
      }]
    }
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    }

    barChartOptions.datasetFill = true
    barChart.Bar(barChartData, barChartOptions)

    $('#modal-filter-pembelian').modal('hide')

  }

  $(document).ready(function() {
    // setInterval(() => {
    // areaChart($('#tahun_now1').val());
    // barChart($('#tahun_now2').val());
    areaChart();
    barChart();
    // }, 3500);
  });
</script>