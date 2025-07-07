<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Analytics Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        h2 { margin-top: 30px; }
    </style>
</head>
<body>
    <h1>YOURSITA - Yearly Analytics Report</h1>
@if($selectedYear)
    <p><strong>Year:</strong> {{ $selectedYear }}</p>
@endif


    <h2>Monthly Income</h2>
    <table>
        <thead><tr><th>Month</th><th>Total Income (RM)</th></tr></thead>
        <tbody>
            @foreach($months as $i => $month)
                <tr>
                    <td>{{ $month }}</td>
                    <td>RM {{ number_format($incomeByMonth[$i], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Total Clients</h2>
    <p>{{ $clientCount }}</p>

    <h2>Popular Services</h2>
    <table>
        <thead><tr><th>Service</th><th>Total Booked</th></tr></thead>
        <tbody>
            @foreach($popularServices as $service)
                <tr>
                    <td>{{ $service->service }}</td>
                    <td>{{ $service->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Cancellation Reasons</h2>
    <table>
        <thead><tr><th>Reason</th><th>Total Cancellations</th></tr></thead>
        <tbody>
            @foreach($cancelReasons as $reason)
                <tr>
                    <td>{{ $reason->cancel_reason }}</td>
                    <td>{{ $reason->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
