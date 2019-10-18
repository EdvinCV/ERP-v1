@extends('layout')
@section('content')
    <template v-if="menu==100">
        <reportes></reportes>
    </template>
    <!-- MÓDULO USUARIOS -->
    <template v-if="menu==1">
        <Usuarios></Usuarios>
    </template>
    <template v-if="menu==2">
        <Roles></Roles>
    </template>
    <template v-if="menu==3">
        <Permisos></Permisos>
    </template>
    <!-- MÓDULO CLIENTES -->
    <template v-if="menu==4">
        <Cliente></Cliente>
    </template>
    <template v-if="menu==5">
        <reportes_clientes></reportes_clientes>
    </template>
    <!-- MÓDULO PROVEEDORES -->
    <template v-if="menu==6">
        <Proveedor></Proveedor>
    </template>
    <template v-if="menu==7">
        <reportes_prov></reportes_prov>
    </template>
    
    <!-- MÓDULO PRODUCTOS -->
    <template v-if="menu==8">
        <Producto></Producto>
    </template>
    <template v-if="menu==9">
        <Categoria></Categoria>
    </template>
    <template v-if="menu==10">
        <Presentacion></Presentacion>
    </template>
    <template v-if="menu==11">
        <Historialcalidad></Historialcalidad>
    </template>
    <!-- MÓDULO VENTAS -->
    <template v-if="menu==13">
        <Venta></Venta>
    </template>
    <template v-if="menu==14">
        <HistorialVentas></HistorialVentas>
    </template>
    <template v-if="menu==15">
        <Caja></Caja>
    </template>
    <template v-if="menu==16">
        <reportes></reportes>
    </template>
    <!-- MÓDULO COMPRAS-->
    <template v-if="menu==17">
        <Orden></Orden>
    </template>
    <template v-if="menu==18">
        <OrdenesCompra></OrdenesCompra>
    </template>
    <template v-if="menu==19">
        <reportes_compras></reportes_compras>
    </template>
    <template v-if="menu==21">
        <ACaja></ACaja>
    </template>
    <template v-if="menu==22">
        <Ccaja></Ccaja>
    </template>
    <template v-if="menu==30">
        <perfil></perfil>
    </template>
    <template v-if="menu==31">
        <reportes_compras></reportes_compras>
    </template>

@endsection