<template>
     <!-- Contenido Principal -->
 <main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="#">Admin</a></li>
        <li class="breadcrumb-item active">Usuario</li>
    </ol>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Usuarios
                <button type="button" @click="abrirModal('usuario', 'registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                              <option value="nombre">Nombre</option>
                              <option value="CUI">CUI</option>
                              <option value="correo">Correo</option>
                              <option value="telefono">Telefono</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarUsuario(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="listarUsuario(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>CUI</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Direccion</th>
                            <th>Telefono</th>
                            <th>Rol</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="usuarios in arrayUsuario" :key="usuarios.id">
                            <td>
                                <button type="button" @click="abrirModal('usuario', 'actualizar', usuarios)" class="btn btn-warning btn-sm">
                                  <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <template v-if="usuarios.condicion">
                                    <button type="button" class="btn btn-danger btn-sm" @click="desactivarUsuario(usuarios.id)">
                                     <i class="icon-trash"></i>
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-info btn-sm" @click="activarUsuario(usuarios.id)">
                                     <i class="icon-check"></i>
                                    </button>
                                </template>
                            </td>
                            <td v-text="usuarios.CUI"></td>
                            <td v-text="usuarios.nombre"></td>
                            <td v-text="usuarios.correo"></td>
                            <td v-text="usuarios.direccion"></td>
                            <td v-text="usuarios.telefono"></td>
                            <td v-text="usuarios.nombre_rol"></td>
                            <td>
                                <div v-if="usuarios.condicion=='1'">
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
                            <label class="col-md-3 form-control-label" for="text-input">CUI</label>
                            <div class="col-md-9">
                                <input type="text" v-model="CUI" class="form-control" placeholder="CUI de la persona">
                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                            <div class="col-md-9">
                                <input type="text" v-model="nombre" class="form-control" placeholder="Nombre completo de la persona">
                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Email</label>
                            <div class="col-md-9">
                                <input type="text" v-model="correo" class="form-control" placeholder="Correo electronico de la persona">
                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Contraseña</label>
                            <div class="col-md-9">
                                <input type="password" v-model="password" class="form-control" placeholder="Contraseña de acceso">
                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Rol</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idrol">
                                    <option value="0">Seleccione un rol</option>
                                    <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id" v-text="rol.nombre"></option>
                                </select>             
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                            <div class="col-md-9">
                                <input type="text" v-model="direccion" class="form-control" placeholder="Direccion de la persona">
                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Telefono</label>
                            <div class="col-md-9">
                                <input type="text" v-model="telefono" class="form-control" placeholder="Telefono de la persona">
                                
                            </div>
                        </div>
                        <div v-show="errorUsuario" class="form-group row div-error">
                            <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjUsuario" :key="error" v-text="error">

                            </div>
                            </div> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarUsuario()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarUsuario()">Actualizar</button>
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
                correo : '',
                password : '',
                direccion : '',
                CUI : '',
                telefono : '',
                idrol : 0,           
                arrayUsuario : [],
                arrayRol : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorUsuario: 0,
                errorMostrarMsjUsuario : [],
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
            listarUsuario(page,buscar,criterio){
                let me=this;
                var url = '/usuario?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayUsuario = respuesta.usuarios.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error){
                    console.log(error);
                });
            },
            selectRol(){
                let me=this;
                var url = '/rol/selectRol';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayRol = respuesta.roles;
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
                me.listarUsuario(page,buscar,criterio);
            },
            registrarUsuario(){
                if(this.validarUsuario()){
                    return;
                }

                let me = this;
                axios.post('/usuario/registrar',{
                    'CUI': this.CUI,
                    'nombre': this.nombre,
                    'correo': this.correo,
                    'password' : this.password,
                    'idrol' : this.idrol,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarUsuario(1,'','nombre');
                }).catch(function (error){
                    console.log(error);
                });
            },
            actualizarUsuario(){
                if(this.validarUsuario()){
                    return;
                }

                let me = this;
                axios.put('/usuario/actualizar',{
                    'CUI' : this.CUI,
                    'nombre': this.nombre,
                    'correo' : this.correo,
                    'password' : this.password,
                    'idrol' : this.idrol,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'id': this.id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarUsuario(1,'','nombre');
                }).catch(function (error){
                    console.log(error);
                });
            },
            desactivarUsuario(id){
                swal.fire({
                title: 'Esta seguro de desactivar este usuario?',
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

                    axios.put('/usuario/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarUsuario(1,'','nombre');
                        swal.fire(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
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
                    'El usuario sigue activo',
                    'error'
                    )
                }
                })
            },
            activarUsuario(id){
                swal.fire({
                title: 'Esta seguro de activar este usuario?',
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

                    axios.put('/usuario/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarUsuario(1,'','nombre');
                        swal.fire(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
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
                    'El usuario sigue inactivo',
                    'error'
                    )
                }
                })
            },
            validarUsuario(){
                this.errorUsuario=0;
                this.errorMostrarMsjUsuario=[];

                if(!this.CUI) this.errorMostrarMsjUsuario.push("El CUI de la persona no puede estar vacio.");
                if(!this.nombre) this.errorMostrarMsjUsuario.push("El nombre completo de la persona no puede estar vacio.");
                if(!this.correo) this.errorMostrarMsjUsuario.push("El correo de la persona no puede estar vacio.");
                if(!this.password) this.errorMostrarMsjUsuario.push("La contraseña del usuario no puede estar vacio.");
                if(this.idrol == 0) this.errorMostrarMsjUsuario.push("Debe elegir un rol para el usuario");
                if(!this.direccion) this.errorMostrarMsjUsuario.push("La direccion de la persona no puede estar vacia.");
                if(!this.telefono) this.errorMostrarMsjUsuario.push("El telefono de la persona no puede estar vacia.");

                if(this.errorMostrarMsjUsuario.length) this.errorUsuario=1;
                return this.errorUsuario;
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.tipoAccion = 0;
                this.CUI = '';
                this.nombre = '';
                this.correo = '';
                this.password = '';
                this.idrol = 0; 
                this.direccion = '';
                this.telefono = '';
                this.errorUsuario=0;
            },
            abrirModal(modelo, accion, data=[]){
                this.selectRol();
                switch(modelo){
                    case "usuario":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Usuario';
                                this.CUI = '';
                                this.nombre = '';
                                this.correo = '';
                                this.password = '';
                                this.direccion = '';
                                this.telefono = '';
                                this.idrol = 0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar Usuario';
                                this.tipoAccion=2;
                                this.id=data['id'];
                                this.CUI=data['CUI'];
                                this.nombre=data['nombre'];
                                this.correo=data['correo'];
                                this.password=data['password'];
                                this.direccion=data['direccion'];
                                this.telefono=data['telefono'];
                                this.idrol=data['idrol'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarUsuario(1,this.buscar,this.criterio);
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