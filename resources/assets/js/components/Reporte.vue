<template>
     <!-- Contenido Principal -->
 <main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="#">Admin</a></li>
        <li class="breadcrumb-item active">Reportes</li>
    </ol>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Reportes
            </div>
            
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Nombre reporte</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Reporte de Jefes de Familia</td>
                            <td>
                                <button type="button" @click="abrirModalM('jefe', 1)" class="btn btn-info">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Municipio
                                </button><br>
                                <button type="button" @click="abrirModalC('jefe', 2)" class="btn btn-success">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Sede de territorio
                                </button><br>
                                <button type="button" @click="abrirModalD('jefe', 3)" class="btn btn-info">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Comunidad
                                </button>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>Reporte de Viviendas</td>
                            <td>
                                <button type="button" @click="abrirModalM('viviendas', 1)" class="btn btn-info">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Municipio
                                </button><br>
                                <button type="button" @click="abrirModalC('viviendas', 2)" class="btn btn-success">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Sede de territorio
                                </button><br>
                                <button type="button" @click="abrirModalD('viviendas', 3)" class="btn btn-info">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Comunidad
                                </button>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>Reporte de Sexo de la persona</td>
                            <td>
                                <button type="button" @click="abrirModalM('sexo', 1)" class="btn btn-info">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Municipio
                                </button><br>
                                <button type="button" @click="abrirModalC('sexo', 2)" class="btn btn-success">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Sede de territorio
                                </button><br>
                                <button type="button" @click="abrirModalD('sexo', 3)" class="btn btn-info">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Comunidad
                                </button>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>Reporte de Edades</td>
                            <td>
                                <button type="button" @click="abrirModalMEdades('edad', 1)" class="btn btn-info">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Municipio
                                </button><br>
                                <button type="button" @click="abrirModalCEdades('edad', 2)" class="btn btn-success">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Sede de territorio
                                </button><br>
                                <button type="button" @click="abrirModalDEdades('edad', 3)" class="btn btn-info">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Comunidad
                                </button>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>Reporte de Capacidades diferentes</td>
                            <td>
                                <button type="button" @click="abrirModalM('discapacidad', 1)" class="btn btn-info">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Municipio
                                </button><br>
                                <button type="button" @click="abrirModalC('discapacidad', 1)" class="btn btn-success">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Sede de territorio
                                </button><br>
                                <button type="button" @click="abrirModalD('discapacidad', 1)" class="btn btn-info">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Comunidad
                                </button>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>Reporte de Ocupacion</td>
                            <td>
                                <button type="button" @click="abrirModalM('ocupacion', 1)" class="btn btn-info">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Municipio
                                </button><br>
                                <button type="button" @click="abrirModalC('ocupacion', 2)" class="btn btn-success">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Sede de territorio
                                </button><br>
                                <button type="button" @click="abrirModalD('ocupacion', 3)" class="btn btn-info">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Comunidad
                                </button>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>Reporte de Migracion</td>
                            <td>
                                <button type="button" @click="abrirModalM('migracion', 1)" class="btn btn-info">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Municipio
                                </button><br>
                                <button type="button" @click="abrirModalC('migracion', 2)" class="btn btn-success">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Sede de territorio
                                </button><br>
                                <button type="button" @click="abrirModalD('migracion', 3)" class="btn btn-info">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Comunidad
                                </button>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>Reporte de Fallecidos</td>
                            <td>
                                <button type="button" @click="abrirModalMFallecidos('fallecidos', 1)" class="btn btn-info">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Municipio
                                </button><br>
                                <button type="button" @click="abrirModalCFallecidos('fallecidos', 2)" class="btn btn-success">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Sede de territorio
                                </button><br>
                                <button type="button" @click="abrirModalDFallecidos('fallecidos', 3)" class="btn btn-info">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Comunidad
                                </button>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>Reporte de Servicios</td>
                            <td>
                                <button type="button" @click="abrirModalMServicios('servicios', 1)" class="btn btn-info">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Municipio
                                </button><br>
                                <button type="button" @click="abrirModalCServicios('servicios', 2)" class="btn btn-success">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Sede de territorio
                                </button><br>
                                <button type="button" @click="abrirModalDServicios('servicios', 3)" class="btn btn-info">
                                    <i class="icon-doc"></i>&nbsp;Reporte por Comunidad
                                </button>
                            </td>
                            
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Fin ejemplo de tabla Listado -->

    <!--Inicio del modal municipio-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Municipio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idmunicipio">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="municipio in arrayMunicipio" :key="municipio.id" :value="municipio.id" v-text="municipio.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div v-show="errorReporte" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjReporte" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="cargarRJefe()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="cargarRViviendas()">Guardar</button>
                    <button type="button" v-if="tipoAccion==3" class="btn btn-primary" @click="cargarRSexo()">Guardar</button>
                    <button type="button" v-if="tipoAccion==4" class="btn btn-primary" @click="cargarREdad()">Guardar</button>
                    <button type="button" v-if="tipoAccion==5" class="btn btn-primary" @click="cargarRDiscapacidad()">Guardar</button>
                    <button type="button" v-if="tipoAccion==6" class="btn btn-primary" @click="cargarROcupacion()">Guardar</button>
                    <button type="button" v-if="tipoAccion==7" class="btn btn-primary" @click="cargarRMigracion()">Guardar</button>
                    <button type="button" v-if="tipoAccion==8" class="btn btn-primary" @click="cargarRFallecidos()">Guardar</button>
                    <button type="button" v-if="tipoAccion==9" class="btn btn-primary" @click="cargarRServicios()">Guardar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->

    <!--Inicio del modal comunidad-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalComunidad}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Municipio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idmunicipio"  @change="MunicipioS()">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="municipio in arrayMunicipio" :key="municipio.id" :value="municipio.id" v-text="municipio.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div v-show="errorReporte" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjReporte" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Sede de territorio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idcomunidad">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="comunidad in arrayComunidad" :key="comunidad.id" :value="comunidad.id" v-text="comunidad.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div v-show="errorReporte" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjReporte" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="cargarRJefe()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="cargarRViviendas()">Guardar</button>
                    <button type="button" v-if="tipoAccion==3" class="btn btn-primary" @click="cargarRSexo()">Guardar</button>
                    <button type="button" v-if="tipoAccion==4" class="btn btn-primary" @click="cargarREdad()">Guardar</button>
                    <button type="button" v-if="tipoAccion==5" class="btn btn-primary" @click="cargarRDiscapacidad()">Guardar</button>
                    <button type="button" v-if="tipoAccion==6" class="btn btn-primary" @click="cargarROcupacion()">Guardar</button>
                    <button type="button" v-if="tipoAccion==7" class="btn btn-primary" @click="cargarRMigracion()">Guardar</button>
                    <button type="button" v-if="tipoAccion==8" class="btn btn-primary" @click="cargarRFallecidos()">Guardar</button>
                    <button type="button" v-if="tipoAccion==9" class="btn btn-primary" @click="cargarRServicios()">Guardar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->


    <!--Inicio del modal distrito-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalDistrito}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Municipio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idmunicipio"  @change="MunicipioS()">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="municipio in arrayMunicipio" :key="municipio.id" :value="municipio.id" v-text="municipio.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div v-show="errorReporte" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjReporte" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Sede de territorio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idcomunidad" @change="ComunidadS()">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="comunidad in arrayComunidad" :key="comunidad.id" :value="comunidad.id" v-text="comunidad.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div v-show="errorReporte" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjReporte" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                         <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Comunidad</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="iddistrito">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="distrito in arrayDistrito" :key="distrito.id" :value="distrito.id" v-text="distrito.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div v-show="errorReporte" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjReporte" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="cargarRJefe()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="cargarRViviendas()">Guardar</button>
                    <button type="button" v-if="tipoAccion==3" class="btn btn-primary" @click="cargarRSexo()">Guardar</button>
                    <button type="button" v-if="tipoAccion==4" class="btn btn-primary" @click="cargarREdad()">Guardar</button>
                    <button type="button" v-if="tipoAccion==5" class="btn btn-primary" @click="cargarRDiscapacidad()">Guardar</button>
                    <button type="button" v-if="tipoAccion==6" class="btn btn-primary" @click="cargarROcupacion()">Guardar</button>
                    <button type="button" v-if="tipoAccion==7" class="btn btn-primary" @click="cargarRMigracion()">Guardar</button>
                    <button type="button" v-if="tipoAccion==8" class="btn btn-primary" @click="cargarRFallecidos()">Guardar</button>
                    <button type="button" v-if="tipoAccion==9" class="btn btn-primary" @click="cargarRServicios()">Guardar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->

    <!--Inicio del modal municipio y servicios-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalServiciosM}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Municipio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idmunicipio">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="municipio in arrayMunicipio" :key="municipio.id" :value="municipio.id" v-text="municipio.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Servicios</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idservicios">
                                    <option value="0" disabled>Seleccione</option>
                                    <option value="1" >Tenencia de la vivienda</option>
                                    <option value="2" >Tipo de vivienda</option>
                                    <option value="3" >Separacion de ambientes</option>
                                    <option value="4" >Ubicacion y tipo de cocina</option>
                                    <option value="5" >Techo</option>
                                    <option value="6" >Pared</option>
                                    <option value="7" >Piso</option>
                                    <option value="8" >Abastecimiento de agua</option>
                                    <option value="9" >Tratamiento de aguas servidas</option>
                                    <option value="10" >Eliminacion final de excretas</option>
                                    <option value="11" >Eliminacion final de basura</option>
                                    <option value="12" >Ubicacion de animales domesticos</option>
                                    <option value="13" >Condiciones dell lugar de los animales domesticos</option>
                                    <option value="14" >Zoonosis</option>
                                    <option value="15" >Otros servicios</option>
                                </select>
                            </div>
                        </div>
                        <div v-show="errorReporte" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjReporte" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="cargarRJefe()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="cargarRViviendas()">Guardar</button>
                    <button type="button" v-if="tipoAccion==3" class="btn btn-primary" @click="cargarRSexo()">Guardar</button>
                    <button type="button" v-if="tipoAccion==4" class="btn btn-primary" @click="cargarREdad()">Guardar</button>
                    <button type="button" v-if="tipoAccion==5" class="btn btn-primary" @click="cargarRDiscapacidad()">Guardar</button>
                    <button type="button" v-if="tipoAccion==6" class="btn btn-primary" @click="cargarROcupacion()">Guardar</button>
                    <button type="button" v-if="tipoAccion==7" class="btn btn-primary" @click="cargarRMigracion()">Guardar</button>
                    <button type="button" v-if="tipoAccion==8" class="btn btn-primary" @click="cargarRFallecidos()">Guardar</button>
                    <button type="button" v-if="tipoAccion==9" class="btn btn-primary" @click="cargarRServicios()">Guardar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->

    <!--Inicio del modal comunidad-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalServiciosC}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Municipio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idmunicipio"  @change="MunicipioS()">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="municipio in arrayMunicipio" :key="municipio.id" :value="municipio.id" v-text="municipio.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Sede de territorio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idcomunidad">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="comunidad in arrayComunidad" :key="comunidad.id" :value="comunidad.id" v-text="comunidad.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Servicios</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idservicios">
                                    <option value="0" disabled>Seleccione</option>
                                    <option value="1" >Tenencia de la vivienda</option>
                                    <option value="2" >Tipo de vivienda</option>
                                    <option value="3" >Separacion de ambientes</option>
                                    <option value="4" >Ubicacion y tipo de cocina</option>
                                    <option value="5" >Techo</option>
                                    <option value="6" >Pared</option>
                                    <option value="7" >Piso</option>
                                    <option value="8" >Abastecimiento de agua</option>
                                    <option value="9" >Tratamiento de aguas servidas</option>
                                    <option value="10" >Eliminacion final de excretas</option>
                                    <option value="11" >Eliminacion final de basura</option>
                                    <option value="12" >Ubicacion de animales domesticos</option>
                                    <option value="13" >Condiciones del lugar de los animales domesticos</option>
                                    <option value="14" >Zoonosis</option>
                                    <option value="15" >Otros servicios</option>
                                </select>
                            </div>
                        </div>
                        <div v-show="errorReporte" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjReporte" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="cargarRJefe()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="cargarRViviendas()">Guardar</button>
                    <button type="button" v-if="tipoAccion==3" class="btn btn-primary" @click="cargarRSexo()">Guardar</button>
                    <button type="button" v-if="tipoAccion==4" class="btn btn-primary" @click="cargarREdad()">Guardar</button>
                    <button type="button" v-if="tipoAccion==5" class="btn btn-primary" @click="cargarRDiscapacidad()">Guardar</button>
                    <button type="button" v-if="tipoAccion==6" class="btn btn-primary" @click="cargarROcupacion()">Guardar</button>
                    <button type="button" v-if="tipoAccion==7" class="btn btn-primary" @click="cargarRMigracion()">Guardar</button>
                    <button type="button" v-if="tipoAccion==8" class="btn btn-primary" @click="cargarRFallecidos()">Guardar</button>
                    <button type="button" v-if="tipoAccion==9" class="btn btn-primary" @click="cargarRServicios()">Guardar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->


    <!--Inicio del modal distrito-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalServiciosD}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Municipio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idmunicipio"  @change="MunicipioS()">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="municipio in arrayMunicipio" :key="municipio.id" :value="municipio.id" v-text="municipio.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Sede de territorio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idcomunidad" @change="ComunidadS()">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="comunidad in arrayComunidad" :key="comunidad.id" :value="comunidad.id" v-text="comunidad.nombre"></option>
                                </select>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Comunidad</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="iddistrito">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="distrito in arrayDistrito" :key="distrito.id" :value="distrito.id" v-text="distrito.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Servicios</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idservicios">
                                    <option value="0" disabled>Seleccione</option>
                                    <option value="1" >Tenencia de la vivienda</option>
                                    <option value="2" >Tipo de vivienda</option>
                                    <option value="3" >Separacion de ambientes</option>
                                    <option value="4" >Ubicacion y tipo de cocina</option>
                                    <option value="5" >Techo</option>
                                    <option value="6" >Pared</option>
                                    <option value="7" >Piso</option>
                                    <option value="8" >Abastecimiento de agua</option>
                                    <option value="9" >Tratamiento de aguas servidas</option>
                                    <option value="10" >Eliminacion final de excretas</option>
                                    <option value="11" >Eliminacion final de basura</option>
                                    <option value="12" >Ubicacion de animales domesticos</option>
                                    <option value="13" >Condiciones dell lugar de los animales domesticos</option>
                                    <option value="14" >Zoonosis</option>
                                    <option value="15" >Otros servicios</option>
                                </select>
                            </div>
                        </div>
                        <div v-show="errorReporte" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjReporte" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="cargarRJefe()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="cargarRViviendas()">Guardar</button>
                    <button type="button" v-if="tipoAccion==3" class="btn btn-primary" @click="cargarRSexo()">Guardar</button>
                    <button type="button" v-if="tipoAccion==4" class="btn btn-primary" @click="cargarREdad()">Guardar</button>
                    <button type="button" v-if="tipoAccion==5" class="btn btn-primary" @click="cargarRDiscapacidad()">Guardar</button>
                    <button type="button" v-if="tipoAccion==6" class="btn btn-primary" @click="cargarROcupacion()">Guardar</button>
                    <button type="button" v-if="tipoAccion==7" class="btn btn-primary" @click="cargarRMigracion()">Guardar</button>
                    <button type="button" v-if="tipoAccion==8" class="btn btn-primary" @click="cargarRFallecidos()">Guardar</button>
                    <button type="button" v-if="tipoAccion==9" class="btn btn-primary" @click="cargarRServicios()">Guardar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->


    <!--Inicio del modal municipio y edades-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalEdadesM}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Municipio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idmunicipio">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="municipio in arrayMunicipio" :key="municipio.id" :value="municipio.id" v-text="municipio.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Fecha inicial</label>
                            <div class="col-md-3">
                                <input type="date" v-model="fecha1" class="form-control" min="0">
                            </div>
                            <label class="col-md-3 form-control-label" for="text-input">Fecha final</label>
                            <div class="col-md-3">
                                <input type="date" v-model="fecha2" class="form-control" min="0">
                            </div>
                        </div>
                        <div v-show="errorReporte" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjReporte" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==4" class="btn btn-primary" @click="cargarREdad()">Guardar</button>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->

    <!--Inicio del modal comunidad-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalEdadesC}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Municipio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idmunicipio"  @change="MunicipioS()">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="municipio in arrayMunicipio" :key="municipio.id" :value="municipio.id" v-text="municipio.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Sede de territorio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idcomunidad">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="comunidad in arrayComunidad" :key="comunidad.id" :value="comunidad.id" v-text="comunidad.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Fecha inicial</label>
                            <div class="col-md-3">
                                <input type="date" v-model="fecha1" class="form-control" min="0">
                            </div>
                            <label class="col-md-3 form-control-label" for="text-input">Fecha final</label>
                            <div class="col-md-3">
                                <input type="date" v-model="fecha2" class="form-control" min="0">
                            </div>
                        </div>
                        <div v-show="errorReporte" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjReporte" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==4" class="btn btn-primary" @click="cargarREdad()">Guardar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->


    <!--Inicio del modal distrito-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalEdadesD}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Municipio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idmunicipio"  @change="MunicipioS()">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="municipio in arrayMunicipio" :key="municipio.id" :value="municipio.id" v-text="municipio.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Sede de territorio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idcomunidad" @change="ComunidadS()">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="comunidad in arrayComunidad" :key="comunidad.id" :value="comunidad.id" v-text="comunidad.nombre"></option>
                                </select>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Comunidad</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="iddistrito">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="distrito in arrayDistrito" :key="distrito.id" :value="distrito.id" v-text="distrito.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Fecha inicial</label>
                            <div class="col-md-3">
                                <input type="date" v-model="fecha1" class="form-control" min="0">
                            </div>
                            <label class="col-md-3 form-control-label" for="text-input">Fecha final</label>
                            <div class="col-md-3">
                                <input type="date" v-model="fecha2" class="form-control" min="0">
                            </div>
                        </div>
                        <div v-show="errorReporte" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjReporte" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==4" class="btn btn-primary" @click="cargarREdad()">Guardar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->


    <!--Inicio del modal municipio y edades-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalFallecidosM}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Municipio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idmunicipio">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="municipio in arrayMunicipio" :key="municipio.id" :value="municipio.id" v-text="municipio.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Fecha inicial</label>
                            <div class="col-md-3">
                                <input type="date" v-model="fecha1" class="form-control" min="0">
                            </div>
                            <label class="col-md-3 form-control-label" for="text-input">Fecha final</label>
                            <div class="col-md-3">
                                <input type="date" v-model="fecha2" class="form-control" min="0">
                            </div>
                        </div>
                        <div v-show="errorReporte" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjReporte" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==8" class="btn btn-primary" @click="cargarRFallecidos()">Guardar</button>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->

    <!--Inicio del modal comunidad-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalFallecidosC}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Municipio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idmunicipio"  @change="MunicipioS()">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="municipio in arrayMunicipio" :key="municipio.id" :value="municipio.id" v-text="municipio.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Sede de territorio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idcomunidad">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="comunidad in arrayComunidad" :key="comunidad.id" :value="comunidad.id" v-text="comunidad.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Fecha inicial</label>
                            <div class="col-md-3">
                                <input type="date" v-model="fecha1" class="form-control" min="0">
                            </div>
                            <label class="col-md-3 form-control-label" for="text-input">Fecha final</label>
                            <div class="col-md-3">
                                <input type="date" v-model="fecha2" class="form-control" min="0">
                            </div>
                        </div>
                        <div v-show="errorReporte" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjReporte" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==8" class="btn btn-primary" @click="cargarRFallecidos()">Guardar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->


    <!--Inicio del modal distrito-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalFallecidosD}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Municipio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idmunicipio"  @change="MunicipioS()">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="municipio in arrayMunicipio" :key="municipio.id" :value="municipio.id" v-text="municipio.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Sede de territorio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idcomunidad" @change="ComunidadS()">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="comunidad in arrayComunidad" :key="comunidad.id" :value="comunidad.id" v-text="comunidad.nombre"></option>
                                </select>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Comunidad</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="iddistrito">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="distrito in arrayDistrito" :key="distrito.id" :value="distrito.id" v-text="distrito.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Fecha inicial</label>
                            <div class="col-md-3">
                                <input type="date" v-model="fecha1" class="form-control" min="0">
                            </div>
                            <label class="col-md-3 form-control-label" for="text-input">Fecha final</label>
                            <div class="col-md-3">
                                <input type="date" v-model="fecha2" class="form-control" min="0">
                            </div>
                        </div>
                        <div v-show="errorReporte" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjReporte" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==8" class="btn btn-primary" @click="cargarRFallecidos()">Guardar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->

