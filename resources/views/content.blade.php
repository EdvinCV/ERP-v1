@extends('layout')
@section('content')
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
    <!-- MÓDULO PROVEEDORES -->
    <template v-if="menu==6">
        <Proveedor></Proveedor>
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
    <!-- MÓDULO COMPRAS-->
    <template v-if="menu==17">
        <Orden></Orden>
    </template>
    <template v-if="menu==18">
        <OrdenesCompra></OrdenesCompra>
    </template>
    <template v-if="menu==19">
        <chart></chart>
    </template>
    <template v-if="menu==30">
        <perfil></perfil>
    </template>
    <template v-if="menu==31">
        <reportes></reportes>
    </template>

@endsection