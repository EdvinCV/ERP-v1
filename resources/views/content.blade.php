@extends('layout')
@section('content')
    <template v-if="menu==0">
        <Usuarios></Usuarios>
    </template>
    <template v-if="menu==1">
        <Proveedor></Proveedor>
    </template>
    <template v-if="menu==2">
        <Cliente></Cliente>
    </template>
    <template v-if="menu==3">
        <Roles></Roles>
    </template>
    <template v-if="menu==4">
        <Permisos></Permisos>
    </template>
    <template v-if="menu==5">
        <Producto></Producto>
    </template>
    <template v-if="menu==6">
        <Categoria></Categoria>
    </template>
    <template v-if="menu==7">
        <Presentacion></Presentacion>
    </template>
    <template v-if="menu==8">
        <Historialcalidad></Historialcalidad>
    </template>
<!-- 9 proveedores-->
<!-- 10 reporte proveedores-->
<!-- 11 clientes proveedores-->
<!-- 12 reporte clientes-->

    <template v-if="menu==13">
        <Venta></Venta>
    </template>
    <template v-if="menu==14">
        <HistorialVentas></HistorialVentas>
    </template>
    <template v-if="menu==15">
        <Caja></Caja>
    </template>
    <!-- 16 reporte ventas-->

    <template v-if="menu==17">
        <Orden></Orden>
    </template>
    <template v-if="menu==18">
        <OrdenesCompra></OrdenesCompra>
    </template>
    <template v-if="menu==19">
        <chart></chart>
    </template>

@endsection