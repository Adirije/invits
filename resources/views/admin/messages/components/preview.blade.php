<div class="modal fade" id="messagePreviewModal" tabindex="-1" role="dialog" aria-labelledby="messagePreviewModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark font-weight-bold" id="messagePreviewModalTitle">Contact Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  

            <div class="modal-body">
                <p id="msgFrom">From: <span class="font-weight-bold"></span></p>

                <p id="msgEmail">Email: <a class="font-weight-bold text-danger"></a></p>
                <hr>

                <h5>Subject:</h5>
                <div class="mb-3" id="subject"></div>
                <hr>
                <div id="content"></div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-xs btn-danger">Close</button>
            </div>
        </div>
    </div>
</div>
  
  