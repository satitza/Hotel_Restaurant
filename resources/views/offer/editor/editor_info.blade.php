@extends('layouts.chart_app')

@section('content')
    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Search Option</div>
                <div class="panel-body">
                    {{ Form::open(array('url' => 'search_offer', 'method' => 'post')) }}
                    <label>Restaurants</label>
                    <div class="form-group">
                        <select class="form-control" name="restaurant_id">
                            <!--option value="" disabled selected>please_selected</option-->
                            @foreach($restaurants as $restaurant)
                                <option value="{{ $restaurant->id }}">{{ $restaurant->restaurant_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{ Form::submit('Search', ['class' => 'btn btn-success']) }}
                    <a href="{{ action('OffersController@create') }}" class="button-link-dark">
                        Clear
                    </a>
                <!--{{ csrf_field() }}
                {!! Form::close() !!} -->
                </div>
            </div>
        </div>
    </div>
@endsection
