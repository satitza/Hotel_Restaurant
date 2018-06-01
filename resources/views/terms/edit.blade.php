@extends('layouts.app')

@section('content')
    {{--<script type="text/javascript">--}}
        {{--jQuery(document).ready(function ($) {--}}
            {{--ClassicEditor--}}
                {{--.create( document.querySelector( '#editor' ) )--}}
                {{--.then( editor => {--}}
                {{--console.log( editor );--}}
        {{--} )--}}
        {{--.catch( error => {--}}
                {{--console.error( error );--}}
        {{--} );--}}
        {{--});--}}
    {{--</script>--}}
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
                            {{ Form::open(array('url' => '#' , 'method' => 'put')) }}
                            <table class="table table-striped table-hover ">
                                <thead>
                                <tr class="">
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ Form::label('lb_offer_name', 'Offer Name') }}</td>
                                    <td>{{ Form::text('offer_name', $offer_name, ['class' => 'form-control', 'placeholder' => 'Hotel Name', 'readonly']) }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <center>
                                {{ Form::submit('Update Terms & Conditions', ['class' => 'btn btn-success']) }}
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