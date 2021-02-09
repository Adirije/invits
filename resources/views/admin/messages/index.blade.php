@extends('admin.app')

@section('page-header', 'Contact Messages')

@section('styles')
    <link rel="stylesheet" href="/css/swiper.min.css">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <table class="table w-100" id="messageTable">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Sender</th>
                                <th>Subject</th>
                                <th style="width:100px">Action</th>
                            </tr>
                        </thead>
                    <tbody id="messages">
                        @foreach ($messages as $i => $message)
                            
                            <tr class="{{ $message->is_read ? '' : 'font-weight-bold'}}">
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $message->name }}</td>
                                <td>
                                    <a class="text-dark" href="javascript:void(0)" data-msg-id="{{ $message->id }}">{{ $message->subject }}</a>
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-primary modalPeviewBtn" data-msg-id="{{ $message->id }}" title="preview"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-xs btn-danger slideDelBtn" data-del-id="{{ $message->id }}" title="delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>


@include('admin.messages.components.preview')

@endsection

@section('scripts')
<script type='text/javascript' src='/js/swiper.min.js'></script>

<script>
    var messages = JSON.parse("{!! addslashes(json_encode($messages)) !!}");
</script>

<script>

    (function($){
        let shouldRefresh = false;

        let preserveLineBreaks = function(str){
            return (str && typeof str == 'string') ? str.replace(/\n/g, '<br>') : str;
        }

        let init = function(){

            $('#messages').click(function(e){

                if(e.target.dataset.msgId || $(e.target).parent().data('msgId')){

                    const msgId = e.target.dataset.msgId || $(e.target).parent().data('msgId');

                    let msg = messages.find(msg => msg.id == msgId);

                    if(msg){

                        $('#msgFrom span').text(msg.name);

                        $('#msgEmail a').text(msg.email).attr('href', 'mailto:' +msg.email);

                        $('#subject').text(msg.subject);

                        $('#content').html(preserveLineBreaks(msg.content));

                        $('#messagePreviewModal').modal('show');

                        //if the user has viewd a message for the first time, we set the reload flag 
                        //to refresh the page when the modal is closed.

                        if(! msg.is_read){

                            shouldRefresh = true;
                            axios.post(`/admin/messages/${msgId}/read`, {}).catch(e => console.log(e));
                        }

                    }

                }else if (e.target.dataset.delId || $(e.target).parent().data('delId')){
                    const msgId = e.target.dataset.delId || $(e.target).parent().data('delId');

                    let msg = messages.find(msg => msg.id == msgId); 

                    if(msg){
                        _confirmAction('Are you sure?', 'Message will be permanently deleted')
                            .then(() => {

                                axios.post(`/admin/messages/${msgId}/delete`, {})
                                    .then(() => {
                                        location.reload(true);
                                    })
                                    .catch(e => {
                                        let text = 'An unknown error has occured please try again';

                                        if(e.response.status == 404){
                                            text = 'The message may have been deleted already.'
                                        }

                                        PNotify.error({
                                            title: 'Oh No!',
                                            text
                                        });
                                    });
                            })
                            .catch(() => {});
                    }   
                }
            });

            $('#messagePreviewModal').on('hide.bs.modal', function(e){
                if(shouldRefresh){
                    location.reload();
                }
            })
        }

        $(document).ready(function(){

            $('#messageTable').DataTable();
            
            init();
        });
    })(jQuery);
   

</script>
@endsection