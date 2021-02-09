<div class="modal fade" id="editImageModal" tabindex="-1" role="dialog" aria-labelledby="editImageModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Gallery Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card card-widget widget-user-2 border-0 shadow-none">
                    <form class="editImageForm" id="editImageForm">
                        @csrf
                        <div class="mt-1">
                            <div class="form-group">
                                <img data-input="galleryImageInputEdit" id="imgPreviewEdit" class="d-block mb-3" style="max-width: 100%; max-height: 300px" src="" alt="">
                                <div class="custom-file">
                                    <input name="image" type="file" class="custom-file-input" id="galleryImageInputEdit" accept="image/*">
                                    <label class="custom-file-label" id="imageLabel" for="galleryImageInputEdit">Choose file</label>
                                </div>
                                <p class="help-block">Max. 32MB</p>
                            </div>

                            <div class="form-group">
                                <label class="d-block" for="eventEdit">Event (Optional)</label>
                                <select class="j2-select custom-select" name="event" id="eventEdit">
                                    <option value="">-- choose event --</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input {{ $event->featured ? 'checked' : '' }} type="checkbox" name="visible" class="custom-control-input" id="featuredEdit">
                                    <label class="custom-control-label" style="" for="featuredEdit">Visible</label>
                                </div>
                                <small>Let the image be visible in the gallery section</small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-sm btn-dark">Close</button>
                <div id="submitBtnAreaEdit">
                    <button type="submit" form="editImageForm" class="btn btn-sm btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
  
  