@extends('layouts.chart_app')

@section('content')

    <script type="text/javascript">
        jQuery(document).ready(function ($) {

            $(".datepicker_from").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
            });

            $(".datepicker_to").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
            });

            $("#search_restaurant_id").click(function () {
                if ($(this).is(":checked")) {
                    $("#restaurant_id").show();
                } else {
                    $("#restaurant_id").remove();
                    $("#offer_id").remove();
                    $("#offer_date").remove();
                }
            });

            $("#search_offer_id").click(function () {
                if ($(this).is(":checked")) {
                    $("#offer_id").show();
                } else {
                    $("#offer_id").remove();
                    $("#offer_date").remove();
                }
            });

            $("#search_date").click(function () {
                if ($(this).is(":checked")) {
                    $("#offer_date").show();
                } else {
                    $("#offer_date").remove();
                }
            });

            $("#search_id").click(function () {
                if ($(this).is(":checked")) {
                    $("#order_id").show();
                } else {
                    $("#order_id").remove();
                }
            });

            /*$("#hotel_id_select").change(function () {
                var hotel_id = $("#hotel_id_select").val();
                $('#text_date').val('');
                $.ajax({
                    url: 'get_restaurant',
                    type: 'GET',
                    data: {hotel_id: hotel_id},
                    success: function (response) {
                        $('#restaurant_id_select').find('option').remove().end()
                        $("#restaurant_id_select").prepend("<option value='' selected='selected'>Please Select</option>");
                        $('#offer_id_select').find('option').remove().end()
                        $("#offer_id_select").prepend("<option value='' selected='selected'>Please Select</option>");
                        $.each(response, function (index, value) {
                            $('#restaurant_id_select')
                                .append($("<option></option>")
                                    .attr("value", value.id)
                                    .text(value.restaurant_name));
                        })
                    }
                });
            });*/

            $("#restaurant_id_select").change(function () {
                var hotel_id = $("#hotel_id_select").val();
                var restaurant_id = $("#restaurant_id_select").val();
                $('#text_date').val('');
                $.ajax({
                    url: 'get_offer',
                    type: 'GET',
                    data: {id: restaurant_id},
                    success: function (response) {
                        $('#offer_id_select').find('option').remove().end()
                        $("#offer_id_select").prepend("<option value='' selected='selected'>Please select</option>");
                        $.each(response, function (index, value) {
                            $('#offer_id_select')
                                .append($("<option></option>")
                                    .attr("value", value.id)
                                    .text(value.offer_name_en));
                        })
                    }
                });
            });

            $("#offer_id_select").change(function () {
                $('#text_date_from').val('');
                $('#text_date_to').val('');
            });

        });

    </script>

    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Search Option</div>
                    <div class="panel-body">
                        {{ Form::open(array('url' => 'search_report', 'method' => 'post')) }}

                        <label for="search">
                            <input type="checkbox" id="search_restaurant_id"/>
                            Restaurant<br>
                            <input type="checkbox" id="search_offer_id"/>
                            Offer <br>

                            <hr>

                            <input type="checkbox" id="search_date"/>
                            Include Date <br>
                            <input type="checkbox" id="search_id">
                            Search By ID<br>
                        </label>
                        <hr>

                        <div id="restaurant_id" style="display: none;">
                            <label>Restaurant Name</label>
                            <select class="form-control" name="restaurant_id" id="restaurant_id_select">
                                <option value="">Please Select</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->restaurant_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="offer_id" style="display: none;">
                            <label>Offer Name</label>
                            <select class="form-control" name="offer_id" id="offer_id_select">
                                <option value="">Please Select</option>
                            </select>
                        </div>

                        <div id="offer_date" style="display: none;">

                            <label>From</label>
                            {{ Form::text('offer_date_from', null, ['class' => 'form-control datepicker_from', 'placeholder' => 'Click select date from', 'id' => 'text_date_from']) }}

                            <label>To</label>
                            {{ Form::text('offer_date_to', null, ['class' => 'form-control datepicker_to', 'placeholder' => 'Click select date to', 'id' => 'text_date_to']) }}

                        </div>

                        <div id="order_id" style="display: none;">
                            <label>Order ID</label>
                            {{ Form::text('booking_id', null, ['class' => 'form-control', 'placeholder' => 'Insert order id for searching', 'id' => 'text_order_id']) }}
                        </div>

                        <br>
                        {{ Form::submit('Search', ['class' => 'btn btn-success', 'name' => 'submitbutton', 'value' => 'search']) }}
                        <a href="{{ action('ReportsController@index') }}" class="button-link-dark">
                            Clear
                        </a>
                    {{ Form::submit('Custom PDF', ['class' => 'btn btn-info', 'name' => 'submitbutton', 'value' => 'search-pdf']) }}
                    {{ csrf_field() }}
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <button type="button" class="btn btn-primary">Booking <span class="badge">{{ $count_book }}</span></button>
        <button type="button" class="btn btn-success">Guest <span class="badge">{{ $count_guest }}</span></button>
        <button type="button" class="btn btn-dark">Price <span class="badge">{{ $count_price }}</span></button>
    </div>
    <br>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">List Booking Complete</div>
                    <div class="panel-body">
                    <!--{!! Form::open(['url' => '#', 'files' => false]) !!} -->
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Booking ID</th>
                                <th scope="col">Offer Name</th>
                                <th scope="col">Hotel Name</th>
                                <th scope="col">Restaurant Name</th>
                                <th scope="col">Booking Date</th>
                                <th scope="col">Guest Name</th>
                                <th scope="col">Offer Guest</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Currency</th>
                                <th scope="col">Rate Suffix</th>
                                <th scope="col1">Gift Voucher</th>
                                <th scope="col">Usage Status</th>
                            </tr>
                            </thead>
                            @foreach($reports as $report)
                                <tr>
                                    <td>{{ $report->booking_id }}</td>
                                    <td>{{ $report->offer_name_en }}</td>
                                    <td>{{ $report->hotel_name }}</td>
                                    <td>{{ $report->restaurant_name }}</td>
                                    <td>{{ $report->booking_date }}</td>
                                    <td>{{ $report->booking_contact_firstname."&nbsp;&nbsp;".$report->booking_contact_lastname  }}</td>
                                    <td>{{ $report->booking_guest }}</td>
                                    <td>{{ $report->booking_price }}</td>
                                    <td>{{ $report->currency }}</td>
                                    <td>{{ $report->rate_suffix }}</td>
                                    <td>
                                        @if($report->booking_voucher == 2)
                                            <a href="{{ url('view_voucher/'.$report->booking_id) }}"
                                               class="button-link-gift">
                                                Gift Voucher
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($report->usage_status == null)
                                            <p>Never Used</p>
                                        @elseif($report->usage_status == 'used')
                                            <p>Already Used</p>
                                        @endif
                                    </td>
                                    <!--td>
                                        <a href="{{ url('report/'.$report->id.'/edit') }}"
                                           class="button-link-success">
                                            Edit Report
                                        </a>
                                    </td-->
                                </tr>
                                @endforeach
                                </tbody>
                        </table>
                    {!! $reports->render() !!}
                    <!--{{ csrf_field() }}
                    {!! Form::close() !!} -->
                    </div>
                </div>
                <center>
                    <a href="{{ route('load_all') }}" class="button-link-info">
                        PDF All Report
                    </a>
                </center>
            </div>
        </div>
    </div>

@endsection
