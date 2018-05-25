@extends('layouts.app')

@section('content')
    <script type="text/javascript">

        $(document).ready(function () {
            $('.add_more').click(function (e) {
                e.preventDefault();
                $(this).before("<input type='file' name='images[]' />");
            });
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
                    <div class="panel-heading">Upload Images</div>

                    <div class="panel-body">

                        <div class="panel-body">

                            <div class="form-group">
                            <!--  {!! Form::open(['url' => 'image', 'files' => true]) !!} -->
                                <form class="form-horizontal" enctype="multipart/form-data" method="post"
                                      action="image" class="createAlbumFileUpload">
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
                                            <!--required-->
                                            <td>{{ Form::label('lb_image', 'Offer Images') }}</td>
                                            <td><input type="file" name="images[]">
                                                <button class="add_more" class="btn btn-primary">Add More Files</button>
                                            </td>
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