<div class="modal fade" id="editExpenseModal" tabindex="-1" role="dialog" aria-labelledby="editExpenseModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Expenditure</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card card-widget widget-user-2 border-0 shadow-none">
                    <form class="editExpenseForm" id="editExpenseForm">
                        @csrf
                        
                        <div class="mt-1">
                            <div class="form-group">
                                <label class="" for="titleEdit">Title</label>
                                <input name="title" placeholder="Enter expense title" type="text" class="form-control" id="titleEdit" required>
                            </div>

                            <div class="form-group">
                                <label class="" for="amountEdit">Amount</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="naira1">&#8358;</span>
                                    </div>
                                    <input name="amount" placeholder="Enter amont" type="number" step="0.01" class="form-control" id="amountEdit" aria-describedby="naira1" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="" for="infoEdit">Info (Optional but recommended)</label>
                                <textarea name="info" placeholder="Enter a brief description of the expense" type="text" class="form-control" id="infoEdit"></textarea>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-sm btn-dark">Close</button>
                <div id="submitBtnAreaEdit">
                    <button type="submit" form="editExpenseForm" class="btn btn-sm btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
  
  