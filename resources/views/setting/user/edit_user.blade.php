@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">
                    <div class="panel-heading">Add User</div>

                    <div class="panel-body">

                        <div class="form-group">
                        <!-- {!! Form::open(['url' => 'setting/users', 'files' => false]) !!} -->
                            {{ Form::open(array('url' => 'setting/users/'.$user_id , 'method' => 'put')) }}
                            <table class="table table-striped table-hover ">
                                <thead>
                                <tr class="">
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ Form::label('lb_user_name', 'ชื่อ') }}</td>
                                    <td>{{ Form::text('user_name', $user_name, ['class' => 'form-control', 'placeholder' => 'ชื่อ']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_user_email', 'อีเมล์') }}</td>
                                    <td>{{ Form::text('user_email', $user_email, ['class' => 'form-control', 'placeholder' => 'อีเมล์']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_role', 'สถานะ') }}</td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" name="user_role">
                                                <option value="{{ $user_role_id }}"> {{ $user_role }}</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}"> {{ $role->role }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <center>
                                {{ Form::submit('Edit User', ['class' => 'btn btn-primary']) }}
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