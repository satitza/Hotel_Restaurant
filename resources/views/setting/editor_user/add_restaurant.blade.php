@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">
                    <div class="panel-heading">Add Restaurant</div>

                    <div class="panel-body">

                        <div class="form-group">
                            <?php // {!! Form::open(['url' => 'setting/report/users', 'files' => false]) !!} ?>
                            {{ Form::open(array('url' => 'setting/editor/users_add_restaurant/'.$id, 'method' => 'post')) }}
                            <table class="table table-striped table-hover ">
                                <thead>
                                <tr class="">
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ Form::label('lb_user_report', 'User Editor') }}</td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" name="user_id">
                                                <!--option value="" disabled selected>please_selected</option-->
                                                <option value="{{ $user_id }}"> {{ $user_name }} </option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_restaurant', 'Restaurant') }}</td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" name="restaurant_id">
                                            @foreach($restaurants as $restaurant)
                                                <!--option value="" disabled selected>please_selected</option-->
                                                    <option value="{{ $restaurant->id}}">{{ $restaurant->restaurant_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <center>
                                {{ Form::submit('Add Restaurant', ['class' => 'btn btn-success']) }}
                            </center>
                            {{ csrf_field() }}
                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection