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
      table {
        width: 100%;
        border-collapse: collapse;
      }
      table th, table td {
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
      
      /* A4 page styling for print */
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
        <p>Store Name</p>
      </div>
      <address>
        Street City, State 000<br />
        Tel: 01000000000<br />
        Mail: store@store.com
      </address>
      <p class="invoice-title">Order</p>
      <div class="order-info">
        <span>Table: 3</span> | 
        <span>Order No. : 12345</span>
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
          <tr>
            <td>Burger</td>
            <td>2</td>
            <td>60</td>
            <td>120</td>
          </tr>
          <tr>
            <td>Fried Chicken</td>
            <td>2</td>
            <td>30</td>
            <td>60</td>
          </tr>
          <tr>
            <td>Cola</td>
            <td>3</td>
            <td>5</td>
            <td>15</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3">Total:</td>
            <td>195</td>
          </tr>
        </tfoot>
      </table>

      <footer>
        <p>Thank you for your purchase!</p>
        <p class="footer-text">
          Returns within 14 days and purchases within 24 hours of the original
          invoice. The products must be in their original condition.
        </p>
        <img src="barcode.svg" alt="Barcode" />
        <div>
          <span>8/5/2020 08:05:59</span>
        </div>
      </footer>
    </div>
  </body>
</html>
