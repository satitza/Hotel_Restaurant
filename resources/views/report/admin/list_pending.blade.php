@extends('layouts.app')

@section('content')

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $(".datepicker").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
            });
        });


        jQuery(document).ready(function ($) {
            $("#search_offer_id").click(function () {
                if ($(this).is(":checked")) {
                    $("#offer_id").show();
                } else {
                    $("#offer_id").remove();
                }
            });
        });

        jQuery(document).ready(function ($) {
            $("#search_offer_date").click(function () {
                if ($(this).is(":checked")) {
                    $("#offer_date").show();
                } else {
                    $("#offer_date").remove();
                }
            });
        });

        jQuery(document).ready(function ($) {
            $("#search_time_type").click(function () {
                if ($(this).is(":checked")) {
                    $("#time_type").show();
                } else {
                    $("#time_type").remove();
                }
            });
        });
    </script>

    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Search Option</div>
                    <div class="panel-body">
                        {{ Form::open(array('url' => '#', 'method' => 'post')) }}


                        <label for="search">
                            <input type="checkbox" id="search_offer_id"/>
                            Offer Name <br>
                            <input type="checkbox" id="search_offer_date"/>
                            Offer Date <br>
                            <input type="checkbox" id="search_time_type"/>
                            Offer Time Type <br>
                        </label>
                        <hr>
                        <div id="offer_id" style="display: none;">
                            <label>Offer Name</label>
                            <select class="form-control" name="offer_id">
                                <option value="">please_selected</option>

                                <option value=""></option>

                            </select>
                        </div>

                        <div id="offer_date" style="display: none;">
                            <label>Offer Date</label>
                            {{ Form::text('offer_date', null, ['class' => 'form-control datepicker', 'placeholder' => 'Click select date']) }}
                        </div>

                        <div id="time_type" style="display: none;">
                            <label>Time Type</label>
                            <select class="form-control" name="time_type">
                                <option value="">please_selected</option>
                                <option value="lunch">Lunch</option>
                                <option value="dinner">Dinner</option>
                            </select>
                        </div>

                        <br>
                        {{ Form::submit('Search', ['class' => 'btn btn-success']) }}
                        <button type="submit" class="btn btn-dark">
                            <a href="{{ action('ReportsController@ListBookingPending') }}">
                                Clear
                            </a>
                        </button>
                    <!--{{ csrf_field() }}
                    {!! Form::close() !!} -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">List Booking Pending</div>
                    <div class="panel-body">
                    <!--{!! Form::open(['url' => '#', 'files' => false]) !!} -->
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Booking ID</th>
                                <th scope="col">Offer Name</th>
                                <th scope="col">Offer Date</th>
                                <th scope="col">Guest Name</th>
                                <th scope="col">Guest Email</th>
                                <th scope="col">Guest Phone</th>
                                <th scope="col1">Number Guest</th>
                                <th scope="col1">Check Bill</th>
                            </tr>
                            </thead>
                            @foreach($reports as $report)
                                <tr>
                                    <th>{{ $report->booking_id }}</th>
                                    <td>{{ $report->offer_name_en }}</td>
                                    <td>{{ $report->booking_date }}</td>
                                    <td>{{ $report->booking_contact_firstname."&nbsp;&nbsp;".$report->booking_contact_lastname  }}</td>
                                    <td>{{ $report->booking_contact_email }}</td>
                                    <td>{{ $report->booking_contact_phone }}</td>
                                    <td>{{ $report->booking_guest }}</td>
                                    <td>
                                        <a href="{{ url('check_bill/'.$report->id.'/booking_id/'.$report->booking_id ) }}"
                                           class="button-link-success"
                                           onclick="return confirm('Confrim Check Bill ?')">
                                            Check Bill
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                        </table>
                    {!! $reports->render() !!}
                    <!--{{ csrf_field() }}
                    {!! Form::close() !!} -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
