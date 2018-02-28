@extends('layouts.app')

@section('content')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $(".datepicker").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
            });
        });
    </script>
    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px">
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
                    <div class="panel-heading">Add Menu</div>

                    <div class="panel-body">

                    {!! Form::open(['url' => 'set_menu', 'files' => false]) !!}
                    <!-- {{ Form::open(array('url' => 'hotel/create', 'method' => 'get')) }} -->
                        <table class="table table-striped table-hover ">
                            <thead>
                            <tr class="">
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr style="display: none">
                                <td>{{ Form::label('lb_hotel_name', 'ชื่อโรงแรม') }}</td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="hotel_id">
                                            <!--option value="" disabled selected>please_selected</option-->
                                            @foreach($hotels as $hotel)
                                                <option value="{{ $hotel->id }}">{{ $hotel->hotel_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_restaurant_name', 'ชื่อร้านอาหาร') }}</td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="restaurant_id">
                                            <!--option value="" disabled selected>please_selected</option-->
                                            @foreach($restaurants as $restaurant)
                                                <option value="{{ $restaurant->id }}">{{ $restaurant->restaurant_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_name', 'ชื่อเมนู') }}</td>
                                <td>{{ Form::text('menu_name', null, ['class' => 'form-control', 'placeholder' => 'ชื่อเมนู']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_date_start', 'เริ่มตั้งแต่วันที่') }}</td>
                                <td>{{ Form::text('menu_date_start', null, ['class' => 'form-control datepicker', 'placeholder' => 'คลิกเลือกวัน']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_date_end', 'สิ้นสุดวันที่') }}</td>
                                <td>{{ Form::text('menu_date_end', null, ['class' => 'form-control datepicker', 'placeholder' => 'คลิกเลือกวัน']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_date_select', 'เลือกวัน') }}</td>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="date_check_box[]" value="sun"> Sun.
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="date_check_box[]" value="mon"> Mon.
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="date_check_box[]" value="tues"> Tues.
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="date_check_box[]" value="wed"> Wed.
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="date_check_box[]" value="thurs"> Thurs.
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="date_check_box[]" value="fri"> Fri.
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="date_check_box[]" value="sat"> Sat.
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_time_lunch_start', 'เวลาเริ่มช่วงกลางวัน') }}</td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="menu_time_lunch_start">
                                            <!--option value="" disabled selected>please_selected</option-->
                                            @foreach($time_lunchs as $time_lunch)
                                                <option value="{{ $time_lunch->time_lunch }}">{{ $time_lunch->time_lunch }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_time_lunch_end', 'เวลาสิ้นสุดช่วงกลางวัน') }}</td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="menu_time_lunch_end">
                                            <!--option value="" disabled selected>please_selected</option-->
                                            @foreach($time_lunchs as $time_lunch)
                                                <option value="{{ $time_lunch->time_lunch }}">{{ $time_lunch->time_lunch }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_time_dinner_start', 'เวลาเริ่มช่วงกลางคืน') }}</td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="menu_time_dinner_start">
                                            <!--option value="" disabled selected>please_selected</option-->
                                            @foreach($time_dinners as $time_dinner)
                                                <option value="{{ $time_dinner->time_dinner }}">{{ $time_dinner->time_dinner }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_time_dinner_end', 'เวลาสิ้นสุดช่วงกลางคืน') }}</td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="menu_time_dinner_end">
                                            <!--option value="" disabled selected>please_selected</option-->
                                            @foreach($time_dinners as $time_dinner)
                                                <option value="{{ $time_dinner->time_dinner }}">{{ $time_dinner->time_dinner }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_price', 'ราคาต่อคน') }}</td>
                                <td>{{ Form::text('menu_price', null, ['class' => 'form-control', 'placeholder' => '00.00']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_guest', 'จำนวนคน') }}</td>
                                <td>{{ Form::text('menu_guest', null, ['class' => 'form-control', 'placeholder' => 'จำนวนคน']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_set_menu_comment', 'รายละเอียด') }}</td>
                                <td>{{ Form::textarea('set_menu_comment', null, ['class' => 'form-control', 'placeholder' => 'รายละเอียด']) }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <center>
                            {{ Form::submit('Add Menu', ['class' => 'btn btn-primary']) }}
                        </center>
                        {{ csrf_field() }}
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

