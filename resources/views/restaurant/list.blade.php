@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

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
                                <th scope="col">Active</th>
                                <th scope="col">Restaurant Comment</th>
                                <th scope="col1">Edit Hotel</th>
                                <th scope="col1">Delete</th>
                            </tr>
                        </thead>
                        @foreach ($restaurants as $restaurant)
                        <tr>
                            <th></th>
                            <td>{{ $restaurant->restaurant_name }}</td>
                            <td>{{ $restaurant->hotel_name }}</td>
                            <td>{{ $restaurant->active }}</td>
                            <td>{{ $restaurant->restaurant_comment }}</td>
                            <td>
                                <?php /*
                                  {{ Form::submit('แก้ใข', ['class' => 'btn btn-primary']) }}
                                 */ ?>
                                <button type="button" class="btn btn-info">
                                    <a href="{{ url('restaurant/'.$restaurant->id.'/edit') }}">
                                        Edit Hotel
                                    </a>
                                </button>

                            </td>
                            <td>                      
                                <button type="submit" class="btn btn-danger">
                                    <a href="{{ url('delete_restaurant/'.$restaurant->id ) }}" onclick="return confirm('Confrim Delete ?')">
                                        Delete Hotel
                                    </a> 
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <!--{{ csrf_field() }}
                    {!! Form::close() !!} -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
