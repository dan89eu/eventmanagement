@extends('admin/layouts/default')

@section('title')
Email
@parent
@stop
{{-- page level styles --}}
@section('header_styles')

<link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}"  rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/iCheck/css/all.css') }}"  rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/summernote/summernote.css') }}" rel="stylesheet" media="screen" />
<link href="{{ asset('assets/css/pages/mail_box.css') }}" rel="stylesheet" type="text/css" />

@stop
@section('content')
@include('core-templates::common.errors')
<section class="content-header">
    <h1>Email</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>Emails</li>
        <li class="active">Create Email </li>
    </ol>
</section>
<section class="content paddingleft_right15">
<div class="row">
 <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                Create New  Email
            </h4></div>
        <br />
        <div class="panel-body">
        {!! Form::open(['route' => 'admin.emails.store']) !!}

            @include('admin.emails.fields')

        {!! Form::close() !!}
    </div>
  </div>
 </div>
</section>
 @stop
@section('footer_scripts')
<script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
<script  src="{{ asset('assets/vendors/summernote/summernote.min.js') }}"  type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("form").submit(function() {
                $('input[type=submit]').attr('disabled', 'disabled');
                return true;
            });
	        $('input[type="checkbox"].custom-checkbox, input[type="radio"].custom-radio').iCheck({
		        checkboxClass: 'icheckbox_minimal-blue',
		        radioClass: 'iradio_minimal-blue',
		        increaseArea: '20%'
	        });


	        $('#summernote').summernote({
		        fontNames: ['Lato', 'Arial', 'Courier New']
	        });
	        $('body').on('click', '.btn-codeview', function (e) {

		        if ( $('.note-editor').hasClass("fullscreen") ) {
			        var windowHeight = $(window).height();
			        $('.note-editable').css('min-height',windowHeight);
		        }else{
			        $('.note-editable').css('min-height','300px');
		        }
	        });
	        $('body').on('click','.btn-fullscreen', function (e) {
		        setTimeout (function(){
			        if ( $('.note-editor').hasClass("fullscreen") ) {
				        var windowHeight = $(window).height();
				        $('.note-editable').css('min-height',windowHeight);
			        }else{
				        $('.note-editable').css('min-height','300px');
			        }
		        },500);

	        });
	        $('.note-link-url').on('keyup', function() {
		        if($('.note-link-text').val() != '') {
			        $('.note-link-btn').attr('disabled', false).removeClass('disabled');
		        }
	        });
	        $('#slimscrollside').slimscroll({
		        height: '700px',
		        size: '3px',
		        color: 'black',
		        opacity: .3
	        });

        });

    </script>
@stop
