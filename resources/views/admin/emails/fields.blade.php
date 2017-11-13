<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    {!! Form::hidden('content', null, ['id' => 'content']) !!}
</div>

<!-- Category Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('category_id', 'Category:') !!}
    {!! Form::select('category_id', App\Models\Category::pluck('name','id'), null, ['class' => 'form-control']) !!}
</div>

<!-- Subject Field -->
<div class="form-group col-sm-12">
    {!! Form::label('subject', 'Subject:') !!}
    {!! Form::text('subject', null, ['class' => 'form-control']) !!}
</div>


    <div class='form-group box-body pad col-sm-12'>
        <div id="summernote"></div>
    </div>




<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    <label class="radio-inline">
        {!! Form::radio('type', '1',null,['class'=>'custom-radio']) !!} automatic
    </label>
    <label class="radio-inline">
        {!! Form::radio('type', '2',null,['class'=>'custom-radio']) !!} manual
    </label>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12 text-center">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.emails.index') !!}" class="btn btn-default">Cancel</a>
</div>
