@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Search Option</div>
                    <div class="panel-body">
                        {{ Form::open(array('url' => 'search_image', 'method' => 'post')) }}
                        <label>Offer Name</label>
                        <select class="form-control" name="offer_id">
                            @foreach($offer_items as $item)
                                <option value="{{ $item->id }}">{{ $item->offer_name_en }}</option>
                            @endforeach
                        </select>
                        <br>
                        {{ Form::submit('Search', ['class' => 'btn btn-success']) }}
                        <a href="{{ action('ImagesController@create') }}" class="button-link-dark">
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
                    <div class="panel-heading">List Images</div>

                    <div class="panel-body">
                    <!--{!! Form::open(['url' => 'edit_hotel', 'files' => false]) !!} -->
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Hotel Name</th>
                                <th scope="col">Restaurant Name</th>
                                <th scope="col">Offer Name</th>
                                <th scope="col">Edit</th>
                                <th scope="col1">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($images as $image)
                                <tr>
                                    <th>{{ $image->hotel_name }}</th>
                                    <td>{{ $image->restaurant_name }}</td>
                                    <td>{{ $image->offer_name_en }}</td>
                                    <td>
                                        <a href="{{ url('image/'.$image->id.'/edit') }}" class="button-link-success">
                                            Edit Images
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ url('delete_image/'.$image->id) }}" class="button-link-dark"
                                           onclick="return confirm('Confrim Delete ?')">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    {!! $images->render() !!}
                    <!--{{ csrf_field() }}
                    {!! Form::close() !!} -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection