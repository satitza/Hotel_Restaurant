@extends('layouts.chart_app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">        
            <div class="panel panel-danger">
                <div class="panel-heading"><h4>Error Message</h4></div>
                <div class="panel-body">
                    {{ $error }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
