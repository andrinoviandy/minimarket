<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Grafik In/Out Barang
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Grafik In/Out Barang</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-sm btn-primary" onclick="modalFilterPenjualan(); return false"><i class="fa fa-cog"></i> Filter</button>
                        </div>
                    </div>
                    <div class="box-header no-padding">
                        <div class="row">
                            <center>
                                <table align="center">
                                    <tr>
                                        <td style="padding: 10px" align="center" class="bg-info" colspan="3" width="300px"><strong>Filter</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="45%">Merk Barang</td>
                                        <td width="5%" align="center">:</td>
                                        <td>
                                            <div id="filterMerkBarang"></div>
                                            <input type="hidden" id="inputMerkBarang" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="45%">Tipe Barang</td>
                                        <td width="5%" align="center">:</td>
                                        <td>
                                            <div id="filterTipeBarang"></div>
                                            <input type="hidden" id="inputTipeBarang" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Tahun</td>
                                        <td align="center">:</td>
                                        <td>
                                            <div id="filterTahun"></div>
                                            <input type="hidden" id="inputTahun" />
                                        </td>
                                    </tr>
                                </table>
                                <br>
                            </center>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="areaChart" style="height:250px;"></canvas>
                        </div>
                        <hr>
                        <div id="tabelTransaksi"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
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
                <h4 class="modal-title"><i class=""></i> Filter Grafik</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="formJual" enctype="multipart/form-data" onsubmit="goFilter(); return false;">
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
        await $.get("data/modal-grafik-in-out.php", {
                merk: $('#inputMerkBarang').val(),
                tipe: $('#inputTipeBarang').val(),
                tahun: $('#inputTahun').val()
            },
            function(data) {
                $('#data-modal-jual').html(data);
            }
        );

        await $.get("data/getTipeBarang.php", {
                merk: $('#inputMerkBarang').val(),
                tipe: $('#inputTipeBarang').val(),
            },
            function(data) {
                $('#data_tipe_barang').html(data);
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
        let tipe = $('#tipe').val();
        // let filter = $('#filterRekap').val();
        // let pembeli = $('#pembeli').val();
        // let prov = $('#provinsi1').val();
        // let kab = $('#kabupaten1').val();
        // let kec = $('#kecamatan1').val();
        let thn = $('#tahun_now1').val();
        await $.get("data/table-grafik.php", {
                alkes: alkes ? alkes : 'all',
                tipe: tipe ? tipe : 'all',
                // filter: filter ? filter : '',
                // pembeli: pembeli ? pembeli : 'all',
                // provinsi: prov ? prov : 'all',
                // kabupaten: kab ? kab : 'all',
                // kecamatan: kec ? kec : 'all',
                tahun: thn ? thn : new Date().getFullYear(),
            },
            function(data) {
                $('#tabelTransaksi').html(data);
            }
        );
    }

    async function setFilter() {
        // await $.get("data/filter-grafik.php", {
        //         alkes: $('#alkes').val() ? $('#alkes').val() : 'All',
        //         tipe: $('#tipe').val() ? $('#tipe').val() : 'All',
        //         // pembeli: $('#pembeli').val(),
        //         // provinsi: $('#provinsi1').val(),
        //         // kabupaten: $('#kabupaten1').val(),
        //         // kecamatan: $('#kecamatan1').val(),
        //         tahun: $('#tahun_now1').val() ? $('#tahun_now1').val() : new Date().getFullYear(),
        //     },
        //     function(data) {
        //         $('#dataFilter').html(data);
        //         $('#dataFilter2').html(data);
        //     }
        // );
        let merk = $('#alkes').val() ? $('#alkes').val() : 'All'
        let tipe = $('#tipe').val() ? $('#tipe').val() : 'All'
        let tahun = $('#tahun_now1').val() ? $('#tahun_now1').val() : new Date().getFullYear()
        $('#filterMerkBarang').html(merk);
        $('#filterTipeBarang').html(tipe);
        $('#filterTahun').html(tahun);
        $('#inputMerkBarang').val(merk);
        $('#inputTipeBarang').val(tipe);
        $('#inputTahun').val(tahun);
    }

    async function areaChart() {
        loadingLine();
        // memanggil nama provinsi
        let alkes = $('#alkes').val();
        let tipe = $('#tipe').val();
        // let filter = $('#filterRekap').val();
        // let pembeli = $('#pembeli').val();
        // let prov = $('#provinsi1').val();
        // let kab = $('#kabupaten1').val();
        // let kec = $('#kecamatan1').val();
        let thn = $('#tahun_now1').val();

        //--------------
        //- AREA CHART -
        //--------------
        let data_in, data_out;
        // Get context with jQuery - using jQuery's .get() method.
        // await $.get("http://localhost/ALKES_2/json/monitoring_penjualan.php", {
        await $.get("http://173.212.225.28/ALKES_2/json/in_barang.php", {
                alkes: alkes ? alkes : 'all',
                tipe: tipe ? tipe : 'all',
                // filter: filter ? filter : '',
                // pembeli: pembeli ? pembeli : 'all',
                // provinsi: prov ? prov : 'all',
                // kabupaten: kab ? kab : 'all',
                // kecamatan: kec ? kec : 'all',
                tahun: thn ? thn : new Date().getFullYear(),
            },
            function(data) {
                // alert(data);
                var dt = data.replace('[', '');
                var dt2 = dt.replace(']', '');
                data_in = dt2.split(',');
            }
        );
        await $.get("http://173.212.225.28/ALKES_2/json/out_barang.php", {
                alkes: alkes ? alkes : 'all',
                tipe: tipe ? tipe : 'all',
                // filter: filter ? filter : '',
                // pembeli: pembeli ? pembeli : 'all',
                // provinsi: prov ? prov : 'all',
                // kabupaten: kab ? kab : 'all',
                // kecamatan: kec ? kec : 'all',
                tahun: thn ? thn : new Date().getFullYear(),
            },
            function(data) {
                // alert(data);
                var dt = data.replace('[', '');
                var dt2 = dt.replace(']', '');
                data_out = dt2.split(',');
            }
        );

        var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
        // This will get the first returned node in the jQuery collection.
        var areaChart = new Chart(areaChartCanvas)

        var areaChartData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                    label: 'Electronics',
                    fillColor: 'rgba(210, 214, 222, 1)',
                    strokeColor: 'rgba(210, 214, 222, 1)',
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    barPercentage: 0.5, // Atur lebar bar
                    // categoryPercentage: 0.6, // Atur lebar kategori
                    data: data_in
                },
                {
                    label: 'Digital Goods',
                    fillColor: 'rgba(60,141,188,0.9)',
                    strokeColor: 'rgba(60,141,188,0.8)',
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    barPercentage: 0.5, // Atur lebar bar
                    data: data_out
                }
            ]
        }

        // areaChartData.datasets[1].fillColor = '#00a65a'
        // areaChartData.datasets[1].strokeColor = '#00a65a'
        // areaChartData.datasets[1].pointColor = '#00a65a'

        var areaChartOptions = {
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
            barValueSpacing: 10,
            //Number - Spacing between data sets within X values
            barDatasetSpacing: 1,
            //String - A legend template
            legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
            //Boolean - whether to make the chart responsive
            responsive: true,
            scales: {
                x: {
                    stacked: false
                },
                y: {
                    beginAtZero: true
                }
            },
            maintainAspectRatio: true,
            tooltipEvents: [],
        }
        //Create the line chart
        areaChartOptions.datasetFill = true
        areaChart.Bar(areaChartData, areaChartOptions)

        $('#modal-filter-penjualan').modal('hide')

    }

    async function goFilter() {
        showLoading(1)
        await areaChart(); 
        await setFilter(); 
        await setTableTransaksi();
        showLoading(0)

    }

    $(document).ready(function() {
        areaChart();
        setTableTransaksi();
        setFilter()
    });
</script>