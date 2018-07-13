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
                                <th scope="col">Rate Suffix</th>
                                <th scope="col">Description</th>
                                <th scope="col1">Edit Currency</th>
                                <th scope="col1">Delete Currency</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($rate_suffixes as $rate_suffix)
                                <tr>
                                    <th>{{ $rate_suffix->rate_suffix }}</th>
                                    <td>{!!  $rate_suffix->description !!}</td>
                                    <td>
                                        <a href="{{ url('setting/rate_suffixes/rate_suffix/'.$rate_suffix->id.'/edit') }}" class="button-link-success">
                                            Edit
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ url('setting/rate_suffixes/delete_rate_suffix/'.$rate_suffix->id) }}" class="button-link-dark" onclick="return confirm('Confrim Delete ?')">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    {!! $rate_suffixes->render() !!}
                    <!--{{ csrf_field() }}
                    {!! Form::close() !!} -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection