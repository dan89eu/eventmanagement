<table class="table table-responsive" id="campaigns-table" width="100%">
    <thead>
     <tr>
        <th>Date</th>
        <th>Name</th>
        <th>User Id</th>
        <th>Event Id</th>
        <th>Status</th>
        <th >Action</th>
     </tr>
    </thead>
    <tbody>
    @foreach($campaigns as $campaign)
        <tr>
            <td>{!! $campaign->date !!}</td>
            <td>{!! $campaign->name !!}</td>
            <td>{!! $campaign->user_id !!}</td>
            <td>{!! $campaign->event_id !!}</td>
            <td>{!! $campaign->events->contacts !!}</td>
            <td>
                 <a href="{{ route('admin.campaigns.show', $campaign->id) }}">
                     <i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="view campaign"></i>
                 </a>
                 <a href="{{ route('admin.campaigns.edit', $campaign->id) }}">
                     <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit campaign"></i>
                 </a>
                 <a href="{{ route('admin.campaigns.confirm-delete', $campaign->id) }}" data-toggle="modal" data-target="#delete_confirm">
                     <i class="livicon" data-name="remove-alt" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete campaign"></i>
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
        $('#campaigns-table').DataTable({
                      responsive: true,
                      pageLength: 10
                  });
                  $('#campaigns-table').on( 'length.dt', function ( e, settings, len ) {
                     setTimeout(function(){
                           $('.livicon').updateLivicon();
                     },500);
                  } );

       </script>

@stop