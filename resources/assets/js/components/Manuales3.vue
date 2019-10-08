<template>
     <!-- Contenido Principal -->
 <main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="#">Admin</a></li>
        <li class="breadcrumb-item active">Manuales de usuario</li>
    </ol>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Tipo de manual</th>
                            <th>Manual (Click para descargar)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                               Manual de Usuario
                            
                            </td>
                            <td><a href="./img/ManualUsr.pdf" target="blank">
                                Descargar
                            </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                               Lineamientos para llenado de conteo poblacional
                            </td>
                            <td><a href="./img/Lineamientos.pdf" target="blank">
                                Descargar
                            </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>
</main>
<!--Fin del contenido principal-->
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
