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
                    <div class="panel-heading">Reset Password</div>

                    <div class="panel-body">

                        <div class="form-group">
                        <!-- {!! Form::open(['url' => 'setting/users_update_password', 'files' => false]) !!} -->
                            {{ Form::open(array('url' => 'setting/users_update_password', 'method' => 'post')) }}
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
                                    <td>{{ Form::text('user_name', $user_name, ['class' => 'form-control', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_old_password', 'Encrypted Password') }}</td>
                                    <td>{{ Form::text('old_password', $password, ['class' => 'form-control', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_new_password', 'New password') }}</td>
                                    <td>{{ Form::text('user_password', null, ['class' => 'form-control', 'placeholder' => 'New password']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_new_password', 'Confirm password') }}</td>
                                    <td>{{ Form::text('user_password_2', null, ['class' => 'form-control', 'placeholder' => 'Confirm password']) }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <center>
                                {{ Form::submit('Update Password', ['class' => 'btn btn-success']) }}
                            </center>
                            {{ Form::hidden('user_id', $user_id) }}
                            {{ Form::hidden('user_email', 'email@email.com') }}
                            {{ csrf_field() }}
                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection