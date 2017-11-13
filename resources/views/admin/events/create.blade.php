@extends('admin/layouts/default')

@section('title')
Event
@parent
@stop
@section('header_styles')
<link href="{{ asset('assets/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
@stop
@section('content')
@include('core-templates::common.errors')
<section class="content-header">
    <h1>Event</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>Events</li>
        <li class="active">Create Event </li>
    </ol>
</section>
<section class="content paddingleft_right15">
<div class="row">
 <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                Create New  Event
            </h4></div>
        <br />
        <div class="panel-body">
        {!! Form::open(['route' => 'admin.events.store']) !!}

            @include('admin.events.fields')

        {!! Form::close() !!}
    </div>
  </div>
 </div>
</section>
 @stop
@section('footer_scripts')

<!-- begining of page level js -->
<script src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/daterangepicker/js/daterangepicker.js') }}" type="text/javascript"></script>

<!-- end of page level js -->

<script type="text/javascript">
        $(document).ready(function() {
            $("form").submit(function() {
                $('input[type=submit]').attr('disabled', 'disabled');
                return true;
            });

	        $("#daterange1").daterangepicker({
		        locale: {
			        format: 'MM/DD/YYYY'
		        },
                minDate: moment().add(1, 'days'),
                startDate:moment().add(1, 'days'),
                endDate:moment().add(1, 'days'),

	        },cb);

	        var daterange2 = $("#daterange2").daterangepicker({
		        locale: {
			        format: 'MM/DD/YYYY'
		        },
		        minDate: moment().add(1, 'days'),

	        },cb2);

	        function cb(start, end) {
		        console.log(start.format(),end);
		        console.log(daterange2);
		        //$("#daterange2").data('daterangepicker').minDate = moment().add(1, 'days');
		        $("#daterange2").data('daterangepicker').maxDate = start.subtract(1,'days');
		        //$("#daterange2").data('daterangepicker').setStartDate(moment().add(1, 'days'));
		        $("#daterange2").data('daterangepicker').setEndDate(start.subtract(1,'days'));
		        $("#start_date").val(start.format('YYYY-MM-DD'))
		        $("#end_date").val(end.format('YYYY-MM-DD'))
		        $("#campaign_start_date").val(moment().add(1, 'days').format('YYYY-MM-DD'))
		        $("#campaign_end_date").val(start.subtract(1,'days').format('YYYY-MM-DD'))
	        }

	        function cb2(start, end) {
		        $("#campaign_start_date").val(start.format('YYYY-MM-DD'))
		        $("#campaign_end_date").val(end.format('YYYY-MM-DD'))
	        }


        });
    </script>
@stop
