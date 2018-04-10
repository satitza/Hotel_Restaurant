@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Search Option</div>
                <div class="panel-body">
                    {{ Form::open(array('url' => 'search_image', 'method' => 'post')) }}
                    <label>Offer Name</label>
                    <div class="form-group">
                        <select class="form-control" name="offer_id">
                            <!--option value="" disabled selected>please_selected</option-->
                            @foreach($offer_items as $item)
                                <option value="{{ $item[0]->id }}">{{ $item[0]->offer_name_en }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{ Form::submit('Search', ['class' => 'btn btn-primary']) }}
                    <button type="submit" class="btn btn-success">
                        <a href="{{ action('ImagesController@create') }}">
                            Clear
                        </a>
                    </button>
                <!--{{ csrf_field() }}
                {!! Form::close() !!} -->
                </div>
            </div>
        </div>
    </div>
@endsection
