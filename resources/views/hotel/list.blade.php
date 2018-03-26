@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Search Option</div>
                    <div class="panel-body">
                        {{ Form::open(array('url' => 'search_hotel', 'method' => 'post')) }}
                        <label>Hotels</label>
                        <select class="form-control" name="hotel_id">
                            @foreach($hotel_items as $item)
                                <option value="{{ $item->id }}">{{ $item->hotel_name }}</option>
                            @endforeach
                        </select>
                        <br>
                    {{ Form::submit('Search', ['class' => 'btn btn-primary']) }}
                        <button type="submit" class="btn btn-success">
                            <a href="{{ action('HotelController@create') }}">
                                Clear
                            </a>
                        </button>
                    <!--{{ csrf_field() }}
                    {!! Form::close() !!} -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">List Hotel</div>

                    <div class="panel-body">
                    <!--{!! Form::open(['url' => 'edit_hotel', 'files' => false]) !!} -->
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Hotel Name</th>
                                <th scope="col">Hotel Status</th>
                                <th scope="col">Hotel Comment</th>
                                <th scope="col1">Edit Hotel</th>
                                <th scope="col1">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($hotels as $hotel)
                                <tr>
                                    <th></th>
                                    <td>{{ $hotel->hotel_name }}</td>
                                    <td>{{ $hotel->active }}</td>
                                    <td>{{ $hotel->hotel_comment }}</td>
                                    <td>
                                        <?php /*
                                      {{ Form::submit('แก้ใข', ['class' => 'btn btn-primary']) }}
                                     */ ?>
                                        <button type="button" class="btn btn-info">
                                            <a href="{{ url('hotel/'.$hotel->id .'/edit') }}">
                                                Edit Hotel
                                            </a>
                                        </button>

                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-danger">
                                            <a href="{{ url('delete_hotel/'.$hotel->id) }}"
                                               onclick="return confirm('Confrim Delete ?')">
                                                Delete Hotel
                                            </a>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    {!! $hotels->render() !!}
                    <!--{{ csrf_field() }}
                    {!! Form::close() !!} -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
