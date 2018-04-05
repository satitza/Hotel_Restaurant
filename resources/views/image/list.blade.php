@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Search Option</div>
                    <div class="panel-body">
                        {{ Form::open(array('url' => 'search_image', 'method' => 'post')) }}
                        <label>Offer Name</label>
                        <select class="form-control" name="offer_id">
                            @foreach($offer_items as $item)
                                <option value="{{ $item->id }}">{{ $item->offer_name_en }}</option>
                            @endforeach
                        </select>
                        <br>
                        {{ Form::submit('Search', ['class' => 'btn btn-primary']) }}
                        <button type="submit" class="btn btn-success">
                            <a href="{{ action('ImagesController@create') }}">
                                Clear
                            </a>
                        </button>
                    <!--{{ csrf_field() }}
                    {!! Form::close() !!} -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">List Images</div>

                    <div class="panel-body">
                    <!--{!! Form::open(['url' => 'edit_hotel', 'files' => false]) !!} -->
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Hotel Name</th>
                                <th scope="col">Restaurant Name</th>
                                <th scope="col">Offer Name</th>
                                <th scope="col">View All Image</th>
                                <th scope="col1">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($images as $image)
                                <tr>
                                    <th>{{ $image->hotel_name }}</th>
                                    <td>{{ $image->restaurant_name }}</td>
                                    <td>{{ $image->offer_name_en }}</td>
                                    <td>
                                        <?php /*
                                      {{ Form::submit('แก้ใข', ['class' => 'btn btn-primary']) }}
                                     */ ?>
                                        <button class="btn btn-default" data-toggle="modal"
                                                data-target=".bs-example-modal-lg">View Images
                                        </button>

                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-danger">
                                            <a href="{{ url('delete_hotel/') }}"
                                               onclick="return confirm('Confrim Delete ?')">
                                                Delete
                                            </a>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    <!--{{ csrf_field() }}
                    {!! Form::close() !!} -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center">
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">


                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <div class="item active">
                                <img class="img-responsive" src="http://placehold.it/1200x600/555/000&text=One"
                                     alt="...">
                                <div class="carousel-caption">
                                    One Image
                                </div>
                            </div>
                            <div class="item">
                                <img class="img-responsive" src="http://placehold.it/1200x600/fffccc/000&text=Two"
                                     alt="...">
                                <div class="carousel-caption">
                                    Another Image
                                </div>
                            </div>
                            <div class="item">
                                <img class="img-responsive" src="http://placehold.it/1200x600/fcf00c/000&text=Three"
                                     alt="...">
                                <div class="carousel-caption">
                                    Another Image
                                </div>
                            </div>
                        </div>

                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" role="button"
                           data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button"
                           data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection