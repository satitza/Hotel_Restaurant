@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">Add Menu</div>

                <div class="panel-body">

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
                                <td>{{ Form::label('lb_restaurant_name', 'ชื่อร้านอาหาร') }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_name', 'ชื่อเมนู') }}</td>
                                <td>{{ Form::text('menu_name', null, ['class' => 'form-control', 'placeholder' => 'ชื่อเมนู']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_date_start', 'เริ่มตั้งแต่วันที่') }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_date_end', 'สิ้นสุดวันที่') }}</td>
                                <td></td>
                            </tr>
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            <tr>
                                <td>{{ Form::label('lb_active', 'สถานะ') }}</td>
                                <td>
                                    <div class="form-group">                     
                                        <select class="form-control" name="active_id">
                                            <!--option value="" disabled selected>please_selected</option-->
                                           
                                            <option value=""><option>
                                            
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
@endsection
