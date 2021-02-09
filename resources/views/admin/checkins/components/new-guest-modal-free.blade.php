<div class="modal fade" id="createGuestModal" tabindex="-1" role="dialog" aria-labelledby="createGuestModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Register a guest for this event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card card-widget widget-user-2 border-0 shadow-none">
                    <form class="createFreeGuestForm" id="createFreeGuestForm" action="{{ route('admin.registrations.store', ['id' => $event->id]) }}" method="POST">
                        @csrf
                        
                        <div class="mt-1">
                            <div class="form-group">
                                <label class="" for="fname">First name</label>
                                <input name="firstName" placeholder="Enter first name" type="text" class="form-control" id="fname" required>
                            </div>
                            <div class="form-group">
                                <label class="" for="lname">Last name</label>
                                <input name="lastName" placeholder="Enter last name" type="text" class="form-control" id="lname" required>
                            </div>
                            <div class="form-group">
                                <label class="" for="e-mail">Email</label>
                                <input name="email" placeholder="Enter email address" type="email" class="form-control" id="e-mail">
                            </div>
                            <div class="form-group">
                                <label class="" for="phone2">Phone</label>
                                <input name="phone" placeholder="Enter phone number" type="text" class="form-control" id="phone2">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input name="checkin" type="checkbox" class="custom-control-input" id="checkedIn">
                                    <label class="custom-control-label" for="checkedIn">Check-in guest</label>
                                </div>
                                <small class="text-info">Regsiter the guest and also check them in</small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-sm btn-dark">Close</button>
                <div id="submitBtnArea">
                    <button type="submit" form="createFreeGuestForm" class="btn btn-sm btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
  
  