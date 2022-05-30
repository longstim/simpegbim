@extends('layouts.dashboard')
@section('page_heading','Dashboard')
@section('content')
  <!-- Main content -->
   <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-primary">
          <div class="inner">
            <h3>{{$data['jlhpegawai']}}</h3>

            <p>Jumlah Pegawai</p>
          </div>
          <div class="icon">
            <i class="ion ion-person"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{$data['jlhpns']}}</h3>

            <p>PNS</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{$data['jlhcpns']}}</h3>

            <p>CPNS</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{$data['jlhppnpn']}}</h3>

            <p>PPNPN</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
        <!-- ./col -->
      </div>

      <div class="row">
          <!-- GOLONGAN RUANG CHART -->
          <div class = "col-md-6">
            <div class="card card-light">
              <div class="card-header">
                <h3 class="card-title"><b>Golongan Ruang</b></h3>    
                <div class="card-tools">
                  <a href="{{ url('/lappangkatgol') }}" class="btn btn-tool" role="button"><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="Detail"></i></a>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

          <!-- JENIS KELAMIN CHART -->
          <div class = "col-md-6">

            <div class="card card-light">
              <div class="card-header">
                <h3 class="card-title"><b>Jenis Kelamin</b></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
      </div>

      <div class="row">

        <!-- JABATAN-->
          <div class = "col-md-6">

            <div class="card card-light">
              <div class="card-header">
                <h3 class="card-title"><b>Jabatan</b></h3>

                <div class="card-tools">
                  <a href="{{ url('/lapjabatanfungsional') }}" class="btn btn-tool" role="button"><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="Detail"></i></a>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <!-- PENDIDIKAN -->
          <div class = "col-md-6">
            <div class="card card-light">
              <div class="card-header">
                <h3 class="card-title"><b>Pendidikan</b></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="pendidikanChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

      </div>

<!-- ChartJS -->
<script src="{{asset('assets/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
  $( document ).ready(function () {
 
    //-------------
    //- JENIS KELAMIN CHART -
    //-------------

    var dataJK        = {
      labels: [
          'Laki-laki', 'Perempuan',
      ],
      datasets: [
        {
          data: [{{$datajk['lk']}},{{$datajk['pr']}}],
          backgroundColor : ['#f56954',  '#00a65a'],
        }
      ]
    }

    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = dataJK;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })


    //-------------
    //- GOLONGAN RUANG CHART -
    //-------------

    var areaChartData = {
    labels  : ['Gol. I', 'Gol. II', 'Gol. III', 'Gol. IV'],
    datasets: [
        {
          label               : 'Golongan',
          backgroundColor     : '#dc3545',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [{{$datagol['gol1']}},{{$datagol['gol2']}},{{$datagol['gol3']}},{{$datagol['gol4']}}]
        }
      ]
    }

    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp1 = areaChartData.datasets[0]
    barChartData.datasets[0] = temp1

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

    //-------------
    //- JABATAN CHART -
    //-------------

    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: ['Struktural', 'Fungsional', 'Pelaksana',
      ],
      datasets: [
        {
          data: [{{$datajabatan['struktural']}}, {{$datajabatan['fungsional']}}, {{$datajabatan['pelaksana']}}],
          backgroundColor : ['#007bff', '#20c997', '#17a2b8'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })


    //-------------
    //- PENDIDIKAN CHART -
    //-------------

    var areaChartData = {
    labels  : ['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'],
    datasets: [
        {
          label               : 'Pendidikan',
          backgroundColor     : '#007bff',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [{{$datapendidikan['sd']}}, {{$datapendidikan['smp']}}, {{$datapendidikan['sma']}}, {{$datapendidikan['d1']}}, {{$datapendidikan['d2']}}, {{$datapendidikan['d3']}}, {{$datapendidikan['s1']}}, {{$datapendidikan['s2']}}, {{$datapendidikan['s3']}}]
        }
      ]
    }

    var barChartCanvas = $('#pendidikanChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp1 = areaChartData.datasets[0]
    barChartData.datasets[0] = temp1

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

    
  })
</script>
@endsection
