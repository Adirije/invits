<div class="modal fade" id="createLocationModal" tabindex="-1" role="dialog" aria-labelledby="createLocationModalTitle" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card card-widget widget-user-2 border-0 shadow-none">
                    
                    <form class="createLocationForm" id="createLocationForm" action="{{ route('admin.locations.store') }}">
                        @csrf
                        <div class="mt-4">
                            <div class="form-group">
                                <label class="" for="type">Type</label>
                                <select class="custom-select" name=type id="type">
                                    <option value="virtual">Virtual (Online)</option>
                                    <option value="physical">Physical</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="" for="name">Name</label>
                                <input name="name" placeholder="Enter name of venue" type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group" id="addressHolder">
                                <label class="" for="address">Address</label>
                                <textarea name="address" placeholder="Enter address of location" type="text" class="form-control" id="address"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-sm btn-dark">Close</button>
                <div id="submitBtnArea">
                    <button type="submit" form="createLocationForm" class="btn btn-sm btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
  
  