<template>
        <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/main">Escritorio</a></li>
            </ol>

            <!-- Inicio de Vivienda -->
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
                                    <input type="text" v-model="buscar_viv" @keyup.enter="listarVivienda(1,buscar_viv,criterio_viv)" class="form-control" placeholder="Vivienda a buscar">
                                    <button type="submit" @click="listarVivienda(1,buscar_viv,criterio_viv)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
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
                                <tr v-for="viviendas in arrayVivienda1" :key="viviendas.id">
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
                                <li class="page-item" v-if="pagination_viv.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina_viv(pagination_viv.current_page - 1,buscar_viv,criterio_viv)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber_viv" :key="page" :class="[page == isActived_viv ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina_viv(page,buscar_viv,criterio_viv)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination_viv.current_page < pagination_viv.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina_viv(pagination_viv.current_page + 1,buscar_viv,criterio_viv)">Sig</a>
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
                                        <input type="number" v-model="numvivienda" class="form-control" min="0">
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
            <!-- Fin de Vivienda -->

            <!-- Inicio de Familia -->
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Familias
                        <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <!-- Listado -->
                    <template v-if="listado==1">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio_fam">
                                        <option value="num_familia">Número de Familia</option>
                                        <option value="num_vivienda">Numero de Vivienda</option>
                                        </select>
                                        <input type="text" v-model="buscar_fam" @keyup.enter="listarFamilia(1,buscar_fam,criterio_fam)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarFamilia(1,buscar_fam,criterio_fam)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Numero de Familia</th>                                        
                                            <th>Numero de Vivienda</th>
                                            <th>Lider de Familia</th>
                                            <th>Sector</th>
                                            <th>Ubicacion</th>
                                            <th>Dirección</th>
                                            <th>Fecha Inicial</th>
                                            <th>Fecha de Actualizacion</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayFamilia.length">
                                        <tr v-for="familia in arrayFamilia" :key="familia.id">
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm" @click="editarFamilia(familia.id)">
                                                <i class="icon-pencil"></i>
                                                </button> &nbsp;
                                                <template v-if="familia.condicion">
                                                    <button type="button" class="btn btn-danger btn-sm" @click="desactivarFamilia(familia.id)">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                </template>
                                                <template v-else>
                                                    <button type="button" class="btn btn-info btn-sm" @click="activarFamilia(familia.id)">
                                                        <i class="icon-check"></i>
                                                    </button>
                                                </template>
                                            </td>
                                            <td v-text="familia.num_familia"></td>
                                            <td v-text="familia.num_vivienda"></td>
                                            <td v-text="familia.CUI + ', ' + familia.nombres + ' ' + familia.apellidos"></td>
                                            <td v-text="familia.sector"></td>
                                            <td v-text="familia.ubicacion1 + ', ' + familia.ubicacion2 + ', ' + familia.ubicacion3"></td>
                                            <td v-text="familia.direccion"></td>
                                            <td v-text="familia.fecha_inicial"></td>
                                            <td v-text="familia.updated_at"></td> 
                                            <td>
                                                <div v-if="familia.condicion=='1'">
                                                    <span class="badge badge-success">Activo</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-danger">Inactivo</span>
                                                </div>
                                            </td>
                                        </tr>                                
                                    </tbody>
                                </table>
                            </div>
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" v-if="pagination_fam.current_page > 1">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina_fam(pagination_fam.current_page - 1,buscar_fam,criterio_fam)">Ant</a>
                                    </li>
                                    <li class="page-item" v-for="page in pagesNumber_fam" :key="page" :class="[page == isActived_fam ? 'active' : '']">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina_fam(page,buscar_fam,criterio_fam)" v-text="page"></a>
                                    </li>
                                    <li class="page-item" v-if="pagination_fam.current_page < pagination_fam.last_page">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina_fam(pagination_fam.current_page + 1,buscar_fam,criterio_fam)">Sig</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </template>
                    <!-- Fin listado -->
                    <!-- Detalle ingresar -->
                    <template v-else-if="listado==0">
                        <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-3">
                                    <label for="">Numero familia</label>
                                    <input type="number" min="0" class="form-control" v-model="num_familia">
                                </div>
                                <div class="col-md-3">
                                    <label for="">Municipio</label>
                                    <select class="form-control" v-model="municipio_id">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="municipios in arrayMunicipio" :key="municipios.id" :value="municipios.id" v-text="municipios.nombre"></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Comunidad</label>
                                    <select class="form-control" v-model="comunidad_id">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="comunidades in arrayComunidad" :key="comunidades.id" :value="comunidades.id" v-text="comunidades.nombre"></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Distrito</label>
                                    <select class="form-control" v-model="distrito_id">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="distritos in arrayDistrito" :key="distritos.id" :value="distritos.id" v-text="distritos.nombre_distrito"></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Area de Salud</label>
                                    <select class="form-control" v-model="entidad_salud_id">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="entidades in arrayEntidad" :key="entidades.id" :value="entidades.id" v-text="entidades.nombre">Puesto de salud</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Sector</label>
                                    <input type="text" class="form-control" v-model="sector">
                                </div>
                                <div class="col-md-3">
                                    <label for="">Numero de Vivienda</label>
                                    <select class="form-control" id="sel03" v-model="detalle_vivienda_id">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="viviendas in arrayVivienda2" :key="viviendas.id" :value="viviendas.id" v-text="viviendas.numvivienda"></option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <div v-show="errorFamilia" class="form-group row div-error">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjFamilia" :key="error" v-text="error"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row border">
                                <div class="col-md-12">
                                    <div class="form-group col-md-9">
                                        <label>Nombres: <span style="color:red;" v-show="!nombres">(*Ingrese)</span></label>
                                        <input type="text" class="form-control" v-model="nombres">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>Apellidos: <span style="color:red;" v-show="!apellidos">(*Ingrese)</span></label>
                                        <input type="text" class="form-control" v-model="apellidos">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>Apellido de casada:</label>
                                        <input type="text" class="form-control" v-model="apellido_casada">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>Sexo: </label>
                                        <input type="checkbox" id="cb4" value='true' v-model="sexo">
                                        <label v-if="sexo=='1'" for="cb4">Hombre</label>
                                        <label v-else for="cb4">Mujer</label>
                                        <span style="color:orange;">(* Chequee si es hombre, sin chequear si es mujer)</span>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>Fecha de Nacimiento: <span style="color:red;" v-show="!nacimiento">(*Ingrese)</span></label>
                                        <input type="date" class="form-control" v-model="nacimiento">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>CUI: <span style="color:red;" v-show="!CUI">(*Ingrese)</span></label>
                                        <input type="text" class="form-control" v-model="CUI">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="cb5">Lider de Familia</label>
                                        <input type="checkbox" id="cb5" value='true' v-model="lider">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="">Puesto de Comunidad:</label>
                                        <select class="form-control" v-model="puesto_comunidad_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="puestocoms in arrayPuestoCom" :key="puestocoms.id" :value="puestocoms.id" v-text="puestocoms.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="">Parentesco: <span style="color:red;" v-show="parentesco_id==0">(*Seleccione)</span></label>
                                        <select class="form-control" v-model="parentesco_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="parentescos in arrayParentesco" :key="parentescos.id" :value="parentescos.id" v-text="parentescos.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="">Pueblo: <span style="color:red;" v-show="pueblo_id==0">(*Seleccione)</span></label>
                                        <select class="form-control" v-model="pueblo_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="pueblos in arrayPueblo" :key="pueblos.id" :value="pueblos.id" v-text="pueblos.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="">Comunidad Linguistica: <span style="color:red;" v-show="comlinguistica_id==0">(*Seleccione)</span></label>
                                        <select class="form-control" v-model="comlinguistica_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="comlinguisticas in arrayComlinguistica" :key="comlinguisticas.id" :value="comlinguisticas.id" v-text="comlinguisticas.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="cb6">Alfabetismo:</label>
                                        <input type="checkbox" id="cb6" value='true' v-model="alfabetismo">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="">Escolaridad: <span style="color:red;" v-show="escolaridad_id==0">(*Seleccione)</span></label>
                                        <select class="form-control" v-model="escolaridad_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="escolaridades in arrayEscolaridad" :key="escolaridades.id" :value="escolaridades.id" v-text="escolaridades.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="">Discapacidad: <span style="color:red;" v-show="discapacidad_id==0">(*Seleccione)</span></label>
                                        <select class="form-control" v-model="discapacidad_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="discapacidades in arrayDiscapacidad" :key="discapacidades.id" :value="discapacidades.id" v-text="discapacidades.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="">Ocupacion: <span style="color:red;" v-show="ocupacion_id==0">(*Seleccione)</span></label>
                                        <select class="form-control" v-model="ocupacion_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="ocupaciones in arrayOcupacion" :key="ocupaciones.id" :value="ocupaciones.id" v-text="ocupaciones.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="cb7">Migracion:</label>
                                        <input type="checkbox" id="cb7" value='true' v-model="migracion" @click="habilitarmig(!migracion)">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="">Permanencia de Migracion:</label>
                                        <select class="form-control" id="sel01" v-model="permanencia_id" disabled>
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="permanencias in arrayPermanencia" :key="permanencias.id" :value="permanencias.id" v-text="permanencias.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>Comunidad de Migracion:</label>
                                        <input type="text" id="tx01" class="form-control" v-model="commigracion" disabled>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>Municipio de Migracion:</label>
                                        <input type="text" id="tx02" class="form-control" v-model="munmigracion" disabled>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>Departamento de Migracion:</label>
                                        <input type="text" id="tx03" class="form-control" v-model="depmigracion" disabled>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="">Pais de Migracion:</label>
                                        <select class="form-control" id="sel02" v-model="pais_id" disabled>
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="paises in arrayPais" :key="paises.id" :value="paises.id" v-text="paises.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="cb8">Mortalidad:</label>
                                        <input type="checkbox" id="cb8" value='true' v-model="mortalidad" @click="habilitar('inf01', !mortalidad)">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>Fecha de mortalidad:</label>
                                        <input type="date" id="inf01" class="form-control" v-model="fechamortalidad" disabled>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar"><i class="icon-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row border" style="direction: ltr; height: 250px; overflow: scroll;">
                                <div class="table-responsive col-md-12">
                                    <table class="table table-bordered table_stripered trable-sm" >
                                        <thead>
                                            <th>Opciones</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Apellido de Casada</th>
                                            <th>Sexo</th>
                                            <th>Fecha de Nacimiento</th>
                                            <th>Edad</th>
                                            <th>CUI</th>
                                            <th>Lider</th>
                                            <th>Puesto Comunidad</th>
                                            <th>Parentesco</th>
                                            <th>Pueblos</th>
                                            <th>Comunidad Linguistica</th>
                                            <th>Alfabetismo</th>
                                            <th>Escolaridad</th>
                                            <th>Discapacidad</th>
                                            <th>Ocupacion</th>
                                            <th>Migracion</th>
                                            <th>Permanencia de Migracion</th>
                                            <th>Comunidad de Migracion</th>
                                            <th>Municipio de Migracion</th>
                                            <th>Departamento de Migracion</th>
                                            <th>Pais de Migracion</th>
                                            <th>Mortalidad</th>
                                            <th>Fecha Fallecimiento</th>
                                        </thead>
                                        <tbody v-if="arrayDetalle.length">
                                            <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                                <td><button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm"><i class="icon-close"></i></button></td>
                                                <td v-text="detalle.nombres"></td>
                                                <td v-text="detalle.apellidos"></td>
                                                <td v-text="detalle.apellido_casada"></td>
                                                <td><div v-if="detalle.sexo=='0'">Mujer</div><div v-if="detalle.sexo=='1'">Hombre</div></td>
                                                <td v-text="detalle.nacimiento"></td>
                                                <td v-text="detalle.edad"></td>
                                                <td v-text="detalle.CUI"></td>
                                                <td><div v-if="detalle.lider=='0'">Falso</div><div v-if="detalle.lider=='1'">Verdadero</div></td>
                                                <td v-text="detalle.puestocom_nombre"></td>
                                                <td v-text="detalle.parentesco_nombre"></td>
                                                <td v-text="detalle.pueblo_nombre"></td>
                                                <td v-text="detalle.comlinguistica_nombre"></td>
                                                <td><div v-if="detalle.alfabetismo=='0'">Falso</div><div v-if="detalle.alfabetismo=='1'">Es analfabeta</div></td>
                                                <td v-text="detalle.escolaridad_nombre"></td>
                                                <td v-text="detalle.discapacidad_nombre"></td>
                                                <td v-text="detalle.ocupacion_nombre"></td>
                                                <td><div v-if="detalle.migracion=='0'">No ha viajado</div><div v-if="detalle.migracion=='1'">Ha viajado</div></td>
                                                <td v-text="detalle.permanencia_nombre"></td>
                                                <td v-text="detalle.commigracion"></td>
                                                <td v-text="detalle.munmigracion"></td>
                                                <td v-text="detalle.depmigracion"></td>
                                                <td v-text="detalle.pais_nombre"></td>
                                                <td><div v-if="detalle.mortalidad=='0'">Falso</div><div v-if="detalle.mortalidad=='1'">Ha fallecido</div></td>
                                                <td v-text="detalle.fechamortalidad"></td>
                                            </tr>
                                            <tr style="background-color: #CEECF5;">
                                                <td colspan="24" align="right"><strong>Total de Personas</strong></td>
                                                <td v-text="total_personas"></td>
                                            </tr> 
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="25">No hay personas agregadas</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-secondary" @click="ocultarDetalle()">Cerrar</button>
                                    <button type="button" class="btn btn-primary" @click="registrarFamilia()">Registrar Familia</button>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!-- Fin detalle ingresar-->
                    <!-- Detalle actualizar -->
                    <template v-else-if="listado==2">
                        <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-3">
                                    <label for="">Numero familia</label>
                                    <input type="number" min="0" class="form-control" v-model="num_familia">
                                </div>
                                <div class="col-md-3">
                                    <label for="">Municipio</label>
                                    <select class="form-control" v-model="municipio_id">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="municipios in arrayMunicipio" :key="municipios.id" :value="municipios.id" v-text="municipios.nombre"></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Comunidad</label>
                                    <select class="form-control" v-model="comunidad_id">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="comunidades in arrayComunidad" :key="comunidades.id" :value="comunidades.id" v-text="comunidades.nombre"></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Distrito</label>
                                    <select class="form-control" v-model="distrito_id">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="distritos in arrayDistrito" :key="distritos.id" :value="distritos.id" v-text="distritos.nombre_distrito"></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Area de Salud</label>
                                    <select class="form-control" v-model="entidad_salud_id">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="entidades in arrayEntidad" :key="entidades.id" :value="entidades.id" v-text="entidades.nombre">Puesto de salud</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Sector</label>
                                    <input type="text" class="form-control" v-model="sector">
                                </div>
                                <div class="col-md-3">
                                    <label for="">Numero de Vivienda</label>
                                    <select class="form-control" id="sel03" v-model="detalle_vivienda_id">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="viviendas in arrayVivienda2" :key="viviendas.id" :value="viviendas.id" v-text="viviendas.numvivienda"></option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <div v-show="errorFamilia" class="form-group row div-error">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjFamilia" :key="error" v-text="error"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row border">
                                <div class="col-md-12">
                                    <div class="form-group col-md-9">
                                        <label>Nombres: <span style="color:red;" v-show="!nombres">(*Ingrese)</span></label>
                                        <input type="text" class="form-control" v-model="nombres">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>Apellidos: <span style="color:red;" v-show="!apellidos">(*Ingrese)</span></label>
                                        <input type="text" class="form-control" v-model="apellidos">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>Apellido de casada:</label>
                                        <input type="text" class="form-control" v-model="apellido_casada">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>Sexo: </label>
                                        <input type="checkbox" id="cb4" value='true' v-model="sexo">
                                        <label v-if="sexo=='1'" for="cb4">Hombre</label>
                                        <label v-else for="cb4">Mujer</label>
                                        <span style="color:orange;">(* Chequee si es hombre, sin chequear si es mujer)</span>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>Fecha de Nacimiento: <span style="color:red;" v-show="!nacimiento">(*Ingrese)</span></label>
                                        <input type="date" class="form-control" v-model="nacimiento">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>CUI: <span style="color:red;" v-show="!CUI">(*Ingrese)</span></label>
                                        <input type="text" class="form-control" v-model="CUI">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="cb5">Lider de Familia</label>
                                        <input type="checkbox" id="cb5" value='true' v-model="lider">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="">Puesto de Comunidad:</label>
                                        <select class="form-control" v-model="puesto_comunidad_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="puestocoms in arrayPuestoCom" :key="puestocoms.id" :value="puestocoms.id" v-text="puestocoms.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="">Parentesco: <span style="color:red;" v-show="parentesco_id==0">(*Seleccione)</span></label>
                                        <select class="form-control" v-model="parentesco_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="parentescos in arrayParentesco" :key="parentescos.id" :value="parentescos.id" v-text="parentescos.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="">Pueblo: <span style="color:red;" v-show="pueblo_id==0">(*Seleccione)</span></label>
                                        <select class="form-control" v-model="pueblo_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="pueblos in arrayPueblo" :key="pueblos.id" :value="pueblos.id" v-text="pueblos.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="">Comunidad Linguistica: <span style="color:red;" v-show="comlinguistica_id==0">(*Seleccione)</span></label>
                                        <select class="form-control" v-model="comlinguistica_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="comlinguisticas in arrayComlinguistica" :key="comlinguisticas.id" :value="comlinguisticas.id" v-text="comlinguisticas.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="cb6">Alfabetismo:</label>
                                        <input type="checkbox" id="cb6" value='true' v-model="alfabetismo">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="">Escolaridad: <span style="color:red;" v-show="escolaridad_id==0">(*Seleccione)</span></label>
                                        <select class="form-control" v-model="escolaridad_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="escolaridades in arrayEscolaridad" :key="escolaridades.id" :value="escolaridades.id" v-text="escolaridades.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="">Discapacidad: <span style="color:red;" v-show="discapacidad_id==0">(*Seleccione)</span></label>
                                        <select class="form-control" v-model="discapacidad_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="discapacidades in arrayDiscapacidad" :key="discapacidades.id" :value="discapacidades.id" v-text="discapacidades.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="">Ocupacion: <span style="color:red;" v-show="ocupacion_id==0">(*Seleccione)</span></label>
                                        <select class="form-control" v-model="ocupacion_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="ocupaciones in arrayOcupacion" :key="ocupaciones.id" :value="ocupaciones.id" v-text="ocupaciones.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="cb7">Migracion:</label>
                                        <input type="checkbox" id="cb7" value='true' v-model="migracion" @click="habilitarmig(!migracion)">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="">Permanencia de Migracion:</label>
                                        <select class="form-control" id="sel01" v-model="permanencia_id" disabled>
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="permanencias in arrayPermanencia" :key="permanencias.id" :value="permanencias.id" v-text="permanencias.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>Comunidad de Migracion:</label>
                                        <input type="text" id="tx01" class="form-control" v-model="commigracion" disabled>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>Municipio de Migracion:</label>
                                        <input type="text" id="tx02" class="form-control" v-model="munmigracion" disabled>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>Departamento de Migracion:</label>
                                        <input type="text" id="tx03" class="form-control" v-model="depmigracion" disabled>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="">Pais de Migracion:</label>
                                        <select class="form-control" id="sel02" v-model="pais_id" disabled>
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="paises in arrayPais" :key="paises.id" :value="paises.id" v-text="paises.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="cb8">Mortalidad:</label>
                                        <input type="checkbox" id="cb8" value='true' v-model="mortalidad" @click="habilitar('inf01', !mortalidad)">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label>Fecha de mortalidad:</label>
                                        <input type="date" id="inf01" class="form-control" v-model="fechamortalidad" disabled>
                                    </div>
                                    <div v-if="boolpersona=='agregar'" class="form-group col-md-9">
                                        <button @click="nuevaPersona()" class="btn btn-success form-control btnagregar"><i class="icon-plus"></i></button>
                                    </div>
                                    <div v-if="boolpersona=='editar'" class="form-group col-md-9">
                                        <button @click="actualizarPersona()" class="btn btn-success form-control btnactualizar"><i class="icon-check"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row border" style="direction: ltr; height: 250px; overflow: scroll;">
                                <div class="table-responsive col-md-12">
                                    <table class="table table-bordered table_stripered trable-sm" >
                                        <thead>
                                            <th>Opciones</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Apellido de Casada</th>
                                            <th>Sexo</th>
                                            <th>Fecha de Nacimiento</th>
                                            <th>Edad</th>
                                            <th>CUI</th>
                                            <th>Lider</th>
                                            <th>Puesto Comunidad</th>
                                            <th>Parentesco</th>
                                            <th>Pueblos</th>
                                            <th>Comunidad Linguistica</th>
                                            <th>Alfabetismo</th>
                                            <th>Escolaridad</th>
                                            <th>Discapacidad</th>
                                            <th>Ocupacion</th>
                                            <th>Migracion</th>
                                            <th>Permanencia de Migracion</th>
                                            <th>Comunidad de Migracion</th>
                                            <th>Municipio de Migracion</th>
                                            <th>Departamento de Migracion</th>
                                            <th>Pais de Migracion</th>
                                            <th>Mortalidad</th>
                                            <th>Fecha Fallecimiento</th>
                                        </thead>
                                        <tbody v-if="arrayDetalle.length">
                                            <tr v-for="detalle in arrayDetalle" :key="detalle.persona_id">
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm" @click="editarPersona(detalle)"><i class="icon-pencil"></i></button>
                                                    <template v-if="detalle.mortalidad==1 && !detalle.fechamortalidad">
                                                        <button type="button" class="btn btn-info btn-sm"  @click="activarPersona(detalle.persona_id)"><i class="icon-check"></i></button>
                                                    </template>
                                                    <template v-else>
                                                        <button type="button" class="btn btn-danger btn-sm"  @click="desactivarPersona(detalle.persona_id)"><i class="icon-close"></i></button>
                                                    </template>
                                                </td>
                                                <td v-text="detalle.nombres"></td>
                                                <td v-text="detalle.apellidos"></td>
                                                <td v-text="detalle.apellido_casada"></td>
                                                <td><div v-if="detalle.sexo=='0'">Mujer</div><div v-if="detalle.sexo=='1'">Hombre</div></td>
                                                <td v-text="detalle.nacimiento"></td>
                                                <td v-text="detalle.edad"></td>
                                                <td v-text="detalle.CUI"></td>
                                                <td><div v-if="detalle.lider=='0'">Falso</div><div v-if="detalle.lider=='1'">Verdadero</div></td>
                                                <td v-text="detalle.puestocom_nombre"></td>
                                                <td v-text="detalle.parentesco_nombre"></td>
                                                <td v-text="detalle.pueblo_nombre"></td>
                                                <td v-text="detalle.comlinguistica_nombre"></td>
                                                <td><div v-if="detalle.alfabetismo=='0'">Falso</div><div v-if="detalle.alfabetismo=='1'">Es analfabeta</div></td>
                                                <td v-text="detalle.escolaridad_nombre"></td>
                                                <td v-text="detalle.discapacidad_nombre"></td>
                                                <td v-text="detalle.ocupacion_nombre"></td>
                                                <td><div v-if="detalle.migracion=='0'">No ha viajado</div><div v-if="detalle.migracion=='1'">Ha viajado</div></td>
                                                <td v-text="detalle.permanencia_nombre"></td>
                                                <td v-text="detalle.commigracion"></td>
                                                <td v-text="detalle.munmigracion"></td>
                                                <td v-text="detalle.depmigracion"></td>
                                                <td v-text="detalle.pais_nombre"></td>
                                                <td><div v-if="detalle.mortalidad=='0'">Falso</div><div v-if="detalle.mortalidad=='1'">Ha fallecido</div></td>
                                                <td v-text="detalle.fechamortalidad"></td>
                                            </tr>
                                            <tr style="background-color: #CEECF5;">
                                                <td colspan="24" align="right"><strong>Total de Personas</strong></td>
                                                <td v-text="total_personas"></td>
                                            </tr> 
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="25">No hay personas agregadas</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-secondary" @click="ocultarDetalle()">Cerrar</button>
                                    <button type="button" class="btn btn-primary" @click="actualizarFamilia()">Actualizar Familia</button>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!-- Fin detalle actuaualizar -->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!-- Fin de Familia -->
        </main>
