<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:', array('class'=>'col-md-3')) !!}
    <div class="col-md-9">{!! $event->id !!}</div>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:', array('class'=>'col-md-3')) !!}
    <span class="col-md-9">{!! $event->name !!}</span>
</div>

<!-- Start Date Field -->
<div class="form-group">
    {!! Form::label('start_date', 'Start Date:', array('class'=>'col-md-3')) !!}
    <div class="col-md-9">{!! $event->start_date !!}</div>
</div>

<!-- End Date Field -->
<div class="form-group">
    {!! Form::label('end_date', 'End Date:', array('class'=>'col-md-3')) !!}
    <div class="col-md-9">{!! $event->end_date !!}</div>
</div>

<!-- Details Field -->
<div class="form-group">
    {!! Form::label('details', 'Details:', array('class'=>'col-md-3')) !!}
    <div class="col-md-9">{!! $event->details !!}</div>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:', array('class'=>'col-md-3')) !!}
    <div class="col-md-9">{!! $event->statusDescription->name !!}</div>
</div>

<!-- Created by Field -->
<div class="form-group">
    {!! Form::label('created_by', 'Created by:', array('class'=>'col-md-3')) !!}
    <div class="col-md-9">{!! $event->user->fullName !!}</div>
</div>

<!-- Created by Field -->
<div class="form-group">
    {!! Form::label('category', 'Category:', array('class'=>'col-md-3')) !!}
    <div class="col-md-9">{!! $event->categorys->name !!}</div>
</div>


<!-- Contacts Field -->
<div class="form-group">
    {!! Form::label('contacts', 'Contacts:', array('class'=>'col-md-3')) !!}
    <div class="col-md-9">{!! Form::select('contacts[]', App\Models\Contact::pluck('first_name','id'), $contacts, ['class' => 'form-control select2','multiple', 'disabled']) !!}</div>
</div>
{{$event->categorys->manualemails()->get()}}
<!-- Emails Field -->
<div class="form-group">
    {!! Form::label('emails', 'Emails:', array('class'=>'col-md-3')) !!}
    <div class="col-md-9">
        <table class="table table-responsive table-striped table-hover" id="events-table" width="100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($event->campaigns as $campaign)
                <tr>
                    <td>{!! $campaign->name !!}</td>
                    <td>{!! $campaign->date !!}</td>
                    <td>Automatic</td>
                    <td>{!! $campaign->statusDescription !!}</td>
                    <td>
                    <!--<a href="{{ route('admin.campaigns.edit', $campaign->id) }}">
                            <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit event"></i>
                        </a>-->
                    </td>
                </tr>
            @endforeach
            @foreach($event->categorys->manualemails()->get() as $campaign)
                <tr>
                    <td>{!! $campaign->name !!}</td>
                    <td></td>
                    <td>Manual</td>
                    <td></td>
                    <td>
                        <a href="{{ route('admin.events.edit', $campaign->id) }}">
                            <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit email"></i>
                        </a>
                        <a href="javascript:;" class="send-email" onclick="sendEmail({{$event}},{{$campaign}})">
                            <i class="livicon" data-name="mail-alt" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="send email"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>
<!-- Files Field -->
<div class="form-group">
    {!! Form::label('files', 'Files:', array('class'=>'col-md-3')) !!}
    <div class="col-md-9">
        <table class="table table-responsive table-striped table-hover" id="files-table" width="100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($event->files as $file)
                <tr>
                    <td><a href="{!! URL::to('/uploads/files/'.$file->filename); !!}" target="_blank">{!! $file->original_filename !!}</a> </td>
                    <td>{!! $file->created_at !!}</td>
                    <td>{!! $file->statusDescription->name !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>





