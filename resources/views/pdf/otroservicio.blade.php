<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de servicios</title>
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
        <h3>Listado de viviendas</h3>
    </div>
    <div>
        <table class="table table-bordered table-striped table-sm">
            <thead> 
                <tr>
                    <th>No.</th>
                    <th>Num. de Vivienda</th>
                    <th>Direccion</th>
                    <th>Lider de Familia</th>
                    <th>Electricidad</th>
                    <th>Telefonia</th>
                    <th>Emisora radial</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($servicios as $serv)
                
                <tr>
                    <td><?php 
                        if (1==1)
                        $cantidad++;
                        echo $cantidad; ?></td>
                    <td>{{$serv->numvivienda}}</td>
                    <td>{{$serv->direccion}}</td>
                    <td>{{$serv->nombres." ".$serv->apellidos}}</td>
                    <td><?php 
                        if ($serv->electricidad==1)
                        {
                            echo "Si";
                            $electricidad++;
                        }
                        else {
                            echo "No";
                        }
                             ?></td>
                    <td><?php 
                        if ($serv->telefonia==1)
                        {
                            echo "Si";
                            $telefonia++;
                        }
                        else {
                            echo "No";
                        }
                             ?></td>
                    <td><?php 
                        if ($serv->radio!=null)
                        {
                            echo strtoupper($serv->radio);
                        }
                        else {
                            echo "No especifica";
                        }
                         ?></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="izquierda">
        <p><strong>Total de viviendas registradas: </strong>{{$cont1}} </p>
        <p><strong>Total de viviendas con electricidad: </strong>{{$electricidad}} </p>
        <p><strong>Total de viviendas con telefonia: </strong>{{$telefonia}} </p>
        <p><strong>Total de viviendas sin electricidad: </strong>{{$ne}} </p>
        <p><strong>Total de viviendas sin telefonia: </strong>{{$nt}} </p>
    </div>
</body>
</html>