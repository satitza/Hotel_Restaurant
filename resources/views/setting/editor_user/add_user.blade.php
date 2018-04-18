@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">
                    <div class="panel-heading">Make Editor User</div>

                    <div class="panel-body">

                        <div class="form-group">
                            <?php // {!! Form::open(['url' => 'setting/report/users', 'files' => false]) !!} ?>
                            {{ Form::open(array('url' => 'setting/editor/users', 'method' => 'post')) }}
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
                                                @foreach($editor_users as $editor_user)
                                                    <option value="{{ $editor_user->id }}">{{ $editor_user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_restaurant', 'Restaurant') }}</td>
                                    <td>
                                        @foreach ($restaurants as $restaurant)
                                            <?php /* {{ Form::checkbox('role', $restaurant->id, in_array($restaurant->id, $all_data[])) }} ?>
                                            {{ Form::label('role', $restaurant->restaurant_name) }}<br>  */ ?>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="restaurants_check_box[]" value="{{ $restaurant->id }}"> {{ $restaurant->restaurant_name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <center>
                                {{ Form::submit('Match User', ['class' => 'btn btn-success']) }}
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