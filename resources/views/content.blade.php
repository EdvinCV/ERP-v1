@extends('layout')
@section('content')
    <template v-if="menu==0">
        
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
    <template v-if="menu==6">
        <Categoria></Categoria>
    </template>
    <template v-if="menu==7">
        <Presentacion></Presentacion>
    </template>

    <template v-if="menu==10">
        <Presentacion></Presentacion>
    </template>
@endsection