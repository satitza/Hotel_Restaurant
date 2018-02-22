@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">Edit Restaurant</div>

                <div class="panel-body">
                    <div class="form-group">
                        <!-- {!! Form::open(['url' => 'hotel', 'files' => false]) !!} -->
                        {{ Form::open(array('url' => 'restaurant/'.$id , 'method' => 'put')) }}
                        <table class="table table-striped table-hover ">
                            <thead>
                                <tr class="">
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ Form::label('lb_restaurant_name', 'ชื่อร้านอาหาร') }}</td>
                                    <td>{{ Form::text('restaurant_name', $restaurant_name, ['class' => 'form-control', 'placeholder' => 'ชื่อร้านอาหาร']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_hotel_id', 'โรงแรม') }}</td>
                                    <td>
                                        <div>
                                            {{ Form::text('restaurant_name', $hotel_name, ['class' => 'form-control', 'placeholder' => 'ชื่อร้านอาหาร', 'readonly']) }}
                                        </div>
                                        <br>
                                        <div class="form-group">                                                              
                                            <select class="form-control" name="hotel_id">
                                                @foreach ($hotels as $hotel)
                                                <!--   -->
                                                <option value="{{ $hotel->id }}"> {{ $hotel->hotel_name }} </option>
                                                @endforeach
                                            </select>                                 
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_active', 'สถานะ') }}</td>
                                    <td>
                                        <div>
                                            {{ Form::text('restaurant_name', $active, ['class' => 'form-control', 'placeholder' => 'ชื่อร้านอาหาร', 'readonly']) }}
                                        </div>
                                        <br>
                                        <div class="form-group">                                                              
                                            <select class="form-control" name="active_id">
                                                @foreach ($actives as $active)
                                                <!--   -->
                                                <option value="{{ $active->id }}"> {{ $active->active }} </option>
                                                @endforeach
                                            </select>                                 
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_restaurant_comment', 'หมายเหตุ') }}</td>
                                    <td>{{ Form::textarea('restaurant_comment', $restaurant_comment, ['class' => 'form-control', 'placeholder' => 'หมายเหตุ']) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <center>
                            {{ Form::submit('Edit Restaurant', ['class' => 'btn btn-primary']) }}
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