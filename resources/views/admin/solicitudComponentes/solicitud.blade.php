<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF de Solicitud de Componentes</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'sans-serif', Tahoma, Geneva, Verdana;
            font-size: 14px;
        }
        .container {
            margin-top: 50px;
        }
        h1, h2 {
            color: #333;
            text-align: center;
        }
        .table {
            margin-bottom: 30px;
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Solicitud de Componentes</h1>
        <div class="row">
            <div class="col-md-6">
                <h2>Datos de la Solicitud</h2>
                <table class="table">
                    <tr>
                        <th>ID de Solicitud</th>
                        <td>{{ $solicitud->id }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de Solicitud</th>
                        <td>{{ $solicitud->created_at }}</td>
                    </tr>
                    <!-- Agrega más detalles de la solicitud según sea necesario -->
                </table>
            </div>
            <div class="col-md-6">
                <h2>Datos del Pedido</h2>
                <table class="table">
                    <tr>
                        <th>Código del Pedido</th>
                        <td>{{ $pedido->codigo }}</td>
                    </tr>
                    <tr>
                        <th>Cliente</th>
                        <td>{{ $pedido->cliente->nombres }}</td>
                    </tr>
                    <tr>
                        <th>Número de Documento del Cliente</th>
                        <td>{{ $pedido->cliente->numeroDoc }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de Pedido</th>
                        <td>{{ $pedido->fechaPedido }}</td>
                    </tr>
                    <!-- Agrega más detalles del pedido según sea necesario -->
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Detalles de Componentes</h2>
                <table class="table">
                    <tr>
                        <th>Codigo</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                    @foreach($detallesComponentes as $detalle)
                    <tr>
                        <td>{{ $detalle->codigo}}</td>
                        <td>{{ $detalle->descripcion }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>{{ $detalle->subtotal }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</body>
</html>
