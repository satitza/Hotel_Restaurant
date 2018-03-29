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
                <div class="panel-heading">Add Restautant</div>

                <div class="panel-body">
                    <div class="form-group">
                        {!! Form::open(['url' => 'restaurant', 'files' => true]) !!}
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
                                    <td>{{ Form::text('restaurant_name', null, ['class' => 'form-control', 'placeholder' => 'Restaurant Name']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_restaurant_email', 'Email Address') }}</td>
                                    <td>{{ Form::text('restaurant_email', null, ['class' => 'form-control', 'placeholder' => 'Email Address']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_hotel', 'Hotel') }}</td>
                                    <td>
                                        <div class="form-group">                     
                                            <select class="form-control" name="hotel_id">
                                                <!-- option value="" disabled selected>please_selected</option -->
                                                @foreach ($hotels as $hotel)
                                                <option value="{{ $hotel->id }}"> {{ $hotel->hotel_name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_restaurant_active', 'Status') }}</td>
                                    <td>
                                        <div class="form-group">                     
                                            <select class="form-control" name="active_id">
                                                <!-- option value="" disabled selected>please_selected</option -->
                                                @foreach ($actives as $active)
                                                <option value="{{ $active->id }}"> {{ $active->active }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_restaurant_comment', 'Comment') }}</td>
                                    <td>{{ Form::textarea('restaurant_comment', null, ['class' => 'form-control', 'placeholder' => 'comment']) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <center>
                            {{ Form::submit('Add Restaurant', ['class' => 'btn btn-primary']) }}
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

