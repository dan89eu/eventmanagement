@extends('admin/layouts/default')

@section('title')
EventDate
@parent
@stop

@section('content')
@include('core-templates::common.errors')
<section class="content-header">
    <h1>EventDate</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>EventDates</li>
        <li class="active">Create EventDate </li>
    </ol>
</section>
<section class="content paddingleft_right15">
<div class="row">
 <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                Create New  EventDate
            </h4></div>
        <br />
        <div class="panel-body">
        {!! Form::open(['route' => 'admin.eventDates.store']) !!}

            @include('admin.eventDates.fields')

        {!! Form::close() !!}
    </div>
  </div>
 </div>
</section>
 @stop
@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $("form").submit(function() {
                $('input[type=submit]').attr('disabled', 'disabled');
                return true;
            });
        });
    </script>
@stop
