<template>
     <!-- Contenido Principal -->
 <main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="#">Admin</a></li>
        <li class="breadcrumb-item active">Vivienda</li>
    </ol>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Viviendas
                <button type="button" @click="abrirModal('vivienda','registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" id="opcion" name="opcion">
                              <option value="numvivienda">Numero de Vivienda</option>
                              <option value="direccion">Direccion</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarVivienda(1,buscar,criterio)" class="form-control" placeholder="Vivienda a buscar">
                            <button type="submit" @click="listarVivienda(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Numero de Vivienda</th>
                            <th>Fecha Inicial</th>
                            <th>Fecha de Actualizacion</th>
                            <th>Direccion</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="viviendas in arrayVivienda" :key="viviendas.id">
                            <td>
                                <button type="button" @click="abrirModal('vivienda', 'actualizar', viviendas)" class="btn btn-warning btn-sm">
                                  <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <template v-if="viviendas.condicion">
                                    <button type="button" class="btn btn-danger btn-sm" @click="desactivarVivienda(viviendas.id)">
                                     <i class="icon-trash"></i>
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-info btn-sm" @click="activarVivienda(viviendas.id)">
                                     <i class="icon-check"></i>
                                    </button>
                                </template>
                            </td>
                            <td v-text="viviendas.numvivienda"></td>
                            <td v-text="viviendas.created_at"></td>
                            <td v-text="viviendas.updated_at"></td>
                            <td v-text="viviendas.direccion"></td>
                            <td>
                                <div v-if="viviendas.condicion=='1'">
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
                        <div class="form-group row modalrow">
                            <label class="col-md-3 form-control-label" for="text-input">Numero de Vivienda</label>
                            <div class="col-md-9">
                                <input type="number" v-model="numvivienda" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row modalrow">
                            <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                            <div class="col-md-9">
                                <input type="text" v-model="direccion" class="form-control" placeholder="Direccion de la Vivienda">
                            </div>
                        </div>
                        <div class="form-group row modalrow">
                            <label class="col-md-3 form-control-label" for="text-input">Tenencia de la Vivienda</label>
                            <div class="col-md-5">
                                <input type="radio" id="rd01" value="1" v-model="idtenencia" @click="habilitar('tbo01', false)"> <label for="rd01">Propia</label>
                                <input type="radio" id="rd02" value="2" v-model="idtenencia" @click="habilitar('tbo01', false)"> <label for="rd02">Alquila</label>
                                <input type="radio" id="rd03" value="3" v-model="idtenencia" @click="habilitar('tbo01', false)"> <label for="rd03">Prestada</label>
                                <input type="radio" id="rd04" value="4" v-model="idtenencia" @click="habilitar('tbo01', true)"> <label for="rd04">Otro</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="tbo01" v-model="otratenencia" class="form-control" placeholder="Tenencia" disabled>
                            </div>
                        </div>
                        <div class="form-group row modalrow">
                            <label class="col-md-3 form-control-label" for="text-input">Tipo Vivienda</label>
                            <div class="col-md-9">
                                <input type="radio" id="rd05" value="1" v-model="idtipovivienda"> <label for="rd05">Unifamiliar</label>
                                <input type="radio" id="rd06" value="2" v-model="idtipovivienda"> <label for="rd06">Multifamiliar</label>
                            </div>
                        </div>
                        <div class="form-group row modalrow">
                            <label class="col-md-3 form-control-label" for="text-input">Ambientes de la Vivienda</label>
                            <div class="col-md-9">
                                <input type="radio" id="rd07" value="1" v-model="idambiente"> <label for="rd07">Ambiente unico</label>
                                <input type="radio" id="rd08" value="2" v-model="idambiente"> <label for="rd08">Número de Ambientes Separados</label>
                                <input type="radio" id="rd09" value="3" v-model="idambiente"> <label for="rd09">Bodega</label>
                            </div>
                        </div>
                        <div class="form-group row modalrow">
                            <label class="col-md-3 form-control-label" for="text-input">Tipo de cocina</label>
                            <div class="col-md-9">
                                <label for="text-input">Dentro de la casa: </label>
                                <input type="radio" id="rd10" value="1" v-model="idcocina"> <label for="rd10">Estufa de gas</label>
                                <input type="radio" id="rd11" value="2" v-model="idcocina"> <label for="rd11">Estufa mejorada</label>
                                <input type="radio" id="rd12" value="3" v-model="idcocina"> <label for="rd12">Poyo</label>
                                <input type="radio" id="rd13" value="4" v-model="idcocina"> <label for="rd13">En el suelo</label>
                            </div>
                            <label class="col-md-3 form-control-label" for="text-input"></label>
                            <div class="col-md-9">
                                <label for="text-input">Fuera de la casa:</label>
                                <input type="radio" id="rd14" value="5" v-model="idcocina"> <label for="rd14">Estufa de gas</label>
                                <input type="radio" id="rd15" value="6" v-model="idcocina"> <label for="rd15">Estufa mejorada</label>
                                <input type="radio" id="rd16" value="7" v-model="idcocina"> <label for="rd16">Poyo</label>
                                <input type="radio" id="rd17" value="8" v-model="idcocina"> <label for="rd17">En el suelo</label>
                            </div>
                        </div>
                        <div class="form-group row modalrow">
                            <label class="col-md-3 form-control-label" for="text-input">Techo</label>
                            <div class="col-md-6">
                                <input type="radio" id="rd18" value="1" v-model="idtecho" @click="habilitar('tbo02', false)"> <label for="rd18">Cemento</label>
                                <input type="radio" id="rd19" value="2" v-model="idtecho" @click="habilitar('tbo02', false)"> <label for="rd19">Lámina</label>
                                <input type="radio" id="rd20" value="3" v-model="idtecho" @click="habilitar('tbo02', false)"> <label for="rd20">Teja</label>
                                <input type="radio" id="rd21" value="4" v-model="idtecho" @click="habilitar('tbo02', false)"> <label for="rd21">Palma</label>
                                <input type="radio" id="rd22" value="5" v-model="idtecho" @click="habilitar('tbo02', false)"> <label for="rd22">Paja</label>
                                <input type="radio" id="rd23" value="6" v-model="idtecho" @click="habilitar('tbo02', true)"> <label for="rd23">Otro</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="tbo02" v-model="otrotecho" class="form-control" placeholder="Techo que tiene" disabled>
                            </div>
                        </div>
                        <div class="form-group row modalrow">
                            <label class="col-md-3 form-control-label" for="text-input">Pared</label>
                            <div class="col-md-9">
                                <input type="radio" id="rd24" value="1" v-model="idpared" @click="habilitar('tbo03', false)"> <label for="rd24">Ladrillo</label>
                                <input type="radio" id="rd25" value="2" v-model="idpared" @click="habilitar('tbo03', false)"> <label for="rd25">Block</label>
                                <input type="radio" id="rd26" value="3" v-model="idpared" @click="habilitar('tbo03', false)"> <label for="rd26">Adobe</label>
                                <input type="radio" id="rd27" value="4" v-model="idpared" @click="habilitar('tbo03', false)"> <label for="rd27">Madera</label>
                                <input type="radio" id="rd28" value="5" v-model="idpared" @click="habilitar('tbo03', false)"> <label for="rd28">Bahareque</label>
                                <input type="radio" id="rd28" value="6" v-model="idpared" @click="habilitar('tbo03', false)"> <label for="rd28">Varas</label>
                                <input type="radio" id="rd29" value="7" v-model="idpared" @click="habilitar('tbo03', true)"> <label for="rd29">Otro</label>
                                <input type="text" id="tbo03" v-model="otrapared" class="form-control" placeholder="Pared que tiene" disabled>
                            </div>
                        </div>
                        <div class="form-group row modalrow">
                            <label class="col-md-3 form-control-label" for="text-input">Piso</label>
                            <div class="col-md-9">
                                <input type="radio" id="rd30" value="1" v-model="idpiso" @click="habilitar('tbo04', false)"> <label for="rd30">Granito</label>
                                <input type="radio" id="rd31" value="2" v-model="idpiso" @click="habilitar('tbo04', false)"> <label for="rd31">Cerámico</label>
                                <input type="radio" id="rd32" value="3" v-model="idpiso" @click="habilitar('tbo04', false)"> <label for="rd32">Cemento</label>
                                <input type="radio" id="rd33" value="4" v-model="idpiso" @click="habilitar('tbo04', false)"> <label for="rd33">Madera</label>
                                <input type="radio" id="rd34" value="5" v-model="idpiso" @click="habilitar('tbo04', false)"> <label for="rd34">Tierra</label>
                                <input type="radio" id="rd35" value="6" v-model="idpiso" @click="habilitar('tbo04', true)"> <label for="rd35">Otro</label>
                                <input type="text" id="tbo04" v-model="otropiso" class="form-control" placeholder="Piso que tiene" disabled>
                            </div>
                        </div>
                        <div class="form-group row modalrow">
                            <label class="col-md-3 form-control-label" for="text-input">Abastecimiento de Agua</label>
                            <div class="col-md-9">
                                <input type="radio" id="rd36" value="1" v-model="idaguaabast" @click="habilitar('tbo05', false)"> <label for="rd36">Chorro Propio</label>
                                <input type="radio" id="rd37" value="2" v-model="idaguaabast" @click="habilitar('tbo05', false)"> <label for="rd37">Pozo propio</label>
                                <input type="radio" id="rd38" value="3" v-model="idaguaabast" @click="habilitar('tbo05', false)"> <label for="rd38">Chorro Comunitario</label>
                                <input type="radio" id="rd39" value="4" v-model="idaguaabast" @click="habilitar('tbo05', false)"> <label for="rd39">Pozo Comunitario</label>
                                <input type="radio" id="rd40" value="5" v-model="idaguaabast" @click="habilitar('tbo05', false)"> <label for="rd40">Río</label>
                                <input type="radio" id="rd41" value="6" v-model="idaguaabast" @click="habilitar('tbo05', true)"> <label for="rd41">Otro</label>
                                <input type="text" id="tbo05" v-model="otroabastagua" class="form-control" placeholder="Abastecimiento que tiene" disabled>
                            </div>
                        </div>
                        <div class="form-group row modalrow">
                            <label class="col-md-3 form-control-label" for="text-input">Tratamiento de Aguas Servidas</label>
                            <div class="col-md-9">
                                <input type="radio" id="rd42" value="1" v-model="idaguatrat"> <label for="rd42">Drenaje/Alcantarillado</label>
                                <input type="radio" id="rd43" value="2" v-model="idaguatrat"> <label for="rd43">Fosa Séptica</label>
                                <input type="radio" id="rd44" value="3" v-model="idaguatrat"> <label for="rd44">Pozo/Sumidero</label>
                                <input type="radio" id="rd45" value="4" v-model="idaguatrat"> <label for="rd45">A flor de tierra</label>
                            </div>
                        </div>
                        <div class="form-group row modalrow">
                            <label class="col-md-3 form-control-label" for="text-input">Eliminación Final de Excretas</label>
                            <div class="col-md-9">
                                <input type="radio" id="rd46" value="1" v-model="ideliminexcretas" @click="habilitar('tbo06', false)"> <label for="rd46">Cantidad</label>
                                <input type="radio" id="rd47" value="2" v-model="ideliminexcretas" @click="habilitar('tbo06', false)"> <label for="rd47">En Uso</label>
                                <input type="radio" id="rd48" value="3" v-model="ideliminexcretas" @click="habilitar('tbo06', false)"> <label for="rd48">Mantenimiento</label>
                                <input type="radio" id="rd49" value="4" v-model="ideliminexcretas" @click="habilitar('tbo06', false)"> <label for="rd49">A flor de tierra</label>
                                <input type="radio" id="rd50" value="5" v-model="ideliminexcretas" @click="habilitar('tbo06', true)"> <label for="rd50">Otro</label>
                                <input type="text" id="tbo06" v-model="otroelimexcretas" class="form-control" placeholder="Eliminacion final que realiza" disabled>
                            </div>
                        </div>
                        <div class="form-group row modalrow">
                            <label class="col-md-3 form-control-label" for="text-input">Eliminación de Basura</label>
                            <div class="col-md-9">
                                <input type="radio" id="rd51" value="1" v-model="ideliminbasura" @click="habilitar('tbo07', false)"> <label for="rd51">Tren de aseo</label>
                                <input type="radio" id="rd52" value="2" v-model="ideliminbasura" @click="habilitar('tbo07', false)"> <label for="rd52">Clasifican</label>
                                <input type="radio" id="rd53" value="3" v-model="ideliminbasura" @click="habilitar('tbo07', false)"> <label for="rd53">Entierran</label>
                                <input type="radio" id="rd54" value="4" v-model="ideliminbasura" @click="habilitar('tbo07', false)"> <label for="rd54">Aire libre</label>
                                <input type="radio" id="rd55" value="5" v-model="ideliminbasura" @click="habilitar('tbo07', false)"> <label for="rd55">La Quema</label>
                                <input type="radio" id="rd56" value="6" v-model="ideliminbasura" @click="habilitar('tbo07', true)"> <label for="rd56">Otro</label>
                                <input type="text" id="tbo07" v-model="otroelimbasura" class="form-control" placeholder="Eliminacion de basura que realiza" disabled>
                            </div>
                        </div>
                        <div class="form-group row modalrow">
                            <label class="col-md-3 form-control-label" for="text-input">Ubicación de los Animales Domésticos</label>
                            <div class="col-md-9">
                                <input type="radio" id="rd57" value="1" v-model="idanimalubic"> <label for="rd57">Adecuado</label>
                                <input type="radio" id="rd58" value="2" v-model="idanimalubic"> <label for="rd58">Inadecuado</label>
                            </div>
                        </div>
                        <div class="form-group row modalrow">
                            <label class="col-md-3 form-control-label" for="text-input">Condiciones del lugar de los Animales Domésticos</label>
                            <div class="col-md-9">
                                <input type="radio" id="rd59" value="1" v-model="idanimalcondlugar"> <label for="rd59">Adecuado</label>
                                <input type="radio" id="rd60" value="2" v-model="idanimalcondlugar"> <label for="rd60">Inadecuado</label>
                            </div>
                        </div>
                        <div class="form-group row modalrow">
                            <label class="col-md-3 form-control-label" for="text-input">No. de Perros</label>
                            <div class="col-md-3">
                                <input type="number" v-model="perros" class="form-control" min="0">
                            </div>
                            <label class="col-md-3 form-control-label" for="text-input">No. de Gatos</label>
                            <div class="col-md-3">
                                <input type="number" v-model="gatos" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="form-group row modalrow">
                            <label class="col-md-3 form-control-label" for="text-input">Otra informacion relacionada</label>
                            <div class="col-md-5">
                                <input type="checkbox" id="cb1" value='true' v-model="electricidad"><label for="cb1">Energia electrica</label>
                                <input type="checkbox" id="cb2" value='true' v-model="telefonia"><label for="cb2">Señal de telefonia móvil</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" v-model="radio" class="form-control" placeholder="Emisora radial de mayor audiencia">
                            </div>
                        </div>
                        <div class="form-group row modalrow">
                            <label class="col-md-3 form-control-label" for="text-input">Otros servicios</label>
                            <div class="col-md-9">
                                <input type="text" v-model="otroservicios" class="form-control" placeholder="Otros servicios que poseen">
                            </div>
                        </div>
                        <div v-show="errorVivienda" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjVivienda" :key="error" v-text="error"></div>
                            </div> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal(), habilitar('', 'todos')">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarVivienda()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarVivienda()">Actualizar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
    <!-- Inicio del modal Eliminar -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-danger" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Eliminar Categoría</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Estas seguro de eliminar la categoría?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Fin del modal Eliminar -->
