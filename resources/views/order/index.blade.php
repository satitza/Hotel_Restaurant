@extends('layouts.chart_app')

@section('content')

    <script>
        jQuery(document).ready(function ($) {

        });


    </script>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">
                    <div class="panel-heading">Search Order ID</div>

                    <div class="panel-body">

                        {{ Form::open(array('url' => 'search_order', 'method' => 'post')) }}
                        <table class="table table-striped table-hover ">
                            <thead>
                            <tr class="">
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{ Form::label('lb_order_id', 'Order ID') }}</td>
                                <td>{{ Form::text('order_id', null, ['class' => 'form-control', 'placeholder' => 'Please insert order id', 'required','id' => 'text_search']) }}</td>
                            </tr>

                            </tbody>
                        </table>
                        <center>
                            {{ Form::submit('Search Order ID', ['class' => 'btn btn-success']) }}
                        </center>
                        {{ csrf_field() }}
                        {!! Form::close() !!}

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

