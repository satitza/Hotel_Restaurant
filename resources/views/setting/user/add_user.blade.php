@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <center>{{ $error }}</center>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">Add User</div>

                    <div class="panel-body">

                        <div class="form-group">
                            {!! Form::open(['url' => 'setting/users', 'files' => false]) !!}
                            <?php // {{ Form::open(array('url' => 'setting/create_user', 'method' => 'post')) }} ?>
                            <table class="table table-striped table-hover ">
                                <thead>
                                <tr class="">
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ Form::label('lb_user_name', 'Username') }}</td>
                                    <td>{{ Form::text('user_name', null, ['class' => 'form-control', 'placeholder' => 'Username']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_user_email', 'Email Address') }}</td>
                                    <td>{{ Form::text('user_email', null, ['class' => 'form-control', 'placeholder' => 'Email Address']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_user_password', 'Password') }}</td>
                                    <td><input id="password" type="password" class="form-control" name="user_password"
                                               placeholder="รหัสผ่าน"></td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_role', 'Permission') }}</td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" name="user_role">
                                                <!--option value="" disabled selected>please_selected</option-->
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
                                {{ Form::submit('Add User', ['class' => 'btn btn-primary']) }}
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
