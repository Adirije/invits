<div class="modal fade" id="createTicketModal" tabindex="-1" role="dialog" aria-labelledby="createTicketModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card card-widget widget-user-2 border-0 shadow-none">
                    <form class="createTicketForm" id="createTicketForm" action="{{ route('admin.tickets.store') }}">
                        @csrf
                        <div class="mt-1">
                            <div class="form-group">
                                <label class="" for="name">Ticket Name</label>
                                <input name="name" placeholder="E.g. Singles" type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label class="" for="guests">Number of Guests Per Ticket</label>
                                <input name="guests" placeholder="Number of guests allowed for this ticket" min="0" type="number" class="form-control" id="guests">
                            </div>
                            <div class="form-group">
                                <label class="" for="price">Price</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2">&#8358;</span>
                                    </div>
                                    <input name="price" placeholder="Enter ticket price" min="0" step="0.01" type="number" class="form-control" id="price">
                                </div>
                            </div>
                            <div class="form-group" id="volume">
                                <label class="" for="volume">Volume</label>
                                <input name="volume" placeholder="How many of this tickets do you want to create?" min="0" type="number" class="form-control" id="volume">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="enabled" class="custom-control-input" id="male">
                                    <label class="custom-control-label" style="" for="male">Enabled</label>
                                </div>
                                <div class="small">Enable the ticket to allow guests to purchase it</div>
                            </div>
                            <input type="hidden" name="event" id="event" value="{{ $event->id }}">
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-sm btn-dark">Close</button>
                <div id="submitBtnArea">
                    <button type="submit" form="createTicketForm" class="btn btn-sm btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
  
  