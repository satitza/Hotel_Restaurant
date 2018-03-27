@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Choose Languages</div>
                    <div class="panel-body">

                        {{ Form::open(array('url' => 'set_menu', 'method' => 'post')) }}

                        {{ Form::submit('Add Menu', ['class' => 'btn btn-primary']) }}
                        {{ csrf_field() }}
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection