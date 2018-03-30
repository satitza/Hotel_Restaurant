@extends('layouts.app')

@section('content')
    <script>
        jQuery(document).ready(function ($) {
            $('.datepicker').datepicker({
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
                    <div class="panel-heading">Edit Menu</div>

                    <div class="panel-body">

                        <?php /* {!! Form::open(['url' => 'edit_set_menu', 'files' => false]) !!} --> */ ?>
                        {{ Form::open(array('url' => 'set_menu/'.$set_menu_id, 'method' => 'put', 'files' => true)) }}
                        <table class="table table-striped table-hover ">
                            <thead>
                            <tr class="">
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{ Form::label('lb_menu_old_image', 'Image') }}</td>
                                <td><img class="d-block w-50" src="{{ asset('images/'.$old_image ) }}" alt="First slide" height="200"></td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_image', 'New Image', array('class' => 'lb_menu_image')) }}</td>
                                <td>{{ Form::file('image', array('class' => 'image')) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_restaurant_name', 'Restaurant Name') }}</td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="restaurant_id">
                                            <option value="{{ $restaurant_id }}">{{ $restaurant_name }}</option>
                                            <!--option value="" disabled selected>please_selected</option-->
                                            @foreach($restaurants as $restaurant)
                                                <option value="{{ $restaurant->id }}">{{ $restaurant->restaurant_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_name_th', 'ชื่อเมนู') }}</td>
                                <td>{{ Form::text('menu_name_th', $menu_name_th, ['class' => 'form-control', 'placeholder' => 'ชื่อเมนู']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_name_en', 'Menu Name') }}</td>
                                <td>{{ Form::text('menu_name_en', $menu_name_en, ['class' => 'form-control', 'placeholder' => 'Menu Name']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_name_cn', '菜單標題') }}</td>
                                <td>{{ Form::text('menu_name_cn', $menu_name_cn, ['class' => 'form-control', 'placeholder' => '菜單標題']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_date_start', 'Date start') }}</td>
                                <td>{{ Form::text('menu_date_start', $menu_date_start, ['class' => 'form-control datepicker', 'placeholder' => 'Click select date']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_date_end', 'Date end') }}</td>
                                <td>{{ Form::text('menu_date_end', $menu_date_end, ['class' => 'form-control datepicker', 'placeholder' => 'Click select date']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_date_select', 'Select date') }}</td>
                                <td>{{ Form::text('old_date_select', $menu_date_select, ['class' => 'form-control', 'placeholder' => 'Select date', 'readonly']) }}</td>
                                <td>
                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                            data-target="#myModal">Edit
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_menu_time_lunch_start', 'Time lunch start') }}</td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="menu_time_lunch_start">
                                            <option value="{{ $menu_time_lunch_start }}">{{ $menu_time_lunch_start }}</option>
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
                                            <option value="{{ $menu_time_lunch_end }}">{{ $menu_time_lunch_end }}</option>
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
                                            <option value="{{ $menu_time_dinner_start }}">{{ $menu_time_dinner_start }}</option>
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
                                            <option value="{{ $menu_time_dinner_end }}">{{ $menu_time_dinner_end }}</option>
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
                                <td>{{ Form::text('menu_price', $menu_price, ['class' => 'form-control', 'placeholder' => '00.00']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_guest', 'Max guest') }}</td>
                                <td>{{ Form::text('menu_guest', $menu_guest, ['class' => 'form-control', 'placeholder' => 'Max guest']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_set_menu_comment_th', 'รายละเอียด') }}</td>
                                <td>{{ Form::textarea('menu_comment_th', $menu_comment_th, ['class' => 'form-control', 'placeholder' => 'รายละเอียด']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_set_menu_comment_en', 'Comment') }}</td>
                                <td>{{ Form::textarea('menu_comment_en', $menu_comment_en, ['class' => 'form-control', 'placeholder' => 'Comment']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_set_menu_comment_cn', '細節') }}</td>
                                <td>{{ Form::textarea('menu_comment_cn', $menu_comment_cn, ['class' => 'form-control', 'placeholder' => '細節']) }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <center>
                            {{ Form::submit('Update Menu', ['class' => 'btn btn-primary']) }}
                        </center>
                        {{ csrf_field() }}

                    <!--Modal-->

                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">

                                <!--Modal Content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        Edit Date Select
                                    </div>
                                    <div class="modal-content">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-lg-1"></div>
                                                <div class="col-lg-10">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="date_check_box[]" value="sun">
                                                            Sun.
                                                        </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="date_check_box[]" value="mon">
                                                            Mon.
                                                        </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="date_check_box[]" value="tues">
                                                            Tues.
                                                        </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="date_check_box[]" value="wed">
                                                            Wed.
                                                        </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="date_check_box[]"
                                                                   value="thurs"> Thurs.
                                                        </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="date_check_box[]" value="fri">
                                                            Fri.
                                                        </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="date_check_box[]" value="sat">
                                                            Sat.
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-info" data-dismiss="modal"
                                                id="modal-close">Close
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

