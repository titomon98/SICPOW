<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>['guest']], function(){
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});

Route::group(['middleware'=>['auth']], function(){
    
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/dashboard', 'DashboardController');

    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

    Route::group(['middleware'=>['Superusuario']], function(){
        //Controladores de rol
        Route::get('/rol', 'RolController@index');//Para ver los datos
        Route::get('/rol/selectRol', 'RolController@selectRol');
        
        //Controladores de municipio
        Route::get('/municipio','MunicipioController@index'); //Para agarrar datos
        Route::post('/municipio/registrar','MunicipioController@store'); //Para meter datos
        Route::put('/municipio/actualizar','MunicipioController@update'); //Para actualizar datos
        Route::put('/municipio/desactivar','MunicipioController@desactivar'); //Para actualizar datos
        Route::put('/municipio/activar','MunicipioController@activar'); //Para actualizar datos
        Route::get('/municipio/selectMunicipio','MunicipioController@selectMunicipio');
        
        //Controladores de comunidad
        Route::get('/comunidad','ComunidadController@index');
        Route::post('/comunidad/registrar','ComunidadController@store'); //Para meter datos
        Route::put('/comunidad/actualizar','ComunidadController@update'); //Para actualizar datos
        Route::put('/comunidad/desactivar','ComunidadController@desactivar'); //Para actualizar datos
        Route::put('/comunidad/activar','ComunidadController@activar'); //Para actualizar datos
        Route::get('/comunidad/selectComunidad','ComunidadController@selectComunidad');
        Route::get('/comunidad/selectComunidadD/{id}','ComunidadController@selectComunidadD');
        
        //Controladores de distrito
        Route::get('/distrito','DistritoController@index');
        Route::post('/distrito/registrar','DistritoController@store'); //Para meter datos
        Route::put('/distrito/actualizar','DistritoController@update'); //Para actualizar datos
        Route::put('/distrito/desactivar','DistritoController@desactivar'); //Para actualizar datos
        Route::put('/distrito/activar','DistritoController@activar'); //Para actualizar datos
        Route::get('/distrito/selectDistrito','DistritoController@selectDistrito');
        Route::get('/distrito/selectDistritoD/{id}','DistritoController@selectDistritoD');
        
        //Controladores de Usuario
        Route::get('/usuario','UsuarioController@index');
        Route::post('/usuario/registrar','UsuarioController@store'); //Para meter datos
        Route::put('/usuario/actualizar','UsuarioController@update'); //Para actualizar datos
        Route::put('/usuario/desactivar','UsuarioController@desactivar'); //Para actualizar datos
        Route::put('/usuario/activar','UsuarioController@activar'); //Para actualizar datos
        Route::get('/usuario/selectUsuario','UsuarioController@selectUsuario');
        
        //Controladores de Familia
        Route::get('/familia','FamiliaController@index');
        Route::get('/usuariofam','FamiliaController@selectUsuario');
        Route::get('/distritofam','FamiliaController@selectDistrito');
        Route::get('/entidads','FamiliaController@selectEntidadSalud');
        Route::get('/Municipiofam','FamiliaController@selectMunicipio');
        Route::get('/Comunidadfam/{id}','FamiliaController@selectComunidad');
        Route::get('/Distritofam/{id}','FamiliaController@selectDistrito');
        Route::get('/Parentesco','FamiliaController@selectParentesco');
        Route::get('/Pueblo','FamiliaController@selectPueblo');
        Route::get('/Comlinguistica','FamiliaController@selectLinguistica');
        Route::get('/Escolaridad','FamiliaController@selectEscolaridad');
        Route::get('/Discapacidad','FamiliaController@selectDiscapacidad');
        Route::get('/Ocupacion','FamiliaController@selectOcupacion');
        Route::get('/Permanencia','FamiliaController@selectPermanencia');
        Route::get('/Pais','FamiliaController@selectPais');
        Route::get('/PuestoCom','FamiliaController@selectPuestoCom');
        Route::post('/familia/registrar','FamiliaController@store'); //Para meter datos
        Route::put('/familia/actualizar','FamiliaController@update'); //Para actualizar datos
        Route::put('/familia/desactivar','FamiliaController@desactivar'); //Para actualizar datos
        Route::put('/familia/activar','FamiliaController@activar'); //Para actualizar datos
        Route::get('/familia/selectfamilia','FamiliaController@selectFamilia');
        Route::get('/familia/obtenerFamilia', 'FamiliaController@obtenerFamilia');
        Route::get('/familia/obtenerPersonas', 'FamiliaController@obtenerPersonas');
        Route::post('familia/nuevaPersona', 'FamiliaController@nuevaPersona');
        Route::put('/familia/editarPersona', 'FamiliaController@editarPersona');
        Route::put('/familia/desactivarPersona', 'FamiliaController@desactivarPersona');
        Route::put('/familia/activarPersona', 'FamiliaController@activarPersona');

        //Controladores de Vivienda
        Route::get('/vivienda','ViviendaController@index');
        Route::post('/vivienda/registrar','ViviendaController@store');
        Route::put('/vivienda/actualizar','ViviendaController@update');
        Route::put('/vivienda/desactivar','ViviendaController@desactivar');
        Route::put('/vivienda/activar','ViviendaController@activar');
        Route::get('/vivienda/selectVivienda', 'ViviendaController@selectVivienda');
        Route::get('/tenencia','ViviendaController@selectTenencia');
        Route::get('/tipovivienda','ViviendaController@selectTipovivienda');
        Route::get('/ambiente','ViviendaController@selectAmbiente');
        Route::get('/cocina','ViviendaController@selectCocina');
        Route::get('/techo','ViviendaController@selectTecho');
        Route::get('/pared','ViviendaController@selectPared');
        Route::get('/piso','ViviendaController@selectPiso');
        Route::get('/aguaabast','ViviendaController@selectAguaabast');
        Route::get('/aguatrat','ViviendaController@selectAguatrat');
        Route::get('/eliminexcretas','ViviendaController@selectEliminexcretas');
        Route::get('/eliminbasura','ViviendaController@selectEliminbasura');
        Route::get('/animalubic','ViviendaController@selectAnimalubic');
        Route::get('/animalcondlugar','ViviendaController@selectAnimalcondlugar');
        
        //Controladores de Reportes
        Route::get('/RJefes/{fil}/{id}/{id2}/{id3}', 'ReporteController@listarJefe')->name('jefes_pdf');
        Route::get('/RViviendas/{fil}/{id}/{id2}/{id3}', 'ReporteController@listarVivienda')->name('viviendas_pdf');
        Route::get('/RSexo/{fil}/{id}/{id2}/{id3}', 'ReporteController@listarSexo')->name('sexo_pdf');
        Route::get('/REdad/{fil}/{id}/{id2}/{id3}', 'ReporteController@listarEdad')->name('edad_pdf');
        Route::get('/RDiscapacidad/{fil}/{id}/{id2}/{id3}', 'ReporteController@listarDiscapacidad')->name('discapacidad_pdf');
        Route::get('/ROcupacion/{fil}/{id}/{id2}/{id3}', 'ReporteController@listarOcupacion')->name('ocupacion_pdf');
        Route::get('/RMigracion/{fil}/{id}/{id2}/{id3}', 'ReporteController@listarMigrantes')->name('migrantes_pdf');
        Route::get('/RFallecidos/{fil}/{id}/{id2}/{id3}', 'ReporteController@listarFallecidos')->name('fallecidos_pdf');
        Route::get('/RServicios/{fil}/{id}/{id2}/{id3}/{servicio}', 'ReporteController@listarServicio')->name('servicios_pdf');
    });

    Route::group(['middleware'=>['Estadista']], function(){
        //Controladores de municipio
        Route::get('/municipio','MunicipioController@index'); 
        
        //Controladores de comunidad
        Route::get('/comunidad','ComunidadController@index');
        
        //Controladores de distrito
        Route::get('/distrito','DistritoController@index');
        
        //Controladores de Familia
        Route::get('/familia','FamiliaController@index');
        Route::get('/usuariofam','FamiliaController@selectUsuario');
        Route::get('/distritofam','FamiliaController@selectDistrito');
        Route::get('/entidads','FamiliaController@selectEntidadSalud');
        Route::get('/Municipiofam','FamiliaController@selectMunicipio');
        Route::get('/Comunidadfam/{id}','FamiliaController@selectComunidad');
        Route::get('/Distritofam/{id}','FamiliaController@selectDistrito');
        Route::get('/Parentesco','FamiliaController@selectParentesco');
        Route::get('/Pueblo','FamiliaController@selectPueblo');
        Route::get('/Comlinguistica','FamiliaController@selectLinguistica');
        Route::get('/Escolaridad','FamiliaController@selectEscolaridad');
        Route::get('/Discapacidad','FamiliaController@selectDiscapacidad');
        Route::get('/Ocupacion','FamiliaController@selectOcupacion');
        Route::get('/Permanencia','FamiliaController@selectPermanencia');
        Route::get('/Pais','FamiliaController@selectPais');
        Route::get('/PuestoCom','FamiliaController@selectPuestoCom');
        Route::post('/familia/registrar','FamiliaController@store'); //Para meter datos
        Route::put('/familia/actualizar','FamiliaController@update'); //Para actualizar datos
        Route::put('/familia/desactivar','FamiliaController@desactivar'); //Para actualizar datos
        Route::put('/familia/activar','FamiliaController@activar'); //Para actualizar datos
        Route::get('/familia/selectfamilia','FamiliaController@selectFamilia');
        Route::get('/familia/obtenerFamilia', 'FamiliaController@obtenerFamilia');
        Route::get('/familia/obtenerPersonas', 'FamiliaController@obtenerPersonas');
        Route::post('familia/nuevaPersona', 'FamiliaController@nuevaPersona');
        Route::put('/familia/editarPersona', 'FamiliaController@editarPersona');
        Route::put('/familia/desactivarPersona', 'FamiliaController@desactivarPersona');
        Route::put('/familia/activarPersona', 'FamiliaController@activarPersona');

        //Controladores de Vivienda
        Route::get('/vivienda','ViviendaController@index');
        Route::post('/vivienda/registrar','ViviendaController@store');
        Route::put('/vivienda/actualizar','ViviendaController@update');
        Route::put('/vivienda/desactivar','ViviendaController@desactivar');
        Route::put('/vivienda/activar','ViviendaController@activar');
        Route::get('/vivienda/selectVivienda', 'ViviendaController@selectVivienda');
        Route::get('/tenencia','ViviendaController@selectTenencia');
        Route::get('/tipovivienda','ViviendaController@selectTipovivienda');
        Route::get('/ambiente','ViviendaController@selectAmbiente');
        Route::get('/cocina','ViviendaController@selectCocina');
        Route::get('/techo','ViviendaController@selectTecho');
        Route::get('/pared','ViviendaController@selectPared');
        Route::get('/piso','ViviendaController@selectPiso');
        Route::get('/aguaabast','ViviendaController@selectAguaabast');
        Route::get('/aguatrat','ViviendaController@selectAguatrat');
        Route::get('/eliminexcretas','ViviendaController@selectEliminexcretas');
        Route::get('/eliminbasura','ViviendaController@selectEliminbasura');
        Route::get('/animalubic','ViviendaController@selectAnimalubic');
        Route::get('/animalcondlugar','ViviendaController@selectAnimalcondlugar');
        
        //Controladores de Reportes
        Route::get('/RJefes/{fil}/{id}/{id2}/{id3}', 'ReporteController@listarJefe')->name('jefes_pdf');
        Route::get('/RViviendas/{fil}/{id}/{id2}/{id3}', 'ReporteController@listarVivienda')->name('viviendas_pdf');
        Route::get('/RSexo/{fil}/{id}/{id2}/{id3}', 'ReporteController@listarSexo')->name('sexo_pdf');
        Route::get('/REdad/{fil}/{id}/{id2}/{id3}', 'ReporteController@listarEdad')->name('edad_pdf');
        Route::get('/RDiscapacidad/{fil}/{id}/{id2}/{id3}', 'ReporteController@listarDiscapacidad')->name('discapacidad_pdf');
        Route::get('/ROcupacion/{fil}/{id}/{id2}/{id3}', 'ReporteController@listarOcupacion')->name('ocupacion_pdf');
        Route::get('/RMigracion/{fil}/{id}/{id2}/{id3}', 'ReporteController@listarMigrantes')->name('migrantes_pdf');
        Route::get('/RFallecidos/{fil}/{id}/{id2}/{id3}', 'ReporteController@listarFallecidos')->name('fallecidos_pdf');
        Route::get('/RServicios/{fil}/{id}/{id2}/{id3}/{servicio}', 'ReporteController@listarServicio')->name('servicios_pdf');
    });

    Route::group(['middleware'=>['Digitador']], function(){
        //Controladores de Familia
        Route::get('/familia','FamiliaController@index');
        Route::get('/usuariofam','FamiliaController@selectUsuario');
        Route::get('/distritofam','FamiliaController@selectDistrito');
        Route::get('/entidads','FamiliaController@selectEntidadSalud');
        Route::get('/Municipiofam','FamiliaController@selectMunicipio');
        Route::get('/Comunidadfam/{id}','FamiliaController@selectComunidad');
        Route::get('/Distritofam/{id}','FamiliaController@selectDistrito');
        Route::get('/Parentesco','FamiliaController@selectParentesco');
        Route::get('/Pueblo','FamiliaController@selectPueblo');
        Route::get('/Comlinguistica','FamiliaController@selectLinguistica');
        Route::get('/Escolaridad','FamiliaController@selectEscolaridad');
        Route::get('/Discapacidad','FamiliaController@selectDiscapacidad');
        Route::get('/Ocupacion','FamiliaController@selectOcupacion');
        Route::get('/Permanencia','FamiliaController@selectPermanencia');
        Route::get('/Pais','FamiliaController@selectPais');
        Route::get('/PuestoCom','FamiliaController@selectPuestoCom');
        Route::post('/familia/registrar','FamiliaController@store'); //Para meter datos
        Route::put('/familia/actualizar','FamiliaController@update'); //Para actualizar datos
        Route::put('/familia/desactivar','FamiliaController@desactivar'); //Para actualizar datos
        Route::put('/familia/activar','FamiliaController@activar'); //Para actualizar datos
        Route::get('/familia/selectfamilia','FamiliaController@selectFamilia');
        Route::get('/familia/obtenerFamilia', 'FamiliaController@obtenerFamilia');
        Route::get('/familia/obtenerPersonas', 'FamiliaController@obtenerPersonas');
        Route::post('familia/nuevaPersona', 'FamiliaController@nuevaPersona');
        Route::put('/familia/editarPersona', 'FamiliaController@editarPersona');
        Route::put('/familia/desactivarPersona', 'FamiliaController@desactivarPersona');
        Route::put('/familia/activarPersona', 'FamiliaController@activarPersona');

        //Controladores de Vivienda
        Route::get('/vivienda','ViviendaController@index');
        Route::post('/vivienda/registrar','ViviendaController@store');
        Route::put('/vivienda/actualizar','ViviendaController@update');
        Route::put('/vivienda/desactivar','ViviendaController@desactivar');
        Route::put('/vivienda/activar','ViviendaController@activar');
        Route::get('/vivienda/selectVivienda', 'ViviendaController@selectVivienda');
        Route::get('/tenencia','ViviendaController@selectTenencia');
        Route::get('/tipovivienda','ViviendaController@selectTipovivienda');
        Route::get('/ambiente','ViviendaController@selectAmbiente');
        Route::get('/cocina','ViviendaController@selectCocina');
        Route::get('/techo','ViviendaController@selectTecho');
        Route::get('/pared','ViviendaController@selectPared');
        Route::get('/piso','ViviendaController@selectPiso');
        Route::get('/aguaabast','ViviendaController@selectAguaabast');
        Route::get('/aguatrat','ViviendaController@selectAguatrat');
        Route::get('/eliminexcretas','ViviendaController@selectEliminexcretas');
        Route::get('/eliminbasura','ViviendaController@selectEliminbasura');
        Route::get('/animalubic','ViviendaController@selectAnimalubic');
        Route::get('/animalcondlugar','ViviendaController@selectAnimalcondlugar');
    }); 
});