</template>

<script>
    import vSelect from 'vue-select';
    export default {
        data (){
            return {
                familia_id:0,
                fecha_inicial:'',
                condicion:0,
                sector:'',
                num_vivienda:0,
                num_familia:0,
                usuario_id:0,
                municipio_id:0,
                comunidad_id:0,
                distrito_id:0,
                entidad_salud_id:0,
                detalle_vivienda_id:0,
                created_at:'',
                updated_at:'',
                arrayFamilia:[],
                arrayUsuario:[],
                arrayMunicipio:[],
                arrayComunidad:[],
                arrayDistrito:[],
                arrayEntidad:[],
                arrayVivienda2:[],
                persona_id:0,
                nombres:'',
                apellidos:'',
                apellido_casada:'',
                lider:0,
                sexo:0,
                nacimiento:'',
                edad:0,
                CUI:'',
                personafamilia_id:0,
                parentesco_id:0,
                pueblo_id:0,
                comlinguistica_id:0,
                alfabetismo:0,
                escolaridad_id:0,
                discapacidad_id:0,
                ocupacion_id:0,
                migracion:0,
                permanencia_id:0,
                commigracion:'',
                munmigracion:'',
                depmigracion:'',
                pais_id:0,
                puesto_comunidad_id:0,
                mortalidad:0,
                fechamortalidad:'',
                arrayPersona:[],
                arrayParentesco:[],
                arrayPueblo:[],
                arrayComlinguistica:[],
                arrayEscolaridad:[],
                arrayDiscapacidad:[],
                arrayOcupacion:[],
                arrayPermanencia:[],
                arrayPais:[],
                arrayPuestoCom:[],
                listado : 1,
                errorFamilia : 0,
                errorMostrarMsjFamilia : [],
                pagination_fam : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset_fam : 3,
                criterio_fam : 'num_familia',
                buscar_fam : '',
                arrayDetalle : [],
                parentesco_nombre:'',
                pueblo_nombre:'',
                comlinguistica_nombre:'',
                escolaridad_nombre:'',
                discapacidad_nombre:'',
                ocupacion_nombre:'',
                permanencia_nombre:'',
                pais_nombre:'',
                puestocom_nombre:'',
                total_personas:0,
                boolpersona:'agregar',

                vivienda_id : 0,
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
                arrayVivienda1 : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorVivienda: 0,
                errorMostrarMsjVivienda : [],
                pagination_viv : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset_viv : 3,
                criterio_viv : 'numvivienda',
                buscar_viv : '',
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
        components:{
            vSelect
        },
        computed:{
            isActived_fam: function(){
                return this.pagination_fam.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber_fam: function() {
                if(!this.pagination_fam.to) {
                    return [];
                }
                
                var from = this.pagination_fam.current_page - this.offset_fam; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset_fam * 2); 
                if(to >= this.pagination_fam.last_page){
                    to = this.pagination_fam.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            },
            isActived_viv: function(){
                return this.pagination_viv.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber_viv: function() {
                if(!this.pagination_viv.to) {
                    return [];
                }
                
                var from = this.pagination_viv.current_page - this.offset_viv; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset_viv * 2); 
                if(to >= this.pagination_viv.last_page){
                    to = this.pagination_viv.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
            listarFamilia (page,buscar,criterio){
                let me=this;
                var url= '/familia?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayFamilia = respuesta.familias.data;
                    me.pagination_fam = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina_fam(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination_fam.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarFamilia(page,buscar,criterio);
            },
            selectMunicipio(){
                let me=this;
                var url= '/Municipiofam';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayMunicipio = respuesta.municipios;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectComunidad(){
                let me=this;
                var url= '/Comunidadfam';
                axios.get(url).then(function (response) {
                    let respuesta= response.data;
                    me.arrayComunidad=respuesta.comunidades;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosComunidad(val1){
                let me = this;
                me.loading = true
                me.idcomunidad = val1.id;
            },
            selectDistrito(){
                let me=this;
                var url= '/Distritofam';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayDistrito = respuesta.distritos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectEntidad(){
                let me=this;
                var url= '/entidads';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayEntidad = respuesta.entidades;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectVivienda(){
                let me=this;
                var url= '/vivienda/selectVivienda';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayVivienda2 = respuesta.viviendas;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectParentesco(){
                let me=this;
                var url= '/Parentesco';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayParentesco = respuesta.parentesco;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectPueblo(){
                let me=this;
                var url= '/Pueblo';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPueblo = respuesta.pueblo;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectComlinguistica(){
                let me=this;
                var url= '/Comlinguistica';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayComlinguistica = respuesta.comlinguistica;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectEscolaridad(){
                let me=this;
                var url= '/Escolaridad';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayEscolaridad = respuesta.escolaridad;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectDiscapacidad(){
                let me=this;
                var url= '/Discapacidad';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayDiscapacidad = respuesta.discapacidad;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectOcupacion(){
                let me=this;
                var url= '/Ocupacion';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayOcupacion = respuesta.ocupacion;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectPermanencia(){
                let me=this;
                var url= '/Permanencia';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPermanencia = respuesta.permanencia;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectPais(){
                let me=this;
                var url= '/Pais';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPais = respuesta.pais;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectPuestoCom(){
                let me=this;
                var url= '/PuestoCom';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPuestoCom = respuesta.puestocom;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            mostrarDetalle(){
                let me = this;

                this.listado=0;
                this.permanencia_id = 6;
                this.pais_id = 8;
                this.puesto_comunidad_id = 3;
                
                me.sector='';
                me.num_vivienda=0;
                me.num_familia=0;
                me.distrito=0;
                me.entidad_salud_id=0;
                me.detalle_vivienda_id=0;
                me.arrayDetalle=[];
                me.boolpersona='agregar';
                
                this.selectVivienda();
                this.selectMunicipio();
                this.selectComunidad();
                this.selectDistrito();
                this.selectEntidad();
                this.selectParentesco();
                this.selectPueblo();
                this.selectComlinguistica();
                this.selectEscolaridad();
                this.selectDiscapacidad();
                this.selectOcupacion();
                this.selectPermanencia();
                this.selectPais();
                this.selectPuestoCom();
            },
            agregarDetalle(){
                let me = this;

                if((!me.CUI) || (!me.nombres) || (!me.apellidos) || (!me.nacimiento) || (me.parentesco_id==0) || (me.pueblo_id==0) || 
                    (me.comlinguistica_id==0) || (me.escolaridad_id==0) || (me.discapacidad_id==0) || (me.ocupacion_id==0) || 
                    (me.puesto_comunidad_id==0) || (me.migracion==1 && me.permanencia_id==6) || (me.migracion==1 && me.pais_id==8)){

                }
                else{

                    if(me.encuentra(me.CUI)){
                        swal.fire({
                            type: 'error',
                            title: 'Error...',
                            text: 'Este numero de CUI ya se encuentra agregado!',
                        })
                    }
                    else{
                        me.parentesco_nombre = me.arrayParentesco[me.parentesco_id - 1].nombre;
                        me.pueblo_nombre = me.arrayPueblo[me.pueblo_id - 1].nombre;
                        me.comlinguistica_nombre = me.arrayComlinguistica[me.comlinguistica_id - 1].nombre;
                        me.escolaridad_nombre = me.arrayEscolaridad[me.escolaridad_id - 1].nombre;
                        me.discapacidad_nombre = me.arrayDiscapacidad[me.discapacidad_id - 1].nombre;
                        me.ocupacion_nombre = me.arrayOcupacion[me.ocupacion_id - 1].nombre;
                        me.permanencia_nombre = me.arrayPermanencia[me.permanencia_id - 1].nombre;
                        me.pais_nombre = me.arrayPais[me.pais_id - 1].nombre;
                        me.puestocom_nombre = me.arrayPuestoCom[me.puesto_comunidad_id - 1].nombre;

                        me.edad = me.calcularEdad(me.nacimiento);

                        me.arrayDetalle.push({
                            nombres : me.nombres,
                            apellidos : me.apellidos,
                            apellido_casada : me.apellido_casada,
                            lider : me.lider,
                            sexo : me.sexo,
                            nacimiento : me.nacimiento,
                            edad : me.edad,
                            CUI : me.CUI,
                            parentesco_id : me.parentesco_id,
                            parentesco_nombre : me.parentesco_nombre,
                            pueblo_id : me.pueblo_id,
                            pueblo_nombre : me.pueblo_nombre,
                            comlinguistica_id : me.comlinguistica_id,
                            comlinguistica_nombre : me.comlinguistica_nombre,
                            alfabetismo : me.alfabetismo,
                            escolaridad_id : me.escolaridad_id,
                            escolaridad_nombre : me.escolaridad_nombre,
                            discapacidad_id : me.discapacidad_id,
                            discapacidad_nombre : me.discapacidad_nombre,
                            ocupacion_id : me.ocupacion_id,
                            ocupacion_nombre : me.ocupacion_nombre,
                            migracion : me.migracion,
                            permanencia_id : me.permanencia_id,
                            permanencia_nombre : me.permanencia_nombre,
                            commigracion : me.commigracion,
                            munmigracion : me.munmigracion,
                            depmigracion : me.depmigracion,
                            pais_id : me.pais_id,
                            pais_nombre : me.pais_nombre,
                            puesto_comunidad_id : me.puesto_comunidad_id,
                            puestocom_nombre : me.puestocom_nombre,
                            mortalidad : me.mortalidad,
                            fechamortalidad : me.fechamortalidad
                        });

                        me.nombres='';
                        me.apellidos='';
                        me.apellido_casada='';
                        me.lider=0;
                        me.sexo=0;
                        me.nacimiento='';
                        me.edad=0;
                        me.CUI='';
                        me.parentesco_id=0;
                        me.parentesco_nombre='';
                        me.pueblo_id=0;
                        me.pueblo_nombre='';
                        me.comlinguistica_id=0;
                        me.comlinguistica_nombre='';
                        me.alfabetismo=0;
                        me.escolaridad_id=0;
                        me.escolaridad_nombre='';
                        me.discapacidad_id=0;
                        me.discapacidad_nombre='';
                        me.ocupacion_id=0;
                        me.ocupacion_nombre='';
                        me.migracion=0;
                        me.permanencia_id=6;
                        me.permanencia_nombre='';
                        me.commigracion='';
                        me.munmigracion='';
                        me.depmigracion='';
                        me.pais_id=8;
                        me.pais_nombre='';
                        me.puesto_comunidad_id=3;
                        me.puestocom_nombre='';
                        me.mortalidad=0;
                        me.fechamortalidad='';
                        me.total_personas++;
                    }
                }
            },
            encuentra(cui){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].CUI==cui){
                        sw=true;
                    }
                }
                return sw;
            },
            calcularEdad(fecha){
                var hoy = new Date();
                var cumple = new Date(fecha);
                var edad = hoy.getFullYear() - cumple.getFullYear();
                var m = hoy.getMonth() - cumple.getMonth();

                if(m < 0 || (m === 0 && hoy.getDate() < cumple.getDate())){
                    edad--;
                }
                return edad;
            },
            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index, 1);
                me.total_personas--;
            },
            registrarFamilia(){
                if (this.validarFamilia()){
                    return;
                }
                
                let me = this;

                me.num_vivienda = me.arrayVivienda2[me.detalle_vivienda_id - 1].numvivienda;

                axios.post('/familia/registrar',{
                    'sector': this.sector,
                    'num_vivienda': this.num_vivienda,
                    'num_familia' : this.num_familia,
                    'distrito_id' : this.distrito_id,
                    'entidad_salud_id' : this.entidad_salud_id,
                    'detalle_vivienda_id' : this.detalle_vivienda_id,
                    'data' : this.arrayDetalle,
                }).then(function (response) {
                    me.listarFamilia(1,'','num_familia');
                    me.ocultarDetalle();
                    me.listado=1;
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarFamilia(){
               if (this.validarFamilia()){
                    return;
                }
                
                let me = this;

                me.num_vivienda = me.arrayVivienda2[me.detalle_vivienda_id - 1].numvivienda;

                axios.put('/familia/actualizar',{
                    'sector': this.sector,
                    'num_vivienda': this.num_vivienda,
                    'num_familia' : this.num_familia,
                    'distrito_id' : this.distrito_id,
                    'entidad_salud_id' : this.entidad_salud_id,
                    'detalle_vivienda_id' : this.detalle_vivienda_id,
                    'id' : this.familia_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.ocultarDetalle();
                    me.listarFamilia('1', '', 'num_familia');
                    me.listado=1;
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            validarFamilia(){
                this.errorFamilia=0;
                this.errorMostrarMsjFamilia =[];

                if (this.distrito_id==0) this.errorMostrarMsjFamilia.push("Seleccione un Distrito.");
                if (this.entidad_salud_id==0) this.errorMostrarMsjFamilia.push("Seleccione una Entidad de Salud.");
                if (this.detalle_vivienda_id==0) this.errorMostrarMsjFamilia.push("Seleccione un numero de Vivienda.");
                if (!this.sector) this.errorMostrarMsjFamilia.push("El sector donde vive la familia no puede estar vacío.");
                if (this.num_familia==0) this.errorMostrarMsjFamilia.push("El nombre de usuario no puede estar vacío.");
                if (this.errorMostrarMsjFamilia.length) this.errorFamilia = 1;

                return this.errorFamilia;
            },
            ocultarDetalle(){
                let me = this;

                this.listado=1;
                this.num_familia=0;
                this.municipio_id=0;
                this.comunidad_id=0;
                this.distrito_id=0;
                this.entidad_salud_id=0;
                this.sector=0;
                this.detalle_vivienda_id=0;
                this.num_vivienda=0;
                this.arrayDetalle=[];

                me.arrayPersona=[];
                me.persona_id=0;
                me.nombres='';
                me.apellidos='';
                me.apellido_casada='';
                me.lider=0;
                me.sexo=0;
                me.nacimiento='';
                me.edad=0;
                me.CUI='';
                me.parentesco_id=0;
                me.parentesco_nombre='';
                me.pueblo_id=0;
                me.pueblo_nombre='';
                me.comlinguistica_id=0;
                me.comlinguistica_nombre='';
                me.alfabetismo=0;
                me.escolaridad_id=0;
                me.escolaridad_nombre='';
                me.discapacidad_id=0;
                me.discapacidad_nombre='';
                me.ocupacion_id=0;
                me.ocupacion_nombre='';
                me.migracion=0;
                me.permanencia_id=6;
                me.permanencia_nombre='';
                me.commigracion='';
                me.munmigracion='';
                me.depmigracion='';
                me.pais_id=8;
                me.pais_nombre='';
                me.puesto_comunidad_id=3;
                me.puestocom_nombre='';
                me.mortalidad=0;
                me.fechamortalidad='';

                me.boolpersona='agregar';
            },
            editarFamilia(id){
                let me = this;
                this.boolpersona='agregar';
                this.permanencia_id = 6;
                this.pais_id = 8;
                this.puesto_comunidad_id = 3;

                //Obtener datos de familia
                var arrayFamiliaT=[];
                var url= '/familia/obtenerFamilia?id=' + id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayFamiliaT = respuesta.familias;

                    me.familia_id = arrayFamiliaT[0]['familia_id'];
                    me.num_familia = arrayFamiliaT[0]['num_familia'];
                    me.municipio_id = arrayFamiliaT[0]['municipio_id'];
                    me.comunidad_id = arrayFamiliaT[0]['comunidad_id'];
                    me.distrito_id = arrayFamiliaT[0]['distrito_id'];
                    me.entidad_salud_id = arrayFamiliaT[0]['entidad_salud_id'];
                    me.sector = arrayFamiliaT[0]['sector'];
                    me.detalle_vivienda_id = arrayFamiliaT[0]['detalle_vivienda_id'];
                    me.num_vivienda = arrayFamiliaT[0]['num_vivienda'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener datos de personas
                var url= '/familia/obtenerPersonas?id=' + id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.personas;

                    me.total_personas = me.arrayDetalle.length;

                    for (let i = 0; i < me.arrayDetalle.length; i++) {
                        me.edad = me.calcularEdad(me.arrayDetalle[i].nacimiento);
                        me.arrayDetalle[i].edad = me.edad;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });

                this.selectVivienda();
                this.selectMunicipio();
                this.selectComunidad();
                this.selectDistrito();
                this.selectEntidad();
                this.selectParentesco();
                this.selectPueblo();
                this.selectComlinguistica();
                this.selectEscolaridad();
                this.selectDiscapacidad();
                this.selectOcupacion();
                this.selectPermanencia();
                this.selectPais();
                this.selectPuestoCom();

                this.listado=2;
            },
            desactivarFamilia(id){
                swal.fire({
                title: 'Esta seguro de desactivar esta familia?',
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

                    axios.put('/familia/desactivar',{
                        'id' : id
                    }).then(function (response) {
                        me.listarFamilia(1,'','num_familia');
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
                    
                }
                }) 
            },
            activarFamilia(id){
                swal.fire({
                title: 'Esta seguro de activar esta familia?',
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

                    axios.put('/familia/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarFamilia(1,'','num_vivienda');
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
                    
                }
                }) 
            },
            habilitarmig(habil){
                if(habil == true){
                    document.getElementById("sel01").disabled = false;
                    document.getElementById("tx01").disabled = false;
                    document.getElementById("tx02").disabled = false;
                    document.getElementById("tx03").disabled = false;
                    document.getElementById("sel02").disabled = false;
                }else if (habil == false){
                    document.getElementById("sel01").disabled = true;
                    document.getElementById("tx01").disabled = true;
                    document.getElementById("tx02").disabled = true;
                    document.getElementById("tx03").disabled = true;
                    document.getElementById("sel02").disabled = true;
                }else if (habil == 'todos'){
                    // document.getElementById("tbo01").disabled = true;
                    // document.getElementById("tbo02").disabled = true;
                    // document.getElementById("tbo03").disabled = true;
                    // document.getElementById("tbo04").disabled = true;
                    // document.getElementById("tbo05").disabled = true;
                    // document.getElementById("tbo06").disabled = true;
                    // document.getElementById("tbo07").disabled = true;
                }              
            },
            editarPersona(data=[]){
                this.boolpersona = 'editar';

                this.persona_id=data['persona_id'];
                this.nombres=data['nombres'];
                this.apellidos=data['apellidos'];
                this.apellido_casada=data['apellido_casada'];
                this.sexo=data['sexo'];
                this.nacimiento=data['nacimiento'];
                this.CUI=data['CUI'];
                this.lider=data['lider'];
                this.puesto_comunidad_id=data['puesto_comunidad_id'];
                this.parentesco_id=data['parentesco_id'];
                this.pueblo_id=data['pueblo_id'];
                this.comlinguistica_id=data['comlinguistica_id'];
                this.alfabetismo=data['alfabetismo_id'];
                this.escolaridad_id=data['escolaridad_id'];
                this.discapacidad_id=data['discapacidad_id'];
                this.ocupacion_id=data['ocupacion_id'];
                this.migracion=data['migracion'];
                this.permanencia_id=data['permanencia_id'];
                this.commigracion=data['commigracion'];
                this.munmigracion=data['munmigracion'];
                this.depmigracion=data['depmigracion'];
                this.pais_id=data['pais_id'];
                this.mortalidad=data['mortalidad'];
                this.fechamortalidad=data['fechamortalidad'];
            },
            listadoPersona(){
                let me = this;
                this.permanencia_id = 6;
                this.pais_id = 8;
                this.puesto_comunidad_id = 3;
                var url= '/familia/obtenerPersonas?id=' + me.familia_id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.personas;

                    me.total_personas = me.arrayDetalle.length;

                    for (let i = 0; i < me.arrayDetalle.length; i++) {
                        me.edad = me.calcularEdad(me.arrayDetalle[i].nacimiento);
                        me.arrayDetalle[i].edad = me.edad;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            nuevaPersona(){
                let me = this;

                if((!me.CUI) || (!me.nombres) || (!me.apellidos) || (!me.nacimiento) || (me.parentesco_id==0) || (me.pueblo_id==0) || 
                    (me.comlinguistica_id==0) || (me.escolaridad_id==0) || (me.discapacidad_id==0) || (me.ocupacion_id==0) || 
                    (me.puesto_comunidad_id==0) || (me.migracion==1 && me.permanencia_id==6) || (me.migracion==1 && me.pais_id==8)){
                }
                else{
                    
                    let me = this;

                    axios.post('/familia/nuevaPersona',{
                        'nombres': this.nombres,
                        'apellidos': this.apellidos,
                        'apellido_casada' : this.apellido_casada,
                        'sexo' : this.sexo,
                        'nacimiento' : this.nacimiento,
                        'CUI' : this.CUI,
                        'lider' : this.lider,
                        'puesto_comunidad_id': this.puesto_comunidad_id,
                        'parentesco_id': this.parentesco_id,
                        'pueblo_id': this.pueblo_id,
                        'comlinguistica_id': this.comlinguistica_id,
                        'alfabetismo': this.alfabetismo,
                        'escolaridad_id': this.escolaridad_id,
                        'discapacidad_id': this.discapacidad_id,
                        'ocupacion_id': this.ocupacion_id,
                        'migracion': this.migracion,
                        'permanencia_id': this.permanencia_id,
                        'commigracion': this.commigracion,
                        'munmigracion': this.munmigracion,
                        'depmigracion': this.depmigracion,
                        'pais_id': this.pais_id,
                        'mortalidad': this.mortalidad,
                        'fechamortalidad': this.fechamortalidad,
                        'familia_id': this.familia_id,
                    }).then(function (response) {
                        me.listadoPersona();
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            },
            actualizarPersona(){
                let me = this;
                this.alfabetismo=true;

                if((!me.CUI) || (!me.nombres) || (!me.apellidos) || (!me.nacimiento) || (me.parentesco_id==0) || (me.pueblo_id==0) || 
                    (me.comlinguistica_id==0) || (me.escolaridad_id==0) || (me.discapacidad_id==0) || (me.ocupacion_id==0) || 
                    (me.puesto_comunidad_id==0) || (me.migracion==1 && me.permanencia_id==6) || (me.migracion==1 && me.pais_id==8)){

                }
                else{
                    axios.put('/familia/editarPersona',{
                        'nombres': this.nombres,
                        'apellidos': this.apellidos,
                        'apellido_casada' : this.apellido_casada,
                        'sexo' : this.sexo,
                        'nacimiento' : this.nacimiento,
                        'CUI' : this.CUI,
                        'lider' : this.lider,
                        'puesto_comunidad_id': this.puesto_comunidad_id,
                        'parentesco_id': this.parentesco_id,
                        'pueblo_id': this.pueblo_id,
                        'comlinguistica_id': this.comlinguistica_id,
                        'alfabetismo': this.alfabetismo,
                        'escolaridad_id': this.escolaridad_id,
                        'discapacidad_id': this.discapacidad_id,
                        'ocupacion_id': this.ocupacion_id,
                        'migracion': this.migracion,
                        'permanencia_id': this.permanencia_id,
                        'commigracion': this.commigracion,
                        'munmigracion': this.munmigracion,
                        'depmigracion': this.depmigracion,
                        'pais_id': this.pais_id,
                        'mortalidad': this.mortalidad,
                        'fechamortalidad': this.fechamortalidad,
                        'id': this.persona_id
                    }).then(function (response) {
                        me.listadoPersona();
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            },
            desactivarPersona(id){
                swal.fire({
                title: 'Esta seguro de desactivar esta familia?',
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

                    axios.put('/familia/desactivarPersona',{
                        'id' : id
                    }).then(function (response) {
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
                    
                }
                }) 
            },
            activarPersona(id){
                swal.fire({
                title: 'Esta seguro de activar esta familia?',
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

                    axios.put('/familia/activarPersona',{
                        'id': id
                    }).then(function (response) {
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
                    
                }
                })
            },

            
            listarVivienda(page,buscar,criterio){
                let me=this;
                var url='/vivienda?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayVivienda1 = respuesta.viviendas.data;
                    me.pagination_viv = respuesta.pagination;
                })
                .catch(function (error){
                    console.log(error);
                });
            },
            cambiarPagina_viv(page,buscar,criterio){
                let me = this;
                //Actualiza la pagina
                me.pagination_viv.current_page = page;
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

                }).then(function (response) {
                    me.cerrarModal();
                    me.listarVivienda(1,'','numvivienda');
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
                                this.tituloModal='Actualizar Vivienda';
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
            this.listarFamilia(1,this.buscar_fam,this.criterio_fam);
            this.listarVivienda(1,this.buscar_viv,this.criterio_viv);
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
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }

</style>
