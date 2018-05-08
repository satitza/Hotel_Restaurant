@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Search Option</div>
                <div class="panel-body">
                    {{ Form::open(array('url' => 'search_offer', 'method' => 'post')) }}
                    <label>Restaurants</label>
                    <div class="form-group">
                        <select class="form-control" name="restaurant_id">
                            <!--option value="" disabled selected>please_selected</option-->
                            @foreach($restaurant_items as $restaurant)
                                <option value="{{ $restaurant[0]->id }}">{{ $restaurant[0]->restaurant_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{ Form::submit('Search', ['class' => 'btn btn-success']) }}
                    <a href="{{ action('OffersController@create') }}" class="button-link-dark">
                        Clear
                    </a>
                <!--{{ csrf_field() }}
                {!! Form::close() !!} -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">List Menu</div>
                <div class="panel-body">
                <!--{!! Form::open(['url' => '#', 'files' => false]) !!} -->
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Hotel Name</th>
                            <th scope="col">Restaurant Name</th>
                            <th scope="col">Offer Name</th>
                            <th scope="col">Attachments</th>
                            <th scope="col">Date Start</th>
                            <th scope="col">Date End</th>
                            <!--th scope="col">Comment</th-->
                            <th scope="col">View Attachments</th>
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
                                <td>{{ $offer->attachments }}</td>
                                <td>{{ date('d/m/Y', strtotime($offer->offer_date_start)) }}</td>
                                <td>{{ date('d/m/Y', strtotime($offer->offer_date_end)) }}</td>
                                <!--td>{{ $offer->offer_comment_en }}</td-->
                                <td>
                                    <a href="{{ url('offer/'.$offer->id) }}" class="button-link-info">
                                        View Attachments
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('offer/'.$offer->id.'/edit') }}" class="button-link-success">
                                        Edit Offer
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('delete_offer/'.$offer->id) }}" class="button-link-dark"
                                       onclick="return confirm('Confrim Delete ?')">
                                        Delete Offer
                                    </a>
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
