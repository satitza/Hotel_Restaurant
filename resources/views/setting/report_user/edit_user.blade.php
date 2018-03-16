@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">
                    <div class="panel-heading">Edit Report User</div>

                    <div class="panel-body">

                        <div class="form-group">
                           <?php // {!! Form::open(['url' => 'setting/report/users/', 'files' => false]) !!} ?>
                           {{ Form::open(array('url' => 'setting/report/users/'.$id, 'method' => 'put')) }}
                            <table class="table table-striped table-hover ">
                                <thead>
                                <tr class="">
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ Form::label('lb_user_report', 'ชื่อ') }}</td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" name="user_id">
                                                <option value="{{ $user_id }}" >{{ $user_name }}</option>
                                                @foreach($report_users as $report_user)
                                                    <option value="{{ $report_user->id }}">{{ $report_user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_hotel', 'โรงแรม') }}</td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" name="hotel_id">
                                                <option value="{{ $hotel_id }}" >{{ $hotel_name }}</option>
                                                @foreach($hotels as $hotel)
                                                    <option value="{{ $hotel->id }}">{{ $hotel->hotel_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <center>
                                {{ Form::submit('Edit Match', ['class' => 'btn btn-primary']) }}
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