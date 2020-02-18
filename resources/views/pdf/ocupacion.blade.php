<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de ocupaciones</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.875rem;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;           
        }
        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }
        .table-bordered {
            border: 1px solid #c2cfd6;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #c2cfd6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 2px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #c2cfd6;
        }
        th, td {
            display: table-cell;
            vertical-align: inherit;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }
    </style>
</head>
<body>
    <img src="./img/logoDS.png" class="derecha"><br>
    <div>
        <h3>Dirección Departamental de Salud de Quetzaltenango</h3>
        <h3>Quetzaltenango</h3>
        <h3><span class="izquierda">{{now()}}</span></h3><br>
        <h3>Lista de ocupacion u oficio</h3>
    </div>
    <div>
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>No. de vivienda</th>
                    <th>Direccion</th>
                    <th>Fecha de nacimiento</th>
                    <th>Ocupacion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ocupacion as $dis)
                    

                <tr>
                    <td>{{$dis->nombres}}</td>
                    <td>{{$dis->apellidos}}</td>
                    <td>{{$dis->numvivienda}}</td>
                    <td>{{$dis->direccion}}</td>
                    <td><?php 
                        $fechaorg=$dis->nacimiento;
                        $fechanueva=date("d/m/Y", strtotime($fechaorg));
                        echo $fechanueva;
                        ?></td>
                    <td><?php
                    if ($dis->nombre == "Agricultor")
                    {
                        $agri++;
                    }
                    else if ($dis->nombre == "Ama de casa")
                    {
                        $ama++;
                    }
                    else if ($dis->nombre == "Albañil")
                    {
                        $alba++;
                    }
                    else if ($dis->nombre == "Carpintero")
                    {
                        $carpin++;
                    }
                    else if ($dis->nombre == "Comerciante")
                    {
                        $comer++;
                    }
                    else if ($dis->nombre == "Profesional universitario")
                    {
                        $prof++;
                    }
                    else if ($dis->nombre == "Estudiante")
                    {
                        $est++;
                    }
                    else if ($dis->nombre == "Otros")
                    {
                        $otros++;
                    }
                    echo $dis->nombre;
                    ?></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="izquierda">
        <p><strong>Total de registros: </strong>{{$cont}} </p>
        <p><strong>Total de amas de casa: </strong>{{$ama}} </p>
        <p><strong>Total de agricultores: </strong>{{$agri}} </p>
        <p><strong>Total de albañiles: </strong>{{$alba}} </p>
        <p><strong>Total de carpintero: </strong>{{$carpin}} </p>
        <p><strong>Total de comerciante: </strong>{{$comer}} </p>
        <p><strong>Total de profesionales universitarios: </strong>{{$prof}} </p>
        <p><strong>Total de estudiantes: </strong>{{$est}} </p>
        <p><strong>Total de personas con otras ocupaciones: </strong>{{$otros}} </p>
    </div>
</body>
</html>