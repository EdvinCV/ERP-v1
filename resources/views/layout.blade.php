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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script>
var a = 0;
function myFunction() {
    a = a + 1;
    document.getElementById("demo").textContent = a;
    return a;
}
</script>
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
              
                    <span class="b-title">INCOFIN</span>
                </a>
            </div>
            <a class="mobile-menu" id="mobile-header" href="#!">
                <i class="feather icon-more-horizontal"></i>
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li><a href="#!" class="full-screen" onclick="javascript:toggleFullScreen()"><i
                                class="feather icon-maximize"></i></a></li>
             
           
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li>
                    <img src="assets/images/user/avatar-1.jpg" class="img-radius"
                                        alt="User-Profile-Image" width="35" height="35">
                    <span style="color:#000">{{ auth()->user()->name }}</span>
                  
               
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
                                    @php
                                        $c = 0;
                                        $val = "<script>document.writeln(a);</script>";
                                        echo $val;
                                    @endphp
                                    @foreach($permisos as $p)
                                        @if($p->nombrePermiso == "Caja" && $p->estado)
                                            @php
                                                $c = 1;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @if($c>0 && $val == 0 )
                                    <a href=""
                                            class="dud-logout" title="Cerrar Sesión" 
                                            class="dropdown-item" data-toggle="modal" data-target="#myModal2">
                                            <i class="feather icon-log-out"></i>
                                        <form  style="display: none;">
                                        </form>
                                    </a>
                                    @else
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dud-logout" title="Cerrar Sesión">
                                        <i class="feather icon-log-out"></i>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    </a>
                                    
                                    @endif
                                    
                                </div>
                
                                <ul class="pro-body">
                                <li><a href="#!" class="dropdown-item" data-toggle="modal" data-target="#myModal"><i class="feather icon-user"></i> Perfil</a></li>
                                    
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
                   
                        <div class="page-header-title">
                                            <h3 class="m-b-10" style="color:#668C2D"><a ><i class="feather icon-home"></i></a> Menú</h3>
                                        </div>
                        <v-app style="background: white">
                  
                      <!--  <div id="chartdiv" style="width: 100%; height: 500px;"></div> -->
                        @yield('content')

                        </v-app>


<!--ingresar modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                 <h2>¿Desea cerrar caja?</h2>
            </div>
           
            <div class="modal-footer">
                <button type="button" class="btn btn-default" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dud-logout" >

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                No</button>
                <button type="submit" @onclick="myFunction()" @click="menu=22" class="btn btn-primary save" data-dismiss="modal" style="background-color:#668C2D" >Si</button>
            </div>            

        </div>
                        
                       
    </div>
</div>
<!--terminar modal-->
<!--ingresar modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form method="POST"  class="form-horizontal" enctype="multipart/form-data">
    @csrf
                                    @method('PUT')
            <div class="modal-header">
          <img src="assets/images/user/avatar-1.jpg" class="img-radius"
                                        alt="User-Profile-Image" width="100" height="100">
                                     <h2>{{ auth()->user()->name }}</h2>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>

                </button>
                
            </div>
            <div class="modal-body">
                <div role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#uploadTab" aria-controls="uploadTab" role="tab" data-toggle="tab" style="color:#668C2D">Perfil</a>

                        </li>
                        <li role="presentation"><a href="#browseTab" aria-controls="browseTab" role="tab" data-toggle="tab" style="color:#668C2D">Contraseña</a>

                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="uploadTab">
                        <div class="form-group">
    <label for="exampleInputEmail1">Nombre</label>
    <input type="text" id="name" class="form-control" placeholder="Enter your name" name="name" value="{{ Auth::user()->name }}">
  </div>
                        
  <div class="form-group">
    <label for="exampleInputEmail1">Correo electronico</label>
    <input type="text" id="email_address_2" class="form-control" placeholder="Enter your email address" name="email" value="{{ Auth::user()->email }}">
    
  </div>
  <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary save" style="background-color:#668C2D" >Guardar Cambios</button>
            </div>
            </form>
                        
                        </div>
                        
                        <div role="tabpanel" class="tab-pane" id="browseTab">
                        <form method="POST"  class="form-horizontal">
                        @csrf
                                    @method('PUT')
                        <div class="form-group">
    <label for="exampleInputEmail1">Contraseña actual</label>
    <input type="password" id="old_password" class="form-control" placeholder="Enter your old password" name="old_password">
    
  </div>     

  <div class="form-group">
    <label for="password">Contraseña Nueva</label>
    <input type="password" id="password" class="form-control" placeholder="Enter your new password" name="password" >
    
  </div>     

  <div class="form-group">
    <label for="confirm_password">Confirmar Contraseña</label>
    <input type="password" id="confirm_password" class="form-control" placeholder="Enter your new password again" name="password_confirmation" style="color:#668C2D">
    
  </div>         
      
  <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary save"  style="background-color:#668C2D">Guardar Cambios</button>
            </div>      
          
                        
                        </form>
                        </div>
                    </div>
                </div>
            </div>
       
           
        </div>
    </div>
</div>
<!--terminar modal-->
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

    <script src="http://www.amcharts.com/lib/3/amcharts.js"></script>
  <script src="http://www.amcharts.com/lib/3/serial.js"></script>
  <script src="http://www.amcharts.com/lib/3/plugins/dataloader/dataloader.min.js"></script>
    <script>
    
  var chart = AmCharts.makeChart( "chartdiv", {
    "type": "serial",
    "dataLoader": {
      "url": "data.php"
    },
    "pathToImages": "http://www.amcharts.com/lib/images/",
    "categoryField": "created_at",
    "dataDateFormat": "YYYY-MM-DD",
    "startDuration": 1,
    "categoryAxis": {
      "parseDates": true
    },
    "graphs": [ {
      "valueField": "total",
      "bullet": "round",
      "bulletBorderColor": "#FFFFFF",
      "bulletBorderThickness": 2,
      "lineThickness ": 2,
      "lineAlpha": 0.5
    }]
  } );
    
  </script>
   
    
</body>

</html>