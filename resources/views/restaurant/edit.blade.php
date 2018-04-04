@extends('layouts.app')

@section('content')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .then( editor => {
                console.log( editor );
        } )
        .catch( error => {
                console.error( error );
        } );
        });
    </script>
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
                    <div class="panel-heading">Edit Restaurant</div>

                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::open(array('url' => 'restaurant/'.$id, 'method' => 'put', 'files' => true)) }}
                            <table class="table table-striped table-hover ">
                                <thead>
                                <tr class="">
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ Form::label('lb_restaurant_name', 'Restaurant Name') }}</td>
                                    <td>{{ Form::text('restaurant_name', $restaurant_name, ['class' => 'form-control', 'placeholder' => 'Restaurant Name']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_restaurant_email', 'Email Address') }}</td>
                                    <td>{{ Form::text('restaurant_email', $restaurant_email, ['class' => 'form-control', 'placeholder' => 'Email Address']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_hotel_id', 'Hotel') }}</td>
                                    <td style="display: none;">
                                        <div style="display: none">
                                            {{ Form::text('hotel_name', $hotel_name, ['class' => 'form-control', 'placeholder' => 'Hotel', 'readonly']) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" name="hotel_id">
                                                <option value="{{$hotel_id }}">{{ $hotel_name }}</option>
                                                @foreach ($hotels as $hotel)
                                                    <option value="{{ $hotel->id }}"> {{ $hotel->hotel_name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_active', 'Status') }}</td>
                                    <td>
                                        <div style="display: none">
                                            {{ Form::text('active', $active, ['class' => 'form-control', 'placeholder' => 'Restaurant Name', 'readonly']) }}
                                        </div>

                                        <div class="form-group">
                                            <select class="form-control" name="active_id">
                                                <option value="{{ $active_id }}">{{ $active }}</option>
                                            @foreach ($actives as $active)
                                                <!--   -->
                                                    <option value="{{ $active->id }}"> {{ $active->active }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_restaurant_comment', 'Comment') }}</td>
                                    <td>{{ Form::textarea('restaurant_comment', $restaurant_comment, ['id' => 'editor', 'placeholder' => 'Comment']) }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <center>
                                {{ Form::submit('Update Restaurant', ['class' => 'btn btn-primary']) }}
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