@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">List Hotel</div>

                <div class="panel-body">    
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Hotel Name</th>
                                <th scope="col">Hotel Address</th>
                                <th scope="col">Hotel Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach ($hotels as $hotel)
                            <tr>
                                <th></th>
                                <td>{{ $hotel->hotel_name }}</td>
                                <td>{{ $hotel->hotel_address }}</td>
                                <td>{{ $hotel->hotel_comment }}</td>
                            </tr>
                             @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
