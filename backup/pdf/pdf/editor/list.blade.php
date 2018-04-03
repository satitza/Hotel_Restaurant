@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Search Option</div>
                <div class="panel-body">
                    {{ Form::open(array('url' => 'search_pdf', 'method' => 'post')) }}
                    <label>Search By</label>
                    <select class="form-control" name="search_value">
                        <!--option value="" disabled selected>please_selected</option-->
                        <option value="restaurant">Restaurant</option>
                    </select>
                    <label>Restaurant</label>
                    <select class="form-control" name="restaurant_id">
                        <!--option value="" disabled selected>please_selected</option-->
                        @foreach($restaurant_items as $item)
                            <option value="{{ $item[0]->id }}">{{ $item[0]->restaurant_name }}</option>
                        @endforeach
                    </select>
                    <br>
                    {{ Form::submit('Search', ['class' => 'btn btn-primary']) }}
                    <button type="submit" class="btn btn-success">
                        <a href="{{ action('SetMenusController@create') }}">
                            Clear
                        </a>
                    </button>
                <!--{{ csrf_field() }}
                {!! Form::close() !!} -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">List PDF</div>
                <div class="panel-body">
                <!--{!! Form::open(['url' => '#', 'files' => false]) !!} -->
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Restaurant Name</th>
                            <th scope="col">PDF File name</th>
                            <th scope="col">หัวข้อภาษาไทย</th>
                            <th scope="col">Title</th>
                            <th scope="col">標題</th>
                            <th scope="col">View PDF</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($restaurant_pdfs as $restaurant_pdf)
                            <tr>
                                <td>{{ $restaurant_pdf->restaurant_name }}</td>
                                <td>{{ $restaurant_pdf->pdf_file_name }}</td>
                                <td>{{ $restaurant_pdf->pdf_title_th }}</td>
                                <td>{{ $restaurant_pdf->pdf_title_en }}</td>
                                <td>{{ $restaurant_pdf->pdf_title_cn }}</td>
                                <td>
                                    <button type="button" class="btn btn-dark">
                                        <a href="{{ url('restaurant_pdf/'.$restaurant_pdf->id) }}">
                                            View PDF
                                        </a>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info">
                                        <a href="{{ url('restaurant_pdf/'.$restaurant_pdf->id.'/edit') }}">
                                            Edit Menu
                                        </a>
                                    </button>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-danger">
                                        <a href="{{ url('delete_restaurant_pdf/'.$restaurant_pdf->id) }}"
                                           onclick="return confirm('Confrim Delete ?')">
                                            Delete Menu
                                        </a>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                {!! $restaurant_pdfs->render() !!}
                <!--{{ csrf_field() }}
                {!! Form::close() !!} -->

                </div>
            </div>

        </div>
    </div>
@endsection
