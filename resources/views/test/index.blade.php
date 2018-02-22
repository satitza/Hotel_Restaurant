@extends('layouts.app')

@section('content')
<!--scrip src="{{ asset('jquery/jquery-1.10.2.min.js') }}"></scrip-->
<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script-->

<script>
    $(function () {
        $("#btn-edit").click(function () {
            $("#select").toggle("hide")();
        });
    });
</script>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">Test JQuery</div>

                <div class="panel-body">

                    <div>
                        <select id="select">
                            <option>Enable</option>
                            <option>Disable</option>
                        </select>
                    </div>
                    <button id="btn-edit">edit</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


