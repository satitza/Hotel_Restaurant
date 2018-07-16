<html>
<head>
    <title>PDF Report</title>
    <meta charset="UTF-8">
    <style>
        .table tr th {
            font-size: 10px;
            border: 1px solid black;
            background-color: #4caf50;
        }

        .table tr td {
            font-size: 10px;
            text-align: center;
        }
        .box-count tr td{
            background-color: #5bc0de;
            padding: 10px;
        }
    </style>
</head>
<body>
<h3>Hotel Restaurant Report</h3>
<p>DATE : {{ $date_now }}</p>
<hr>
<table class="table">
    <tr class="table-header">
        <th>Booking ID</th>
        <th>Offer Name</th>
        <th>Hotel Name</th>
        <th>Restaurant Name</th>
        <th>Booking Date</th>
        <th>Guest Name</th>
        <th>Offer Guest</th>
        <th>Total Price</th>
        <th>Currency</th>
        <th>Rate Suffix</th>
        <th>Gift Voucher</th>
    </tr>

    @foreach($reports as $report)
        <tr>
            <td>{{ $report->booking_id }}</td>
            <td>{{ $report->offer_name_en }}</td>
            <td>{{ $report->hotel_name }}</td>
            <td>{{ $report->restaurant_name }}</td>
            <td>{{ $report->booking_date }}</td>
            <td>{{ $report->booking_contact_firstname ." ".$report->booking_contact_lastname }}</td>
            <td>{{ $report->booking_guest }}</td>
            <td>{{ $report->booking_price }}</td>
            <td>{{ $report->currency }}</td>
            <td>{{ $report->rate_suffix }}</td>
            <td>
                @if($report->booking_voucher == 2)
                    Yes
                @endif
            </td>
        </tr>
    @endforeach
</table>
<hr>
<table class="box-count">
    <tr>
        <td>Booking : {{ $count_book }}</td>
        <td>Guest : {{ $count_guest }}</td>
        <td>Price : {{ $count_price }}</td>
    </tr>
</table>
</body>
</html>