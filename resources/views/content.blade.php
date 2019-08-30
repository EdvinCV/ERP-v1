@extends('layout')
@section('content')
    <template v-if="menu==1">
        <Roles></Roles>
    </template>
    <template v-if="menu==2">
        <Permisos></Permisos>
    </template>
    <template v-if="menu==3">
        <categoria></categoria>
    </template>
    <template v-if="menu==4">
        <Presentacion></Presentacion>
    </template>
@endsection