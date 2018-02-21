@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">Add Hotel</div>

                <div class="panel-body">
                    <div class="form-group">
                        {!! Form::open(['url' => 'hotel', 'files' => false]) !!}
                        <!-- {{ Form::open(array('url' => 'hotel/create', 'method' => 'get')) }} -->
                        <table class="table table-striped table-hover ">
                            <thead>
                                <tr class="">
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ Form::label('lb_hotel_name', 'ชื่อโรงแรม') }}</td>
                                    <td>{{ Form::text('hotel_name', null, ['class' => 'form-control', 'placeholder' => 'ชื่อโรงแรม']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_active', 'สถานะ') }}</td>
                                    <td>
                                        <div class="form-group">                     
                                            <select class="form-control" name="active_id">
                                                @foreach ($actives as $active)
                                                <option value="{{ $active->id }}"> {{ $active->active }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_hotel_comment', 'หมายเหตุ') }}</td>
                                    <td>{{ Form::textarea('hotel_comment', null, ['class' => 'form-control', 'placeholder' => 'หมายเหตุ']) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <center>
                            {{ Form::submit('Add Hotel', ['class' => 'btn btn-primary']) }}
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