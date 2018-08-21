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
                    <div class="panel-heading">Order Information</div>

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
                                    <td>{{ Form::text('booking_id', $booking_id, ['class' => 'form-control', 'placeholder' => 'Booking ID', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_offer_name', 'Offer Name') }}</td>
                                    <td>{{ Form::text('offer_name_en', $offer_name_en, ['class' => 'form-control', 'placeholder' => 'Offer Name', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_hotel_name', 'Hotel Name') }}</td>
                                    <td>{{ Form::text('hotel_name', $hotel_name, ['class' => 'form-control', 'placeholder' => 'Hotel Name', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_restaurant_name', 'Restaurant Name') }}</td>
                                    <td>{{ Form::text('restaurant_name', $restaurant_name, ['class' => 'form-control', 'placeholder' => 'Restaurant Name', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_booking_date', 'Booking Date') }}</td>
                                    <td>{{ Form::text('booking_date', $booking_date, ['class' => 'form-control', 'placeholder' => 'Booking Date', 'readonly']) }}</td>
                                </tr>

                                <tr>
                                    <td>{{ Form::label('lb_first_name', 'First Name') }}</td>
                                    <td>{{ Form::text('voucher_fname', $first_name, ['class' => 'form-control', 'placeholder' => 'First Name', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_last_name', 'Last Name') }}</td>
                                    <td>{{ Form::text('voucher_lname', $last_name, ['class' => 'form-control', 'placeholder' => 'Last Name', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_guest', 'Guest') }}</td>
                                    <td>{{ Form::text('booking_guest', $booking_guest, ['class' => 'form-control', 'placeholder' => 'Booking Guest', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_price', 'Total Price') }}</td>
                                    <td>{{ Form::text('booking_price', $booking_price, ['class' => 'form-control', 'placeholder' => 'Booking Price', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_currency', 'Currency') }}</td>
                                    <td>{{ Form::text('currency', $currency, ['class' => 'form-control', 'placeholder' => 'Currency', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_rate_suffix', 'Rate Suffix') }}</td>
                                    <td>{{ Form::text('rate_suffix', $rate_suffix, ['class' => 'form-control', 'placeholder' => 'Rate Suffix', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_voucher', 'Gift Voucher') }}</td>
                                    <td>
                                        @if($gift_voucher == 2)
                                            <a href="{{ url('view_voucher/'.$booking_id) }}"
                                               class="button-link-gift">
                                                Gift Voucher
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_usage_status', 'Usage Status') }}</td>
                                    <td>
                                        @if($usage_status == null)
                                            <a href="{{ url('update_usage/'.$booking_id) }}"
                                               class="button-link-gift">
                                               Update to used
                                            </a>
                                        @elseif($usage_status == 'used')
                                            <p>Used To</p>
                                        @endif
                                    </td>
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