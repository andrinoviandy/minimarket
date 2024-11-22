<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Monitoring Penjualan
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Monitoring Penjualan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <?php
        if (isset($_SESSION['user_administrator']) || isset($_SESSION['user_admin_keuangan']) || isset($_SESSION['user_manajer_keuangan'])) {
        ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Grafik Penjualan Alkes</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-sm btn-primary" onclick="modalFilterPenjualan(); return false"><i class="fa fa-cog"></i> Filter</button>
                            </div>
                        </div>
                        <div class="box-header no-padding">
                            <div class="row">
                                <center>
                                    <div id="dataFilter"></div>
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
                            <h3 class="box-title">Tabel Penjualan Alkes</h3>

                            <div class="box-tools pull-right">
                                <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button> -->
                                <!-- <button class="btn btn-sm btn-primary" onclick="modalFilterPembelian()"><i class="fa fa-cog"></i> Filter</button> -->
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="">
                                <div class="row">
                                    <center>
                                        <div id="dataFilter2"></div>
                                    </center>
                                </div>
                                <div id="tabelTransaksi"></div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- /.row -->
        <!-- Main row -->
        <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
</div>
<div class="modal fade" id="modal-filter-penjualan">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class=""></i> Filter Grafik Penjualan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="formJual" enctype="multipart/form-data" onsubmit="areaChart(); setFilter(); setTableTransaksi(); return false;">
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

    function filterCetak(param) {
        if (param == '1') {
            $.get("data/modal-dinas-rs.php",
                function(data) {
                    $('#filterData').html(data);
                }
            );
        } else if (param == '2') {
            $.get("data/modal-provinsi-kabupaten-kecamatan.php",
                function(data) {
                    $('#filterData').html(data);
                }
            );
        }
    }

    async function modalFilterPenjualan() {
        $('#modal-filter-penjualan').modal('show')
        loading2('#data-modal-jual')
        await $.get("data/modal-monitoring-penjualan.php",
            function(data) {
                $('#data-modal-jual').html(data);
            }
        );
    }

    function loadingLine() {
        // $.get("include/getLoading.php", function(data) {
        //     $('#areaChart').html(data);
        // });
        $('#areaChart').html('<center><div class="overlay"><h1><i class="fa fa-refresh fa-spin"></i></h1></div></center>');
    }

    function loadingTable() {
        // $.get("include/getLoading.php", function(data) {
        //     $('#tabelTransaksi').html(data);
        // });
        $('#tabelTransaksi').html('<center><div class="overlay"><h1><i class="fa fa-refresh fa-spin"></i></h1></div></center>');
    }

    async function setTableTransaksi() {
        loadingTable();
        let alkes = $('#alkes').val();
        let filter = $('#filterRekap').val();
        let pembeli = $('#pembeli').val();
        let prov = $('#provinsi1').val();
        let kab = $('#kabupaten1').val();
        let kec = $('#kecamatan1').val();
        let thn = $('#tahun_now1').val();
        await $.get("data/table-transaksi.php", {
                alkes: alkes ? alkes : 'all',
                filter: filter ? filter : '',
                pembeli: pembeli ? pembeli : 'all',
                provinsi: prov ? prov : 'all',
                kabupaten: kab ? kab : 'all',
                kecamatan: kec ? kec : 'all',
                tahun: thn ? thn : new Date().getFullYear(),
            },
            function(data) {
                $('#tabelTransaksi').html(data);
            }
        );
    }

    async function setFilter() {
        await $.get("data/filter-monitoring.php", {
                alkes: $('#alkes').val(),
                pembeli: $('#pembeli').val(),
                provinsi: $('#provinsi1').val(),
                kabupaten: $('#kabupaten1').val(),
                kecamatan: $('#kecamatan1').val(),
                tahun: $('#tahun_now1').val(),
            },
            function(data) {
                $('#dataFilter').html(data);
                $('#dataFilter2').html(data);
            }
        );
    }

    async function areaChart() {
        loadingLine();
        // memanggil nama provinsi
        let alkes = $('#alkes').val();
        let filter = $('#filterRekap').val();
        let pembeli = $('#pembeli').val();
        let prov = $('#provinsi1').val();
        let kab = $('#kabupaten1').val();
        let kec = $('#kecamatan1').val();
        let thn = $('#tahun_now1').val();

        //--------------
        //- AREA CHART -
        //--------------
        let dataa;
        // Get context with jQuery - using jQuery's .get() method.
        // await $.get("http://localhost/ALKES_2/json/monitoring_penjualan.php", {
        await $.get("http://173.212.225.28/ALKES_2/json/monitoring_penjualan.php", {
                alkes: alkes ? alkes : 'all',
                filter: filter ? filter : '',
                pembeli: pembeli ? pembeli : 'all',
                provinsi: prov ? prov : 'all',
                kabupaten: kab ? kab : 'all',
                kecamatan: kec ? kec : 'all',
                tahun: thn ? thn : new Date().getFullYear(),
            },
            function(data) {
                // alert(data);
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
            responsive: false,
            tooltipEvents: [],
        }
        //Create the line chart
        areaChartOptions.datasetFill = true
        areaChart.Line(areaChartData, areaChartOptions)

        $('#modal-filter-penjualan').modal('hide')

    }



    $(document).ready(function() {
        areaChart();
        setTableTransaksi();
    });
</script>