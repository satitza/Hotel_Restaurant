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
                .create(document.querySelector('#short_en'))
                .then(editor => {
                console.log(editor);
        } )
        .
            catch(error => {
                console.error(error);
        } )
            ;
        });

        jQuery(document).ready(function ($) {
            ClassicEditor
                .create(document.querySelector('#short_th'))
                .then(editor => {
                console.log(editor);
        } )
        .
            catch(error => {
                console.error(error);
        } )
            ;
        });

        jQuery(document).ready(function ($) {
            ClassicEditor
                .create(document.querySelector('#short_cn'))
                .then(editor => {
                console.log(editor);
        } )
        .
            catch(error => {
                console.error(error);
        } )
            ;
        });

        jQuery(document).ready(function ($) {
            ClassicEditor
                .create(document.querySelector('#editor_th'))
                .then(editor => {
                console.log(editor);
        } )
        .
            catch(error => {
                console.error(error);
        } )
            ;
        });

        jQuery(document).ready(function ($) {
            ClassicEditor
                .create(document.querySelector('#editor_en'))
                .then(editor => {
                console.log(editor);
        } )
        .
            catch(error => {
                console.error(error);
        } )
            ;
        });

        jQuery(document).ready(function ($) {
            ClassicEditor
                .create(document.querySelector('#editor_cn'))
                .then(editor => {
                console.log(editor);
        } )
        .
            catch(error => {
                console.error(error);
        } )
            ;
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
                    <div class="panel-heading">Edit Offer</div>

                    <div class="panel-body">

                        <?php /* {!! Form::open(['url' => 'edit_set_menu', 'files' => false]) !!} --> */ ?>
                        {{ Form::open(array('url' => 'offer/'.$offer_id, 'method' => 'put', 'files' => true)) }}
                        <table class="table table-striped table-hover ">
                            <thead>
                            <tr class="">
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{ Form::label('lb_offer_old_attachments', 'Attachments') }}</td>
                                <td>{{ Form::text('old_attachments', $old_attachments, ['class' => 'form-control', 'placeholder' => '', 'id' => 'text_attachments','readonly']) }}</td>
                                <td>
                                    <button type="button" class="btn btn-success" onclick="document.getElementById('text_attachments').value = ''">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_offer_attachments', 'New Attachments', array('class' => 'lb_offer_image')) }}</td>
                                <td>{{ Form::file('attachments', array('class' => 'image')) }}</td>
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
                                <td>{{ Form::label('lb_offer_name_th', 'ชื่ออ๊อฟเฟอร์') }}</td>
                                <td>{{ Form::text('offer_name_th', $offer_name_th, ['class' => 'form-control', 'placeholder' => 'ชื่ออ๊อฟเฟอร์']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_offer_name_en', 'Offer Name') }}</td>
                                <td>{{ Form::text('offer_name_en', $offer_name_en, ['class' => 'form-control', 'placeholder' => 'Offer Name']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_offer_name_cn', '提供名稱') }}</td>
                                <td>{{ Form::text('offer_name_cn', $offer_name_cn, ['class' => 'form-control', 'placeholder' => '提供名稱']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_offer_date_start', 'Date start') }}</td>
                                <td>{{ Form::text('offer_date_start', $offer_date_start, ['class' => 'form-control datepicker', 'placeholder' => 'Click select date']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_offer_date_end', 'Date end') }}</td>
                                <td>{{ Form::text('offer_date_end', $offer_date_end, ['class' => 'form-control datepicker', 'placeholder' => 'Click select date']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_offer_day_select', 'Day Select') }}</td>
                                <td>{{ Form::text('old_day_select', $offer_day_select, ['class' => 'form-control', 'placeholder' => 'Select Day', 'readonly']) }}</td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#myModal">Edit
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <table>
                            <tr>
                                <h2>Offer Time Setting</h2>
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#lunch_time">Lunch Time</a></li>
                                    <li><a data-toggle="tab" href="#dinner_time">Dinner Time</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div id="lunch_time" class="tab-pane fade in active">
                                        <div class="form-group">
                                            <br>
                                            {{ Form::label('lb_time_lunch_start', 'Lunch time start') }}
                                            <select class="form-control" name="offer_time_lunch_start">
                                                <option value="{{ $offer_time_lunch_start }}">{{ $offer_time_lunch_start }}</option>
                                                @foreach($time_lunchs as $time_lunch)
                                                    <option value="{{ $time_lunch->time_lunch }}">{{ $time_lunch->time_lunch }}</option>
                                                @endforeach
                                            </select>
                                            {{ Form::label('lb_time_lunch_end', 'Lunch time end') }}
                                            <select class="form-control" name="offer_time_lunch_end">
                                                <option value="{{ $offer_time_lunch_end }}">{{ $offer_time_lunch_end }}</option>
                                                @foreach($time_lunchs as $time_lunch)
                                                    <option value="{{ $time_lunch->time_lunch }}">{{ $time_lunch->time_lunch }}</option>
                                                @endforeach
                                            </select>

                                            {{ Form::label('lb_lunch_price', 'Lunch Price per person') }}
                                            {{ Form::text('offer_lunch_price', $offer_lunch_price, ['class' => 'form-control', 'placeholder' => '00.00', 'readonly']) }}

                                            {{ Form::label('lb_lunch_currency', 'Lunch Currency') }}
                                            {{ Form::text('offer_lunch_currency', $lunch_currency, ['class' => 'form-control', 'placeholder' => 'Lunch Currency', 'readonly']) }}

                                            {{ Form::label('lb_lunch_guest', 'Lunch Max guest') }}
                                            {{ Form::text('offer_lunch_guest', $offer_lunch_guest, ['class' => 'form-control', 'placeholder' => 'Max Guest', 'readonly']) }}

                                        </div>
                                    </div>
                                    <div id="dinner_time" class="tab-pane fade">
                                        <br>
                                        {{ Form::label('lb_time_dinner_start', 'Dinner time start') }}
                                        <div class="form-group">
                                            <select class="form-control" name="offer_time_dinner_start">
                                                <option value="{{ $offer_time_dinner_start }}">{{ $offer_time_dinner_start }}</option>
                                                @foreach($time_dinners as $time_dinner)
                                                    <option value="{{ $time_dinner->time_dinner }}">{{ $time_dinner->time_dinner }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{ Form::label('lb_time_dinner_end', 'Dinner time end') }}
                                        <div class="form-group">
                                            <select class="form-control" name="offer_time_dinner_end">
                                                <option value="{{ $offer_time_dinner_end }}">{{ $offer_time_dinner_end }}</option>
                                                @foreach($time_dinners as $time_dinner)
                                                    <option value="{{ $time_dinner->time_dinner }}">{{ $time_dinner->time_dinner }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{ Form::label('lb_price', 'Dinner Price per person') }}
                                        {{ Form::text('offer_dinner_price', $offer_dinner_price, ['class' => 'form-control', 'placeholder' => '00.00', 'readonly']) }}

                                        {{ Form::label('lb_dinner_currency', 'Dinner Currency') }}
                                        {{ Form::text('offer_dinner_currency', $dinner_currency, ['class' => 'form-control', 'placeholder' => 'Dinner Currency', 'readonly']) }}

                                        {{ Form::label('lb_guest', 'Dinner Max guest') }}
                                        {{ Form::text('offer_dinner_guest', $offer_dinner_guest, ['class' => 'form-control', 'placeholder' => 'Max Guest', 'readonly']) }}

                                    </div>
                                </div>
                            </tr>
                        </table>
                        <hr>


                        <table class="table table-striped table-hover">
                            <tr>
                                <td>
                                    <h3>Short Description</h3>
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#tab_short_th">คำอธิบายสั้น</a>
                                        </li>
                                        <li><a data-toggle="tab" href="#tab_short_en">Short Description</a></li>
                                        <li><a data-toggle="tab" href="#tab_short_cn">簡短的介紹</a></li>

                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="tab-content">
                                        <div id="tab_short_th" class="tab-pane fade in active">
                                            {{ Form::textarea('offer_short_th', $offer_short_th, ['id' => 'short_th']) }}
                                        </div>
                                        <div id="tab_short_en" class="tab-pane fade">
                                            {{ Form::textarea('offer_short_en', $offer_short_en, ['id' => 'short_en']) }}
                                        </div>
                                        <div id="tab_short_cn" class="tab-pane fade">
                                            {{ Form::textarea('offer_short_cn', $offer_short_cn, ['id' => 'short_cn']) }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <hr>
                        <table class="table table-striped table-hover">
                            <tr>
                                <td>
                                    <h3>Long Description</h3>
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#tab_long_th">รายละเอียด</a>
                                        </li>
                                        <li><a data-toggle="tab" href="#tab_long_en">Long Description</a></li>
                                        <li><a data-toggle="tab" href="#tab_long_cn">細節</a></li>

                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="tab-content">
                                        <div id="tab_long_th" class="tab-pane fade in active">
                                            {{ Form::textarea('offer_comment_th', $offer_comment_th , ['id' => 'editor_th']) }}
                                        </div>
                                        <div id="tab_long_en" class="tab-pane fade">
                                            {{ Form::textarea('offer_comment_en', $offer_comment_en, ['id' => 'editor_en']) }}
                                        </div>
                                        <div id="tab_long_cn" class="tab-pane fade">
                                            {{ Form::textarea('offer_comment_cn', $offer_comment_cn, ['id' => 'editor_cn']) }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <hr>


                        <hr>

                        <center>
                            <div class="container-fluid">
                                {{ Form::submit('Update Offer', ['class' => 'btn btn-success']) }}
                                <a href="{{ url('list_term/'.$offer_id) }}" class="button-link-success">
                                    Terms & Conditions
                                </a>
                                <a href="{{ url('upload/'.$offer_id) }}" class="button-link-info">
                                    Upload Images
                                </a>
                                <a href="{{ url('image/'.$offer_id.'/edit') }}" class="button-link-dark">
                                    View Images
                                </a>
                            </div>
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
                                                            <input type="checkbox" name="day_check_box[]" value="sun">
                                                            Sun.
                                                        </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="day_check_box[]" value="mon">
                                                            Mon.
                                                        </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="day_check_box[]" value="tues">
                                                            Tues.
                                                        </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="day_check_box[]" value="wed">
                                                            Wed.
                                                        </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="day_check_box[]"
                                                                   value="thurs"> Thurs.
                                                        </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="day_check_box[]" value="fri">
                                                            Fri.
                                                        </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="day_check_box[]" value="sat">
                                                            Sat.
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-dismiss="modal"
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

