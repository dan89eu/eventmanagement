@extends('admin/layouts/default')

@section('title')
Event
@parent
@stop
@section('header_styles')
    <link href="{{ asset('assets/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet" />
@stop
@section('content')
<section class="content-header">
    <h1>Event View</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>Events</li>
        <li class="active">Event View</li>
    </ol>
</section>

<section class="content paddingleft_right15">
    <div class="row">
       <div class="panel panel-primary">
        <div class="panel-heading clearfix">
            <h4 class="panel-title"> <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                Event details
            </h4>
        </div>
            <div class="panel-body form-horizontal">
                @include('admin.events.show_fields')
            </div>
        </div>
        <div class="form-group ">
            <a href="{!! route('admin.events.index') !!}" class="btn btn-default">Back</a>
            <a href="{!! route('admin.events.edit',$event->id) !!}" class="btn btn-primary">edit</a>
    </div>
  </div>
</section>
@stop
@section('footer_scripts')

    <!-- begining of page level js -->
    <script src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/daterangepicker/js/daterangepicker.js') }}" type="text/javascript"></script>
    <script language="javascript" type="text/javascript" src="{{ asset('assets/vendors/select2/js/select2.js') }}"></script>
    <!-- end of page level js -->
    <script type="text/javascript">
	    $(document).ready(function() {
		    $(".select2").select2({
			    theme:"bootstrap",
			    placeholder:"Select a value"
		    });

	    });
    </script>
@stop