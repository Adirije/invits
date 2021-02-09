@extends('admin.app')

@section('page-header')
<span><i class="fas fa-map-marker-alt"></i> Locations</span>
@endsection

@section('actionBtn')
    <button type="button" id="addBtn" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
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
                        <th class="d-none d-md-table-cell">Address</th>
                        <th style="width: 80px">Type</th>
                        <th style="width: 170px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($locations as $i => $location)
                        <tr data-location="{{ $location }}">
                            <td class="d-none d-md-table-cell">{{ $i + 1 }}</td>
                            <td>{{ $location->name }}</td>
                            <td class="d-none d-md-table-cell">
                                {{ $location->address }}
                            </td>
                            <td class="">
                                @if($location->type == 'virtual')
                                    <span class="badge badge-secondary">Virtual</span>
                                @else
                                    <span class="badge badge-success">Physical</span>
                                @endif
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn mr-sm-1 mb-2 mb-sm-0 __locationViewBtn btn-xs btn-primary d-block d-sm-inline-block"  title="preview"><i class="fas fa-eye"></i> View</a>
                                <a href="javascript:void(0)" class="btn mr-sm-1 mb-2 mb-sm-0 __locEditBtn btn-xs btn-warning d-block d-sm-inline-block"  title="preview"><i class="fas fa-edit"></i> Edit</a>
                                <a href="javascript:void(0)" class="btn btn-xs btn-danger __locationDelBtn d-block d-sm-inline-block" data-link={{route('admin.locations.delete', ['id' => $location->id])}} title="delete"><i class="fas fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.locations.components.create-modal')
@include('admin.locations.components.edit-modal')
@include('admin.locations.components.view-modal')

@endsection

@section('scripts')
<script src="/js/utils.js"></script>
<script>

    (function($){

        var locationToEdit = null;
        var locationToView = null;

        function createAddressInput(type, name, address, addressHolder){
            if($('#' + type).val() == 'virtual'){
                $('#' + name).attr('placeholder', 'Eg: WhatsApp, Zoom, etc');

                $('#' + address).remove();

                var input = $('<input />');

                input.attr({
                    name: 'address',
                    placeholder: 'Link to WhatsApp, Zoom, etc',
                    type: 'text',
                    class: 'form-control',
                    id: address
                });

                $('#' + addressHolder).append(input);

            }else{
                $('#' + name).attr('placeholder', 'Eg: UBA Events Hall');
                $('#' + address).remove();

                var ta = $('<textarea />');

                ta.attr({
                    name: 'address',
                    placeholder: 'Address to location',
                    class: 'form-control',
                    id: address
                });

                $('#' + addressHolder).append(ta);
            }
        }

        $('#usersTable').DataTable();

        $('.__locEditBtn').click(function(e){
            locationToEdit = $(this)
                            .parents('tr')
                            .first()
                            .data('location');

            var type = $('#typeEdit')[0];

            for (const opt of type.options) {
                if(opt.value == locationToEdit.type){
                    opt.selected = true;
                    type.value = opt.value;
                    type.dispatchEvent(new Event('input', { bubbles: true }));
                    break;
                }
            }

            $('#nameEdit').val(locationToEdit.name);
            $('#addressEdit').val(locationToEdit.address);

            $('#editLocationModal').modal('show');
            
        });
            
        $('.__locationDelBtn').click(function(e){
            _confirmAction('Are you sure?', 'client will be permanently deleted')
                .then(() => {

                    axios.post(e.currentTarget.dataset.link, {})
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

        //viewing locations
        $('.__locationViewBtn').click(function(e){
            locationToView = $(this)
                            .parents('tr')
                            .first()
                            .data('location');

            var badgeClass = locationToView.type == 'physical' ? 'badge badge-success' : 'badge badge-secondary'

            var badge = $('<div />').addClass(badgeClass).text( locationToView.type[0].toUpperCase() + locationToView.type.substring(1))

            $('#viewLocationType').html(badge);
            $('#viewLocationName').text(locationToView.name)
            $('#viewLocationAddress').html(preserveLineBreaks(locationToView.address))
            
            $('#viewLocationModal').modal('show');

        })

        $('#addBtn').click(function(e){
            $('#createLocationModal').modal('show');
        });

        $('#type').on('input', function(e){
            createAddressInput('type', 'name', 'address', 'addressHolder')
        });

        $('#typeEdit').on('input', function(e){
            createAddressInput('typeEdit', 'nameEdit', 'addressEdit', 'addressHolderEdit')
            $('#addressEdit').val(locationToEdit.address);
        });

        $('#editLocationForm').submit(function(e){
            e.preventDefault();
            
            clearErrors('#updateErrors');
            
            var formData = new FormData(this);

            $('#submitBtnAreaEdit').html(createLoadingBtn());

            axios.post(locationToEdit.update_link, formData).then(re => {
                location.reload();
            }).catch(e => {
                $('#submitBtnAreaEdit').html(createSubmitBtn(this.id));
                        
                let ul = $('<ul></ul>').addClass('list-unstyled alert alert-danger').attr('id', 'updateErrors');
                
                if(e.response.status == 422){

                    let errs = Object.values(e.response.data.errors).reduce((acc, val) =>  acc.concat(val), []);

                    for(let err of errs){
                        let li = $('<li></li>').text(err);
                        ul.append(li);
                    }

                }else{
                    let li = $('<li></li>').text('An uknown error has occured. Please try again later.');
                    ul.append(li);
                }

                $(this).append(ul);
            })
        });

        $('#createLocationForm').submit(function(e)
        {
            e.preventDefault();
            
            clearErrors('#saveErrors');
            
            var formData = new FormData(this);

            $('#submitBtnArea').html(createLoadingBtn());

            axios.post(this.action, formData)
                .then(response => {
                    location.reload()
                })
                .catch(e => {
                    $('#submitBtnArea').html(createSubmitBtn(this.id));
                        
                        let ul = $('<ul></ul>').addClass('list-unstyled alert alert-danger').attr('id', 'saveErrors');
                        
                        if(e.response.status == 422){

                            let errs = Object.values(e.response.data.errors).reduce((acc, val) =>  acc.concat(val), []);

                            for(let err of errs){
                                let li = $('<li></li>').text(err);
                                ul.append(li);
                            }

                        }else{
                            let li = $('<li></li>').text('An uknown error has occured. Please try again later.');
                            ul.append(li);
                        }

                        $('#createLocationForm').append(ul);
                });
        })
        
        createAddressInput('type', 'name', 'address', 'addressHolder');
        createAddressInput('typeEdit', 'nameEdit', 'addressEdit', 'addressHolderEdit');
    })(jQuery);

</script>
@endsection