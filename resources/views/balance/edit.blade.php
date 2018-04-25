@extends('layouts.app')

@section('content')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            ClassicEditor
                .create(document.querySelector('#editor'))
                .then(editor = > {
                console.log(editor);
        } )
        .
            catch(error = > {
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
                    <div class="panel-heading">Edit Balance</div>

                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::open(array('url' => 'balance/'.$balances->id, 'method' => 'put', 'files' => false)) }}
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
                                    <td>{{ Form::text('offer_name', $balances->offer_name_en, ['class' => 'form-control', 'placeholder' => 'Offer Name', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_time_type', 'Time Type') }}</td>
                                    <td>{{ Form::text('time_type', $balances->book_time_type, ['class' => 'form-control', 'placeholder' => 'Time Type', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_offer_date', 'Offer Date') }}</td>
                                    <td>{{ Form::text('time_type', $balances->book_offer_date, ['class' => 'form-control', 'placeholder' => 'Offer Date', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_last_guest', 'Last Guest') }}</td>
                                    <td>{{ Form::text('offer_guest', $balances->book_offer_guest, ['class' => 'form-control', 'placeholder' => 'Last Guest', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_offer_balance', 'Offer Balance') }}</td>
                                    <td>{{ Form::text('offer_balance', $balances->book_offer_balance, ['class' => 'form-control', 'placeholder' => 'Offer Balance', 'readonly']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('lb_active', 'Status') }}</td>
                                    <td>

                                        <div class="form-group">
                                            <select class="form-control" name="active_id">
                                                <option value="{{ $balances->active_id }}">{{ $balances->active }}</option>
                                                @foreach($actives as $active)
                                                    <option value="{{ $active->id }}">{{ $active->active }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <center>
                                {{ Form::submit('Update Balance', ['class' => 'btn btn-success']) }}
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