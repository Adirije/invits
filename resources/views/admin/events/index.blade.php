@extends('admin.app')

@section('page-header', 'Events')


@section('actionBtn')
<div class="d-flex">
    <a href="{{  route('admin.events.create') }}" id="addBtn" class="btn btn-primary"><i class="fas fa-plus"></i> New Event</a>
</div>
@endsection

@section('styles')
    <link rel="stylesheet" href="/css/swiper.min.css">
    <style>
     
        .w-40-px{
            width: 40px;
        }

        .bg-md-white{
            box-shadow: none;
            background-color: #f4f6f9;
        }
        @media(min-width: 576px){
            .w-sm-100-px{
                width: 100px;
            }
        }

        @media(min-width: 768px){
            .bg-md-white{
                background-color: var(--white) !important;
                box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2);
            }
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card bg-md-white shadow-none shadow">
        <div class="card-body p-0 p-md-3">
            <table class="table w-100" id="usersTable">
                <thead>
                    <tr>
                        <th class="d-none d-md-table-cell" style="width: 10px">#</th>
                        <th style="width:200px">Name</th>
                        <th class="d-none d-md-table-cell" style="width:100px">Type</th>
                        <th class="w-sm-100-px w-40-px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $i => $event)
                        <tr>
                            <td class="d-none d-md-table-cell">{{ $i + 1 }}</td>
                            <td>{{ $event->name }}</td>
                            <td class="d-none d-md-table-cell">
                                @if ($event->type == 'open')
                                    <span class="badge badge-success">Open</span>
                                @else
                                    <span class="badge badge-info">Invite Only</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.events.show', ['id' => $event->id]) }}" class="btn mr-2 btn-xs btn-primary"  title="Preview"><i class="fas fa-eye"></i> View</a>
                                <a href="{{ route('admin.events.edit', ['id' => $event->id]) }}" class="btn mr-2 btn-xs btn-warning"  title="Edit"><i class="fas fa-edit"></i> Edit</a>
                                <button class="btn btn-xs btn-danger slideDelBtn" data-link={{route('admin.events.delete', ['id' => $event->id])}} title="delete"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>

    (function($){

        $('#usersTable').DataTable();
            
        $('.slideDelBtn').click(function(e){
            _confirmAction('Are you sure?', 'client will be permanently deleted')
                .then(() => {
                    const url = e.currentTarget.dataset.link;
                    axios.post(url, {})
                        .then(() => {
                            location.reload(true);
                        })
                        .catch(e => {

                            if(e.response.status == 404){

                                PNotify.error({
                                    title: 'Oh No!',
                                    text: 'The client may have been deleted already.'
                                });

                                setTimeout(() => {
                                    location.reload(true);
                                }, 2000);

                                return;
                            }

                            PNotify.error({
                                title: 'Oh No!',
                                text: 'An unknown error has occured. Please try again later'
                            });

                        });
                }).catch(() => {});
        });
           
    })(jQuery);

</script>
@endsection