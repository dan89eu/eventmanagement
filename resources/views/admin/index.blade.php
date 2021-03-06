@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Calendar
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link href="{{ asset('assets/dhtmlx_lib/dhtmlxScheduler/dhtmlxscheduler.css') }}" rel="stylesheet" />
<link href="{{ mix('assets/css/dhtmlx/styles.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/modal/css/component.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/pages/advmodals.css') }}" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />


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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Upload files</h5>
            </div>
            <div class="modal-body">
                <div class="file-loading">
                    <input id="input-b9" name="file[]" multiple type="file">
                </div>
                <div id="kartik-file-errors"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-primary" title="Your custom upload logic">Save</button>-->
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-fade-in-scale-up" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true" data-campaignID=0 data-action="">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="confirmModalLabel">Confirm your action</h5>
            </div>
            <div class="modal-body">
                <p>Please confirm your action: <strong id="confirmModalAction">Send email now</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn bg-warning" title="Save" id="confirmModalSave">Save</button>
            </div>
        </div>
    </div>
</div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/modal/js/classie.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/underscore/js/underscore-min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/moment/js/moment.min.js')}}"></script>
<script language="javascript" type="text/javascript" src="{{ asset('assets/dhtmlx_lib/dhtmlxScheduler/dhtmlxscheduler.js') }}"></script>
<script language="javascript" type="text/javascript" src="{{ asset('assets/dhtmlx_lib/dhtmlxScheduler/ext/dhtmlxscheduler_limit.js') }}"></script>
<script language="javascript" type="text/javascript" src="{{ asset('assets/dhtmlx_lib/dhtmlxScheduler/ext/dhtmlxscheduler_collision.js') }}"></script>
<script language="javascript" type="text/javascript" src="{{ asset('assets/dhtmlx_lib/dhtmlxScheduler/ext/dhtmlxscheduler_timeline.js') }}"></script>
<script language="javascript" type="text/javascript" src="{{ asset('assets/dhtmlx_lib/dhtmlxScheduler/ext/dhtmlxscheduler_editors.js') }}"></script>
<script language="javascript" type="text/javascript" src="{{ asset('assets/dhtmlx_lib/dhtmlxScheduler/ext/dhtmlxscheduler_minical.js') }}"></script>
<script language="javascript" type="text/javascript" src="{{ asset('assets/dhtmlx_lib/dhtmlxScheduler/ext/dhtmlxscheduler_tooltip.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/js/fileinput.min.js"></script>
<script language="javascript" type="text/javascript" src="{{ mix('assets/js/dhtmlx/scripts.js') }}"></script>
@stop
