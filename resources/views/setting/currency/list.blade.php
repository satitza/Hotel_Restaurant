@extends('layouts.app')

@section('content')

    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">List Hotel</div>

                    <div class="panel-body">
                    <!--{!! Form::open(['url' => '#', 'files' => false]) !!} -->
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Currency</th>
                                <th scope="col">Description</th>
                                <th scope="col1">Edit Currency</th>
                                <th scope="col1">Delete Currency</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($currencies as $currency)
                                <tr>
                                    <th></th>
                                    <td>{{ $currency->currency }}</td>
                                    <td>{{ $currency->description }}</td>
                                    <td>
                                        <a href="{{ url('setting/currencies/currency/'.$currency->id.'/edit') }}" class="button-link-success">
                                            Edit
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ url('setting/currencies/delete_currency/'.$currency->id) }}" class="button-link-dark" onclick="return confirm('Confrim Delete ?')">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    {!! $currencies->render() !!}
                    <!--{{ csrf_field() }}
                    {!! Form::close() !!} -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection