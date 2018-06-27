@extends('layouts.app')

@section('content')

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $(".datepicker").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
            });
        });


        jQuery(document).ready(function ($) {
            $("#search_offer_id").click(function () {
                if ($(this).is(":checked")) {
                    $("#offer_id").show();
                } else {
                    $("#offer_id").remove();
                }
            });
        });

        jQuery(document).ready(function ($) {
            $("#search_offer_date").click(function () {
                if ($(this).is(":checked")) {
                    $("#offer_date").show();
                } else {
                    $("#offer_date").remove();
                }
            });
        });

        jQuery(document).ready(function ($) {
            $("#search_time_type").click(function () {
                if ($(this).is(":checked")) {
                    $("#time_type").show();
                } else {
                    $("#time_type").remove();
                }
            });
        });

    </script>

    <div class="container-fluid" style="margin-left: 10px; margin-right: 10px;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Search Option</div>
                    <div class="panel-body">
                        {{ Form::open(array('url' => 'delete_pending', 'method' => 'post')) }}
                        <table class="table">
                            <thead class="thead-drack">
                            <tr>
                                <td><label>Delete before date</label></td>
                                <td>{{ Form::text('delete_before_date', null, ['class' => 'form-control datepicker', 'placeholder' => 'Delete before date', 'required']) }}</td>
                                <td>{{ Form::submit('Delete', ['class' => 'btn btn-success']) }}</td>
                            </tr>
                            </thead>
                        </table>

                        {{ csrf_field() }}
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">List Booking Pending</div>
                    <div class="panel-body">
                    <!--{!! Form::open(['url' => '#', 'files' => false]) !!} -->
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Booking ID</th>
                                <th scope="col">Offer Name</th>
                                <th scope="col">Offer Date</th>
                                <th scope="col">Guest Name</th>
                                <th scope="col">Guest Email</th>
                                <th scope="col">Guest Phone</th>
                                <th scope="col">Offer Guest</th>
                                <th scope="col">Gift Voucher</th>
                                <th scope="col1">Delete</th>
                            </tr>
                            </thead>
                            @foreach($reports as $report)
                                <tr>
                                    <th>{{ $report->booking_id }}</th>
                                    <td>{{ $report->offer_name_en }}</td>
                                    <td>{{ $report->booking_date }}</td>
                                    <td>{{ $report->booking_contact_firstname."&nbsp;&nbsp;".$report->booking_contact_lastname  }}</td>
                                    <td>{{ $report->booking_contact_email }}</td>
                                    <td>{{ $report->booking_contact_phone }}</td>
                                    <td>{{ $report->booking_guest }}</td>
                                    <td>
                                        @if($report->booking_voucher == 2)
                                            <a href="{{ url('view_voucher/'.$report->booking_id) }}"
                                               class="button-link-gift">
                                                Gift Voucher
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('delete_report/'.$report->id ) }}"
                                           class="button-link-dark"
                                           onclick="return confirm('Confrim Delete ?')">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                        </table>
                    {!! $reports->render() !!}
                    <!--{{ csrf_field() }}
                    {!! Form::close() !!} -->
                        <center>
                            <a href="{{ route('delete_all_pending') }}" class="button-link-info"
                               onclick="return confirm('Confrim Delete ?')">Delete All Pending</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
