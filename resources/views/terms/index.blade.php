@extends('layouts.app')

@section('content')
    <script>
        // $(document).ready(function () {
        //     $('.add_more_th').click(function (e) {
        //         e.preventDefault();
        //         $(this).before("<br>\n" +
        //             "<input type=\"text\" name=\"term_header_th[]\" class=\"form-control\"\n" +
        //             "placeholder=\"หัวข้อเงือนไข\">\n" +
        //             "<br>\n" +
        //             "<textarea name=\"term_content_th[]\"  class=\"form-control\" cols=\"30\" rows=\"5\" placeholder=\"รายละเอียดเงือนไข\"></textarea>\n" +
        //             "<br>");
        //     });
        // });
        //
        // $(document).ready(function () {
        //     $('.add_more_en').click(function (e) {
        //         e.preventDefault();
        //         $(this).before("<br>\n" +
        //             "<input type=\"text\" name=\"term_header_en[]\" class=\"form-control\"\n" +
        //             "placeholder=\"Terms Conditions Header\">\n" +
        //             "<br>\n" +
        //             "<textarea name=\"term_content_en[]\"  class=\"form-control\" cols=\"30\" rows=\"5\" placeholder=\"Terms Conditions Content\"></textarea>\n" +
        //             "<br>");
        //     });
        // });
        //
        // $(document).ready(function () {
        //     $('.add_more_cn').click(function (e) {
        //         e.preventDefault();
        //         $(this).before("<br>\n" +
        //             "<input type=\"text\" name=\"term_header_cn[]\" class=\"form-control\"\n" +
        //             "placeholder=\"條款條件標題\">\n" +
        //             "<br>\n" +
        //             "<textarea name=\"term_content_en[]\"  class=\"form-control\" cols=\"30\" rows=\"5\" placeholder=\"條款條件內容\"></textarea>\n" +
        //             "<br>");
        //     });
        // });
    </script>
    <div class="container">
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
                    <div class="panel-heading">Add Terms & Conditions</div>

                    <div class="panel-body">
                        <div class="form-group">
                            {!! Form::open(['url' => 'store_term', 'files' => false]) !!}
                            <table class="table table-striped table-hover">
                                <tr>
                                    {{ Form::label('lb_offer_name', 'Offer Name') }}
                                    {{ Form::text('offer_name_en', $offer_name, ['class' => 'form-control', 'placeholder' => 'Offer Name', 'readonly']) }}
                                </tr>
                                <tr>
                                    <td>
                                        <h3>Term Description</h3>
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab"
                                                                  href="#tab_term_th">คำอธิบายเนื่องในวาระ</a>
                                            </li>
                                            <li><a data-toggle="tab" href="#tab_term_en">Term Description</a></li>
                                            <li><a data-toggle="tab" href="#tab_term_cn">在議程上</a></li>

                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="tab-content">
                                            <div id="tab_term_th" class="tab-pane fade in active">
                                                <form action="#">
                                                    <br>
                                                    <input type="text" name="term_header_th" class="form-control"
                                                           placeholder="หัวข้อเงือนไข">
                                                    <br>
                                                    <textarea name="term_content_th" class="form-control" cols="30"
                                                              rows="5" placeholder="รายละเอียดเงือนไข"></textarea>
                                                    <br>
                                                    {{--<center>--}}
                                                        {{--<button class="add_more_th">เพิ่มเงือนใขอีก</button>--}}
                                                    {{--</center>--}}
                                                </form>
                                            </div>
                                            <div id="tab_term_en" class="tab-pane fade">
                                                <br>
                                                <input type="text" name="term_header_en" class="form-control"
                                                       placeholder="Terms Conditions Header">
                                                <br>
                                                <textarea name="term_content_en" class="form-control" cols="30"
                                                          rows="5" placeholder="Terms Conditions Content"></textarea>
                                                <br>
                                                {{--<center>--}}
                                                    {{--<button class="add_more_en">Add More Conditions</button>--}}
                                                {{--</center>--}}
                                            </div>
                                            <div id="tab_term_cn" class="tab-pane fade">
                                                <br>
                                                <input type="text" name="term_header_cn" class="form-control"
                                                       placeholder="條款條件標題">
                                                <br>
                                                <textarea name="term_content_cn" class="form-control" cols="30"
                                                          rows="5" placeholder="條款條件內容"></textarea>
                                                <br>
                                                {{--<center>--}}
                                                    {{--<button class="add_more_cn">添加更多條件</button>--}}
                                                {{--</center>--}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <center>
                                {{ Form::submit('Add Terms & Conditions', ['class' => 'btn btn-success']) }}
                            </center>
                            {{ Form::hidden('offer_id', $offer_id) }}
                            {{ csrf_field() }}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection