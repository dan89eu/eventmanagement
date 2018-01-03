<table class="table table-responsive" id="events-table" width="100%">
    <thead>
     <tr>
         <th>Name</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Status</th>
        <th >Action</th>
     </tr>
    </thead>
    <tbody>
    @foreach($events as $event)
        <tr>
            <td>{!! $event->name !!}</td>
            <td>{!! $event->start_date !!}</td>
            <td>{!! $event->end_date !!}</td>
            <td>{!! $event->statusDescription->name !!}</td>
            <td>
                 <a href="{{ route('admin.events.show', $event->id) }}">
                     <i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="view event"></i>
                 </a>
                 <a href="{{ route('admin.events.edit', $event->id) }}">
                     <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit event"></i>
                 </a>
                 <a href="{{ route('admin.events.confirm-delete', $event->id) }}" data-toggle="modal" data-target="#delete_confirm">
                     <i class="livicon" data-name="remove-alt" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete event"></i>
                 </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
