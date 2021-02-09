@extends('admin.app')

@section('page-header')
    <span><i class="fas fa-users"></i> Clients</span>
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

@section('actionBtn')
    <button type="button" id="addBtn" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
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
                        <th class="d-none d-md-table-cell" style="width:100px">Email</th>
                        <th class="w-sm-100-px w-40-px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $i => $client)
                        <tr data-client="{{ $client }}">
                            <td class="d-none d-md-table-cell">{{ $i + 1 }}</td>
                            <td>{{ $client->name }}</td>
                            <td class="d-none d-md-table-cell">{{ $client->email }}</td>
                            <td>
                                <a href="javascript:void(0)" class="btn mr-2 btn-xs __viewBtn btn-primary"  title="preview"><i class="fas fa-eye"></i> View</a>
                                <a href="javascript:void(0)" class="btn mr-2 btn-xs __editBtn btn-warning"  title="preview"><i class="fas fa-edit"></i> Edit</a>
                                <button class="btn btn-xs btn-danger slideDelBtn" data-link={{route('admin.events.delete', ['id' => $client->id])}} title="delete"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.clients.components.create-modal')
@include('admin.clients.components.view-modal')
@include('admin.clients.components.edit-modal')
@endsection

@section('scripts')
<script src="/js/utils.js"></script>

<script>

    (function($){

        var clientToView = null;

        $('#usersTable').DataTable();

        $('.__viewBtn').click(function(e){

            clientToView = $(this).parents('tr').data('client');

            const avatar = clientToView.gender  == 'male' ? '/images/male_avatar.png' : '/images/female_avatar.png'

            $('#fnameView').text(clientToView.firstname)
            $('#lnameView').text(clientToView.lastname)
            $('#addressView').text(clientToView.address)
            $('#phoneView').text(clientToView.phone)
            $('#emailView').text(clientToView.email)
            $('#aboutView').html(preserveLineBreaks(clientToView.about))
            $('#clientAvatar').attr('src', avatar)
            $('#viewClientModal').modal('show');
        });

        $('.__editBtn').click(function(e)
        {
            const clientToEdit = $(this).parents('tr').data('client');

            $('#editClientForm').attr('action', clientToEdit.edit_link);

            $('#fnameEdit').val(clientToEdit.firstname)
            $('#lnameEdit').val(clientToEdit.lastname)
            $('#addressEdit').val(clientToEdit.address)
            $('#phoneEdit').val(clientToEdit.phone)
            $('#emailEdit').val(clientToEdit.email)
            $('#aboutEdit').val(clientToEdit.about)

            if(clientToEdit.gender == 'male'){
                $('#maleEdit').attr('checked', true)
            }else{
                $('#femaleEdit').attr('checked', true)
            }

            $('#editClientModal').modal('show');
        });

        $('#editClientForm').submit(function(e)
        {
            e.preventDefault();

            $('#submitBtnAreaEdit').html(createLoadingBtn());

            clearErrors('#editErrors');

            var formData = new FormData(this);

            axios.post(this.action, formData).then(r => {
                location.reload();
            }).catch(e => {
                $('#submitBtnAreaEdit').html(createSubmitBtn(this.id));
                        
                let ul = $('<ul></ul>').addClass('list-unstyled alert alert-danger').attr('id', 'editErrors');
                
                if(e.response.status == 422){

                    let errs = Object.values(e.response.data.errors).reduce((acc, val) =>  acc.concat(val), []);

                    for(let err of errs){
                        ul.append($('<li></li>').text(err));
                    }

                }else{
                    var li = $('<li></li>').text('An uknown error has occured. Please try again later.');
                    ul.append(li);
                }

                $(this).append(ul);

                $('#editClientModal').modal('handleUpdate');
                
                ul[0].scrollIntoView();

            });
        });

        $('#createClientForm').submit(function(e)
        {
            e.preventDefault();

            $('#submitBtnArea').html(createLoadingBtn());

            clearErrors('#createErrors');

            var formData = new FormData(this);

            axios.post(this.action, formData).then(r => {
                this.reset();
                location.reload();
            }).catch(e => {
                $('#submitBtnArea').html(createSubmitBtn(this.id));
                        
                let ul = $('<ul></ul>').addClass('list-unstyled alert alert-danger').attr('id', 'createErrors');
                
                if(e.response.status == 422){

                    let errs = Object.values(e.response.data.errors).reduce((acc, val) =>  acc.concat(val), []);

                    for(let err of errs){
                        ul.append($('<li></li>').text(err));
                    }

                }else{
                    var li = $('<li></li>').text('An uknown error has occured. Please try again later.');
                    ul.append(li);
                }

                $(this).append(ul);

                $('#createClientModal').modal('handleUpdate');
                
                ul[0].scrollIntoView();

            });
        });

        $('#addBtn').click(function(e){
            $('#createClientModal').modal('show');
        })
            
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