</main>
<!--Fin del contenido principal-->
</template>

<script>
    export default {
        data(){
            return {
                id : 0,
                numvivienda : 0,
                direccion : '',
                fecha : '',
                idtenencia : 0,
                idtipovivienda : 0,
                idambiente : 0,
                idcocina : 0,
                idtecho : 0,
                idpared : 0,
                idpiso : 0,
                idaguaabast : 0,
                idaguatrat : 0,
                ideliminexcretas : 0,
                ideliminbasura : 0,
                idanimalubic : 0,
                idanimalcondlugar : 0,
                perros : 0,
                gatos : 0,
                electricidad : 0,
                telefonia : 0,
                radio : '',
                otratenencia : '',
                otrotecho : '',
                otrapared : '',
                otropiso : '',
                otroabastagua : '',
                otroelimexcretas : '',
                otroelimbasura : '',
                otroservicios : '',
                created_at : '',
                updated_at : '',
                arrayVivienda : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorVivienda: 0,
                errorMostrarMsjVivienda : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'numvivienda',
                buscar : '',
                arrayTenencia : [],
                arrayTipovivienda : [],
                arrayAmbiente : [],
                arrayCocina : [],
                arrayTecho : [],
                arrayPared : [],
                arrayPiso : [],
                arrayAguaabast : [],
                arrayAguatrat : [],
                arrayEliminexcretas : [],
                arrayEliminbasura : [],
                arrayAnimalubic : [],
                arrayAnimalcondlugar : [],
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
            listarVivienda(page,buscar,criterio){
                let me=this;
                var url='/vivienda?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayVivienda = respuesta.viviendas.data;
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
                me.listarVivienda(page,buscar,criterio);
            },
            registrarVivienda(){
                if(this.validarVivienda()){
                    return;
                }

                let me = this;
                axios.post('/vivienda/registrar',{
                    'numvivienda':this.numvivienda,
                    'direccion':this.direccion,
                    'idtenencia':this.idtenencia,
                    'idtipovivienda':this.idtipovivienda,
                    'idambiente':this.idambiente,
                    'idcocina':this.idcocina,
                    'idtecho':this.idtecho,
                    'idpared':this.idpared,
                    'idpiso':this.idpiso,
                    'idaguaabast':this.idaguaabast,
                    'idaguatrat':this.idaguatrat,
                    'ideliminexcretas':this.ideliminexcretas,
                    'ideliminbasura':this.ideliminbasura,
                    'idanimalubic':this.idanimalubic,
                    'idanimalcondlugar':this.idanimalcondlugar,
                    'perros':this.perros,
                    'gatos':this.gatos,
                    'electricidad':this.electricidad,
                    'telefonia':this.telefonia,
                    'radio':this.radio,
                    'otratenencia':this.otratenencia,
                    'otrotecho':this.otrotecho,
                    'otrapared':this.otrapared,
                    'otropiso':this.otropiso,
                    'otroabastagua':this.otroabastagua,
                    'otroelimexcretas':this.otroelimexcretas,
                    'otroelimbasura':this.otroelimbasura,
                    'otroservicios':this.otroservicios,
                    'id': this.id,

                }).then(function (response) {
                    me.cerrarModal();
                    me.listarVivienda(1,'','numvivienda');
                    me.console.log(response.data);
                }).catch(function (error){
                    console.log(error);
                });
            },
            actualizarVivienda(){
                if(this.validarVivienda()){
                    return;
                }

                let me = this;
                axios.put('/vivienda/actualizar',{
                    'numvivienda':this.numvivienda,
                    'direccion':this.direccion,
                    'idtenencia':this.idtenencia,
                    'idtipovivienda':this.idtipovivienda,
                    'idambiente':this.idambiente,
                    'idcocina':this.idcocina,
                    'idtecho':this.idtecho,
                    'idpared':this.idpared,
                    'idpiso':this.idpiso,
                    'idaguaabast':this.idaguaabast,
                    'idaguatrat':this.idaguatrat,
                    'ideliminexcretas':this.ideliminexcretas,
                    'ideliminbasura':this.ideliminbasura,
                    'idanimalubic':this.idanimalubic,
                    'idanimalcondlugar':this.idanimalcondlugar,
                    'perros':this.perros,
                    'gatos':this.gatos,
                    'electricidad':this.electricidad,
                    'telefonia':this.telefonia,
                    'radio':this.radio,
                    'otratenencia':this.otratenencia,
                    'otrotecho':this.otrotecho,
                    'otrapared':this.otrapared,
                    'otropiso':this.otropiso,
                    'otroabastagua':this.otroabastagua,
                    'otroelimexcretas':this.otroelimexcretas,
                    'otroelimbasura':this.otroelimbasura,
                    'otroservicios':this.otroservicios,
                    'id':this.id,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarVivienda(1,'','numvivienda');
                }).catch(function (error){
                    console.log(error);
                });
            },
            desactivarVivienda(id){
                swal.fire({
                title: 'Esta seguro de desactivar esta vivienda?',
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

                    axios.put('/vivienda/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarVivienda(1,'','numvivienda');
                        swal.fire(
                        'Desactivado!',
                        'La vivienda ha sido desactivada con éxito.',
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
                    'La vivienda sigue activa',
                    'error'
                    )
                }
                })
            },
            activarVivienda(id){
                swal.fire({
                title: 'Esta seguro de activar esta Vivienda?',
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

                    axios.put('/vivienda/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarVivienda(1,'','numvivienda');
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
                    'La vivienda sigue inactiva',
                    'error'
                    )
                }
                })
            },
            validarVivienda(){
                this.errorVivienda=0;
                this.errorMostrarMsjVivienda=[];

                if(!this.numvivienda) this.errorMostrarMsjVivienda.push("El numero de la vivienda no puede estar vacio.");
                if(!this.direccion) this.errorMostrarMsjVivienda.push("La direccion de la vivienda no puede estar vacia.");
                if(this.idtenencia==0) this.errorMostrarMsjVivienda.push("Seleccione el tipo de tenencia de la vivienda.");
                if(this.idtipovivienda==0) this.errorMostrarMsjVivienda.push("Seleccione un tipo de la vivienda.");
                if(this.idambiente==0) this.errorMostrarMsjVivienda.push("Seleccione el tipo de ambiente de la vivienda.");
                if(this.idcocina==0) this.errorMostrarMsjVivienda.push("Seleccione el tipo de cocina de la vivienda.");
                if(this.idtecho==0) this.errorMostrarMsjVivienda.push("Seleccione el tipo de techo de la vivienda.");
                if(this.idpared==0) this.errorMostrarMsjVivienda.push("Seleccione el tipo de pared de la vivienda.");
                if(this.idpiso==0) this.errorMostrarMsjVivienda.push("Seleccione el tipo de piso de la vivienda.");
                if(this.idaguaabast==0) this.errorMostrarMsjVivienda.push("Seleccione el tipo de abastecimiento de agua.");
                if(this.idaguatrat==0) this.errorMostrarMsjVivienda.push("Seleccione el tipo de tratamiento de agua.");
                if(this.ideliminexcretas==0) this.errorMostrarMsjVivienda.push("Seleccione el tipo de eliminacion de excretas.");
                if(this.ideliminbasura==0) this.errorMostrarMsjVivienda.push("Seleccione el tipo de eliminacion de basura.");
                if(this.idanimalubic==0) this.errorMostrarMsjVivienda.push("Seleccione el tipo de ubicacion de la mascota/s.");
                if(this.idanimalcondlugar==0) this.errorMostrarMsjVivienda.push("Seleccione la condicion del lugar de la mascota/s.");
                if((this.idtenencia==4)&&(!this.otratenencia)) this.errorMostrarMsjVivienda.push("Especifique la tenencia de la vivienda.");
                if((this.idtecho==6)&&(!this.otrotecho)) this.errorMostrarMsjVivienda.push("Especifique la tipo de techo.");
                if((this.idpared==7)&&(!this.otrapared)) this.errorMostrarMsjVivienda.push("Especifique la tipo de pared.");
                if((this.idpiso==6)&&(!this.otropiso)) this.errorMostrarMsjVivienda.push("Especifique la tipo de piso.");
                if((this.idaguaabast==6)&&(!this.otroabastagua)) this.errorMostrarMsjVivienda.push("Especifique la tipo de abastecimiento de agua.");
                if((this.ideliminexcretas==5)&&(!this.otroelimexcretas)) this.errorMostrarMsjVivienda.push("Especifique la tipo de eliminacion de excretas.");
                if((this.ideliminbasura==6)&&(!this.otroelimbasura)) this.errorMostrarMsjVivienda.push("Especifique la tipo de eliminacion final de basura.");
                if(!this.perros) this.errorMostrarMsjVivienda.push("Para el numero de perros por lo menos debe colocar 0.");
                if(!this.gatos) this.errorMostrarMsjVivienda.push("Para el numero de gatos por lo menos debe colocar 0.");
                if(!this.radio) this.errorMostrarMsjVivienda.push("Debe colocar que emisora radial escucha.");
                if(!this.otroservicios) this.errorMostrarMsjVivienda.push("Para otros servicios, debe colocar por lo menos ninguno.");

                if(this.errorMostrarMsjVivienda.length) this.errorVivienda=1;
                return this.errorVivienda;
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.numvivienda=0;
                this.fecha='';
                this.direccion='';
                this.idtenencia = 0,
                this.idtipovivienda = 0,
                this.idambiente = 0,
                this.idcocina = 0,
                this.idtecho = 0,
                this.idpared = 0,
                this.idpiso = 0,
                this.idaguaabast = 0,
                this.idaguatrat = 0,
                this.ideliminexcretas = 0,
                this.ideliminbasura = 0,
                this.idanimalubic = 0,
                this.idanimalcondlugar = 0,
                this.perros = 0,
                this.gatos = 0,
                this.electricidad = 0,
                this.telefonia = 0,
                this.radio = '',
                this.otratenencia = '',
                this.otrotecho = '',
                this.otrapared = '',
                this.otropiso = '',
                this.otroabastagua = '',
                this.otroelimexcretas = '',
                this.otroelimbasura = '',
                this.otroservicios = '',
                this.tipoAccion = 0;
                this.errorVivienda=0;
            },
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "vivienda":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Vivienda';
                                this.numvivienda=0;
                                this.fecha='';
                                this.direccion='';
                                this.idtenencia = 0,
                                this.idtipovivienda = 0,
                                this.idambiente = 0,
                                this.idcocina = 0,
                                this.idtecho = 0,
                                this.idpared = 0,
                                this.idpiso = 0,
                                this.idaguaabast = 0,
                                this.idaguatrat = 0,
                                this.ideliminexcretas = 0,
                                this.ideliminbasura = 0,
                                this.idanimalubic = 0,
                                this.idanimalcondlugar = 0,
                                this.perros = 0,
                                this.gatos = 0,
                                this.electricidad = 0,
                                this.telefonia = 0,
                                this.radio = '',
                                this.otratenencia = '',
                                this.otrotecho = '',
                                this.otrapared = '',
                                this.otropiso = '',
                                this.otroabastagua = '',
                                this.otroelimexcretas = '',
                                this.otroelimbasura = '',
                                this.otroservicios = '',
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar Comunidad';
                                this.tipoAccion=2;
                                this.id=data['id'];
                                this.numvivienda=data['numvivienda'];
                                this.fecha=data['fecha'];
                                this.direccion=data['direccion'];
                                this.idtenencia=data['tenencia'];
                                this.idtipovivienda=data['tipovivienda'];
                                this.idambiente=data['ambiente'];
                                this.idcocina=data['cocina'];
                                this.idtecho=data['techo'];
                                this.idpared=data['pared'];
                                this.idpiso=data['piso'];
                                this.idaguaabast=data['aguaabastecimiento'];
                                this.idaguatrat=data['aguatrat'];
                                this.ideliminexcretas=data['eliminexcretas'];
                                this.ideliminbasura=data['eliminbasura'];
                                this.idanimalubic=data['animalubic'];
                                this.idanimalcondlugar=data['animalcondlugar'];
                                this.perros=data['perros'];
                                this.gatos=data['gatos'];
                                this.electricidad=data['electricidad'];
                                this.telefonia=data['telefonia'];
                                this.radio=data['radio'];
                                this.otratenencia=data['otratenencia'];
                                this.otrotecho=data['otrotecho'];
                                this.otrapared=data['otrapared'];
                                this.otropiso=data['otropiso'];
                                this.otroabastagua=data['otroabastagua'];
                                this.otroelimexcretas=data['otroelimexcretas'];
                                this.otroelimbasura=data['otroelimbasura'];
                                this.otroservicios=data['otroservicios'];
                                break;
                            }
                        }
                    }
                }
            },
            habilitar(tbid, habil){
                if(habil == true){
                    document.getElementById(tbid).disabled = false;
                }else if (habil == false){
                    document.getElementById(tbid).value = '';
                    document.getElementById(tbid).disabled = true;
                }else if (habil == 'todos'){
                    document.getElementById("tbo01").disabled = true;
                    document.getElementById("tbo02").disabled = true;
                    document.getElementById("tbo03").disabled = true;
                    document.getElementById("tbo04").disabled = true;
                    document.getElementById("tbo05").disabled = true;
                    document.getElementById("tbo06").disabled = true;
                    document.getElementById("tbo07").disabled = true;
                }              
            }
        },
        mounted() {
            this.listarVivienda(1,this.buscar,this.criterio);
        },
        
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

    /*div.modalrow{
        border-top-style: solid;
        border-top-color: #b0c9f8;
    }*/
</style>