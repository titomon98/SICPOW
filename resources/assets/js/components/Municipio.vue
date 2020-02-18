<template>
     <!-- Contenido Principal -->
 <main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="#">Admin</a></li>
        <li class="breadcrumb-item active">Municipio</li>
    </ol>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Municipios
                <button type="button" @click="abrirModal('municipio', 'registrar')" class="btn btn-secondary">
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
                            <input type="text" v-model="buscar" @keyup.enter="listarMunicipio(1,buscar,criterio)" class="form-control" placeholder="Municipio a buscar">
                            <button type="submit" @click="listarMunicipio(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="municipios in arrayMunicipio" :key="municipios.id">
                            <td>
                                <button type="button" @click="abrirModal('municipio', 'actualizar', municipios)" class="btn btn-warning btn-sm">
                                  <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <template v-if="municipios.condicion">
                                    <button type="button" class="btn btn-danger btn-sm" @click="desactivarmunicipio(municipios.id)">
                                     <i class="icon-trash"></i>
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-info btn-sm" @click="activarmunicipio(municipios.id)">
                                     <i class="icon-check"></i>
                                    </button>
                                </template>
                            </td>
                            <td v-text="municipios.nombre"></td>
                            <td>
                                <div v-if="municipios.condicion=='1'">
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
                            <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                            <div class="col-md-9">
                                <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de municipio">
                                
                            </div>
                        </div>
                        <div v-show="errorMunicipio" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjMunicipio" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarMunicipio()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarMunicipio()">Actualizar</button>
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
                municipio_id: 0,
                nombre : '',
                arrayMunicipio : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorMunicipio: 0,
                errorMostrarMsjMunicipio : [],
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
                controlingreso:0,
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
            listarMunicipio(page,buscar,criterio){
                this.controlingreso=0; 
                let me=this;
                var url = '/municipio?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayMunicipio = respuesta.municipios.data;
                    me.pagination = respuesta.pagination;
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
                me.listarMunicipio(page,buscar,criterio);
            },
            registrarMunicipio(){
                
                if (!this.validarMunicipio())
                {
                    this.controlingreso++;
                    if(this.controlingreso==1){
                        let me = this;
                        axios.post('/municipio/registrar',{
                            'nombre': this.nombre
                        }).then(function (response) {
                            me.cerrarModal();
                            me.listarMunicipio(1,'','nombre');
                        }).catch(function (error){
                            console.log(error);
                        });
                    }
                    
                    
                }
                else if (this.controlingreso == 3)
                {
                    console.log("Arturo, Rodolfo, Ischiu, Julio e Isra les desean lo mejor en sus arduas labores");
                }
            },
            actualizarMunicipio(){
                if(this.validarMunicipio()){
                    return;
                }

                let me = this;
                axios.put('/municipio/actualizar',{
                    'nombre': this.nombre,
                    'id': this.municipio_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarMunicipio(1,'','nombre');
                }).catch(function (error){
                    console.log(error);
                });
            },
            desactivarmunicipio(id){
                swal.fire({
                title: 'Esta seguro de desactivar este municipio?',
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

                    axios.put('/municipio/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarMunicipio(1,'','nombre');
                        swal.fire(
                        'Desactivado!',
                        'El municipio ha sido desactivado con éxito.',
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
                    'El municipio sigue activo',
                    'error'
                    )
                }
                })
            },
            activarmunicipio(id){
                swal.fire({
                title: 'Esta seguro de activar este municipio?',
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

                    axios.put('/municipio/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarMunicipio(1,'','nombre');
                        swal.fire(
                        'Activado!',
                        'El municipio ha sido activado con éxito.',
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
                    'El municipio sigue inactivo',
                    'error'
                    )
                }
                })
            },
            validarMunicipio(){
                this.errorMunicipio=0;
                this.errorMostrarMsjMunicipio=[];

                if(!this.nombre) this.errorMostrarMsjMunicipio.push("El nombre del Municipio no puede estar vacio.");

                if(this.errorMostrarMsjMunicipio.length) this.errorMunicipio=1;
                return this.errorMunicipio;
            },

            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.tipoAccion = 0;
                this.nombre = '';
            },
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "municipio":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Municipio';
                                this.nombre = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar Municipio';
                                this.tipoAccion=2;
                                this.municipio_id=data['id'];
                                this.nombre=data['nombre'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarMunicipio(1,this.buscar,this.criterio);
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