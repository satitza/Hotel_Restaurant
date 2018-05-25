<html>
   <head>
       <title>PDF Report</title>
       <meta charset="UTF-8">
{{--       <link rel="stylesheet" href="{{ asset('css/kv-mpdf-bootstrap.css') }}">--}}
   </head>
    <body>
        @foreach($reports as $report)
             {{ $report->booking_id }}
        @endforeach
    </body>
</html>