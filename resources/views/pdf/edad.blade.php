<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de personas por edad</title>
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
        <h3>Lista de personas por edad</h3>
    </div>
    <div>
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Edad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($edad as $e)
                    

                <tr>
                    <td>{{$e->nombres}}</td>
                    <td>{{$e->apellidos}}</td>
                    <td><?php 
                    $anio = date('Y'); 
                    $year = date('Y', strtotime($e->nacimiento));

                    $mes = date('m');
                    $month = date('m', strtotime($e->nacimiento));

                    $dia = date('d');
                    $day = date('d', strtotime($e->nacimiento));

                    $difa = $anio - $year;
                    $difm = $mes - $month;
                    $difd = $dia - $day;

                    if ($difm < 0 || $difd < 0)
                        $difa--;

                    echo $difa;
                    if ($difa > 17)
                    $cont1 = $cont1 + 1;
                    else
                    $cont2 = $cont2 + 1;


                    ?></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="izquierda">
        <p><strong>Total de mayores de edad: </strong>{{$cont1}} </p>
        <p><strong>Total de menores de edad: </strong>{{$cont2}} </p>
    </div>
</body>
</html>