@extends('admin.app')

@section('page-header', 'Edit Event')

@section('styles')
    <link rel="stylesheet" href="/admin_assets/plugins/summernote/summernote-bs4.min.css">
@endsection

@section('content')
    <main class="container-fluid">
        <form method="post" id="editForm" action="{{ route('admin.events.update', ['id' => $event->id]) }}" enctype="multipart/form-data">@csrf</form>

        <section class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title">Edit Event</h3>
            </div>

            <div class="card-body" id="composeArea">
                <div class="form-group">
                    <label for="composeTitle">Name</label>
                    <input id="composeTitle" name="name" value="{{ $event->name }}" form="editForm" class="form-control" placeholder="name" required>
                </div>

                <div class="form-group">
                    <label for="tagLine">Tag line</label>
                    <input id="tagLine" name="tagLine" value="{{ $event->tagline }}" form="editForm" class="form-control" placeholder="tag line">
                </div>

                <div class="form-group form-row">
                    <div class="col">
                        <label for="startDate">Start Date</label>
                        <input type="text" value="{{ $event->starts }}" name="startDate" form="editForm" id="startDate" class="form-control" placeholder="Start Date">
                    </div>
                    <div class="col">
                        <label for="endDate">End Date</label>
                        <input type="text" name="endDate" value="{{ $event->ends }}" form="editForm" id="endDate" class="form-control" placeholder="End Date">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <label for="type">Event Type</label>
                            <select class="j2-select custom-select" name="type" id="type" required form="editForm">
                                <option value="">-- choose event type --</option>
                                <option {{ $event->type == 'open' ? 'selected' : ''}} value="open">Open</option>
                                <option {{ $event->type == 'invite' ? 'selected' : ''}} value="invite">Invite Only</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="budget">Budget</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon2">&#8358;</span>
                                </div>
                                <input type="number" min="0" step="0.01" form="editForm" id="budget" name="budget" value="{{ $event->budget }}" class="form-control" placeholder="Estimated Budget" aria-label="ticket fee" aria-describedby="basic-addon2">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <label for="location">Location</label>
                            <select class="j2-select custom-select" name="location" id="location" form="editForm">
                                <option value="">-- choose a location --</option>
                                @foreach ($locations as $location)
                                    <option {{ $event->location->id == $location->id ? 'selected' : ''}} value="{{ $location->id }}">{{ $location->name }} - ({{ $location->type }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col">
                            <label for="client">Event Owner</label>
                            <select class="j2-select custom-select" name="client" id="client" required form="editForm">
                                <option value="">-- choose event owner --</option>
                                @foreach ($clients as $client)
                                    <option {{ $event->client->id == $client->id ? 'selected' : ''}} value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <textarea 
                        id="compose-textarea" 
                        class="form-control" 
                    >
                    </textarea>
                </div>

                <div class="form-group">
                    <img id="featurePhotoPreview" class="d-block mb-3" style="max-width: 100px; max-height: 100px" src="" alt="">
                    <div class="btn btn-default btn-file">
                        <span id="featurePhotoLabel"><i class="fas fa-paperclip"></i> Attach a feature photo</span>
                        <input type="file" form="editForm" id="featurePhoto" name="featureImage"  accept="image/*">
                    </div>
                    <label class="small" for="featurePhoto"></label>
                    <p class="help-block">Max. 32MB</p>
                </div>

                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input {{ $event->enabled ? 'checked' : '' }} form="editForm" type="checkbox" name="enabled" class="custom-control-input" id="slideEditEnabled">
                                <label class="custom-control-label " for="slideEditEnabled">Enabled</label>
                            </div>
                            <small>Turn off to disable all public interaction with the event.</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input {{ $event->published ? 'checked' : '' }}  form="editForm" type="checkbox" name="published" class="custom-control-input" id="slidePublished">
                                <label class="custom-control-label " for="slidePublished">Published</label>
                            </div>
                            <small>Turn off to hide the event from the events section of the website.</small>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input {{ $event->featured ? 'checked' : '' }}  form="editForm" type="checkbox" name="featured" class="custom-control-input" id="featured">
                                <label class="custom-control-label" style="" for="featured">Featured</label>
                            </div>
                            <small>Let the event appear as a featured post across the website</small>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input {{ $event->major ? 'checked' : '' }}  form="editForm" type="checkbox" name="major" class="custom-control-input" id="major">
                                <label class="custom-control-label" style="" for="major">Major</label>
                            </div>
                            <small>Let the event appear first on the home page</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="float-right" id="submitBtnArea">
                    <button type="submit" form="editForm" class="btn btn-danger"><i class="far fa-save"></i> Save</button>
                </div>
                <button type="reset" form="editForm" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
            </div>

        </section>
    </main>
@endsection

@section('scripts')
    <script src="/admin_assets/plugins/summernote/summernote-bs4.min.js"></script>
    <script>
        var event = JSON.parse("{!! addslashes(json_encode($event)) !!}");
        $(function () {
            $('#compose-textarea').summernote({
                placeholder: 'Write your event description here...',
                minHeight: 100,
            });

            $('#compose-textarea').summernote('code', event.desc);

        })
    </script>

    <script>

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $('#featurePhotoPreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);

                $('#featurePhotoLabel').text('Change Feature Photo');
            }
        }

        let clearErrors = function(){
            try{
                $('#composeArea')[0].removeChild($('#saveErrors')[0]);
            }catch(e){}
        }

        let createLoadingBtn = function(){
            let loadingBtn = $('<button></button>').addClass('btn btn-danger')
                                                    .attr({disabled: true, type: 'button'})
                                                    .text('wait...');

            let spinner = $('<span></span>').addClass('spinner-border spinner-border-sm mr-2')
                                            .attr({"role": "status", "aria-hidden": "true"});
            
            loadingBtn.prepend(spinner);

            return loadingBtn;
        }

        let createSubmitBtn = function(){
            return $('<button></button>').addClass('btn btn-danger')
                                        .attr({type: 'submit', form: 'editForm'})
                                        .text('Save');
        }

        //filenames do not show in custom file input when in modal mode
        let fixCustomFileSelectLabelBehaviour = function(inputId){
            let slideImageInput = $(`#${inputId}`)[0];
            let slideImageInputLabel = $(`label[for="${inputId}"]`);
            
            if(slideImageInput.files[0]){
                slideImageInputLabel.text(slideImageInput.files[0].name);
            }
            
            $(`#${inputId}`).on('input', function(e){
                slideImageInputLabel.text(this.files[0].name);
            });
        }

        let saveNewPost = function(){

            $('#editForm').submit(function(e){
                
                e.preventDefault();

                $('#submitBtnArea').html(createLoadingBtn());

                //remove existing error messages if any
                clearErrors();

                let content = $('#compose-textarea').summernote('code');
        
                let formData = new FormData(this);
        
                formData.append('content', content);
        
                axios.post(this.action, formData)
                    .then(response => {
                        location.reload(true);
                    })
                    .catch(e => {
                        $('#submitBtnArea').html(createSubmitBtn());
                        
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

                        $('#composeArea').append(ul);
                    });

            })

            $('button[type="reset"]').click(function(){
                clearErrors();
            });
        }

        $(function(){
            
            $("#featurePhoto").change(function() {
                readURL(this);
            });

            saveNewPost();
        })

        $(document).ready(function(){
            $('.j2-select').select2();
            readURL($("#featurePhoto")[0]);
            
            if(event.feature_img){
                $('#featurePhotoPreview').attr('src', event.feature_img);
                $('#featurePhotoLabel').text('Change Feature Photo');
            }

            $('#startDate').datetimepicker({
                format: 'Y-m-d H:i',
                onShow: function( ct ){
                    this.setOptions({
                        maxDate: $('#endDate').val() ? $('#endDate').val() : false
                    })
                },
            });

            $('#endDate').datetimepicker({
                format: 'Y-m-d H:i',
                onShow: function( ct ){
                    this.setOptions({
                        minDate: $('#startDate').val() ? $('#startDate').val() : false
                    })
                },
            });

            $('#major').on('change', function(e){
                var value = e.target.checked;
                if(value){
                    $('#slideEditEnabled')[0].checked = true
                    $('#slidePublished')[0].checked = true;
                }

            })
            $('#slideEditEnabled').on('change', function(e){
                var value = e.target.checked;
                if(! value){
                    $('#major')[0].checked = false;
                }
            })
            $('#slidePublished').on('change', function(e){
                var value = e.target.checked;
                if(! value){
                    $('#major')[0].checked = false;
                }
            })
        })
    </script>
@endsection