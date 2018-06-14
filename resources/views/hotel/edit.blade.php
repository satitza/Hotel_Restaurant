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
                <div class="panel-heading">Edit Hotel</div>

                <div class="panel-body">
                    <div class="form-group">
                        <!-- {!! Form::open(['url' => 'hotel', 'files' => false]) !!} -->
                        {{ Form::open(array('url' => 'hotel/'.$hotel_id , 'method' => 'put')) }}
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
                                    <td>{{ Form::text('hotel_name', $hotel_name, ['class' => 'form-control', 'placeholder' => 'Hotel Name', 'required']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_mid', 'MID') }}</td>
                                    <td>{{ Form::text('mid', $mid, ['class' => 'form-control', 'placeholder' => 'MID']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_secret_key', 'Secret Key') }}</td>
                                    <td>{{ Form::text('secret_key', $secret_key, ['class' => 'form-control', 'placeholder' => 'Secret Key']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_active', 'Status') }}</td>
                                    <td>
                                        <div style="display: none">
                                            {{ Form::text('hotel_active', $hotel_active , ['class' => 'form-control', 'placeholder' => 'ชื่อโรงแรม', 'readonly']) }}
                                        </div>
                                        
                                        <div class="form-group">
                                            <?php /*
                                              @foreach ($actives as $active)
                                              {{ Form::select('myselect', $active, null, ['class' => 'form-control', 'placeholder' => 'Please Select'])}}
                                              @endforeach
                                             */ ?>      


                                            <select class="form-control" name="active_id" id="select-active">
                                                <option value="{{ $hotel_active_id }}">{{ $hotel_active }}</option>
                                                @foreach ($actives as $active)
                                                <!--   -->
                                                <option value="{{ $active->id}} "> {{ $active->active }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_hotel_comment', 'Comment') }}</td>
                                    <td>{{ Form::textarea('hotel_comment', $hotel_comment, ['id' => 'editor', 'placeholder' => 'Comment']) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <center>
                            {{ Form::submit('Update Hotel', ['class' => 'btn btn-success']) }}
                        </center>
                        {{ csrf_field() }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection