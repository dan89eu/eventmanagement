<table class="table table-responsive" id="contactEvents-table">
    <thead>
     <tr>
        <th>User Id</th>
        <th>Event Id</th>
        <th>Contact Id</th>
        <th colspan="3">Action</th>
     </tr>
    </thead>
    <tbody>
    @foreach($contactEvents as $contactEvent)
        <tr>
            <td>{!! $contactEvent->user_id !!}</td>
            <td>{!! $contactEvent->event_id !!}</td>
            <td>{!! $contactEvent->contact_id !!}</td>
            <td>
                 <a href="{{ route('admin.contactEvents.show', $contactEvent->id) }}">
                     <i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="view contactEvent"></i>
                 </a>
                 <a href="{{ route('admin.contactEvents.edit', $contactEvent->id) }}">
                     <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit contactEvent"></i>
                 </a>
                 <a href="{{ route('admin.contactEvents.confirm-delete', $contactEvent->id) }}" data-toggle="modal" data-target="#delete_confirm">
                     <i class="livicon" data-name="remove-alt" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete contactEvent"></i>
                 </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@section('footer_scripts')
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <script>$(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});</script>
@stop