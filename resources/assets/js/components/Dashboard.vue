<template>

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
    </ol>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">

            </div>
            <div class="car-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4> Prueba1 </h4>
                            </div>
                            <div class = "card-content">
                                <div class="ct-chart">
                                    <canvas id="prueba1">
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Prueba con datos random 1 </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4> Prueba2 </h4>
                            </div>
                            <div class = "card-content">
                                <div class="ct-chart">
                                    <canvas id="prueba1">
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Prueba con datos random 2 </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

</template>

<script>
    export default {
        data(){
            return {
                varMunicipio:null,
                charMunicipio:null,
                prueba1:[],
                varMunicipio:[],
                varTotalMunicipios:[],

            }
        },
        methods:{
            getMunicipios(){
                let me=this;
                var url='/dashboard';
                axios.get(url).then(function (response){
                    var respuesta=response.data;
                    me.prueba1 = respuesta.prueba1;
                    me.loadMunicipios();
                }).catch(function (error)
                {
                    console.log(error);
                });
            },
            loadMunicipios(){
                let me=this;
                me.prueba1.map(function(x){
                    me.varTotalMunicipios.push(x.total);
                });
                me.varMunicipio=document.getElementById('prueba1').getContext('2d');

                me.charMunicipio = new Chart(me.varMunicipio, {
                    type: 'bar',
                    data: {
                        labels: me.varTotalMunicipios,
                        datasets: [{
                            label: 'Municipios',
                            data: me.varTotalMunicipios,
                            backgroundColor:'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 0.2)',
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
                })
            }
        },
        mounted(){
            this.getMunicipios();
        }
    }
</script>