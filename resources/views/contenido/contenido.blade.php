 @extends('principal')
 @section('contenido')
    <template v-if="menu==0">
        <dashboard></dashboard>
    </template>
    <template v-if="menu==1">
        <familia></familia>
    </template>
    <template v-if="menu==2">
        <vivienda></vivienda>
    </template>
    <template v-if="menu==3">
        <reporte></reporte>
    </template>
    <template v-if="menu==4">
        <h1>Contenido del menu de graficos</h1>
    </template>
    <template v-if="menu==5">
        <usuario></usuario>
    </template>
    <template v-if="menu==6">
        <rol></rol>
    </template>
    <template v-if="menu==7">
        <distrito></distrito>
    </template>
    <template v-if="menu==8">
        <comunidad></comunidad>
    </template>
    <template v-if="menu==9">
        <municipio></municipio>
    </template>
    <template v-if="menu==10">
        <h1>Contenido del menu de manuales de usuario</h1>
    </template>
@endsection