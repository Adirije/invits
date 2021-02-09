@extends('admin.app')

@section('page-header')
    <span><i class="fas fa-image"></i> Gallery Images</span>
@endsection

@section('actionBtn')
    <div class="d-flex">
        <button type="button" data-toggle="modal" data-target="#addImageModal" class="btn btn-primary mr-2"><i class="fas fa-plus"></i> Add Image</button>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="/css/swiper.min.css">
    <style>
     
        .gallery-image{
            width: 100%;
            height: 300px;
        }

        .gallery-toolbar{
            position: absolute;
            right: 5px;
            top: 5px;
            display: none;
        }

        .gallery-img-tool{
            background-color: var(--dark);
            color: var(--light) !important;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card bg-md-white shadow-none shadow">
        <div class="card-body p-0 p-md-3">
            <div class="row">     
                @foreach ($galleryImages as $galleryImage)
                    <div class="col-4">
                        <div class="card gallery-entry">
                            <img class="gallery-image" src="{{ $galleryImage->img }}" alt="">
                            <div class="card-body">
                                <div class="small text-muted">Event</div>
                                <h5 class="mb-3">{{ $galleryImage->event->name }}</h5>
                                <div class="small text-muted">Status</div>
                                @if ($galleryImage->enabled)
                                    <div class="badge badge-success">Visible</div>
                                @else
                                    <div class="badge badge-danger">Hidden</div>
                                @endif
                             </div>
                            <div class="gallery-toolbar" data-gallery-image="{{ $galleryImage }}">
                                <div class="gallery-img-tool __editBtn mr-2 text-center small">
                                    <i class="fas fa-pen"></i>
                                </div>
                                <div class="gallery-img-tool __delBtn mr-2 text-center small">
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@include('admin.gallery.components.add-image-modal')
@include('admin.gallery.components.edit-image-modal')
@endsection

@section('scripts')
<script src="/js/utils.js"></script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                $(`img[data-input='${input.id}']`).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);

            $(`label[for='${input.id}']`).text(input.files[0].name);

            $('#addImageModal').modal('handleUpdate');
        }
    }

    function uploadImage(event, form){
        event.preventDefault();
        
        $('#submitBtnArea').html(createLoadingBtn());

        //remove existing error messages if any
        clearErrors('#saveErrors');

        var formData = new FormData(form);

        axios.post(form.action, formData)
                .then(response => {
                    location.reload(true);
                })
                .catch(e => {
                    $('#submitBtnArea').html(createSubmitBtn(form.id));
                    
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

                    $(form).append(ul);

                    ul[0].scrollIntoView();
                });
    }
    
    function uploadEditedImage(event, form){
        event.preventDefault();
        
        $('#submitBtnAreaEdit').html(createLoadingBtn());

        //remove existing error messages if any
        clearErrors('#updaterrors');

        var formData = new FormData(form);

        axios.post(form.action, formData)
                .then(response => {
                    location.reload(true);
                })
                .catch(e => {
                    $('#submitBtnAreaEdit').html(createSubmitBtn(form.id));
                    
                    let ul = $('<ul></ul>').addClass('list-unstyled alert alert-danger').attr('id', 'updaterrors');
                    
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

                    $(form).append(ul);

                    ul[0].scrollIntoView();
                });
    }

    function deleteImage(event, el){
        _confirmAction('Are you sure?', 'Image will be permanently deleted.')
                .then(() => {
                    const img = $(el).parent().data('galleryImage');
                    axios.post(img.del_link, {})
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
    }

    function showEditModal(event, el){
        var galleryImage = $(el).parent().data('galleryImage');
        
        $('#imgPreviewEdit').attr('src', galleryImage.img)
        $('#editImageForm').attr('action', galleryImage.update_link)
        $('#featuredEdit').attr('checked', galleryImage.enabled)
        $('#eventEdit').val(galleryImage.event_id)
        $('#imageLabel').text(galleryImage.img)
        
        $('#editImageModal').modal('show');
    }

    $(document).ready(function(){
        var j2selected = false;
        
        $('#addImageModal').on('shown.bs.modal', function(e){
            if(! j2selected){
                $('.j2-select').select2();
                j2selected = true;
            }
        })

        $('.__editBtn').click(function(e){
            showEditModal(e, this)
        })

        $('.__delBtn').click(function(e){
            deleteImage(e, this);
        })

        $('.gallery-entry').hover(function () {
                // over
                $(this).find('.gallery-toolbar').addClass('d-flex');
            }, function () {
                // out
                $(this).find('.gallery-toolbar').removeClass('d-flex');
            }
        );

        $('#addImageForm').submit(function(e){
            uploadImage(e, this);
        })
        
        $('#editImageForm').submit(function(e){
            uploadEditedImage(e, this);
        })

        readURL($("#galleryImageInput")[0]);

        $("input[type='file']").change(function() {
            readURL(this);
        });
    });

    (function($){
            
        $('.slideDelBtn').click(function(e){
            
        });
           
    })(jQuery);

</script>
@endsection