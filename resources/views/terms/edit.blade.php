@extends('layouts.app')

@section('content')
    <script type="text/javascript">

        jQuery(document).ready(function ($) {
            ClassicEditor
                .create(document.querySelector('#editor'))
                .then(editor => {
                console.log(editor);
        } )
        .
            catch(error => {
                console.error(error);
        } )
            ;
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
                            {{ Form::open(array('url' => 'update_term' , 'method' => 'post')) }}
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
                                    <td>{{ Form::text('offer_name', $offer_name, ['class' => 'form-control',  'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_term_header', 'Term Header') }}</td>
                                    <td>{{ Form::text('term_header', $term_header, ['class' => 'form-control', 'placeholder' => 'Terms & Conditions Header']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_term_content', 'Term Content') }}</td>
                                    <td>{{ Form::textarea('term_content', $term_content , ['id' => 'editor']) }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <center>
                                {{ Form::submit('Update Terms & Conditions', ['class' => 'btn btn-success']) }}
                            </center>
                            {!! Form::hidden('table_name', $table_name) !!}
                            {!! Form::hidden('term_id', $term_id) !!}
                            {!! Form::hidden('offer_id', $offer_id) !!}
                            {{ csrf_field() }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection