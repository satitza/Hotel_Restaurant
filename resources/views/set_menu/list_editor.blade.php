@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Search Option</div>
                <div class="panel-body">
                    {{ Form::open(array('url' => 'search_menu', 'method' => 'post')) }}
                    <div class="form-group">
                        <select class="form-control" name="language_id">
                            <!--option value="" disabled selected>please_selected</option-->
                            @foreach($languages as $language)
                                <option value="{{ $language->id }}">{{ $language->language }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{ Form::submit('Search', ['class' => 'btn btn-primary']) }}
                    <button type="submit" class="btn btn-success">
                        <a href="{{ action('SetMenusController@create') }}">
                            Clear
                        </a>
                    </button>
                <!--{{ csrf_field() }}
                {!! Form::close() !!} -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">List Menu</div>
                <div class="panel-body">
                <!--{!! Form::open(['url' => '#', 'files' => false]) !!} -->
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Hotel Name</th>
                            <th scope="col">Restaurant Name</th>
                            <th scope="col">Menu Name</th>
                            <th scope="col">Date Start</th>
                            <th scope="col">Date End</th>
                            <th scope="col">Date Select</th>
                            <th scope="col">Time Lunch Start</th>
                            <th scope="col">Time Lunch End</th>
                            <th scope="col">Time Dinner Start</th>
                            <th scope="col">Time Dinner End</th>
                            <th scope="col">Price</th>
                            <th scope="col">Guest</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($set_menus as $set_menu)
                            <tr>
                                <td>{{  $set_menu[0]->id }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <button type="button" class="btn btn-info">
                                        <a href="{{ url('set_menu/') }}">
                                            Edit Menu
                                        </a>
                                    </button>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-danger">
                                        <a href="{{ url('delete_set_menu/') }}"
                                           onclick="return confirm('Confrim Delete ?')">
                                            Delete Menu
                                        </a>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
               <?php // {{ $set_menus->render() }} ?>
                <!--{{ csrf_field() }}
                {!! Form::close() !!} -->

                </div>
            </div>

        </div>
    </div>
@endsection
