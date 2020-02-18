<template>
    
    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/main"> Escritorio</a></li>
        </ol>
        <div class ="container-fluid">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-header">
                                <h4>Mujeres</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="mujeres"></canvas>
                                </div>
                                
                            </div>
                            <div class="card-footer">
                                <p>Mujeres registradas a nivel departamental por mes de ingreso</p>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-header">
                                <h4>Hombres</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="hombres"></canvas>
                                </div>
                                
                            </div>
                            <div class="card-footer">
                                <p>Hombres registrados a nivel departamental por mes de ingreso</p>
                                
                            </div>
                        </div>
                        
                        
                        <div class="col-md-6">
                            <div class="card-header">
                                <h4>Municipios</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="municipios"></canvas>
                                </div>
                                
                            </div>
                            <div class="card-footer">
                                <p>Personas registradas a nivel departamental por municipio</p>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-header">
                                <h4>Nacimiento mujeres</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="mujeresN"></canvas>
                                </div>
                                
                            </div>
                            <div class="card-footer">
                                <p>Mujeres nacidas a nivel departamental por mes de nacimiento</p>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-header">
                                <h4>Nacimiento hombres</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="hombresN"></canvas>
                                </div>
                                
                            </div>
                            <div class="card-footer">
                                <p>Hombres nacidos a nivel departamental por mes de nacimiento</p>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-header">
                                <h4>Servicios de salud</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="entidad"></canvas>
                                </div>
                                
                            </div>
                            <div class="card-footer">
                                <p>Personas registradas a nivel departamental por entidad de salud</p>
                                
                            </div>
                        </div>

                    </div>
                </div>
                <h6>Para informacion detallada, consultar el apartado de reportes</h6>
            </div>
        </div>
        
    </main>

</template>

<script>
export default {
    data(){
        return {
            varMujeres:null, //aqui se hace referencia al html
            charMujeres:null, //aqui se guarda el grafico
            mujeres:[], //aqui se guardan todos los datos
            varTotalMujeres:[], //total del texto chiquito que aparece abajo
            varMesMujeres:[], //texto chiquito que aparece abajo

            varMujeresN:null, //aqui se hace referencia al html
            charMujeresN:null, //aqui se guarda el grafico
            mujeresN:[], //aqui se guardan todos los datos
            varTotalMujeresN:[], //total del texto chiquito que aparece abajo
            varMesMujeresN:[],

            varHombres:null,
            charHombres:null,
            hombres:[],
            varTotalHombres:[],
            varMesHombres:[],

            varHombresN:null,
            charHombresN:null,
            hombresN:[],
            varTotalHombresN:[],
            varMesHombresN:[],

            varFallecidos:null,
            charFallecidos:null,
            fallecidos:[],
            varTotalFallecidos:[],
            varMesFallecidos:[],

            varMunicipios:null,
            charMunicipios:null,
            municipios:[],
            varTotalMunicipios:[],
            varMesMunicipios:[],

            varEntidad:null,
            charEntidad:null,
            entidad:[],
            varTotalEntidad:[],
            varMesEntidad:[],
        }
    },
    methods : {
        getMujeres(){
            let me=this;
            var url='/dashboard';
            axios.get(url).then(function(response){
                var respuesta=response.data;
                me.mujeres = respuesta.mujeres;
                me.loadMujeres();
            }).catch(function (error){
                console.log(error);
            });

        },
        loadMujeres(){
            let me=this;
            me.mujeres.map(function(x){
                if (x.mes == 1)
                {
                    me.varMesMujeres.push('Enero');
                }
                else if (x.mes == 2)
                {
                    me.varMesMujeres.push('Febrero');
                }
                else if (x.mes == 3)
                {
                    me.varMesMujeres.push('Marzo');
                }
                else if (x.mes == 4)
                {
                    me.varMesMujeres.push('Abril');
                }
                else if (x.mes == 5)
                {
                    me.varMesMujeres.push('Mayo');
                }
                else if (x.mes == 6)
                {
                    me.varMesMujeres.push('Junio');
                }
                else if (x.mes == 7)
                {
                    me.varMesMujeres.push('Julio');
                }
                else if (x.mes == 8)
                {
                    me.varMesMujeres.push('Agosto');
                }
                else if (x.mes == 9)
                {
                    me.varMesMujeres.push('Septiembre');
                }
                else if (x.mes == 10)
                {
                    me.varMesMujeres.push('Octubre');
                }
                else if (x.mes == 11)
                {
                    me.varMesMujeres.push('Noviembre');
                }
                else if (x.mes == 12)
                {
                    me.varMesMujeres.push('Diciembre');
                }
                me.varTotalMujeres.push(x.total);
            });
            me.varMujeres=document.getElementById('mujeres').getContext('2d');

            me.charMujeres=new Chart(me.varMujeres, {
                type: 'bar',
                data: {
                    labels: me.varMesMujeres,
                    datasets: [{
                        label: 'Personas',
                        data: me.varTotalMujeres,
                        backgroundColor: 'rgba(255, 99, 132, 1)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        },

        getMujeresN(){
            let me=this;
            var url='/dashboard';
            axios.get(url).then(function(response){
                var respuesta=response.data;
                me.mujeresN = respuesta.mujeresN;
                me.loadMujeresN();
            }).catch(function (error){
                console.log(error);
            });

        },
        loadMujeresN(){
            let me=this;
            me.mujeresN.map(function(x){
                if (x.mes == 1)
                {
                    me.varMesMujeresN.push('Enero');
                }
                else if (x.mes == 2)
                {
                    me.varMesMujeresN.push('Febrero');
                }
                else if (x.mes == 3)
                {
                    me.varMesMujeresN.push('Marzo');
                }
                else if (x.mes == 4)
                {
                    me.varMesMujeresN.push('Abril');
                }
                else if (x.mes == 5)
                {
                    me.varMesMujeresN.push('Mayo');
                }
                else if (x.mes == 6)
                {
                    me.varMesMujeresN.push('Junio');
                }
                else if (x.mes == 7)
                {
                    me.varMesMujeresN.push('Julio');
                }
                else if (x.mes == 8)
                {
                    me.varMesMujeresN.push('Agosto');
                }
                else if (x.mes == 9)
                {
                    me.varMesMujeresN.push('Septiembre');
                }
                else if (x.mes == 10)
                {
                    me.varMesMujeresN.push('Octubre');
                }
                else if (x.mes == 11)
                {
                    me.varMesMujeresN.push('Noviembre');
                }
                else if (x.mes == 12)
                {
                    me.varMesMujeresN.push('Diciembre');
                }
                me.varTotalMujeresN.push(x.total);
            });
            me.varMujeresN=document.getElementById('mujeresN').getContext('2d');

            me.charMujeresN=new Chart(me.varMujeresN, {
                type: 'bar',
                data: {
                    labels: me.varMesMujeresN,
                    datasets: [{
                        label: 'Personas',
                        data: me.varTotalMujeresN,
                        backgroundColor: 'rgba(255, 99, 132, 1)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        },

        getHombres(){
            let me=this;
            var url='/dashboard';
            axios.get(url).then(function(response){
                var respuesta=response.data;
                me.hombres = respuesta.hombres;
                me.loadHombres();
            }).catch(function (error){
                console.log(error);
            });
        },
        loadHombres(){
            let me=this;
            me.hombres.map(function(x){
                if (x.mes == 1)
                {
                    me.varMesHombres.push('Enero');
                }
                else if (x.mes == 2)
                {
                    me.varMesHombres.push('Febrero');
                }
                else if (x.mes == 3)
                {
                    me.varMesHombres.push('Marzo');
                }
                else if (x.mes == 4)
                {
                    me.varMesHombres.push('Abril');
                }
                else if (x.mes == 5)
                {
                    me.varMesHombres.push('Mayo');
                }
                else if (x.mes == 6)
                {
                    me.varMesHombres.push('Junio');
                }
                else if (x.mes == 7)
                {
                    me.varMesHombres.push('Julio');
                }
                else if (x.mes == 8)
                {
                    me.varMesHombres.push('Agosto');
                }
                else if (x.mes == 9)
                {
                    me.varMesHombres.push('Septiembre');
                }
                else if (x.mes == 10)
                {
                    me.varMesHombres.push('Octubre');
                }
                else if (x.mes == 11)
                {
                    me.varMesHombres.push('Noviembre');
                }
                else if (x.mes == 12)
                {
                    me.varMesHombres.push('Diciembre');
                }
                me.varTotalHombres.push(x.total);
            });
            me.varHombres=document.getElementById('hombres').getContext('2d');

            me.charHombres=new Chart(me.varHombres, {
                type: 'bar',
                data: {
                    labels: me.varMesHombres,
                    datasets: [{
                        label: 'Personas',
                        data: me.varTotalHombres,
                        backgroundColor: 'rgba(132, 99, 255, 1)',
                            borderColor: 'rgba(132, 99, 255, 1)',
                            borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        },

        getHombresN(){
            let me=this;
            var url='/dashboard';
            axios.get(url).then(function(response){
                var respuesta=response.data;
                me.hombresN = respuesta.hombresN;
                me.loadHombresN();
            }).catch(function (error){
                console.log(error);
            });
        },
        loadHombresN(){
            let me=this;
            me.hombresN.map(function(x){
                if (x.mes == 1)
                {
                    me.varMesHombresN.push('Enero');
                }
                else if (x.mes == 2)
                {
                    me.varMesHombresN.push('Febrero');
                }
                else if (x.mes == 3)
                {
                    me.varMesHombresN.push('Marzo');
                }
                else if (x.mes == 4)
                {
                    me.varMesHombresN.push('Abril');
                }
                else if (x.mes == 5)
                {
                    me.varMesHombresN.push('Mayo');
                }
                else if (x.mes == 6)
                {
                    me.varMesHombresN.push('Junio');
                }
                else if (x.mes == 7)
                {
                    me.varMesHombresN.push('Julio');
                }
                else if (x.mes == 8)
                {
                    me.varMesHombresN.push('Agosto');
                }
                else if (x.mes == 9)
                {
                    me.varMesHombresN.push('Septiembre');
                }
                else if (x.mes == 10)
                {
                    me.varMesHombresN.push('Octubre');
                }
                else if (x.mes == 11)
                {
                    me.varMesHombresN.push('Noviembre');
                }
                else if (x.mes == 12)
                {
                    me.varMesHombresN.push('Diciembre');
                }
                me.varTotalHombresN.push(x.total);
            });
            me.varHombresN=document.getElementById('hombresN').getContext('2d');

            me.charHombresN=new Chart(me.varHombresN, {
                type: 'bar',
                data: {
                    labels: me.varMesHombresN,
                    datasets: [{
                        label: 'Personas',
                        data: me.varTotalHombresN,
                        backgroundColor: 'rgba(132, 99, 255, 1)',
                            borderColor: 'rgba(132, 99, 255, 1)',
                            borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        },


        getFallecidos(){
            let me=this;
            var url='/dashboard';
            axios.get(url).then(function(response){
                var respuesta=response.data;
                me.fallecidos = respuesta.fallecidos;
                me.loadFallecidos();
            }).catch(function (error){
                console.log(error);
            });
        },
        loadFallecidos(){
            let me=this;
            me.fallecidos.map(function(x){
                me.varMesFallecidos.push(x.mes);
                me.varTotalFallecidos.push(x.fallecidos);
            });
            me.varFallecidos=document.getElementById('fallecidos').getContext('2d');

            me.charFallecidos=new Chart(me.varFallecidos, {
                type: 'bar',
                data: {
                    labels: me.varMesFallecidos,
                    datasets: [{
                        label: 'Personas', //criterio que se esta evaluando
                        data: me.varTotalFallecidos, //totales de datos
                        backgroundColor: 'rgba(0, 0, 0, 1)', //color de la barra
                            borderColor: 'rgba(0, 0, 0, 1)', //color de la orilla
                            borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        },

        getMunicipios(){
            let me=this;
            var url='/dashboard';
            axios.get(url).then(function(response){
                var respuesta=response.data;
                me.municipios = respuesta.municipios;
                me.loadMunicipios();
            }).catch(function (error){
                console.log(error);
            });
        },
        loadMunicipios(){
            let me=this;
            me.municipios.map(function(x){
                me.varMesMunicipios.push(x.municipio);
                me.varTotalMunicipios.push(x.total);
            });
            me.varMunicipios=document.getElementById('municipios').getContext('2d');

            me.charMunicipios=new Chart(me.varMunicipios, {
                type: 'bar',
                data: {
                    labels: me.varMesMunicipios,
                    datasets: [{
                        label: 'Personas', //criterio que se esta evaluando
                        data: me.varTotalMunicipios, //totales de datos
                        backgroundColor: 'rgba(51,255,51,1)', //color de la barra
                        borderColor: 'rgba(51,255,51,1)', //color de la orilla
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        },

        getEntidad(){
            let me=this;
            var url='/dashboard';
            axios.get(url).then(function(response){
                var respuesta=response.data;
                me.entidad = respuesta.entidad;
                me.loadEntidad();
            }).catch(function (error){
                console.log(error);
            });
        },
        loadEntidad(){
            let me=this;
            me.entidad.map(function(x){
                me.varMesEntidad.push(x.entidad);
                me.varTotalEntidad.push(x.total);
            });
            me.varEntidad=document.getElementById('entidad').getContext('2d');

            me.charEntidad=new Chart(me.varEntidad, {
                type: 'bar',
                data: {
                    labels: me.varMesEntidad,
                    datasets: [{
                        label: 'Personas', //criterio que se esta evaluando
                        data: me.varTotalEntidad, //totales de datos
                        backgroundColor: 'rgba(51,255,51,1)', //color de la barra
                        borderColor: 'rgba(51,255,51,1)', //color de la orilla
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        },


    },
    mounted() {
        this.getMujeres();
        this.getHombres();
        this.getFallecidos();
        this.getMunicipios();
        this.getMujeresN();
        this.getHombresN();
        this.getEntidad();
    }

    
}
</script>