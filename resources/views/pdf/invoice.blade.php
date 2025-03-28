<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .invoice-logo {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        address {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .invoice-title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .order-info {
            text-align: center;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .customer-info {
            font-size: 14px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tfoot td {
            font-weight: bold;
        }

        footer {
            text-align: center;
            font-size: 14px;
            margin-top: 30px;
        }

        footer img {
            margin-top: 10px;
            width: 100px;
        }

        .footer-text {
            font-size: 12px;
            color: #777;
        }

        @page {
            size: A4;
            margin: 20mm;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .container {
                max-width: 100%;
                width: 100%;
                padding: 0;
            }

            footer img {
                width: 80px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="invoice-logo">
            <p>DEPT IT POS</p>
        </div>
        <address>
            Sargodha<br />
            Tel: 01000000000<br />
            Mail: deptit@store.com
        </address>
        <p class="invoice-title">Order</p>
        <div class="order-info">
            <span>Order No. : {{ $sale->id }}</span>
        </div>

        <div class="customer-info">
            <p><strong>Customer Name:</strong> {{ $customer->name }}</p>
            <p><strong>Phone:</strong> {{ $customer->phone }}</p>
            <p><strong>Email:</strong> {{ $customer->email }}</p>
            <p><strong>Payment Method:</strong> {{ $customer->payment_method }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventoryItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->product->price }}</td>
                        <td>{{ $item->amount }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Total:</td>
                    <td>{{ number_format($sale->amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <footer>
            <p>Thank you for your purchase!</p>
            <p class="footer-text">
                Returns within 14 days and purchases within 24 hours of the original
                invoice. The products must be in their original condition.
            </p>
            <div>
                <span>{{ \Carbon\Carbon::parse($sale->created_at)->format('m/d/Y H:i:s') }}</span>
            </div>
        </footer>
    </div>
</body>

</html>
