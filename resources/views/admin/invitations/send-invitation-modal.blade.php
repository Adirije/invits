<div class="modal fade" id="creataInvitationModal" tabindex="-1" role="dialog" aria-labelledby="createInvitationModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send New Invitations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card card-widget widget-user-2 border-0 shadow-none">
                    <form class="createInvitationForm" id="createInvitationForm" action="{{ route('admin.invitations.store', ['eventId' => $event->id]) }}" method="POST">
                        @csrf
                        <div class="mt-1">
                            <div class="form-group">
                                <label class="" for="email">Emails to invite</label>
                                <textarea name="email"
                                    placeholder="Enter a comma separated list of emails to send invites to. Eg: guest1@example.com,guest1@example.net,etc" 
                                    type="text" class="form-control" id="email"
                                ></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-sm btn-dark">Close</button>
                <div id="submitBtnArea">
                    <button type="submit" form="createInvitationForm" class="btn btn-sm btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
  
  