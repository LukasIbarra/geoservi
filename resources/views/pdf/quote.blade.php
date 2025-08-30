<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cotización #{{ $quoteNumber }} - Geoservi Spa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #f97316;
            padding-bottom: 20px;
        }
        .company-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .quote-info {
            margin-bottom: 30px;
        }
        .customer-info {
            margin-bottom: 30px;
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #e2e8f0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f97316;
            color: white;
            font-weight: bold;
        }
        .total-row {
            font-weight: bold;
            background-color: #f8fafc;
        }
        .subtotal, .iva, .total {
            text-align: right;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            font-size: 10px;
            color: #666;
        }
        .terms {
            margin-top: 30px;
            font-size: 10px;
            color: #666;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            height: 60px;
        }
        .quote-number {
            font-size: 18px;
            font-weight: bold;
            color: #f97316;
        }
        .validity {
            background-color: #fffbeb;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #f59e0b;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <h1>GEOSERVI SPA</h1>
        </div>
        <div class="company-info">
            <p>Av. Industrial 1234, Rancagua, Región de O'Higgins</p>
            <p>Teléfono: +56 9 4120 6045 | Email: pruebasgeoservi@gmail.com</p>
            <p>RUT: 76.123.456-7</p>
        </div>
        <div class="quote-number">COTIZACIÓN #{{ $quoteNumber }}</div>
    </div>

    <div class="quote-info">
        <table>
            <tr>
                <td width="50%">
                    <strong>Fecha:</strong> {{ $quoteDate }}<br>
                    <strong>Válida hasta:</strong> {{ $validUntil }}
                </td>
                <td width="50%">
                    <strong>N° Cotización:</strong> {{ $quoteNumber }}<br>
                    <strong>Página:</strong> 1 de 1
                </td>
            </tr>
        </table>
    </div>

    @if(!empty($customerInfo))
    <div class="customer-info">
        <h3>DATOS DEL CLIENTE</h3>
        <table>
            <tr>
                <td width="50%"><strong>Nombre:</strong> {{ $customerInfo['name'] ?? 'No especificado' }}</td>
                <td width="50%"><strong>Email:</strong> {{ $customerInfo['email'] ?? 'No especificado' }}</td>
            </tr>
            <tr>
                <td><strong>Teléfono:</strong> {{ $customerInfo['phone'] ?? 'No especificado' }}</td>
                <td><strong>Empresa:</strong> {{ $customerInfo['company'] ?? 'No especificado' }}</td>
            </tr>
            @if(isset($customerInfo['address']))
            <tr>
                <td colspan="2"><strong>Dirección:</strong> {{ $customerInfo['address'] }}</td>
            </tr>
            @endif
        </table>
    </div>
    @endif

    <h3>DETALLE DE COTIZACIÓN</h3>
    <table>
        <thead>
            <tr>
                <th width="5%">Cant.</th>
                <th width="50%">Descripción</th>
                <th width="15%">Precio Unit.</th>
                <th width="15%">Subtotal</th>
                <th width="15%">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ $item['name'] }}</td>
                <td>${{ number_format($item['price'], 0, ',', '.') }}</td>
                <td>${{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                <td>${{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3"></td>
                <td class="subtotal">Subtotal:</td>
                <td>${{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="3"></td>
                <td class="iva">IVA (19%):</td>
                <td>${{ number_format($iva, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="3"></td>
                <td class="total">TOTAL:</td>
                <td>${{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="validity">
        <strong>⚠️ VALIDEZ DE COTIZACIÓN:</strong> Esta cotización es válida por 30 días a partir de la fecha de emisión.
    </div>

    <div class="terms">
        <h4>CONDICIONES GENERALES</h4>
        <p>1. Precios en pesos chilenos, incluyen IVA.</p>
        <p>2. Tiempo de entrega sujeto a disponibilidad de stock.</p>
        <p>3. Formas de pago: Transferencia bancaria, cheque a fecha.</p>
        <p>4. Despacho: Coordinar con el departamento de logística.</p>
        <p>5. Garantía: Los productos cuentan con garantía según fabricante.</p>
    </div>

    <div class="footer">
        <p><strong>Geoservi Spa</strong> - Soluciones integrales para la industria minera y construcción</p>
        <p>Av. Industrial 1234, Rancagua, Región de O'Higgins | Tel: +56 9 4120 6045 | Email: pruebasgeoservi@gmail.com</p>
        <p>RUT: 76.123.456-7 | www.geoservi.cl</p>
        <p>Documento generado automáticamente el {{ date('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
