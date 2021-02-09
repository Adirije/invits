<div class="modal fade" id="editLocationModal" tabindex="-1" role="dialog" aria-labelledby="editLocationModalTitle" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Account Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card card-widget widget-user-2 border-0 shadow-none">
                    <form class="editLocationForm" id="editLocationForm" method="post">
                        @csrf
                        <div class="mt-4">
                            <div class="form-group">
                                <label class="" for="typeEdit">Type</label>
                                <select class="custom-select" name="type" id="typeEdit">
                                    <option value="virtual">Virtual (Online)</option>
                                    <option value="physical">Physical</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="" for="nameEdit">Name</label>
                                <input name="name" placeholder="Enter name of venue" type="text" class="form-control" id="nameEdit">
                            </div>
                            <div class="form-group" id="addressHolderEdit">
                                <label class="" for="addressEdit">Address</label>
                                <textarea name="address" placeholder="Enter address of location" type="text" class="form-control" id="addressEdit"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-sm btn-dark">Close</button>
                <div id="submitBtnAreaEdit">
                    <button type="submit" form="editLocationForm" class="btn btn-sm btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
  
  