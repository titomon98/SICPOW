<template>
     <!-- Contenido Principal -->
 <main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="#">Admin</a></li>
        <li class="breadcrumb-item active">Comunidad</li>
    </ol>
    <div class="container-fluid" >
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Comunidades
                <button type="button" @click="abrirModal('distrito', 'registrar')" class="btn btn-secondary">
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
                            <input type="text" v-model="buscar" @keyup.enter="listarDistrito(1,buscar,criterio)" class="form-control" placeholder="Comunidad a buscar">
                            <button type="submit" @click="listarDistrito(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Comunidad</th>
                            <th>Municipio</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="distritos in arrayDistrito" :key="distritos.id">
                            <td>
                                <button type="button" @click="abrirModal('distrito', 'actualizar', distritos)" class="btn btn-warning btn-sm">
                                  <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <template v-if="distritos.condicion">
                                    <button type="button" class="btn btn-danger btn-sm" @click="desactivarDistrito(distritos.id)">
                                     <i class="icon-trash"></i>
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-info btn-sm" @click="activarDistrito(distritos.id)">
                                     <i class="icon-check"></i>
                                    </button>
                                </template>
                            </td>
                            <td v-text="distritos.nombre"></td>
                            <td v-text="distritos.nombre_comunidad"></td>
                            <td v-text="distritos.nombre_municipio"></td>
                            <td>
                                <div v-if="distritos.condicion=='1'">
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
        <div class="modal-dialog  modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow: auto;">
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
                            <label class="col-md-3 form-control-label" for="text-input">Sede de Territorio</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idcomunidad">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="comunidad in arrayComunidad" :key="comunidad.id" :value="comunidad.id" v-text="comunidad.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Nombre comunidad</label>
                            <div class="col-md-9">
                                <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de comunidad">
                                
                            </div>
                        </div>
                        <div v-show="errorDistrito" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjDistrito" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarDistrito()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarDistrito()">Actualizar</button>
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
                idcomunidad:0,
                arrayDistrito : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorDistrito: 0,
                errorMostrarMsjComunidad:[],
                errorMostrarMsjDistrito : [],
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
                arrayComunidad:[],
                idmunicipio:0,
                arrayMunicipio:[],
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
            listarDistrito(page,buscar,criterio){
                let me=this;
                var url = '/distrito?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayDistrito = respuesta.distritos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error){
                    console.log(error);
                });
            },
            MunicipioS(){
                this.idmunicipio;
                this.selectComunidad();
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
            selectComunidad(){
                let me=this;
                var url = '/comunidad/selectComunidadD/'+this.idmunicipio+'/';
                axios.get(url).then(function(response){
                    var respuesta = response.data;
                    me.arrayComunidad = respuesta.comunidades;
                })

            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la pagina
                me.pagination.current_page = page;
                //Peticion para ver la pagina
                me.listarDistrito(page,buscar,criterio);
            },
            registrarDistrito(){
                if(this.validarDistrito()){
                    return;
                }

                let me = this;
                axios.post('/distrito/registrar',{
                    'idcomunidad':this.idcomunidad,
                    'nombre': this.nombre
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarDistrito(1,'','nombre');
                }).catch(function (error){
                    console.log(error);
                });
            },
            actualizarDistrito(){
                if(this.validarDistrito()){
                    return;
                }

                let me = this;
                axios.put('/distrito/actualizar',{
                    'idcomunidad':this.idcomunidad,
                    'nombre': this.nombre,
                    'id': this.id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarDistrito(1,'','nombre');
                }).catch(function (error){
                    console.log(error);
                });
            },
            desactivarDistrito(id){
                swal.fire({
                title: 'Esta seguro de desactivar esta comunidad',
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

                    axios.put('/distrito/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarDistrito(1,'','nombre');
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
            activarDistrito(id){
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
                cancelButtonClass:'btn btn-danger',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/distrito/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarDistrito(1,'','nombre');
                    swalWithBootstrapButtons.fire(
                        'Activado',
                        'La comunidad a sido activada con exito.',
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
            validarDistrito(){
                this.errorDistrito=0;
                this.errorMostrarMsjDistrito=[];

                if(this.idcomunidad==0) this.errorMostrarMsjComunidad.push("Seleccione una sede de territorio.");
                if(!this.nombre) this.errorMostrarMsjDistrito.push("El nombre de la comunidad no puede estar vacio.");

                if(this.errorMostrarMsjDistrito.length) this.errorDistrito=1;
                return this.errorDistrito;
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.idcomunidad=0;
                this.idmunicipio=0;
                this.tipoAccion = 0;
                this.nombre = '';
                this.errorDistrito=0;
                this.arrayComunidad=[];
                
            },
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "distrito":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar comunidad';
                                this.idcomunidad=0;
                                this.idmunicipio=0;
                                this.nombre = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar comunidad';
                                this.tipoAccion=2;
                                this.id=data['id'];
                                this.idmunicipio=data['idmunicipio'];
                                this.idcomunidad=data['idcomunidad'];
                                this.nombre=data['nombre'];
                                break;
                            }
                        }
                    }
                }
                this.selectMunicipio();
                this.selectComunidad();
            }
        },
        mounted() {
            this.listarDistrito(1,this.buscar,this.criterio);
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
    .modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
}
</style>