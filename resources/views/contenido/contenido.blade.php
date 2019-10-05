 @extends('principal')
 @section('contenido')
    <template v-if="menu==0">
        <dashboard></dashboard>
    </template>
    <template v-if="menu==1">
        <familia></familia>
    </template>
    <template v-if="menu==2">
        <reporte></reporte>
    </template>
    <template v-if="menu==3">
        <h1>Contenido del menu de graficos</h1>
    </template>
    <template v-if="menu==4">
        <usuario></usuario>
    </template>
    <template v-if="menu==5">
        <rol></rol>
    </template>
    <template v-if="menu==6">
        <distrito></distrito>
    </template>
    <template v-if="menu==7">
        <comunidad></comunidad>
    </template>
    <template v-if="menu==8">
        <municipio></municipio>
    </template>
    <template v-if="menu==9">
        <acerca></acerca>
    </template>
    <template v-if="menu==10">
        <manuales></manuales>
    </template>
    <template v-if="menu==11">
        <manuales2></manuales2>
    </template>
    <template v-if="menu==12">
        <manuales3></manuales3>
    </template>
@endsection