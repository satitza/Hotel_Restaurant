@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
                    <div class="panel-heading">Edit Images</div>

                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::open(array('url' => 'image/'.$id , 'method' => 'put')) }}
                            <table class="table table-striped table-hover ">
                                <thead>
                                <tr class="">
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ Form::label('lb_offer_name_en', 'Offer Name') }}</td>
                                    <td>{{ Form::text('offer_name_en', $offer_name, ['class' => 'form-control', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_images', 'Images') }}</td>
                                    <td>
                                        @foreach( $photos as $photo )
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="images[]"
                                                           value="{{ $photo }}" >{{ $photo }}
                                                </label>
                                            </div>
                                            <img class="d-block w-50" src="{{ asset('/images/'.$photo) }}" alt="{{ $photo }}" width="200px">
                                            <hr>
                                        @endforeach
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <center>
                                {{ Form::submit('Remove', ['class' => 'btn btn-danger']) }}
                            </center>
                            {{ csrf_field() }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection