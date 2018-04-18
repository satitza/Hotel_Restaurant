@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Search Option</div>
                <div class="panel-body">
                    {{ Form::open(array('url' => 'search_offer', 'method' => 'post')) }}
                    <label>Search By</label>
                    <select class="form-control" name="search_value">
                        <!--option value="" disabled selected>please_selected</option-->
                        <option value="hotel">Hotel</option>
                        <option value="restaurant">Restaurant</option>
                    </select>
                    <label>Hotel</label>
                    <select class="form-control" name="hotel_id">
                        <!--option value="" disabled selected>please_selected</option-->
                        @foreach($hotel_items as $item)
                            <option value="{{ $item->id }}">{{ $item->hotel_name }}</option>
                        @endforeach
                    </select>
                    <label>Restaurant</label>
                    <select class="form-control" name="restaurant_id">
                        <!--option value="" disabled selected>please_selected</option-->
                        @foreach($restaurant_items as $item)
                            <option value="{{ $item->id }}">{{ $item->restaurant_name }}</option>
                        @endforeach
                    </select>
                    <br>
                    {{ Form::submit('Search', ['class' => 'btn btn-success']) }}
                    <button type="submit" class="btn btn-dark">
                        <a href="{{ action('OffersController@create') }}">
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
                <div class="panel-heading">List Offer</div>
                <div class="panel-body">
                <!--{!! Form::open(['url' => '#', 'files' => false]) !!} -->
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Hotel Name</th>
                            <th scope="col">Restaurant Name</th>
                            <th scope="col">Offer Name</th>
                            <th scope="col">PDF</th>
                            <th scope="col">Date Start</th>
                            <th scope="col">Date End</th>
                            <th scope="col">Comment</th>
                            <th scope="col">View PDF</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($offers as $offer)
                            <tr>
                                <td>{{ $offer->hotel_name }}</td>
                                <td>{{ $offer->restaurant_name }}</td>
                                <td>{{ $offer->offer_name_en }}</td>
                                <td>{{ $offer->pdf }}</td>
                                <td>{{ date('d/m/Y', strtotime($offer->offer_date_start)) }}</td>
                                <td>{{ date('d/m/Y', strtotime($offer->offer_date_end)) }}</td>
                                <td>{{ $offer->offer_comment_en }}</td>
                                <td>
                                    <button type="button" class="btn btn-info">
                                        <a href="{{ url('offer/'.$offer->id) }}">
                                            View PDF
                                        </a>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success">
                                        <a href="{{ url('offer/'.$offer->id.'/edit') }}">
                                            Edit Offer
                                        </a>
                                    </button>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-dark">
                                        <a href="{{ url('delete_offer/'.$offer->id) }}"
                                           onclick="return confirm('Confrim Delete ?')">
                                            Delete Offer
                                        </a>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                {{ $offers->render() }}
                <!--{{ csrf_field() }}
                {!! Form::close() !!} -->

                </div>
            </div>

        </div>
    </div>
@endsection
