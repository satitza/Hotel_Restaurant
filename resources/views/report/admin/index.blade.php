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
            $("#search_hotel_id").click(function () {
                if ($(this).is(":checked")) {
                    $("#hotel_id").show();
                } else {
                    $("#hotel_id").remove();
                }
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

    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Search Option</div>
                    <div class="panel-body">
                        {{ Form::open(array('url' => '#', 'method' => 'post')) }}


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
                            <select class="form-control" name="hotel_id">
                                <option value="">please_selected</option>

                                <option value=""></option>

                            </select>
                        </div>

                        <div id="offer_id" style="display: none;">
                            <label>Offer Name</label>
                            <select class="form-control" name="offer_id">
                                <option value="">please_selected</option>

                                <option value=""></option>

                            </select>
                        </div>

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
