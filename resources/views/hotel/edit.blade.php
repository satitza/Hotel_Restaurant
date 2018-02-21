@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">Edit Hotel</div>

                <div class="panel-body">
                    <div class="form-group">
                        <!-- {!! Form::open(['url' => 'hotel', 'files' => false]) !!} -->
                        {{ Form::open(array('url' => 'hotel/'.$hotel_id , 'method' => 'put')) }}
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
                                    <td>{{ Form::text('hotel_name', $hotel_name, ['class' => 'form-control', 'placeholder' => 'ชื่อโรงแรม']) }}</td>
                                </tr>                           
                                <tr>
                                    <td>{{ Form::label('lb_active', 'สถานะ') }}</td>
                                    <td>
                                        <div class="form-group">                                                              
                                            <select class="form-control" name="active_id">
                                                @foreach ($actives as $active) 
                                                <!--   -->
                                                <option value="{{ $active->id}} "> {{ $active->active }} </option>
                                                @endforeach
                                            </select>                                 
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_hotel_comment', 'หมายเหตุ') }}</td>
                                    <td>{{ Form::textarea('hotel_comment', $hotel_comment, ['class' => 'form-control', 'placeholder' => 'หมายเหตุ']) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <center>
                            {{ Form::submit('Edit Hotel', ['class' => 'btn btn-primary']) }}
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