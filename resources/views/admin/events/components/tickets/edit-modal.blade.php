<div class="modal fade" id="editTicketModal" tabindex="-1" role="dialog" aria-labelledby="editTicketModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card card-widget widget-user-2 border-0 shadow-none">
                    <form class="editTicketForm" id="editTicketForm">
                        @csrf
                        <div class="mt-1">
                            <div class="form-group">
                                <label class="" for="nameEdit">Ticket Name</label>
                                <input name="name" placeholder="E.g. Singles" type="text" class="form-control" id="nameEdit">
                            </div>
                            <div class="form-group">
                                <label class="" for="guestsEdit">Number of Guests Per Ticket</label>
                                <input name="guests" placeholder="Number of guests allowed for this ticket" min="0" type="number" class="form-control" id="guestsEdit">
                            </div>
                            <div class="form-group">
                                <label class="" for="priceEdit">Price</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2">&#8358;</span>
                                    </div>
                                    <input name="price" placeholder="Enter ticket price" min="0" step="0.01" type="number" class="form-control" id="priceEdit">
                                </div>
                            </div>
                            <div class="form-group" id="volume">
                                <label class="" for="volumeEdit">Volume</label>
                                <input name="volume" placeholder="How many of this tickets do you want to create?" min="0" type="number" class="form-control" id="volumeEdit">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="enabled" class="custom-control-input" id="enabledEdit">
                                    <label class="custom-control-label" style="" for="enabledEdit">Enabled</label>
                                </div>
                                <div class="small">Enable the ticket to allow guests to purchase it</div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-sm btn-dark">Close</button>
                <div id="submitBtnAreaEdit">
                    <button type="submit" form="editTicketForm" class="btn btn-sm btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
  
  