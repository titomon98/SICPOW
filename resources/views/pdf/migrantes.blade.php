<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de migracion</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.7rem;
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
        <h3>Lista de migrantes</h3>
    </div>
    <div>
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th>Nombre completo</th>
                    <th>No. Vivienda</th>
                    <th>Fecha de nacimiento</th>
                    <th>Permanencia</th>
                    <th>Comunidad</th>
                    <th>Municipio</th>
                    <th>Departamento</th>
                    <th>Pais Migracion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($migrantes as $mig)
                

                <tr>
                    <td>{{$mig->nombres . ' ' . $mig->apellidos}}</td>
                    <td>{{$mig->numvivienda}}</td>
                    <td><?php 
                    $fechaorg=$mig->nacimiento;
                    $fechanueva=date("d/m/Y", strtotime($fechaorg));
                    echo $fechanueva;
                    ?></td>
                    <td>{{$mig->nombre}}</td>
                    <td><?php if ($mig->commigracion == null)
                        echo "No Disponible"; 
                        else 
                        echo $mig->commigracion; ?></td>
                    <td><?php if ($mig->munmigracion == null)
                        echo "No Disponible";
                        else
                        echo $mig->munmigracion; ?></td>
                    <td><?php if ($mig->depmigracion == null)
                        echo "No Disponible";
                        else
                        echo $mig->depmigracion; ?></td>
                    <td>{{$mig->pais}}</td>

                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="izquierda">
        <p><strong>Total de registros: </strong>{{$cont}} </p>
    </div>
</body>
</html>