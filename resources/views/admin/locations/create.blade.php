@extends('admin.app')

@section('page-header', 'Create a new event')

@section('styles')
    <link rel="stylesheet" href="/admin_assets/plugins/summernote/summernote-bs4.min.css">
@endsection

@section('content')
    <main class="container-fluid">
        <form method="post" id="createForm" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">@csrf</form>

        <section class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title">New Event</h3>
            </div>

            <div class="card-body" id="composeArea">
                <div class="form-group">
                    <input id="composeTitle" name="name" form="createForm" class="form-control" placeholder="name" required>
                </div>

                <div class="form-group">
                    <input id="tagLine" name="tagLine" form="createForm" class="form-control" placeholder="tag line">
                </div>

                <div class="form-group form-row">
                    <div class="col">
                        <input type="text" name="startDate" form="createForm" id="startDate" class="form-control" placeholder="Start Date">
                    </div>
                    <div class="col">
                        <input type="text" name="endtDate" form="createForm" id="endDate" class="form-control" placeholder="End Date">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <select class="j2-select custom-select" name="type" id="type" required form="createForm">
                                <option value="">-- choose event type --</option>
                                <option value="open">Open</option>
                                <option value="invite">Invite Only</option>
                            </select>
                        </div>
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon2">&#8358;</span>
                                </div>
                                <input type="number" min="0" step="0.01" form="createForm" name="budget" class="form-control" placeholder="Estimated Budget" aria-label="ticket fee" aria-describedby="basic-addon2">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <select class="j2-select custom-select" name="location" id="location" form="createForm">
                                <option value="">-- choose a location --</option>
                                <option value="2">Enugu</option>
                                <option value="1">Aba</option>
                                <option value="3">Umuahia</option>
                                <option value="4">Owerri</option>
                                <option value="5">Kano</option>
                            </select>
                        </div>

                        <div class="col">
                            <select class="j2-select custom-select" name="client" id="client" required form="createForm">
                                <option value="">-- choose event owner --</option>
                                <option value="1">Chuks Amadi</option>
                                <option value="2">Opara Eze</option>
                                <option value="3">Okoro Chidalu</option>
                                <option value="4">Paul Kanu</option>
                                <option value="5">Grant Stanley</option>
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
                    <div class="btn btn-default btn-file">
                        <i class="fas fa-paperclip"></i> Attach a feature photo
                        <input type="file" form="createForm" id="featurePhoto" name="featureImage" >
                    </div>
                    <label class="small" for="featurePhoto"></label>
                    <p class="help-block">Max. 32MB</p>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input form="createForm" type="checkbox" name="enabled" class="custom-control-input" id="slideEditEnabled">
                        <label class="custom-control-label " for="slideEditEnabled">Enabled</label>
                    </div>
                    <small>Turn off to disable all public interaction with the event.</small>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input form="createForm" type="checkbox" name="published" class="custom-control-input" id="slidePublished">
                        <label class="custom-control-label " for="slidePublished">Published</label>
                    </div>
                    <small>Turn off to hide the event from the events section of the website.</small>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input form="createForm" type="checkbox" name="featured" class="custom-control-input" id="featured">
                        <label class="custom-control-label" style="" for="featured">Featured</label>
                    </div>
                    <small>Let the event appear as a featured post across the website</small>
                </div>
                
            </div>

            <div class="card-footer">
                <div class="float-right" id="submitBtnArea">
                    <button type="submit" form="createForm" class="btn btn-danger"><i class="far fa-save"></i> Save</button>
                </div>
                <button type="reset" form="createForm" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
            </div>

        </section>
    </main>
@endsection

@section('scripts')
    <script src="/admin_assets/plugins/summernote/summernote-bs4.min.js"></script>
    <script>
        $(function () {
            $('#compose-textarea').summernote({
                placeholder: 'Write your event description here...',
                minHeight: 100,
                // focus: true
            });

            $('#compose-textarea').summernote('reset');

        })
    </script>

    <script>

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
                                        .attr({type: 'submit', form: 'createForm'})
                                        .text('Save');
        }

        //filenames do not show in custom file input when in modal mode
        let fixCustomFileSelectLabelBehaviour = function(inputId){
            let slideImageInput = $(`#${inputId}`)[0];
            let slideImageInputLabel = $(`label[for="${inputId}"]`);1
            
            if(slideImageInput.files[0]){
                slideImageInputLabel.text(slideImageInput.files[0].name);
            }
            
            $(`#${inputId}`).on('input', function(e){
                slideImageInputLabel.text(this.files[0].name);
            });
        }

        let saveNewPost = function(){

            $('#createForm').submit(function(e){
                
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
            })
        }

        $(function(){
            fixCustomFileSelectLabelBehaviour('featurePhoto');
            saveNewPost();
        })

        $(document).ready(function(){
            $('.j2-select').select2();

            $('#startDate').datetimepicker({
                startDate: new Date(),
                onShow: function( ct ){
                    this.setOptions({
                        maxDate: $('#endDate').val() ? $('#endDate').val() : false
                    })
                },
            });


            $('#endDate').datetimepicker({
                onShow: function( ct ){
                    this.setOptions({
                        minDate: $('#startDate').val() ? $('#startDate').val() : false
                    })
                },
            });
        })
    </script>
@endsection