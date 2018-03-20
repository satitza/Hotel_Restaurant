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
                                    <td>{{ Form::label('lb_user_name', 'ชื่อผู้ใช้งาน') }}</td>
                                    <td>{{ Form::text('user_name', $user_name, ['class' => 'form-control', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_old_password', 'รหัสผ่านเดิมที่เข้ารหัสใว้') }}</td>
                                    <td>{{ Form::text('old_password', $password, ['class' => 'form-control', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_new_password', 'รหัสผ่านใหม่') }}</td>
                                    <td>{{ Form::text('user_password', null, ['class' => 'form-control', 'placeholder' => 'รหัสผ่าน']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_new_password', 'ยืนยันรหัสผ่าน') }}</td>
                                    <td>{{ Form::text('user_password_2', null, ['class' => 'form-control', 'placeholder' => 'ยืนยันรหัสผ่าน']) }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <center>
                                {{ Form::submit('Update Password', ['class' => 'btn btn-primary']) }}
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