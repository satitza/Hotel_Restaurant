@extends('layouts.app')

@section('content')
    {{--<div class="container-fluid" style="margin-left: 10px; margin-right: 10px">--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-12">--}}
    {{--<div class="panel panel-default">--}}
    {{--<div class="panel-heading">Search Option</div>--}}
    {{--<div class="panel-body">--}}
    {{--{{ Form::open(array('url' => 'search_restaurant', 'method' => 'post')) }}--}}
    {{--<label>Search By</label>--}}
    {{--<select class="form-control" name="search_value">--}}
    {{--<option value="hotel">Hotels</option>--}}
    {{--<option value="restaurant">Restaurants</option>--}}
    {{--</select>--}}
    {{--<label>Hotels</label>--}}
    {{--<select class="form-control" name="hotel_id">--}}
    {{--@foreach($hotel_items as $item)--}}
    {{--<option value="{{ $item->id }}">{{ $item->hotel_name }}</option>--}}
    {{--@endforeach--}}
    {{--</select>--}}
    {{--<label>Restaurants</label>--}}
    {{--<select class="form-control" name="restaurant_id">--}}
    {{--@foreach($restaurant_items as $item)--}}
    {{--<option value="{{ $item->id }}">{{ $item->restaurant_name }}</option>--}}
    {{--@endforeach--}}
    {{--</select>--}}
    {{--<br>--}}
    {{--{{ Form::submit('Search', ['class' => 'btn btn-success']) }}--}}
    {{--<a href="{{ action('RestaurantsController@create') }}" class="button-link-dark">--}}
    {{--Clear--}}
    {{--</a>--}}
    {{--<!--{{ csrf_field() }}--}}
    {{--{!! Form::close() !!} -->--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Terms & Conditions</div>
                    <div class="panel-body">


                        <div class="container">
                            <h3>Terms & Conditions</h3>
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab_th">วาระ และ เงือนใข</a></li>
                                <li><a data-toggle="tab" href="#tab_en">Terms & Conditions</a></li>
                                <li><a data-toggle="tab" href="#tab_cn">條款和條件</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="tab_th" class="tab-pane fade in active">
                                <!--{!! Form::open(['url' => '', 'files' => false]) !!} -->
                                    <table class="table">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Restaurant Name</th>
                                            <th scope="col">Hotel Name</th>
                                            <th scope="col">E-Mail</th>
                                            <th scope="col">Status</th>
                                            <!--th scope="col">Restaurant Comment</th-->
                                            <th scope="col1">Edit Restaurant</th>
                                            <th scope="col1">Delete</th>
                                        </tr>
                                        </thead>

                                        <tr>
                                            <th></th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                            <td>
                                                <a href="{{ url('restaurant//edit') }}"
                                                   class="button-link-success">
                                                    Edit Restaurant
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ url('delete_restaurant/' ) }}"
                                                   class="button-link-dark"
                                                   onclick="return confirm('Confrim Delete ?')">
                                                    Delete Restaurant
                                                </a>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                {{--                    {!! $restaurants->render() !!}--}}
                                <!--{{ csrf_field() }}
                                {!! Form::close() !!} -->

                                </div>
                                <div id="tab_en" class="tab-pane fade">
                                   {{--table 2--}}
                                </div>
                                <div id="tab_cn" class="tab-pane fade">
                                   {{--table 3--}}
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
