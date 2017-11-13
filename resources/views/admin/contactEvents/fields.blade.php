<!-- User Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Event Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('event_id', 'Event Id:') !!}
    {!! Form::text('event_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Contact Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('contact_id', 'Contact Id:') !!}
    {!! Form::text('contact_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12 text-center">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.contactEvents.index') !!}" class="btn btn-default">Cancel</a>
</div>
