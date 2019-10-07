<nav class="pcoded-navbar icon-colored">
        <div class="navbar-wrapper">
            <div class="navbar-brand header-logo">
         
                <img src="assets/images/descarga.jpg" width="230" height="70">
        
            </div>
           
           <div > 
              
        
 
            <div class="navbar-content scroll-div">
                <ul class="nav pcoded-inner-navbar ">
              
                    <li class="nav-item pcoded-menu-caption">
                       <center> <h6>GESTION DE VENTAS</h6></center>
                       
                    </li><center><hr class="hrt"></center>
                   
                    @foreach($permisos as $p)
                    @if($p->nombrePermiso == "Usuarios" && $p->estado)
                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project"
                            class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                    class="feather icon-user feather-lg"></i></span><span class="pcoded-mtext">Usuarios</span></a>
                            <ul class="pcoded-submenu">
                            <li><a @click="menu=1" ><span class="pcoded-micon"><i
                                    class="feather icon-users"></i></span><span class="pcoded-mtext">Control usuarios</span></a></li>
                                    <li><a @click="menu=2" ><span class="pcoded-micon"><i
                                    class="feather icon-user-check"></i></span><span class="pcoded-mtext">Control Roles</span></a></li>
                                    <li><a @click="menu=3" ><span class="pcoded-micon"><i
                                    class="feather icon-folder"></i></span><span class="pcoded-mtext">Gestion Permisos</span></a></li>
                           
                            </ul>
                        </li>
                    @endif
                    @if($p->nombrePermiso == "Clientes" && $p->estado)
                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project"
                            class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                    class="feather icon-home"></i></span><span class="pcoded-mtext">Clientes</span></a>
                            <ul class="pcoded-submenu">
                                <li class=""><a @click="menu=4">Control Clientes</a></li>
                                <li class=""><a @click="menu=5">Reportes</a></li>
                            </ul>
                        </li>
                    @endif
                    @if($p->nombrePermiso == "Proveedores" && $p->estado)
                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project"
                            class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                    class="feather icon-home"></i></span><span class="pcoded-mtext">Proveedores</span></a>
                            <ul class="pcoded-submenu">
                                <li class=""><a @click="menu=6">Control Proveedores</a></li>
                                <li class=""><a @click="menu=7">Reportes</a></li>
                            </ul>
                        </li>
                    @endif
                    @if($p->nombrePermiso == "Productos" && $p->estado)
                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project"
                            class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                    class="feather icon-package"></i></span><span class="pcoded-mtext">Productos</span></a> <hr>
                            <ul class="pcoded-submenu">
                            <li><a @click="menu=8" ><span class="pcoded-micon"><i
                                    class="feather icon-clipboard"></i></span><span class="pcoded-mtext">Control Productos</span></a></li>
                                    <li><a @click="menu=9" ><span class="pcoded-micon"><i
                                    class="feather icon-layers"></i></span><span class="pcoded-mtext">Categorias</span></a></li>
                                    <li><a @click="menu=10" ><span class="pcoded-micon"><i
                                    class="feather icon-file"></i></span><span class="pcoded-mtext">Presentacion</span></a></li>
                                    <li><a @click="menu=11" ><span class="pcoded-micon"><i
                                    class="feather icon-calendar"></i></span><span class="pcoded-mtext">Historial Productos</span></a></li>
                                    <li><a @click="menu=12" ><span class="pcoded-micon"><i
                                    class="feather icon-layers"></i></span><span class="pcoded-mtext">Reportes</span></a></li>
                            </ul>
                            
                        </li>
                    @endif
                   
                    @if($p->nombrePermiso == "Ventas" && $p->estado)
                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project"
                            class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                    class="feather icon-tag"></i></span><span class="pcoded-mtext">Ventas</span></a><hr>
                            <ul class="pcoded-submenu">
                            <li><a @click="menu=13" ><span class="pcoded-micon"><i
                                    class="feather icon-credit-card"></i></span><span class="pcoded-mtext">Nueva Venta</span></a></li>
                                    <li><a @click="menu=14" ><span class="pcoded-micon"><i
                                    class="feather icon-share"></i></span><span class="pcoded-mtext">Historial ventas</span></a></li>
                                <li><a @click="menu=15" ><span class="pcoded-micon"><i
                                    class="feather icon-box"></i></span><span class="pcoded-mtext">Control Caja</span></a></li>
                                    <li><a @click="menu=16" ><span class="pcoded-micon"><i
                                    class="feather icon-box"></i></span><span class="pcoded-mtext">Reportes</span></a></li>
                            </ul>
                        </li>
                    @endif
                    @if($p->nombrePermiso == "Compras" && $p->estado)
                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project"
                            class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                    class="feather icon-home"></i></span><span class="pcoded-mtext">Compras</span></a>
                            <ul class="pcoded-submenu">
                                <li class=""><a @click="menu=17">Nueva compra</a></li>
                                <li class=""><a @click="menu=18">Historial compras</a></li>
                                <li class=""><a @click="menu=19">Reportes</a></li>
                            </ul>
                        </li>
                    @endif
                    @if($p->nombrePermiso == "Reportes" && $p->estado)
                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project"
                            class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                    class="feather icon-home"></i></span><span class="pcoded-mtext">Reportes</span></a>
                            <ul class="pcoded-submenu">
                                <li class=""><a @click="menu=19" v-on:click="ruta='Roles'">Pruebas</a></li>
                            </ul>
                        </li>
                    @endif
                    @endforeach
                </ul>

                
            </div>
            
        </div>
        
    </nav>
    <!-- [ navigati
