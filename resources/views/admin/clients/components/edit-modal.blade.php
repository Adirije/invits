<div class="modal fade" id="editClientModal" tabindex="-1" role="dialog" aria-labelledby="editClientModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Client Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card card-widget widget-user-2 border-0 shadow-none">
                    <form class="editClientForm" id="editClientForm">
                        @csrf
                        <div class="mt-1">
                            <div class="form-group">
                                <label class="" for="fnameEdit">First name</label>
                                <input name="firstName" placeholder="Enter first name" type="text" class="form-control" id="fnameEdit">
                            </div>
                            <div class="form-group">
                                <label class="" for="lnameEdit">Last name</label>
                                <input name="lastName" placeholder="Enter last name" type="text" class="form-control" id="lnameEdit">
                            </div>
                            <div class="form-group">
                                <label class="" for="emailEdit">Email</label>
                                <input name="email" placeholder="Enter email address" type="text" class="form-control" id="emailEdit">
                            </div>
                            <div class="form-group">
                                <label class="" for="phoneEdit">Phone</label>
                                <input name="phone" placeholder="Enter phone number" type="text" class="form-control" id="phoneEdit">
                            </div>
                            <div class="form-group" id="addressHolderEdit">
                                <label class="" for="addressEdit">Address</label>
                                <textarea name="address" placeholder="Enter address" type="text" class="form-control" id="addressEdit"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="" for="aboutEdit">About</label>
                                <textarea name="about" placeholder="Profile of client" type="text" class="form-control" id="aboutEdit"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="gender" value="male" class="custom-control-input" id="maleEdit">
                                    <label class="custom-control-label" style="" for="maleEdit">Male</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="gender" class="custom-control-input" value="female" id="femaleEdit">
                                    <label class="custom-control-label" style="" for="femaleEdit">Female</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-sm btn-dark">Close</button>
                <div id="submitBtnAreaEdit">
                    <button type="submit" form="editClientForm" class="btn btn-sm btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
  
  