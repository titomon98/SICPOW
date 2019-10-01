<template>
     <!-- Contenido Principal -->
 <main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="#">Admin</a></li>
        <li class="breadcrumb-item active">Comunidad</li>
    </ol>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Comunidades
                <button type="button" @click="abrirModal('comunidad', 'registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                              <option value="nombre">Nombre</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarComunidad(1,buscar,criterio)" class="form-control" placeholder="Comunidad a buscar">
                            <button type="submit" @click="listarComunidad(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Municipio</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="comunidades in arrayComunidad" :key="comunidades.id">
                            <td>
                                <button type="button" @click="abrirModal('comunidad', 'actualizar', comunidades)" class="btn btn-warning btn-sm">
                                  <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <template v-if="comunidades.condicion">
                                    <button type="button" class="btn btn-danger btn-sm" @click="desactivarComunidad(comunidades.id)">
                                     <i class="icon-trash"></i>
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-info btn-sm" @click="activarComunidad(comunidades.id)">
                                     <i class="icon-check"></i>
                                    </button>
                                </template>
                            </td>
                            <td v-text="comunidades.nombre"></td>
                            <td v-text="comunidades.nombre_municipio"></td>
                            <td>
                                <div v-if="comunidades.condicion=='1'">
                                    <span class="badge badge-success">Activo</span>
                                </div>
                                <div v-else>
                                    <span class="badge badge-danger">Inactivo</span>
                                </div>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
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
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                            <div class="col-md-9">
                                <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de Comunidad">
                            </div>
                        </div>
                        <div v-show="errorComunidad" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjComunidad" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarComunidad()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarComunidad()">Actualizar</button>
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
                id: 0,
                nombre : '',
                idmunicipio:0,
                arrayComunidad : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorComunidad: 0,
                errorMostrarMsjComunidad : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : '',
                arrayMunicipio:[]
            }
        },
        computed : {
            isActived: function(){
                return this.pagination.current_page;
            },
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return []
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods : {
            listarComunidad(page,buscar,criterio){
                let me=this;
                var url = '/comunidad?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayComunidad = respuesta.comunidades.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error){
                    console.log(error);
                });
            },
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
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la pagina
                me.pagination.current_page = page;
                //Peticion para ver la pagina
                me.listarComunidad(page,buscar,criterio);
            },
            registrarComunidad(){
                if(this.validarComunidad()){
                    return;
                }

                let me = this;
                axios.post('/comunidad/registrar',{
                    'idmunicipio':this.idmunicipio,
                    'nombre': this.nombre,

                }).then(function (response) {
                    me.cerrarModal();
                    me.listarComunidad(1,'','nombre');
                }).catch(function (error){
                    console.log(error);
                });
            },
            actualizarComunidad(){
                if(this.validarComunidad()){
                    return;
                }

                let me = this;
                axios.put('/comunidad/actualizar',{
                    'idmunicipio': this.idmunicipio,
                    'nombre': this.nombre,
                    'id': this.id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarComunidad(1,'','nombre');
                }).catch(function (error){
                    console.log(error);
                });
            },
            desactivarComunidad(id){
                swal.fire({
                title: 'Esta seguro de desactivar esta comunidad?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/comunidad/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarComunidad(1,'','nombre');
                        swal.fire(
                        'Desactivado!',
                        'La comunidad ha sido desactivada con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                     swal.fire(
                    'Accion cancelada',
                    'La comunidad sigue activa',
                    'error'
                    )
                }
                })
            },
            activarComunidad(id){
                const swalWithBootstrapButtons = swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                title: 'Esta seguro que desea activar esta comunidad?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                confirmButtonClass:'btn btn-success',
                confirmButtonClass:'btn btn-danger',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/comunidad/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarComunidad(1,'','nombre');
                    swalWithBootstrapButtons.fire(
                        'Activado',
                        'La comunidad ha a sido activada con exito.',
                        'success'
                    )
                    }).catch(function (error){
                        console.log(error);
                    });
               
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                 swal.fire(
                    'Accion cancelada',
                    'La comunidad sigue inactiva',
                    'error'
                    )
                    }
                })
            },
            validarComunidad(){
                this.errorComunidad=0;
                this.errorMostrarMsjComunidad=[];

                if(this.idmunicipio==0) this.errorMostrarMsjComunidad.push("Seleccione un municipio.");
                if(!this.nombre) this.errorMostrarMsjComunidad.push("El nombre de la comunidad no puede estar vacio.");

                if(this.errorMostrarMsjComunidad.length) this.errorComunidad=1;
                return this.errorComunidad;
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.idmunicipio=0;
                this.tipoAccion = 0;
                this.nombre = '';
                this.errorComunidad=0;
            },
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "comunidad":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Comunidad';
                                this.idmunicipio=0;
                                this.nombre = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar Comunidad';
                                this.tipoAccion=2;
                                this.id=data['id'];
                                this.idmunicipio=data['idmunicipio'];
                                this.nombre=data['nombre'];
                                break;
                            }
                        }
                    }
                }
                this.selectMunicipio();
            }
        },
        mounted() {
            this.listarComunidad(1,this.buscar,this.criterio);
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