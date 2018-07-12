@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Search Option</div>
                    <div class="panel-body">
                        {{ Form::open(array('url' => 'search_restaurant', 'method' => 'post')) }}
                        <label>Search By</label>
                        <select class="form-control" name="search_value">
                            <option value="hotel">Hotels</option>
                            <option value="restaurant">Restaurants</option>
                        </select>
                        <label>Hotels</label>
                        <select class="form-control" name="hotel_id">
                            @foreach($hotel_items as $item)
                                <option value="{{ $item->id }}">{{ $item->hotel_name }}</option>
                            @endforeach
                        </select>
                        <label>Restaurants</label>
                        <select class="form-control" name="restaurant_id">
                            @foreach($restaurant_items as $item)
                                <option value="{{ $item->id }}">{{ $item->restaurant_name }}</option>
                            @endforeach
                        </select>
                        <br>
                        {{ Form::submit('Search', ['class' => 'btn btn-success']) }}
                        <a href="{{ action('RestaurantsController@create') }}" class="button-link-dark">
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
                    <div class="panel-heading">List Restaurant</div>
                    <div class="panel-body">
                    <!--{!! Form::open(['url' => 'edit_hotel', 'files' => false]) !!} -->
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Restaurant Name</th>
                                <th scope="col">Hotel Name</th>
                                <th scope="col">E-Mail</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Status</th>
                                <th scope="col1">Edit Restaurant</th>
                            </tr>
                            </thead>
                            @foreach ($restaurants as $restaurant)
                                <tr>
                                    <th></th>
                                    <td>{{ $restaurant->restaurant_name }}</td>
                                    <td>{{ $restaurant->hotel_name }}</td>
                                    <td>{{ $restaurant->restaurant_email }}</td>
                                    <td>{{ $restaurant->restaurant_phone }}</td>
                                    <td>{{ $restaurant->active }}</td>
                                    <!--td>{{ $restaurant->restaurant_comment }}</td-->
                                    <td>
                                        <a href="{{ url('restaurant/'.$restaurant->id.'/edit') }}"
                                           class="button-link-success">
                                            Edit Restaurant
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                        </table>
                    {!! $restaurants->render() !!}
                    <!--{{ csrf_field() }}
                    {!! Form::close() !!} -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
