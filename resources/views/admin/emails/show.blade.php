@extends('admin/layouts/default')

@section('title')
Email
@parent
@stop

@section('content')
<section class="content-header">
    <h1>Email View</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>Emails</li>
        <li class="active">Email View</li>
    </ol>
</section>

<section class="content paddingleft_right15">
    <div class="row">
       <div class="panel panel-primary">
        <div class="panel-heading clearfix">
            <h4 class="panel-title"> <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                Email details
            </h4>
        </div>
            <div class="panel-body">
                @include('admin.emails.show_fields')
            </div>
        </div>
    <div class="form-group">
           <a href="{!! route('admin.emails.index') !!}" class="btn btn-default">Back</a>
    </div>
  </div>
</section>
@stop
