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
                    <div class="panel-heading">Disabled Items Manage</div>

                    <div class="panel-body">
                        <div class="form-group">

                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>
                                        <h3>Disabled Items Manage</h3>
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab"
                                                                  href="#tab_hotel">Disabled Hotel</a>
                                            </li>
                                            <li><a data-toggle="tab" href="#tab_restaurant">Disabled Restaurant</a></li>
                                            <li><a data-toggle="tab" href="#tab_offer">Disabled Offer</a></li>

                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="tab-content">
                                            <div id="tab_hotel" class="tab-pane fade in active">
                                            {{--Hotel--}}

                                            <!--{!! Form::open(['url' => '', 'files' => false]) !!} -->
                                                <table class="table">
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">Hotel Name</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col1"></th>
                                                    </tr>
                                                    </thead>
                                                        @foreach($hotels as $hotel)
                                                        <tr>
                                                            <td>{{ $hotel->hotel_name }}</td>
                                                            <td>{{ $hotel->active }}</td>
                                                            <td>
                                                                <a href="{{ url('') }}"
                                                                   class="button-link-success">
                                                                    Enable
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        </tbody>
                                                </table>
                                            {!! $hotels->render() !!}
                                            <!--{{ csrf_field() }}
                                            {!! Form::close() !!} -->

                                            </div>
                                            <div id="tab_restaurant" class="tab-pane fade">
                                            {{--Restaurant--}}

                                            <!--{!! Form::open(['url' => '', 'files' => false]) !!} -->
                                                <table class="table">
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">Restaurant Name</th>
                                                        <th scope="col">Hotel Name</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col1"></th>
                                                    </tr>
                                                    </thead>
                                                    @foreach($restaurants as $restaurant)
                                                        <tr>
                                                            <td>{{ $restaurant->restaurant_name }}</td>
                                                            <td>{{ $restaurant->hotel_name }}</td>
                                                            <td>{{ $restaurant->active }}</td>
                                                            <td>
                                                                <a href="{{ url('') }}"
                                                                   class="button-link-success">
                                                                    Enable
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        </tbody>
                                                </table>
                                            {!! $restaurants->render() !!}
                                            <!--{{ csrf_field() }}
                                            {!! Form::close() !!} -->

                                            </div>
                                            <div id="tab_offer" class="tab-pane fade">
                                            {{--Offer--}}

                                            <!--{!! Form::open(['url' => '', 'files' => false]) !!} -->
                                                <table class="table">
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">Hotel Name</th>
                                                        <th scope="col">Restaurant Name</th>
                                                        <th scope="col">Offer Name</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col1"></th>
                                                    </tr>
                                                    </thead>
                                                    @foreach($offers as $offer)
                                                        <tr>
                                                            <td>{{ $offer->hotel_name }}</td>
                                                            <td>{{ $offer->restaurant_name }}</td>
                                                            <td>{{ $offer->offer_name_en }}</td>
                                                            <td>{{ $offer->active }}</td>
                                                            <td>
                                                                <a href="{{ url('') }}"
                                                                   class="button-link-success">
                                                                    Enable
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        </tbody>
                                                </table>
                                            {!! $offers->render() !!}
                                            <!--{{ csrf_field() }}
                                            {!! Form::close() !!} -->

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection