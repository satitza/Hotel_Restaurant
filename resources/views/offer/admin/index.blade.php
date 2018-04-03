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

        /*$(function () {
            $('#language_option').change(function () {
                var language = $('#language_option').find(":selected").text();
                if (language == "TH") {
                    $('.lb_language').text("เลือกภาษา");
                    $('.lb_restaurant_name').text("ชื่อโรงแรม");
                    $('.lb_menu_name').text("ชื่อเมนู");
                    $('.lb_menu_image').text("รูปภาพ");
                    $('.lb_date_start').text("วันที่เริ่ม");
                    $('.lb_date_end').text("วันที่สิ้นสุด");
                    $('.lb_date_select').text("เลือกวัน");
                    $('.lb_time_lunch_start').text("เวลาเริ่มช่วงกลางวัน");
                    $('.lb_time_lunch_end').text("เวลาเสิ้นสุดช่วงกลางวัน");
                    $('.lb_time_dinner_start').text("เวลาเริ่มช่วงกลางคืน");
                    $('.lb_time_dinner_end').text("เวลาสิ้นสุดช่วงกลางคืน");
                    $('.lb_price').text("ราคาต่อคน");
                    $('.lb_guest').text("จำนวนคนที่รองรับสูงสุด");
                    $('.lb_comment').text("รายละเอียด");
                } else if (language == "EN") {
                    $('.lb_language').text("Choose Language");
                    $('.lb_restaurant_name').text("Restaurant Name");
                    $('.lb_menu_name').text("Menu Name");
                    $('.lb_menu_image').text("Menu Image");
                    $('.lb_date_start').text("Date Start");
                    $('.lb_date_end').text("Date End");
                    $('.lb_date_select').text("Date Select");
                    $('.lb_time_lunch_start').text("Time Lunch Start");
                    $('.lb_time_lunch_end').text("Time Lunch End");
                    $('.lb_time_dinner_start').text("Time Dinner Start");
                    $('.lb_time_dinner_end').text("Time Dinner End");
                    $('.lb_price').text("Price per person");
                    $('.lb_guest').text("Max guest");
                    $('.lb_comment').text("Comment");
                } else if (language == "CN") {
                    $('.lb_language').text("選擇語言");
                    $('.lb_restaurant_name').text("酒店名稱");
                    $('.lb_menu_name').text("菜單標題");
                    $('.lb_menu_image').text("圖片");
                    $('.lb_date_start').text("開始日期");
                    $('.lb_date_end').text("結束日期");
                    $('.lb_date_select').text("選擇一天");
                    $('.lb_time_lunch_start').text("白天開始");
                    $('.lb_time_lunch_end').text("一天結束");
                    $('.lb_time_dinner_start').text("夜間時間");
                    $('.lb_time_dinner_end').text("夜間時間");
                    $('.lb_price').text("每人價格");
                    $('.lb_guest').text("支持的最大人數");
                    $('.lb_comment').text("細節");
                }
            });
        });*/

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
                    <div class="panel-heading">Add Offer</div>

                    <div class="panel-body">

                        {!! Form::open(['url' => 'offer', 'files' => true]) !!}

                        <table class="table table-striped table-hover ">
                            <thead>
                            <tr class="">
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--tr>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="language_id" id="language_option">


                                                <option value=""></option>

                                        </select>
                                    </div>
                                </td>
                            </tr-->
                            <tr>
                                <td>{{ Form::label('lb_restaurant_name', 'Restaurant Name') }}</td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="restaurant_id">
                                            <!--option value="" disabled selected>please_selected</option-->
                                            @foreach($restaurants as  $restaurant)
                                                <option value="{{ $restaurant->id }}">{{ $restaurant->restaurant_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_offer_name_th', 'ชื่อเมนู') }}</td>
                                <td>{{ Form::text('offer_name_th', null, ['class' => 'form-control', 'placeholder' => 'ชื่อเมนู']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_offer_name_en', 'Offer Name') }}</td>
                                <td>{{ Form::text('offer_name_en', null, ['class' => 'form-control', 'placeholder' => 'Menu Name']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_offer_name_cn', '提供名稱') }}</td>
                                <td>{{ Form::text('offer_name_cn', null, ['class' => 'form-control', 'placeholder' => '提供名稱']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_offer_image', 'Images') }}</td>
                                <td>{{ Form::file('image', array('class' => 'image')) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_date_start', 'Date start') }}</td>
                                <td>{{ Form::text('offer_date_start', null, ['class' => 'form-control datepicker', 'placeholder' => 'Click select date']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_date_end', 'Date end') }}</td>
                                <td>{{ Form::text('offer_date_end', null, ['class' => 'form-control datepicker', 'placeholder' => 'Click select date']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_day_select', 'Day select') }}</td>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="day_check_box[]" value="sun"> Sun.
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="day_check_box[]" value="mon"> Mon.
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="day_check_box[]" value="tues"> Tues.
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="day_check_box[]" value="wed"> Wed.
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="day_check_box[]" value="thurs"> Thurs.
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="day_check_box[]" value="fri"> Fri.
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="day_check_box[]" value="sat"> Sat.
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_time_lunch_start', 'Lunch time start') }}</td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="offer_time_lunch_start">
                                            <!--option value="" disabled selected>please_selected</option-->
                                            @foreach($time_lunchs as $time_lunch)
                                                <option value="{{ $time_lunch->time_lunch }}">{{ $time_lunch->time_lunch }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_time_lunch_end', 'Lunch time end') }}</td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="offer_time_lunch_end">
                                            <!--option value="" disabled selected>please_selected</option-->
                                            @foreach($time_lunchs as $time_lunch)
                                                <option value="{{ $time_lunch->time_lunch }}">{{ $time_lunch->time_lunch }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_time_dinner_start', 'Dinner time start') }}</td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="offer_time_dinner_start">
                                            <!--option value="" disabled selected>please_selected</option-->
                                            @foreach($time_dinners as $time_dinner)
                                                <option value="{{ $time_dinner->time_dinner }}">{{ $time_dinner->time_dinner }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_time_dinner_end', 'Dinner time end') }}</td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="offer_time_dinner_end">
                                            <!--option value="" disabled selected>please_selected</option-->
                                            @foreach($time_dinners as $time_dinner)
                                                <option value="{{ $time_dinner->time_dinner }}">{{ $time_dinner->time_dinner }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_price', 'Price per person') }}</td>
                                <td>{{ Form::text('offer_price', null, ['class' => 'form-control', 'placeholder' => '00.00']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_guest', 'Max guest') }}</td>
                                <td>{{ Form::text('offer_guest', null, ['class' => 'form-control', 'placeholder' => 'Max Guest']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_comment_th', 'รายละเอียด') }}</td>
                                <td>{{ Form::textarea('offer_comment_th', null, ['class' => 'form-control', 'placeholder' => 'รายละเอียด']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_comment_en', 'Comment') }}</td>
                                <td>{{ Form::textarea('offer_comment_en', null, ['class' => 'form-control', 'placeholder' => 'Comment']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_comment_cn', '細節') }}</td>
                                <td>{{ Form::textarea('offer_comment_cn', null, ['class' => 'form-control', 'placeholder' => '細節']) }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <center>
                            {{ Form::submit('Add Offer', ['class' => 'btn btn-primary']) }}
                        </center>
                        {{ csrf_field() }}
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection