<div class="modal fade" id="createGuestModal" tabindex="-1" role="dialog" aria-labelledby="createGuestModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Guest</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card card-widget widget-user-2 border-0 shadow-none">
                    <form class="createGuestForm" id="createGuestForm">
                        @csrf
                        <input type="hidden" name="event" id="event" value="{{ $event->id }}">
                        
                        <div class="mt-1">
                            <div class="form-group">
                                <label class="" for="fname">Ticket</label>
                                <select class="j2-select2 custom-select" name="ticket" id="ticket" required>
                                    <option value="">-- choose ticket --</option>
                                    @foreach ($event->activeTickets() as $ticket)
                                        <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="" for="amount">Amount Paid</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">&#8358;</span>
                                    </div>
                                    <input name="amount" placeholder="Enter amont" type="number" step="0.01" class="form-control" id="amount" required>
                                </div>
                                <small class="text-muted" id="min"></small>
                            </div>

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
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-sm btn-dark">Close</button>
                <div id="submitBtnArea">
                    <button type="submit" form="createGuestForm" class="btn btn-sm btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
  
  