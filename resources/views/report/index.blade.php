@extends('layouts.app')

@section('content')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .then( editor => {
                console.log( editor );
        } )
        .catch( error => {
                console.error( error );
        } );
        });
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
                    <div class="panel-heading">Booking</div>

                    <div class="panel-body">
                        <div class="form-group">
                            {!! Form::open(['url' => 'restaurant', 'files' => false]) !!}
                            <table class="table table-striped table-hover ">
                                <thead>
                                <tr class="">
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ Form::label('lb_booking_id', 'Booking ID') }}</td>
                                    <td>{{ Form::text('booking_id', null, ['class' => 'form-control', 'placeholder' => 'Booking ID']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_offer_name', 'Offer Name') }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_booking_date', 'Booking Date') }}</td>
                                    <td>

                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_booking_guest', 'Booking Guest') }}</td>
                                    <td>

                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_booking_title', 'Booking Title') }}</td>
                                    <td>

                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_booking_firstname', 'First name') }}</td>
                                    <td>

                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_booking_lastname', 'Last name') }}</td>
                                    <td>

                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_restaurant_comment', 'Comment') }}</td>
                                    <td>{{ Form::textarea('restaurant_comment', null, ['id' => 'editor', 'placeholder' => 'comment']) }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <center>
                                {{ Form::submit('Booking', ['class' => 'btn btn-primary']) }}
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

