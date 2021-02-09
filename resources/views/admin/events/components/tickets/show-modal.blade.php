<div class="modal fade" id="viewTicketModal" tabindex="-1" role="dialog" aria-labelledby="viewTicketModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ticket Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card card-widget widget-user-2 border-0 shadow-none">
                    <div class="mb-3">
                        <div class="small text-muted">Name</div>
                        <div id="viewTicketName"></div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col">
                            <div class="small text-muted">Guests Per Ticket</div>
                            <div id="viewTicketGuests"></div>
                        </div>
                        <div class="col">
                            <div class="small text-muted">Ticket Price</div>
                            <span> &#8358;</span><span id="viewTicketPrice"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="small text-muted">Available</div>
                            <div id="viewTicketAvailable"></div>
                        </div>
                        <div class="col">
                            <div class="small text-muted">Sold</div>
                            <div id="viewTicketSold"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="small text-muted">Total (Volume)</div>
                        <div id="viewTicketVolume"></div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <a href="#" id="viewTicketSalesBtn" class="btn btn-sm btn-primary">Sales</a>
                <button type="button" id="ticketEditBtn" class="btn btn-sm btn-warning">Edit</button>
                <button type="button" data-dismiss="modal" class="btn btn-sm btn-dark">Close</button>
            </div>
        </div>
    </div>
</div>
  
  