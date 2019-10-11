<!DOCTYPE html>
<html lang="es">

<head>
    <title>ADAM - INCOFIN</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="Codedthemes" />
    
    <!-- <link rel="stylesheet" href="css/app.css"> -->
    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="assets/fonts/fontawesome/css/fontawesome-all.min.css">
    <!-- animation css -->
    <link rel="stylesheet" href="assets/plugins/animation/css/animate.min.css">
    <!-- data tables css -->
    <link rel="stylesheet" href="assets/plugins/data-tables/css/datatables.min.css">
    <!-- vandor css -->
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
    

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div id="app">
        <!-- [ Pre-loader ] start -->
        <div class="loader-bg">
            <div class="loader-track">
                <div class="loader-fill"></div>
            </div>
        </div>
        <!-- [ Pre-loader ] End -->

        @include('aside')
        <!-- [ navigation menu ] start -->

        <!-- [ Header ] start -->
        <header class="navbar pcoded-header navbar-expand-lg navbar-light">
            <div class="m-header">
                <a class="mobile-menu" id="mobile-collapse1" href="#!"><span></span></a>
                <a href="index.html" class="b-brand">
                    <div class="b-bg">
                        <i class="feather icon-trending-up"></i>
                    </div>
                    <span class="b-title">ADAM</span>
                </a>
            </div>
            <a class="mobile-menu" id="mobile-header" href="#!">
                <i class="feather icon-more-horizontal"></i>
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li><a href="#!" class="full-screen" onclick="javascript:toggleFullScreen()"><i
                                class="feather icon-maximize"></i></a></li>
             
                    <li class="nav-item">
                        <div class="main-search">
                            <div class="input-group">
                                <input type="text" id="m-search" class="form-control" placeholder="Search . . .">
                                <a href="#!" class="input-group-append search-close">
                                    <i class="feather icon-x input-group-text"></i>
                                </a>
                                <span class="input-group-append search-btn btn btn-primary">
                                    <i class="feather icon-search input-group-text"></i>
                                </span>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li>
                    <img src="assets/images/user/avatar-1.jpg" class="img-radius"
                                        alt="User-Profile-Image" width="35" height="35">
                    <span>{{ auth()->user()->name }}</span>
                  
               
                    </li>
                    <li>
                        <div class="dropdown drp-user">
                            <a href="#menusuers" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="icon feather icon-settings"></i>
                            </a>
                            <div id="menusuers" class="dropdown-menu dropdown-menu-right profile-notification">
                                <div class="pro-head">
                                    <img src="assets/images/user/avatar-1.jpg" class="img-radius"
                                        alt="User-Profile-Image">
                                    <span>{{ auth()->user()->name }}</span>
                                    <a href="{{ route('logout') }} "
                                    
                                       onclick="event.preventDefault(); 
                                                     document.getElementById('logout-form').submit();" class="dud-logout" title="Cerrar Sesión">
                                        <i class="feather icon-log-out"></i>
                                       
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    
                                        @csrf
                                    </form>
                                    </a>
                                </div>
                                <ul class="pro-body">
                                    <li><a href="#!" class="dropdown-item"><i class="feather icon-user"></i> Perfil</a></li>
                                    <li><a href="#!" class="dropdown-item"><i class="feather icon-settings"></i>Configuraciones</a></li>
                                    
                                    
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </header>
        <!-- [ Header ] end -->

        <!-- [ chat user list ] start -->
        <section class="header-user-list">
            <div class="h-list-header">
                <div class="input-group">
                    <input type="text" id="search-friends" class="form-control" placeholder="Search Friend . . .">
                </div>
            </div>
            <div class="h-list-body">
                <a href="#!" class="h-close-text"><i class="feather icon-chevrons-right"></i></a>
                <div class="main-friend-cont scroll-div">
                    <div class="main-friend-list">
                        
                    </div>
                </div>
            </div>
        </section>
        <!-- [ chat user list ] end -->

        <!-- [ chat message ] start -->
        <section class="header-chat">
            <div class="h-list-header">
                <h6>Josephin Doe</h6>
                <a href="#!" class="h-back-user-list"><i class="feather icon-chevron-left"></i></a>
            </div>
            <div class="h-list-body">
                <div class="main-chat-cont scroll-div">
                    <div class="main-friend-chat">
                        <div class="media chat-messages">
                            <a class="media-left photo-table" href="#!"><img
                                    class="media-object img-radius img-radius m-t-5"
                                    src="assets/images/user/avatar-2.jpg" alt="Generic placeholder image"></a>
                            <div class="media-body chat-menu-content">
                                <div class="">
                                    <p class="chat-cont">hello Datta! Will you tell me something</p>
                                    <p class="chat-cont">about yourself?</p>
                                </div>
                                <p class="chat-time">8:20 a.m.</p>
                            </div>
                        </div>
                        <div class="media chat-messages">
                            <div class="media-body chat-menu-reply">
                                <div class="">
                                    <p class="chat-cont">Ohh! very nice</p>
                                </div>
                                <p class="chat-time">8:22 a.m.</p>
                            </div>
                        </div>
                        <div class="media chat-messages">
                            <a class="media-left photo-table" href="#!"><img
                                    class="media-object img-radius img-radius m-t-5"
                                    src="assets/images/user/avatar-2.jpg" alt="Generic placeholder image"></a>
                            <div class="media-body chat-menu-content">
                                <div class="">
                                    <p class="chat-cont">can you help me?</p>
                                </div>
                                <p class="chat-time">8:20 a.m.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-list-footer">
                <div class="input-group">
                    <input type="file" class="chat-attach" style="display:none">
                    <a href="#!" class="input-group-prepend btn btn-success btn-attach">
                        <i class="feather icon-paperclip"></i>
                    </a>
                    <input type="text" name="h-chat-text" class="form-control h-send-chat"
                        placeholder="Write hear . . ">
                    <button type="submit" class="input-group-append btn-send btn btn-primary">
                        <i class="feather icon-message-circle"></i>
                    </button>
                </div>
            </div>
        </section>
        <section class="pcoded-main-container">
            <div class="pcoded-wrapper">
                <div class="pcoded-content">
                    <div class="pcoded-inner-content">
                        <!-- [ breadcrumb ] start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <div class="page-header-title">
                                            <h3 class="m-b-10" style="color:#668C2D"><a ><i class="feather icon-home"></i></a> Menú</h3>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <v-app>
                        
                        @yield('content')
                      
                        </v-app>
                        
                    </div>
                </div>
            </div>
        </section>
    </div>
     <!-- datatable Js -->
    <script src="js/app.js"></script>
    <script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
    <!-- chartjs js -->
    <script src="assets/plugins/chart-chartjs/js/Chart.min.js"></script>
    <script src="assets/js/pages/chart-chart-custom.js"></script>

   
    <script>
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";

am4core.useTheme(am4themes_animated);


export default {
  name: 'HelloWorld',
  mounted() {
    let chart = am4core.create(this.$refs.chartdiv, am4charts.XYChart);

    chart.paddingRight = 20;

    let data = [];
    let visits = 10;
    for (let i = 1; i < 366; i++) {
      visits += Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);
      data.push({ date: new Date(2018, 0, i), name: "name" + i, value: visits });
    }

    chart.data = data;

    let dateAxis = chart.xAxes.push(new am4charts.DateAxis());
    dateAxis.renderer.grid.template.location = 0;

    let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.tooltip.disabled = true;
    valueAxis.renderer.minWidth = 35;

    let series = chart.series.push(new am4charts.LineSeries());
    series.dataFields.dateX = "date";
    series.dataFields.valueY = "value";

    series.tooltipText = "{valueY.value}";
    chart.cursor = new am4charts.XYCursor();

    let scrollbarX = new am4charts.XYChartScrollbar();
    scrollbarX.series.push(series);
    chart.scrollbarX = scrollbarX;

    this.chart = chart;
  },

  beforeDestroy() {
    if (this.chart) {
      this.chart.dispose();
    }
  }
}
</script>

    
</body>

</html>