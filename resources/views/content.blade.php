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

    <template v-if="menu==10">
        <Presentacion></Presentacion>
    </template>
    <template v-if="menu==11">
        <Caja></Caja>
    </template>
    <template v-if="menu==20">
        <Venta></Venta>
    </template>
    <template v-if="menu==21">
        <HistorialVentas></HistorialVentas>
    </template>
    <template v-if="menu==22">
        <Orden></Orden>
    </template>
@endsection