</main>
<!--Fin del contenido principal-->
</template>

<script>
    export default {
        data(){
            return {
                reporte_id: 0,
                nombre : '',
                arrayReporte : [],
                modal : 0,
                modalComunidad:0,
                modalDistrito:0,
                modalServiciosM:0,
                modalServiciosC:0,
                modalServiciosD:0,
                modalEdadesM:0,
                modalEdadesC:0,
                modalEdadesD:0,
                modalFallecidosM:0,
                modalFallecidosC:0,
                modalFallecidosD:0,
                tituloModal : '',
                tipoAccion : 0,
                errorReporte: 0,
                errorMostrarMsjReporte : [],
                offset : 3,
                filtro:0,

                //A partir de aqui traemos los datos que necesitaremos en los modales
                idmunicipio:0,
                arrayMunicipio:[],
                idcomunidad:0,
                arrayComunidad:[],
                iddistrito:0,
                arrayDistrito:[],

                idservicios:0,

                edad1:0,
                edad2:0,


                fecha1:'',
                fecha2:'',
            }
        },
        computed : {

        },
        methods : {
            cargarRJefe(){
                if(this.validarReporte()){
                    return;
                }
                let me = this;
                //window.open('https://sicpowquetzaltenango.com/RJefes/'+this.filtro+'/'+this.idmunicipio+'/'+this.idcomunidad+'/'+this.iddistrito+','+'_blank');
                window.open('http://localhost:8000/RJefes/'+this.filtro+'/'+this.idmunicipio+'/'+this.idcomunidad+'/'+this.iddistrito+','+'_blank');
                me.cerrarModal();
            },
            cargarRViviendas(){
                if(this.validarReporte()){
                    return;
                }
                let me = this;
                window.open('https://sicpowquetzaltenango.com/RViviendas/'+this.filtro+'/'+this.idmunicipio+'/'+this.idcomunidad+'/'+this.iddistrito+','+'_blank');
                me.cerrarModal();
            },
            cargarRSexo(){
                if(this.validarReporte()){
                    return;
                }
                let me = this;
                //window.open('https://sicpowquetzaltenango.com/RSexo/'+this.filtro+'/'+this.idmunicipio+'/'+this.idcomunidad+'/'+this.iddistrito+','+'_blank');
                window.open('http://localhost:8000/RSexo/'+this.filtro+'/'+this.idmunicipio+'/'+this.idcomunidad+'/'+this.iddistrito+','+'_blank');
                me.cerrarModal();
            },
            cargarREdad(){
                if(this.validarReporte()){
                    return;
                }
                let me = this;
                //window.open('https://sicpowquetzaltenango.com/REdad/'+this.filtro+'/'+this.idmunicipio+'/'+this.idcomunidad+'/'+this.iddistrito+'/'+this.fecha1+'/'+this.fecha2+','+'_blank');
                window.open('http://localhost:8000/REdad/'+this.filtro+'/'+this.idmunicipio+'/'+this.idcomunidad+'/'+this.iddistrito+'/'+this.fecha1+'/'+this.fecha2+'/'+this.edad1+','+'_blank');
                me.cerrarModal();
            },
            cargarRDiscapacidad(){
                if(this.validarReporte()){
                    return;
                }
                let me = this;
                //window.open('https://sicpowquetzaltenango.com/RDiscapacidad/'+this.filtro+'/'+this.idmunicipio+'/'+this.idcomunidad+'/'+this.iddistrito+','+'_blank');
                window.open('http://localhost:8000/RDiscapacidad/'+this.filtro+'/'+this.idmunicipio+'/'+this.idcomunidad+'/'+this.iddistrito+','+'_blank');
                me.cerrarModal();
            },
            cargarROcupacion(){
                if(this.validarReporte()){
                    return;
                }
                let me = this;
                //window.open('https://sicpowquetzaltenango.com/ROcupacion/'+this.filtro+'/'+this.idmunicipio+'/'+this.idcomunidad+'/'+this.iddistrito+','+'_blank');
                window.open('http://localhost:8000/ROcupacion/'+this.filtro+'/'+this.idmunicipio+'/'+this.idcomunidad+'/'+this.iddistrito+','+'_blank');
                me.cerrarModal();
            },
            cargarRMigracion(){
                if(this.validarReporte()){
                    return;
                }
                let me = this;
                //window.open('https://sicpowquetzaltenango.com/RMigracion/'+this.filtro+'/'+this.idmunicipio+'/'+this.idcomunidad+'/'+this.iddistrito+','+'_blank');
                window.open('http://localhost:8000/RMigracion/'+this.filtro+'/'+this.idmunicipio+'/'+this.idcomunidad+'/'+this.iddistrito+','+'_blank');
                me.cerrarModal();
            },
            cargarRFallecidos(){
                if(this.validarReporte()){
                    return;
                }
                let me = this;
                //window.open('https://sicpowquetzaltenango.com/RFallecidos/'+this.filtro+'/'+this.idmunicipio+'/'+this.idcomunidad+'/'+this.iddistrito+'/'+this.fecha1+'/'+this.fecha2+','+'_blank');
                window.open('http://localhost:8000/RFallecidos/'+this.filtro+'/'+this.idmunicipio+'/'+this.idcomunidad+'/'+this.iddistrito+'/'+this.fecha1+'/'+this.fecha2+','+'_blank');
                me.cerrarModal();
            },
            cargarRServicios(){
                if(this.validarReporte()){
                    return;
                }
                let me = this;
                window.open('https://sicpowquetzaltenango.com/RServicios/'+this.filtro+'/'+this.idmunicipio+'/'+this.idcomunidad+'/'+this.iddistrito+'/'+this.idservicios+','+'_blank');
                me.cerrarModal();
            },
            validarReporte(){
                this.errorReporte=0;
                this.errorMostrarMsjReporte=[];

                if (this.filtro == 1)
                {
                    if(!this.idmunicipio) this.errorMostrarMsjReporte.push("El municipio no puede estar vacio");
                }
                else if (this.filtro == 2)
                {
                    if(!this.idmunicipio) this.errorMostrarMsjReporte.push("El municipio no puede estar vacio");
                    if(!this.idmunicipio) this.errorMostrarMsjReporte.push("La comunidad no puede estar vacia");
                }
                else if (this.filtro == 3)
                {
                    if(!this.idmunicipio) this.errorMostrarMsjReporte.push("El municipio no puede estar vacio");
                    if(!this.idmunicipio) this.errorMostrarMsjReporte.push("La comunidad no puede estar vacia");
                    if(!this.idmunicipio) this.errorMostrarMsjReporte.push("El distrito no puede estar vacio");
                }
                else if (this.filtro ==11)
                {
                    if(!this.idmunicipio) this.errorMostrarMsjReporte.push("El municipio no puede estar vacio");
                    if(!this.idservicios) this.errorMostrarMsjReporte.push("Debe elegir un servicio");
                }
                else if (this.filtro ==12)
                {
                    if(!this.idmunicipio) this.errorMostrarMsjReporte.push("El municipio no puede estar vacio");
                    if(!this.idcomunidad) this.errorMostrarMsjReporte.push("La comunidad no puede estar vacia");
                    if(!this.idservicios) this.errorMostrarMsjReporte.push("Debe elegir un servicio");
                }
                else if (this.filtro ==13)
                {
                    if(!this.idmunicipio) this.errorMostrarMsjReporte.push("El municipio no puede estar vacio");
                    if(!this.idcomunidad) this.errorMostrarMsjReporte.push("La comunidad no puede estar vacia");
                    if(!this.iddistrito) this.errorMostrarMsjReporte.push("El distrito no puede estar vacio");
                    if(!this.idservicios) this.errorMostrarMsjReporte.push("Debe elegir un servicio");
                }

                else if (this.filtro ==14)
                {
                    if(!this.idmunicipio) this.errorMostrarMsjReporte.push("El municipio no puede estar vacio");
                    if(this.fecha1>this.fecha2) this.errorMostrarMsjReporte.push("La edad inicial es mayor que la edad final");
                    if(!this.fecha1) this.errorMostrarMsjReporte.push("La fecha inicial no puede estar vacia");
                    if(!this.fecha2) this.errorMostrarMsjReporte.push("La fecha final no puede estar vacia");
                }
                else if (this.filtro ==15)
                {
                    if(!this.idmunicipio) this.errorMostrarMsjReporte.push("El municipio no puede estar vacio");
                    if(!this.idcomunidad) this.errorMostrarMsjReporte.push("La comunidad no puede estar vacia");
                    if(this.fecha1>this.fecha2) this.errorMostrarMsjReporte.push("La edad inicial es mayor que la edad final");
                    if(!this.fecha1) this.errorMostrarMsjReporte.push("La fecha inicial no puede estar vacia");
                    if(!this.fecha2) this.errorMostrarMsjReporte.push("La fecha final no puede estar vacia");
                }
                else if (this.filtro ==16)
                {
                    if(!this.idmunicipio) this.errorMostrarMsjReporte.push("El municipio no puede estar vacio");
                    if(!this.idcomunidad) this.errorMostrarMsjReporte.push("La comunidad no puede estar vacia");
                    if(!this.iddistrito) this.errorMostrarMsjReporte.push("El distrito no puede estar vacio");
                    if(this.fecha1>this.fecha2) this.errorMostrarMsjReporte.push("La edad inicial es mayor que la edad final");
                    if(!this.fecha1) this.errorMostrarMsjReporte.push("La fecha inicial no puede estar vacia");
                    if(!this.fecha2) this.errorMostrarMsjReporte.push("La fecha final no puede estar vacia");
                }
                else if (this.filtro == 17)
                {
                    if(!this.idmunicipio) this.errorMostrarMsjReporte.push("El municipio no puede estar vacio");
                    if(this.fecha1>this.fecha2) this.errorMostrarMsjReporte.push("La fecha inicial es mayor que la fecha final");
                    if(!this.fecha1) this.errorMostrarMsjReporte.push("La fecha inicial no puede estar vacia");
                    if(!this.fecha2) this.errorMostrarMsjReporte.push("La fecha final no puede estar vacia");
                }
                else if (this.filtro == 18)
                {
                    if(!this.idmunicipio) this.errorMostrarMsjReporte.push("El municipio no puede estar vacio");
                    if(!this.idcomunidad) this.errorMostrarMsjReporte.push("La comunidad no puede estar vacia");
                    if(this.fecha1>this.fecha2) this.errorMostrarMsjReporte.push("La fecha inicial es mayor que la fecha final");
                    if(!this.fecha1) this.errorMostrarMsjReporte.push("La fecha inicial no puede estar vacia");
                    if(!this.fecha2) this.errorMostrarMsjReporte.push("La fecha final no puede estar vacia");
                }
                else if (this.filtro == 19)
                {
                    if(!this.idmunicipio) this.errorMostrarMsjReporte.push("El municipio no puede estar vacio");
                    if(!this.idcomunidad) this.errorMostrarMsjReporte.push("La comunidad no puede estar vacia");
                    if(!this.iddistrito) this.errorMostrarMsjReporte.push("El distrito no puede estar vacio");
                    if(this.fecha1>this.fecha2) this.errorMostrarMsjReporte.push("La fecha inicial es mayor que la fecha final");
                    if(!this.fecha1) this.errorMostrarMsjReporte.push("La fecha inicial no puede estar vacia");
                    if(!this.fecha2) this.errorMostrarMsjReporte.push("La fecha final no puede estar vacia");
                }



                if(this.errorMostrarMsjReporte.length) this.errorReporte=1;
                return this.errorReporte;
            },
            MunicipioS(){
                this.idcomunidad=0;
                this.iddistrito=0;
                this.idmunicipio;
                this.selectComunidad();
            },
            ComunidadS(){
                this.iddistrito=0;
                this.idcomunidad;
                this.selectDistrito();
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.tipoAccion = 0;
                this.filtro=0;
                this.idmunicipio=0;
                this.idcomunidad=0;
                this.iddistrito=0;
                this.idservicios=0;
                this.modalComunidad=0;
                this.modalDistrito=0;
                this.modalServiciosM=0;
                this.modalServiciosC=0;
                this.modalServiciosD=0;
                this.modalEdadesC=0;
                this.modalEdadesM=0;
                this.modalEdadesD=0;
                this.modalFallecidosM=0;
                this.modalFallecidosC=0;
                this.modalFallecidosD=0;
                this.edad1=0;
                this.edad2=0;
                this.fecha1='';
                this.fecha2='';
                this.errorMostrarMsjReporte='';
                this.arrayMunicipio=[];
                this.arrayComunidad=[];
                this.arrayDistrito=[];
            },

            //aqui estaran los modales
            abrirModalM(modelo, accion){
                switch(modelo){
                    case "jefe":
                    {
                        this.modal = 1;
                        this.tituloModal = 'Reporte Jefes de Familia';
                        this.tipoAccion = 1;
                        this.filtro = 1;
                        break;
                    }

                    case "viviendas":
                    {
                        this.modal = 1;
                        this.tituloModal = 'Reporte de Viviendas';
                        this.nombre = '';
                        this.tipoAccion = 2;
                        this.filtro = 1;
                        break;
                    }

                    case "sexo":
                    {
                        this.modal = 1;
                        this.tituloModal = 'Reporte de Sexo de las personas';
                        this.nombre = '';
                        this.tipoAccion = 3;
                        this.filtro = 1;
                        break;
                    }

                    case "discapacidad":
                    {
                        this.modal = 1;
                        this.tituloModal = 'Reporte de Discapacidad';
                        this.nombre = '';
                        this.tipoAccion = 5;
                        this.filtro = 1;
                        break;
                    }

                    case "ocupacion":
                    {
                        this.modal = 1;
                        this.tituloModal = 'Reporte de Ocupacion u Oficio';
                        this.nombre = '';
                        this.tipoAccion = 6;
                        this.filtro = 1;
                        break;
                    }

                    case "migracion":
                    {
                        this.modal = 1;
                        this.tituloModal = 'Reporte de Migracion';
                        this.nombre = '';
                        this.tipoAccion = 7;
                        this.filtro = 1;
                        break;
                    }

                }
                this.selectMunicipio();
            },

            abrirModalC(modelo, accion){
                
                switch(modelo){
                    case "jefe":
                    {
                        this.modalComunidad = 1;
                        this.tituloModal = 'Reporte Jefes de Familia';
                        this.tipoAccion = 1;
                        this.filtro = 2;
                        break;
                    }

                    case "viviendas":
                    {
                        this.modalComunidad = 1;
                        this.tituloModal = 'Reporte de Viviendas';
                        this.nombre = '';
                        this.tipoAccion = 2;
                        this.filtro = 2;
                        break;
                    }

                    case "sexo":
                    {
                        this.modalComunidad = 1;
                        this.tituloModal = 'Reporte de Sexo de las personas';
                        this.nombre = '';
                        this.tipoAccion = 3;
                        this.filtro = 2;
                        break;
                    }

                    case "discapacidad":
                    {
                        this.modalComunidad = 1;
                        this.tituloModal = 'Reporte de Discapacidad';
                        this.nombre = '';
                        this.tipoAccion = 5;
                        this.filtro = 2;
                        break;
                    }

                    case "ocupacion":
                    {
                        this.modalComunidad = 1;
                        this.tituloModal = 'Reporte de Ocupacion u Oficio';
                        this.nombre = '';
                        this.tipoAccion = 6;
                        this.filtro = 2;
                        break;
                    }

                    case "migracion":
                    {
                        this.modalComunidad = 1;
                        this.tituloModal = 'Reporte de Migracion';
                        this.nombre = '';
                        this.tipoAccion = 7;
                        this.filtro = 2;
                        break;
                    }
                    
                }
                this.selectMunicipio();
            },

            abrirModalD(modelo, accion){
                
                switch(modelo){
                    case "jefe":
                    {
                        this.modalDistrito = 1;
                        this.tituloModal = 'Reporte Jefes de Familia';
                        this.tipoAccion = 1;
                        this.filtro = 3;
                        break;
                    }

                    case "viviendas":
                    {
                        this.modalDistrito = 1;
                        this.tituloModal = 'Reporte de Viviendas';
                        this.nombre = '';
                        this.tipoAccion = 2;
                        this.filtro = 3;
                        break;
                    }

                    case "sexo":
                    {
                        this.modalDistrito = 1;
                        this.tituloModal = 'Reporte de Sexo de las personas';
                        this.nombre = '';
                        this.tipoAccion = 3;
                        this.filtro = 3;
                        break;
                    }

                    

                    case "discapacidad":
                    {
                        this.modalDistrito = 1;
                        this.tituloModal = 'Reporte de Discapacidad';
                        this.nombre = '';
                        this.tipoAccion = 5;
                        this.filtro = 3;
                        break;
                    }

                    case "ocupacion":
                    {
                        this.modalDistrito = 1;
                        this.tituloModal = 'Reporte de Ocupacion u Oficio';
                        this.nombre = '';
                        this.tipoAccion = 6;
                        this.filtro = 3;
                        break;
                    }

                    case "migracion":
                    {
                        this.modalDistrito = 1;
                        this.tituloModal = 'Reporte de Migracion';
                        this.nombre = '';
                        this.tipoAccion = 7;
                        this.filtro = 3;
                        break;
                    }
                    
                }
                this.selectMunicipio();
            },

            abrirModalMServicios(modelo, accion){
                switch(modelo){
                    case "servicios":
                    {
                        this.modalServiciosM = 1;
                        this.tituloModal = 'Reporte Servicios';
                        this.tipoAccion = 9;
                        this.filtro = 11;
                        break;
                    }                    
                }
                this.selectMunicipio();
            },

            abrirModalCServicios(modelo, accion){
                
                switch(modelo){
                    case "servicios":
                    {
                        this.modalServiciosC = 1;
                        this.tituloModal = 'Reporte Servicios';
                        this.tipoAccion = 9;
                        this.filtro = 12;
                        break;
                    }
                    
                }
                this.selectMunicipio();
            },

            abrirModalDServicios(modelo, accion){
                
                switch(modelo){
                    case "servicios":
                    {
                        this.modalServiciosD = 1;
                        this.tituloModal = 'Reporte Servicios';
                        this.tipoAccion = 9;
                        this.filtro = 13;
                        break;
                    }
                }
                this.selectMunicipio();
            },

            abrirModalMEdades(modelo, accion){
                switch(modelo){
                    case "edad":
                    {
                        this.modalEdadesM = 1;
                        this.tituloModal = 'Reporte de Edad';
                        this.nombre = '';
                        this.tipoAccion = 4;
                        this.filtro = 14;
                        break;
                    }                    
                }
                this.selectMunicipio();
            },

            abrirModalCEdades(modelo, accion){
                
                switch(modelo){
                    case "edad":
                    {
                        this.modalEdadesC = 1;
                        this.tituloModal = 'Reporte de Edad';
                        this.nombre = '';
                        this.tipoAccion = 4;
                        this.filtro = 15;
                        break;
                    }
                    
                }
                this.selectMunicipio();
            },

            abrirModalDEdades(modelo, accion){
                
                switch(modelo){
                    case "edad":
                    {
                        this.modalEdadesD = 1;
                        this.tituloModal = 'Reporte de Edad';
                        this.nombre = '';
                        this.tipoAccion = 4;
                        this.filtro = 16;
                        break;
                    }
                }
                this.selectMunicipio();
            },

            abrirModalMFallecidos(modelo, accion){
                switch(modelo){
                    case "fallecidos":
                    {
                        this.modalFallecidosM = 1;
                        this.tituloModal = 'Reporte de Fallecidos';
                        this.nombre = '';
                        this.tipoAccion = 8;
                        this.filtro = 17;
                        break;
                    }              
                }
                this.selectMunicipio();
            },

            abrirModalCFallecidos(modelo, accion){
                
                switch(modelo){
                    case "fallecidos":
                    {
                        this.modalFallecidosC = 1;
                        this.tituloModal = 'Reporte de Fallecidos';
                        this.nombre = '';
                        this.tipoAccion = 8;
                        this.filtro = 18;
                        break;
                    }
                    
                }
                this.selectMunicipio();
            },

            abrirModalDFallecidos(modelo, accion){
                
                switch(modelo){
                    case "fallecidos":
                    {
                        this.modalFallecidosD = 1;
                        this.tituloModal = 'Reporte de Fallecidos';
                        this.nombre = '';
                        this.tipoAccion = 8;
                        this.filtro = 19;
                        break;
                    }
                }
                this.selectMunicipio();
            },


            //a partir de aqui vamos a jalar datos para los modales
            selectMunicipio(){
                
                let me=this;
                var url = '/municipio/selectMunicipio';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayMunicipio = respuesta.municipios;
                })
                .catch(function (error){
                    console.log(error);
                });
            },
            selectComunidad(){
                
                let me=this;
                var url = '/comunidad/selectComunidadD/'+this.idmunicipio+'/';
                axios.get(url).then(function(response){
                    var respuesta = response.data;
                    me.arrayComunidad = respuesta.comunidades;
                })

            },
            selectDistrito(){
                let me=this;
                var url = '/distrito/selectDistritoD/'+this.idcomunidad+'/';
                axios.get(url).then(function(response){
                    var respuesta = response.data;
                    me.arrayDistrito = respuesta.distritos;
                })

            }

        },
        mounted() {
            
        }
    }
</script>

<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>