<!-- Start Date Field -->
<div class="form-group col-sm-12">
    {!! Form::hidden('start_date', null, ['class' => 'form-control','id'=>'start_date']) !!}
    {!! Form::hidden('end_date', null, ['class' => 'form-control','id'=>'end_date']) !!}
    {!! Form::hidden('campaign_start_date', null, ['class' => 'form-control','id'=>'campaign_start_date']) !!}
    {!! Form::hidden('campaign_end_date', null, ['class' => 'form-control','id'=>'campaign_end_date']) !!}
</div>

<!-- End Date Field -->
<div class="form-group col-sm-12">
    <label>
        Event Period:
    </label>
    <div class="input-group">
        <div class="input-group-addon">
            <i class="livicon" data-name="calendar" data-size="16" data-c="#555555"
               data-hc="#555555" data-loop="true"></i>
        </div>
        <input type="text" class="form-control" id="daterange1" placeholder="Pick dates"/>
    </div>
</div>
<div class="form-group col-sm-12">
    <label>
        Campaign Period:
    </label>
    <div class="input-group">
        <div class="input-group-addon">
            <i class="livicon" data-name="calendar" data-size="16" data-c="#555555"
               data-hc="#555555" data-loop="true"></i>
        </div>
        <input type="text" class="form-control" id="daterange2" placeholder="Pick dates"/>
    </div>
</div>

<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Details Field -->
<div class="form-group col-sm-12">
    {!! Form::label('details', 'Details:') !!}
    {!! Form::text('details', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', App\Models\EventStatus::pluck('name','id'), null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-12">
    {!! Form::label('category', 'Category:') !!}
    {!! Form::select('category_id', App\Models\Category::pluck('name','id'), null, ['class' => 'form-control select2', 'required']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12 text-center">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.events.index') !!}" class="btn btn-default">Cancel</a>
</div>
