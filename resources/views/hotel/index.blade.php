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

            var x = document.getElementById("key-panel");
            x.style.display = "none";

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
                    <div class="panel-heading">Add Hotel</div>
                    <div class="panel-body">
                        <div class="form-group">
                        {!! Form::open(['url' => 'hotel', 'files' => false]) !!}
                        <!-- {{ Form::open(array('url' => 'hotel/create', 'method' => 'get')) }} -->
                            <table class="table table-striped table-hover ">
                                <thead>
                                <tr class="">
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ Form::label('lb_hotel_name', 'Hotel Name') }}</td>
                                    <td>{{ Form::text('hotel_name', null, ['class' => 'form-control', 'placeholder' => 'Hotel Name', 'required']) }}</td>
                                </tr>

                                <div id="key-panel">
                                    <tr>
                                        <td>{{ Form::label('lb_mid', 'MID') }}</td>
                                        <td>{{ Form::text('mid', null, ['class' => 'form-control', 'placeholder' => 'MID']) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ Form::label('lb_secret_key', 'Secret Key') }}</td>
                                        <td>{{ Form::text('secret_key', null, ['class' => 'form-control', 'placeholder' => 'Secret Key']) }}</td>
                                    </tr>
                                </div>
                                
                                <tr>
                                    <td>{{ Form::label('lb_active', 'Status') }}</td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" name="active_id">
                                                <!--option value="" disabled selected>please_selected</option-->
                                                @foreach ($actives as $active)
                                                    <option value="{{ $active->id }}"> {{ $active->active }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_hotel_comment', 'Comment') }}</td>
                                    <td>{{ Form::textarea('hotel_comment', null, ['id' => 'editor', 'placeholder' => 'Comment']) }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <center>
                                {{ Form::submit('Add Hotel', ['class' => 'btn btn-success']) }}
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