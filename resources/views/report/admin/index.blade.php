@extends('layouts.app')

@section('content')

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $(".datepicker").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
            });

            $("#search_hotel_id").click(function () {
                if ($(this).is(":checked")) {
                    $("#hotel_id").show();
                } else {
                    $("#hotel_id").remove();
                    $("#restaurant_id").remove();
                    $("#offer_id").remove();
                    $("#offer_date").remove();
                }
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

            $("#hotel_id_select").change(function () {
                var hotel_id = $("#hotel_id_select").val();
                $('#text_date').val('');
                $.ajax({
                    url: 'get_restaurant',
                    type: 'GET',
                    data: {hotel_id: hotel_id},
                    success: function (response) {
                        $('#restaurant_id_select').find('option').remove().end()
                        $("#restaurant_id_select").prepend("<option value='' selected='selected'>please_selected</option>");
                        $('#offer_id_select').find('option').remove().end()
                        $("#offer_id_select").prepend("<option value='' selected='selected'>please_selected</option>");
                        $.each(response, function (index, value) {
                            $('#restaurant_id_select')
                                .append($("<option></option>")
                                    .attr("value", value.id)
                                    .text(value.restaurant_name));
                        })
                    }
                });
            });

            $("#restaurant_id_select").change(function () {
                var hotel_id = $("#hotel_id_select").val();
                var restaurant_id = $("#restaurant_id_select").val();
                $('#text_date').val('');
                $.ajax({
                    url: 'get_offer',
                    type: 'GET',
                    data: {hotel_id: hotel_id, restaurant_id: restaurant_id},
                    success: function (response) {
                        $('#offer_id_select').find('option').remove().end()
                        $("#offer_id_select").prepend("<option value='' selected='selected'>please_selected</option>");
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
                $('#text_date').val('');
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
                            <input type="checkbox" id="search_hotel_id"/>
                            Hotel<br>
                            <input type="checkbox" id="search_restaurant_id"/>
                            Restaurant<br>
                            <input type="checkbox" id="search_offer_id"/>
                            Offer <br>
                            <input type="checkbox" id="search_date"/>
                            Date <br>
                        </label>
                        <hr>
                        <div id="hotel_id" style="display: none;">
                            <label>Hotel Name</label>
                            <select class="form-control" name="hotel_id" id="hotel_id_select">
                                <option value="">please_selected</option>
                                @foreach($hotel_items as $item)
                                    <option value="{{ $item->id }}">{{ $item->hotel_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="restaurant_id" style="display: none;">
                            <label>Restaurant Name</label>
                            <select class="form-control" name="restaurant_id" id="restaurant_id_select">
                                <option value="">please_selected</option>
                            </select>
                        </div>

                        <div id="offer_id" style="display: none;">
                            <label>Offer Name</label>
                            <select class="form-control" name="offer_id" id="offer_id_select">
                                <option value="">please_selected</option>
                            </select>
                        </div>

                        <div id="offer_date" style="display: none;">
                            <label>Offer Date</label>
                            {{ Form::text('offer_date', null, ['class' => 'form-control datepicker', 'placeholder' => 'Click select date', 'id' => 'text_date']) }}
                        </div>

                        <br>
                        {{ Form::submit('Search', ['class' => 'btn btn-success']) }}
                        <a href="{{ action('ReportsController@index') }}" class="button-link-dark">
                            Clear
                        </a>
                    <!--{{ csrf_field() }}
                    {!! Form::close() !!} -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
