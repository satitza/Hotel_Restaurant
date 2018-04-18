@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">
                    <div class="panel-heading">Edit Editor User</div>

                    <div class="panel-body">

                        <div class="form-group">
                            <?php // {!! Form::open(['url' => 'setting/report/users', 'files' => false]) !!} ?>
                            {{ Form::open(array('url' => 'setting/editor/users/'.$id, 'method' => 'put')) }}
                            <table class="table table-striped table-hover ">
                                <thead>
                                <tr class="">
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ Form::label('lb_user_editor', 'User Editor') }}</td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" name="user_id">
                                                <!--option value="" disabled selected>please_selected</option-->
                                                <option value="{{ $user_id }}">{{ $user_name }}</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_old_restaurant', 'Restaurant matched') }}</td>
                                    <td>
                                        @foreach($old_restaurants as $indexKey => $old_restaurant )
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="old_restaurants_check_box[]"
                                                           value="{{ $old_restaurants_id[$indexKey] }}" checked> {{ $old_restaurant }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <center>
                                {{ Form::submit('Update Match', ['class' => 'btn btn-success']) }}
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