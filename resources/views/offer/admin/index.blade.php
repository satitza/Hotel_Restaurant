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

        jQuery(document).ready(function ($) {
            ClassicEditor
                .create( document.querySelector( '#editor_th' ) )
                .then( editor => {
                console.log( editor );
        } )
        .catch( error => {
                console.error( error );
        } );
        });

        jQuery(document).ready(function ($) {
            ClassicEditor
                .create( document.querySelector( '#editor_en' ) )
                .then( editor => {
                console.log( editor );
        } )
        .catch( error => {
                console.error( error );
        } );
        });

        jQuery(document).ready(function ($) {
            ClassicEditor
                .create( document.querySelector( '#editor_cn' ) )
                .then( editor => {
                console.log( editor );
        } )
        .catch( error => {
                console.error( error );
        } );
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
                                <td>{{ Form::label('lb_offer_pdf', 'PDF') }}</td>
                                <td>{{ Form::file('pdf', array('class' => 'image')) }}</td>
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
                            <tr style="background: #ffffcc">
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
                            <tr style="background: #ffffcc">
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
                            <tr style="background: #ffffcc">
                                <td>{{ Form::label('lb_lunch_price', 'Lunch Price per person') }}</td>
                                <td>{{ Form::text('offer_lunch_price', null, ['class' => 'form-control', 'placeholder' => '00.00']) }}</td>
                            </tr>
                            <tr style="background: #ffffcc">
                                <td>{{ Form::label('lb_lunch_guest', 'Lunch Max guest') }}</td>
                                <td>{{ Form::text('offer_lunch_guest', null, ['class' => 'form-control', 'placeholder' => 'Max Guest']) }}</td>
                            </tr>
                            <tr style="background: #e0e0d1">
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
                            </tr >
                            <tr style="background: #e0e0d1">
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
                            <tr style="background: #e0e0d1">
                                <td>{{ Form::label('lb_price', 'Dinner Price per person') }}</td>
                                <td>{{ Form::text('offer_dinner_price', null, ['class' => 'form-control', 'placeholder' => '00.00']) }}</td>
                            </tr>
                            <tr style="background: #e0e0d1">
                                <td>{{ Form::label('lb_guest', 'Dinner Max guest') }}</td>
                                <td>{{ Form::text('offer_dinner_guest', null, ['class' => 'form-control', 'placeholder' => 'Max Guest']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_comment_th', 'รายละเอียด') }}</td>
                                <td>{{ Form::textarea('offer_comment_th', null, ['id' => 'editor_th', 'placeholder' => 'รายละเอียด']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_comment_en', 'Comment') }}</td>
                                <td>{{ Form::textarea('offer_comment_en', null, ['id' => 'editor_en', 'placeholder' => 'Comment']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_comment_cn', '細節') }}</td>
                                <td>{{ Form::textarea('offer_comment_cn', null, ['id' => 'editor_cn', 'placeholder' => '細節']) }}</td>
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