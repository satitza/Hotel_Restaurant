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
                                <th scope="col">E-Mail</th>
                                <th scope="col">Role</th>
                                <th scope="col1">Edit User</th>
                                <th scope="col">Reset Password</th>
                                <th scope="col1">Delete User</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <th>{{ $user->name }}</th>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <a href="{{ url('setting/users/'.$user->id.'/edit') }}"
                                           class="button-link-success">
                                            Edit User
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ url('setting/users/'.$user->id) }}" class="button-link-info">
                                            Reset Password
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ url('setting/delete_users/'.$user->id) }}" class="button-link-dark"
                                           onclick="return confirm('Confrim Delete ?')">
                                            Delete User
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    {!! $users->render() !!}
                    <!--{{ csrf_field() }}
                    {!! Form::close() !!} -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection