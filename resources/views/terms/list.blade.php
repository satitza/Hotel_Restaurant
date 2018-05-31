@extends('layouts.app')

@section('content')
    {{--<div class="container-fluid" style="margin-left: 10px; margin-right: 10px">--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-12">--}}
    {{--<div class="panel panel-default">--}}
    {{--<div class="panel-heading">Search Option</div>--}}
    {{--<div class="panel-body">--}}
    {{--{{ Form::open(array('url' => 'search_restaurant', 'method' => 'post')) }}--}}
    {{--<label>Search By</label>--}}
    {{--<select class="form-control" name="search_value">--}}
    {{--<option value="hotel">Hotels</option>--}}
    {{--<option value="restaurant">Restaurants</option>--}}
    {{--</select>--}}
    {{--<label>Hotels</label>--}}
    {{--<select class="form-control" name="hotel_id">--}}
    {{--@foreach($hotel_items as $item)--}}
    {{--<option value="{{ $item->id }}">{{ $item->hotel_name }}</option>--}}
    {{--@endforeach--}}
    {{--</select>--}}
    {{--<label>Restaurants</label>--}}
    {{--<select class="form-control" name="restaurant_id">--}}
    {{--@foreach($restaurant_items as $item)--}}
    {{--<option value="{{ $item->id }}">{{ $item->restaurant_name }}</option>--}}
    {{--@endforeach--}}
    {{--</select>--}}
    {{--<br>--}}
    {{--{{ Form::submit('Search', ['class' => 'btn btn-success']) }}--}}
    {{--<a href="{{ action('RestaurantsController@create') }}" class="button-link-dark">--}}
    {{--Clear--}}
    {{--</a>--}}
    {{--<!--{{ csrf_field() }}--}}
    {{--{!! Form::close() !!} -->--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Terms & Conditions</div>
                    <div class="panel-body">

                        {{ Form::label('lb_offer_name', 'Offer Name') }}
                        {{ Form::text('offer_name_en', $offer_name, ['class' => 'form-control', 'placeholder' => 'Offer Name', 'readonly']) }}

                        <div class="container">
                            <h3>Terms & Conditions</h3>
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab_th">วาระ และ เงือนใข</a></li>
                                <li><a data-toggle="tab" href="#tab_en">Terms & Conditions</a></li>
                                <li><a data-toggle="tab" href="#tab_cn">條款和條件</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="tab_th" class="tab-pane fade in active">

                                <!--{!! Form::open(['url' => '', 'files' => false]) !!} -->
                                    <table class="table">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">หัวข้อ</th>
                                            <th scope="col">รายละเอียด</th>
                                            <th scope="col1">แก้ใข</th>
                                            <th scope="col1">ลบ</th>
                                        </tr>
                                        </thead>
                                        @foreach($terms_th as $term_th)
                                        <tr>
                                            <td>{{ $term_th->term_header_th }}</td>
                                            <td>{{ $term_th->term_content_th }}</td>
                                            <td>
                                                <a href="{{ url('restaurant//edit') }}"
                                                   class="button-link-success">
                                                    แก้ใข
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ url('delete_restaurant/' ) }}"
                                                   class="button-link-dark"
                                                   onclick="return confirm('Confrim Delete ?')">
                                                    ลบ
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                {!! $terms_th->render() !!}
                                <!--{{ csrf_field() }}
                                {!! Form::close() !!} -->


                                </div>
                                <div id="tab_en" class="tab-pane fade">

                                <!--{!! Form::open(['url' => '', 'files' => false]) !!} -->
                                    <table class="table">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Header</th>
                                            <th scope="col">Content</th>
                                            <th scope="col1">Edit</th>
                                            <th scope="col1">Delete</th>
                                        </tr>
                                        </thead>
                                        @foreach($terms_en as $term_en)
                                        <tr>
                                            <td>{{ $term_en->term_header_en }}</td>
                                            <td>{{ $term_en->term_content_en }}</td>
                                            <td>
                                                <a href="{{ url('restaurant//edit') }}"
                                                   class="button-link-success">
                                                    Edit
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ url('delete_restaurant/' ) }}"
                                                   class="button-link-dark"
                                                   onclick="return confirm('Confrim Delete ?')">
                                                    Delete
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                {!! $terms_en->render() !!}
                                <!--{{ csrf_field() }}
                                {!! Form::close() !!} -->

                                </div>
                                <div id="tab_cn" class="tab-pane fade">

                                <!--{!! Form::open(['url' => '', 'files' => false]) !!} -->
                                    <table class="table">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">頭</th>
                                            <th scope="col">內容</th>
                                            <th scope="col1">編輯</th>
                                            <th scope="col1">刪除</th>
                                        </tr>
                                        </thead>
                                        @foreach($terms_cn as $term_cn)
                                        <tr>
                                            <td>{{ $term_cn->term_header_cn }}</td>
                                            <td>{{ $term_cn->term_content_cn }}</td>
                                            <td>
                                                <a href="{{ url('restaurant//edit') }}"
                                                   class="button-link-success">
                                                    編輯
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ url('delete_restaurant/' ) }}"
                                                   class="button-link-dark"
                                                   onclick="return confirm('Confrim Delete ?')">
                                                    刪除
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                {!! $terms_cn->render() !!}
                                <!--{{ csrf_field() }}
                                {!! Form::close() !!} -->

                                </div>
                            </div>
                        </div>

                        <center>
                            <a href="{{ url('insert_term/'.$offer_id) }}" class="button-link-success">
                                Add Terms & Conditions
                            </a>
                        </center>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
