<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>YOURSITA Customer Payment Notice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 30px;
        }
        .card {
            background: white;
            padding: 30px;
            max-width: 700px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        h2 {
            color: #333;
            font-size: 22px;
        }
        .section-title {
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            padding-bottom: 6px;
            margin-top: 30px;
        }
        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }
        td {
            padding: 8px 4px;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            width: 180px;
            color: #444;
        }
        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Customer Payment Notification</h2>
        <p>Dear YOURSITA, a customer has made a payment. Below are the details.</p>

        <div class="section-title">Customer Details</div>
        <table>
            <tr><td class="label">Name:</td><td>{{ $customer_name }}</td></tr>
            <tr><td class="label">Email:</td><td>{{ $email }}</td></tr>
            <tr><td class="label">Phone:</td><td>{{ $phone }}</td></tr>
        </table>

        <div class="section-title">Transaction Details</div>
        <table>
            <tr><td class="label">Bill Name:</td><td>YOURSITA Booking Payment</td></tr>
            <tr><td class="label">Amount Paid:</td><td>RM {{ number_format($amount / 100, 2) }}</td></tr>
            <tr><td class="label">Date & Time:</td><td>{{ now()->format('d/m/Y h:i A') }}</td></tr>
            <tr><td class="label">Status:</td><td><strong style="color: green;">Payment Approved</strong></td></tr>
            <tr><td class="label">Payment Method:</td><td>Card</td></tr>
            <tr><td class="label">Reference No:</td><td>{{ $payment_intent_id }}</td></tr>
            <tr><td class="label">Receipt URL:</td><td><a href="{{ $receipt_url }}">{{ $receipt_url }}</a></td></tr>
        </table>

        <div class="footer">
            This notification is automatically generated by YOURSITA upon successful customer payment.
        </div>
    </div>
</body>
</html>
