@extends('admin/layouts/default')

@section('title')
Events
@parent
@stop
@section('header_styles')

    <link href="{{ asset('assets/vendors/dropzone/css/dropzone.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .dropzone .dz-preview .dz-image img {
            width :100%;
        }
    </style>
@stop
{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Events</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>Events</li>
        <li class="active">Events List</li>
    </ol>
</section>

<section class="content paddingleft_right15">
    <div class="row">
     @include('flash::message')
        <div class="panel panel-info" style="overflow-y:auto; overflow-x: hidden">
            <div class="panel-heading closed">
                <h3 class="panel-title">
                    <i class="livicon" data-name="upload-alt" data-size="20" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Import from file
                </h3>
                <span class="pull-right">
                                    <i class="glyphicon glyphicon-chevron-up showhide clickable panel-collapsed"></i>
                                </span>
            </div>
            <div class="panel-body" style="display: none">
                <div class="col-md-12" style="padding:30px;">
                    {!! Form::open(array('url' => URL::to('admin/file/import'), 'method' => 'post', 'id'=>'myDropzone','class' => 'dropzone', 'files'=> true)) !!}
                    <div class="fallback">
                        <input name="file" type="file"  />
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="panel panel-primary ">
            <div class="panel-heading clearfix">
                <h4 class="panel-title pull-left"> <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Events List
                </h4>
                <div class="pull-right">
                    <a href="{{ route('admin.events.create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> @lang('button.create')</a>
                    <a href="{{ route('admin.events.import') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Import</a>
                </div>
            </div>
            <br />
            <div class="panel-body table-responsive">
                @include('admin.events.table')

            </div>
        </div>
 </div>
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/dropzone/js/dropzone.js') }}" ></script>
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <script>$(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});</script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/buttons.bootstrap.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/buttons.bootstrap.css') }}">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>

    <script>
		$('#events-table').DataTable({
			responsive: true,
			pageLength: 10
		});
		$('#events-table').on( 'length.dt', function ( e, settings, len ) {
			setTimeout(function(){
				$('.livicon').updateLivicon();
			},500);
		} );

		var FormDropzone = function() {
			return {
				//main function to initiate the module
				init: function() {
					Dropzone.options.myDropzone = {
						init: function() {
							this.on("success", function(file,responseText) {

								window.location.href =  "{{route('admin.events.import')}}";
								/*var obj = jQuery.parseJSON(responseText);
								file.id = obj.id;
								file.filename = obj.filename;
								// Create the remove button
								var removeButton = Dropzone.createElement("<button style='margin: 10px 0 0 15px;'>Remove file</button>");

								// Capture the Dropzone instance as closure.
								var _this = this;

								// Listen to the click event
								removeButton.addEventListener("click", function(e) {
									// Make sure the button click doesn't submit the form:
									e.preventDefault();
									e.stopPropagation();

									$.ajax({
										url: "file/delete",
										type: "DELETE",
										data: { "id" : file.id, "_token": '{{ csrf_token() }}' }
									});
									// Remove the file preview.
									_this.removeFile(file);
								});

								// Add the button to the file preview element.
								file.previewElement.appendChild(removeButton);*/



							});

						}
					}
				}
			};
		}();
		jQuery(document).ready(function() {

			FormDropzone.init();
		});

    </script>


@stop




