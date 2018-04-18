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
                                    <td>{{ Form::label('lb_user_name', 'Username') }}</td>
                                    <td>{{ Form::text('user_name', $user_name, ['class' => 'form-control', 'placeholder' => 'Username']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_user_email', 'Email Address') }}</td>
                                    <td>{{ Form::text('user_email', $user_email, ['class' => 'form-control', 'placeholder' => 'Email Address']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_role', 'Permission') }}</td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" name="user_role">
                                                <option value="{{ $user_role_id }}"> {{ $user_role }}</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <center>
                                {{ Form::submit('Update User', ['class' => 'btn btn-success']) }}
                            </center>
                            {{ Form::hidden('user_password', 'secreted') }}
                            {{ csrf_field() }}
                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection