<template>
     <!-- Contenido Principal -->
 <main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="#">Admin</a></li>
    </ol>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            
            <div class="card-body">
                <h1>Acerca del proyecto</h1>
                <p align="justify">El sistema de conteo poblacional fue desarrollado gracias al apoyo
                    de las autoridades de turno de la coordinación de Técnicos en Salud
                    Rural y la Dirección Departamental de Salud de Quetzaltenango, en el
                    periodo de Junio-Octubre 2019
                </p>
                <h3>Acerca de los desarrolladores</h3>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Puesto en el desarrollo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                José Arturo Monterroso Muñoz
                            </td>
                            <td>arturomonterroso3@gmail.com</td>
                            <td>Lider de proyecto</td>
                            <td>
                                <span class="badge badge-success">Vivo</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Josué David Ischiu Hernández
                            </td>
                            <td>josueischiu@gmail.com</td>
                            <td>Programador y Base de datos</td>
                            <td>
                                <span class="badge badge-success">Vivo</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Rodolfo Josué David Ramírez Coronado
                            </td>
                            <td>rjd12rc@gmail.com</td>
                            <td>Programador y creador de manuales</td>
                            <td>
                                <span class="badge badge-success">Vivo</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                José Israel Vásquez Juárez
                            </td>
                            <td>itinbon@gmail.com</td>
                            <td>Programador y creador de manuales</td>
                            <td>
                                <span class="badge badge-success">Vivo</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Julio Rodrigo Escobar Calvillo
                            </td>
                            <td>julio@gmail.com</td>
                            <td>El enamorado</td>
                            <td>
                                <span class="badge badge-secondary">Fallecido</span>
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
