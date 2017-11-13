<table class="table table-responsive" id="eventStatuses-table" width="100%">
    <thead>
     <tr>
        <th>Name</th>
        <th >Action</th>
     </tr>
    </thead>
    <tbody>
    @foreach($eventStatuses as $eventStatus)
        <tr>
            <td>{!! $eventStatus->name !!}</td>
            <td>
                 <a href="{{ route('admin.eventStatuses.show', $eventStatus->id) }}">
                     <i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="view eventStatus"></i>
                 </a>
                 <a href="{{ route('admin.eventStatuses.edit', $eventStatus->id) }}">
                     <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit eventStatus"></i>
                 </a>
                 <a href="{{ route('admin.eventStatuses.confirm-delete', $eventStatus->id) }}" data-toggle="modal" data-target="#delete_confirm">
                     <i class="livicon" data-name="remove-alt" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete eventStatus"></i>
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
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/buttons.bootstrap.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}"/>
 <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/buttons.bootstrap.css') }}">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
 <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>

    <script>
        $('#eventStatuses-table').DataTable({
                      responsive: true,
                      pageLength: 10
                  });
                  $('#eventStatuses-table').on( 'length.dt', function ( e, settings, len ) {
                     setTimeout(function(){
                           $('.livicon').updateLivicon();
                     },500);
                  } );

       </script>

@stop