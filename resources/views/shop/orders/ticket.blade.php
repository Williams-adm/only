<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket de compra</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }
        .ticket{
            max-width: 450px;
            margin: 20px auto;
            padding: 20px;
        }
        h1,h2,h3,h4{
            text-align: center;
            margin-bottom: 10px;
        }
        .info{
            margin-bottom: 20px;
        }
        .info div{
            margin-bottom: 5px;
        }
        .footer{
            text-align: center;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .right {
            text-align: right;
        }
        .total {
            font-weight: bold;
            text-align: left
        }
        span {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <h3>
            Número de orden: {{ $order->id }}
        </h3>

        <div class="info">
            <h4>
                Información de la empresa:
            </h4>
            <div>
                Nombre: ANTTEC
            </div>
            <div>
                Ruc: 20614216345
            </div>
            <div>
                Teléfono: 937 366 147
            </div>
            <div>
                Correo: onlyhome79@gmail.com
            </div>
        </div>

        <div class="info">
            <h4>
                Datos del cliente:
            </h4>

            <div>
                Nombre: {{ $order->address['receiver_info']['name'] . ' ' . $order->address['receiver_info']['last_name']}}
            </div>
            <div>
                Documento: {{ $order->address['receiver_info']['document_type'] . ' - ' . $order->address['receiver_info']['document_number'] }}
            </div>
            <div>
                Dirección: {{ $order->address['district'] . ' - ' . $order->address['street'] }} ({{ $order->address['reference'] }})
            </div>
        </div>

        <div class="info">
            <h4>Detalle de la compra:</h4>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->content as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['qty'] }}</td>
                            <td class="right">S/. {{ $item['price'] }}</td>
                        </tr>
                    @endforeach
                    <!-- Subtotal -->
                    <tr>
                        <td class="total" colspan="2">Subtotal</td>
                        <td class="right">S/. {{ $order['total'] - 15 }}</td>
                    </tr>
                    <!-- Costo de envío -->
                    <tr>
                        <td class="total" colspan="2">Costo de envío</td>
                        <td class="right">S/. 15.00</td>
                    </tr>
                    <!-- Total -->
                    <tr>
                        <td class="total"  colspan="2">Total</td>
                        <td class="right"><span>S/. {{ $order['total'] }}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="footer">
            ¡Gracias por su compra!
        </div>
    </div>
</body>
</html>
