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
                    <div class="panel-heading">Edit Rate Suffix</div>

                    <div class="panel-body">
                        <div class="form-group">
                        <!-- {!! Form::open(['url' => 'hotel', 'files' => false]) !!} -->
                            {{ Form::open(array('url' => 'setting/rate_suffixes/rate_suffix/'.$id , 'method' => 'put')) }}
                            <table class="table table-striped table-hover ">
                                <thead>
                                <tr class="">
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ Form::label('lb_rate_suffix', 'Rate Suffix') }}</td>
                                    <td>{{ Form::text('rate_suffix', $rate_suffix, ['class' => 'form-control', 'placeholder' => 'Rate Suffix', 'required']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_description', 'Comment') }}</td>
                                    <td>{{ Form::textarea('description', $description, ['id' => 'editor', 'placeholder' => 'Description']) }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <center>
                                {{ Form::submit('Update Rate Suffix', ['class' => 'btn btn-success']) }}
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