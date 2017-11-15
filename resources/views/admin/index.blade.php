@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Calendar
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link href="{{ asset('assets/dhtmlx_lib/dhtmlxScheduler/dhtmlxscheduler.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/dhtmlx/styles.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />

@stop

{{-- Page content --}}
@section('content')

<section class="content-header">
    <h1>Calendar</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Calendar</li>
    </ol>
</section>
<section class="content" style="    height: 598px;">

    <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
        <div class="dhx_cal_navline">

            <div style="font-size:16px;padding:4px 20px;">
                Show Category:
                <select id="room_filter" onchange='updateSections(this.value)'></select>
            </div>
            <div class="dhx_cal_prev_button">&nbsp;</div>
            <div class="dhx_cal_next_button">&nbsp;</div>
            <div class="dhx_cal_today_button"></div>
            <div class="dhx_cal_date"></div>
        </div>
        <div class="dhx_cal_header">
        </div>
        <div class="dhx_cal_data">
        </div>
    </div>

</section>


@stop

{{-- page level scripts --}}
@section('footer_scripts')
<script language="javascript" type="text/javascript" src="{{ asset('assets/dhtmlx_lib/dhtmlxScheduler/dhtmlxscheduler.js') }}"></script>
<script language="javascript" type="text/javascript" src="{{ asset('assets/dhtmlx_lib/dhtmlxScheduler/ext/dhtmlxscheduler_limit.js') }}"></script>
<script language="javascript" type="text/javascript" src="{{ asset('assets/dhtmlx_lib/dhtmlxScheduler/ext/dhtmlxscheduler_collision.js') }}"></script>
<script language="javascript" type="text/javascript" src="{{ asset('assets/dhtmlx_lib/dhtmlxScheduler/ext/dhtmlxscheduler_timeline.js') }}"></script>
<script language="javascript" type="text/javascript" src="{{ asset('assets/dhtmlx_lib/dhtmlxScheduler/ext/dhtmlxscheduler_editors.js') }}"></script>
<script language="javascript" type="text/javascript" src="{{ asset('assets/dhtmlx_lib/dhtmlxScheduler/ext/dhtmlxscheduler_minical.js') }}"></script>
<script language="javascript" type="text/javascript" src="{{ asset('assets/dhtmlx_lib/dhtmlxScheduler/ext/dhtmlxscheduler_tooltip.js') }}"></script>
<script language="javascript" type="text/javascript" src="{{ asset('assets/js/dhtmlx/scripts.js') }}"></script>
@stop
