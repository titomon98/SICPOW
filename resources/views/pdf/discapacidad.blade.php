<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de capacidades diferentes</title>
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
            <h3>Lista de capacidades diferentes</h3>
    </div>
    <div>
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th>Nombre completo</th>
                    <th>Capacidades diferentes</th>
                    <th>No. de Vivienda</th>
                    <th>Direccion</th>
                    <th>Fecha de nacimiento</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($discapacidad as $dis)
                    

                <tr>
                    <td>{{$dis->nombres. ' '. $dis->apellidos }}</td>
                    <td>{{$dis->nombre}}</td>
                    <td>{{$dis->numvivienda}}</td>
                    <td>{{$dis->direccion}}</td>
                    <td><?php 
                        $fechaorg=$dis->nacimiento;
                        $fechanueva=date("d/m/Y", strtotime($fechaorg));
                        echo $fechanueva;
                        ?></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="izquierda">
        <p><strong>Total de personas sin capacidades diferentes: </strong>{{$cont1}} </p>
        <p><strong>Total de personas con capacidades diferentes: </strong>{{$cont2}} </p>
    </div>
</body>
</html>