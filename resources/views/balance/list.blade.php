@extends('layouts.app')

@section('content')

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $(".datepicker").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
            });

            $("#search_offer_id").click(function () {
                if ($(this).is(":checked")) {
                    $("#offer_id").show();
                } else {
                    $("#offer_id").remove();
                }
            });

            $("#search_offer_date").click(function () {
                if ($(this).is(":checked")) {
                    $("#offer_date").show();
                } else {
                    $("#offer_date").remove();
                }
            });

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
                        {{ Form::open(array('url' => 'search_balance', 'method' => 'post')) }}


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
                                @foreach($offer_items as $item)
                                    <option value="{{ $item->id }}">{{ $item->offer_name_en }}</option>
                                @endforeach
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
                        <a href="{{ action('BalancesController@create') }}" class="button-link-dark">
                            Clear
                        </a>
                    <!--{{ csrf_field() }}
                    {!! Form::close() !!} -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">List Balance</div>
                    <div class="panel-body">
                    <!--{!! Form::open(['url' => 'edit_hotel', 'files' => false]) !!} -->
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Offer Name</th>
                                <th scope="col">Time Type</th>
                                <th scope="col">Offer Date</th>
                                <th scope="col">Last Guest</th>
                                <th scope="col">Balance</th>
                                <th scope="col">Status</th>
                                <th scope="col1">Edit</th>
                                <th scope="col1">Delete</th>
                            </tr>
                            </thead>
                            @foreach($balances as $balance)
                                <tr>
                                    <th>{{ $balance->offer_name_en }}</th>
                                    <td>{{ $balance->book_time_type }}</td>
                                    <td>{{ $balance->book_offer_date }}</td>
                                    <td>{{ $balance->book_offer_guest }}</td>
                                    <td>{{ $balance->book_offer_balance }}</td>
                                    <td>{{ $balance->active }}</td>
                                    <td>
                                        <a href="{{ url('balance/'.$balance->id.'/edit') }}"
                                           class="button-link-success">
                                            Edit Balance
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ url('delete_balance/'.$balance->id ) }}" class="button-link-dark"
                                           onclick="return confirm('Confrim Delete ?')">
                                            Delete Balance
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                        </table>
                    {!! $balances->render() !!}
                    <!--{{ csrf_field() }}
                    {!! Form::close() !!} -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
