@extends('layouts.chart_app')

@section('content')
    <script type="text/javascript">

    </script>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <center>{{ $error }}</center>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">Gift Voucher Information</div>

                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::open(array('url' => '#', 'method' => 'put', 'files' => true)) }}
                            <table class="table table-striped table-hover ">
                                <thead>
                                <tr class="">
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ Form::label('lb_booking_id', 'Booking ID') }}</td>
                                    <td>{{ Form::text('voucher_booking_id', $booking_id, ['class' => 'form-control', 'placeholder' => 'Booking ID', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_voucher_title', 'Title') }}</td>
                                    <td>{{ Form::text('voucher_title', $voucher_title, ['class' => 'form-control', 'placeholder' => 'Title', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_voucher_fname', 'First Name') }}</td>
                                    <td>{{ Form::text('voucher_fname', $voucher_fname, ['class' => 'form-control', 'placeholder' => 'First Name', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_voucher_lname', 'Last Name') }}</td>
                                    <td>{{ Form::text('voucher_lname', $voucher_lname, ['class' => 'form-control', 'placeholder' => 'Last Name', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_voucher_email', 'E-Mail') }}</td>
                                    <td>{{ Form::text('voucher_email', $voucher_email, ['class' => 'form-control', 'placeholder' => 'E-Mail Address', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_voucher_phone', 'Phone') }}</td>
                                    <td>{{ Form::text('voucher_phone', $voucher_phone, ['class' => 'form-control', 'placeholder' => 'Phone', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_voucher_request', 'Request') }}</td>
                                    <td>{{ Form::text('voucher_request', $voucher_request, ['class' => 'form-control', 'placeholder' => 'Request', 'readonly']) }}</td>
                                </tr>
                                </tbody>
                            </table>
                            {{--<center>--}}
                                {{--<a href="{{ route('list_pending') }}" class="button-link-success">Back</a>--}}
                            {{--</center>--}}
                            {{ csrf_field() }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection