<div class="modal fade" id="createClientModal" tabindex="-1" role="dialog" aria-labelledby="createClientModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card card-widget widget-user-2 border-0 shadow-none">
                    <form class="createClientForm" id="createClientForm" action="{{ route('admin.clients.store') }}">
                        @csrf
                        <div class="mt-1">
                            <div class="form-group">
                                <label class="" for="fname">First name</label>
                                <input name="firstName" placeholder="Enter first name" type="text" class="form-control" id="fname">
                            </div>
                            <div class="form-group">
                                <label class="" for="lname">Last name</label>
                                <input name="lastName" placeholder="Enter last name" type="text" class="form-control" id="lname">
                            </div>
                            <div class="form-group">
                                <label class="" for="email">Email</label>
                                <input name="email" placeholder="Enter email address" type="text" class="form-control" id="email">
                            </div>
                            <div class="form-group">
                                <label class="" for="phone">Phone</label>
                                <input name="phone" placeholder="Enter phone number" type="text" class="form-control" id="phone">
                            </div>
                            <div class="form-group" id="addressHolder">
                                <label class="" for="address">Address</label>
                                <textarea name="address" placeholder="Enter address" type="text" class="form-control" id="address"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="" for="about">About</label>
                                <textarea name="about" placeholder="Profile of client" type="text" class="form-control" id="about"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="gender" value="male" class="custom-control-input" id="male">
                                    <label class="custom-control-label" style="" for="male">Male</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="gender" value="female" class="custom-control-input" id="female">
                                    <label class="custom-control-label" style="" for="female">Female</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-sm btn-dark">Close</button>
                <div id="submitBtnArea">
                    <button type="submit" form="createClientForm" class="btn btn-sm btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
  
  