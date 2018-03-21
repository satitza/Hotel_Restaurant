@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Search Option</div>
                    <div class="panel-body">

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">List User Report</div>

                    <div class="panel-body">
                    <!--{!! Form::open(['url' => '#', 'files' => false]) !!} -->
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Hotels</th>
                                <th scope="col1">Edit User</th>
                                <th scope="col1">Delete User</th>
                            </tr>
                            </thead>
                            <tbody>
                         @foreach($user_reports as $user_report)
                                <tr>
                                    <th>{{ $user_report->name }}</th>
                                    <td>{{ $user_report->hotel_name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info">
                                            <a href="{{ url('setting/report/users/'.$user_report->id.'/edit') }}">
                                                Edit User
                                            </a>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-danger">
                                            <a href="{{ url('setting/report/delete_report_users/'.$user_report->id) }}"
                                               onclick="return confirm('Confrim Delete ?')">
                                                Delete User
                                            </a>
                                        </button>
                                    </td>
                                </tr>
                         @endforeach
                            </tbody>
                        </table>
                    {!! $user_reports->render() !!}
                    <!--{{ csrf_field() }}
                    {!! Form::close() !!} -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection