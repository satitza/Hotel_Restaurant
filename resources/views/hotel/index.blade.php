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
                                    <td>{{ Form::label('lb_address', 'ที่อยู่') }}</td>
                                    <td>{{ Form::textarea('hotel_address', null, ['class' => 'form-control', 'placeholder' => 'ที่อยู่โรงแรม']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_hotel_comment', 'หมายเหตุ') }}</td>
                                    <td>{{ Form::text('hotel_comment', null, ['class' => 'form-control', 'placeholder' => 'หมายเหตุ']) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <center>
                            {{ Form::submit('บันทึกลงฐานข้อมูล', ['class' => 'btn btn-primary']) }}
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