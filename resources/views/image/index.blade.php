@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">Upload Images</div>

                    <div class="panel-body">

                        <div class="panel-body">

                            <div class="form-group">
                               <!--  {!! Form::open(['url' => 'image', 'files' => true]) !!} -->
                                <form class="form-horizontal" enctype="multipart/form-data" method="post"
                                      action="image">
                                    <table class="table table-striped table-hover ">
                                        <thead>
                                        <tr class="">
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{ Form::label('lb_offer', 'Offer Name') }}</td>
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control" name="offer_id">
                                                        <!--option value="" disabled selected>please_selected</option-->
                                                        @foreach($offer_items as $item)
                                                            <option value="{{ $item->id }}">{{ $item->offer_name_en }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ Form::label('lb_image', 'Offer Images') }}</td>
                                            <td><input required type="file" class="form-control" name="images[]" placeholder="address" multiple></td>
                                            <!-- td><input type="file" name="images[]" multiple/></td -->
                                        </tr>

                                        </tbody>
                                    </table>
                                    <center>
                                        {{ Form::submit('Upload', ['class' => 'btn btn-success']) }}
                                    </center>
                                    {{ csrf_field() }}
                                </form>
                                <?php /*
                                {!! Form::close() !!}*/ ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection