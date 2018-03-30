@extends('layouts.app')

@section('content')
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
                    <div class="panel-heading">Edit PDF</div>

                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::open(array('url' => 'restaurant_pdf/'.$restaurant_pdf_id, 'method' => 'put', 'files' => true)) }}
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
                                                <option value="{{ $restaurant_pdf_id }}">{{ $restaurant_name }}</option>
                                                @foreach($restaurants as $restaurant)
                                                    <option value="{{ $restaurant->id }}">{{ $restaurant->restaurant_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_pdf', 'PDF File') }}</td>
                                    <td>{{ Form::text('pdf_file_name', $pdf_file_name, ['class' => 'form-control', 'placeholder' => 'PDF File Name', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_pdf', 'PDF File') }}</td>
                                    <td>{{ Form::file('pdf', array('class' => 'image')) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_pdf_title_th', 'หัวข้อ') }}</td>
                                    <td>{{ Form::text('pdf_title_th', $pdf_title_th, ['class' => 'form-control', 'placeholder' => 'หัวข้อ PDF']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_pdf_title_en', 'Title') }}</td>
                                    <td>{{ Form::text('pdf_title_en', $pdf_title_en, ['class' => 'form-control', 'placeholder' => 'PDF Title']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_pdf_title_cn', '標題') }}</td>
                                    <td>{{ Form::text('pdf_title_cn', $pdf_title_cn, ['class' => 'form-control', 'placeholder' => 'PDF 標題']) }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <center>
                                {{ Form::submit('Upload PDF', ['class' => 'btn btn-primary']) }}
                            </center>
                            {{ csrf_field() }}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

