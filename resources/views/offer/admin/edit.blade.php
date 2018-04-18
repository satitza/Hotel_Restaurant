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
                                <td>{{ Form::label('lb_offer_old_pdf', 'PDF') }}</td>
                                <td>{{ Form::text('old_pdf', $old_pdf, ['class' => 'form-control', 'placeholder' => '', 'readonly']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_offer_pdf', 'New PDF', array('class' => 'lb_offer_image')) }}</td>
                                <td>{{ Form::file('pdf', array('class' => 'image')) }}</td>
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
                                <td>{{ Form::label('lb_offer_name_th', 'ชื่อเมนู') }}</td>
                                <td>{{ Form::text('offer_name_th', $offer_name_th, ['class' => 'form-control', 'placeholder' => 'ชื่อเมนู']) }}</td>
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
                            <tr style="background: #ffffcc">
                                <td>{{ Form::label('lb_offer_time_lunch_start', 'Time lunch start') }}</td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="offer_time_lunch_start">
                                            <option value="{{ $offer_time_lunch_start }}">{{ $offer_time_lunch_start }}</option>
                                            <!--option value="" disabled selected>please_selected</option-->
                                            @foreach($time_lunchs as $time_lunch)
                                                <option value="{{ $time_lunch->time_lunch }}">{{ $time_lunch->time_lunch }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr style="background: #ffffcc">
                                <td>{{ Form::label('lb_offer_time_lunch_end', 'Time lunch end') }}</td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="offer_time_lunch_end">
                                            <option value="{{ $offer_time_lunch_end }}">{{ $offer_time_lunch_end }}</option>
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
                                <td>{{ Form::text('offer_lunch_price', $offer_lunch_price, ['class' => 'form-control', 'placeholder' => '00.00']) }}</td>
                            </tr >
                            <tr style="background: #ffffcc">
                                <td>{{ Form::label('lb_lunch_guest', 'Lunch Max guest') }}</td>
                                <td>{{ Form::text('offer_lunch_guest', $offer_lunch_guest, ['class' => 'form-control', 'placeholder' => 'Max guest']) }}</td>
                            </tr>
                            <tr style="background: #e0e0d1">
                                <td>{{ Form::label('lb_offer_time_dinner_start', 'Time dinner start') }}</td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="offer_time_dinner_start">
                                            <option value="{{ $offer_time_dinner_start }}">{{ $offer_time_dinner_start }}</option>
                                            <!--option value="" disabled selected>please_selected</option-->
                                            @foreach($time_dinners as $time_dinner)
                                                <option value="{{ $time_dinner->time_dinner }}">{{ $time_dinner->time_dinner }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr style="background: #e0e0d1">
                                <td>{{ Form::label('lb_offer_time_dinner_end', 'Time dinner end') }}</td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="offer_time_dinner_end">
                                            <option value="{{ $offer_time_dinner_end }}">{{ $offer_time_dinner_end }}</option>
                                            <!--option value="" disabled selected>please_selected</option-->
                                            @foreach($time_dinners as $time_dinner)
                                                <option value="{{ $time_dinner->time_dinner }}">{{ $time_dinner->time_dinner }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr style="background: #e0e0d1">
                                <td>{{ Form::label('lb_dinner_price', 'Dinner Price per person') }}</td>
                                <td>{{ Form::text('offer_dinner_price', $offer_dinner_price, ['class' => 'form-control', 'placeholder' => '00.00']) }}</td>
                            </tr >
                            <tr style="background: #e0e0d1">
                                <td>{{ Form::label('lb_dinner_guest', 'Dinner Max guest') }}</td>
                                <td>{{ Form::text('offer_dinner_guest', $offer_dinner_guest, ['class' => 'form-control', 'placeholder' => 'Max guest']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_offer_comment_th', 'รายละเอียด') }}</td>
                                <td>{{ Form::textarea('offer_comment_th', $offer_comment_th, ['id' => 'editor_th', 'placeholder' => 'รายละเอียด']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_offer_comment_en', 'Comment') }}</td>
                                <td>{{ Form::textarea('offer_comment_en', $offer_comment_en, ['id' => 'editor_en', 'placeholder' => 'Comment']) }}</td>
                            </tr>
                            <tr>
                                <td>{{ Form::label('lb_offer_comment_cn', '細節') }}</td>
                                <td>{{ Form::textarea('offer_comment_cn', $offer_comment_cn, ['id' => 'editor_cn', 'placeholder' => '細節']) }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <center>
                            {{ Form::submit('Update Offer', ['class' => 'btn btn-success']) }}
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

