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

                        {{ Form::open(array('url' => 'set_menu', 'method' => 'post')) }}

                        <table class="table table-striped table-hover ">
                            <thead>
                            <tr class="">
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{ Form::label('lb_restaurant_language', 'Languages') }}</td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="restaurant_id">
                                            <!--option value="" disabled selected>please_selected</option-->
                                            @foreach($languages as  $language)
                                                <option value="{{ $language->id }}">{{ $language->language }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
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
                                <td>{{ Form::label('lb_menu_name', 'Menu Name') }}</td>
                                <td>{{ Form::text('menu_name', null, ['class' => 'form-control', 'placeholder' => 'Menu Name']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_date_start', 'Date start') }}</td>
                                <td>{{ Form::text('menu_date_start', null, ['class' => 'form-control datepicker', 'placeholder' => 'Click select date']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_date_end', 'Date end') }}</td>
                                <td>{{ Form::text('menu_date_end', null, ['class' => 'form-control datepicker', 'placeholder' => 'Click select date']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_date_select', 'Select date') }}</td>
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
                                <td>{{ Form::label('lb_menu_time_lunch_start', 'Time lunch start') }}</td>
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
                                <td>{{ Form::label('lb_menu_time_lunch_end', 'Time lunch end') }}</td>
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
                                <td>{{ Form::label('lb_menu_time_dinner_start', 'Time dinner start') }}</td>
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
                                <td>{{ Form::label('lb_menu_time_dinner_end', 'Time dinner end') }}</td>
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
                                <td>{{ Form::label('lb_price', 'Price per person') }}</td>
                                <td>{{ Form::text('menu_price', null, ['class' => 'form-control', 'placeholder' => '00.00']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_guest', 'Max guest') }}</td>
                                <td>{{ Form::text('menu_guest', null, ['class' => 'form-control', 'placeholder' => 'Max Guest']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_set_menu_comment', 'Comment') }}</td>
                                <td>{{ Form::textarea('set_menu_comment', null, ['class' => 'form-control', 'placeholder' => 'Comment']) }}</td>
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