<div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog" aria-labelledby="addExpenseModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Expenditure</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card card-widget widget-user-2 border-0 shadow-none">
                    <form class="addExpenseForm" action="{{ route('admin.finance.expenses.store', ['eventId' => $event->id]) }}" id="addExpenseForm">
                        @csrf
                        <input type="hidden" name="event" id="event" value="{{ $event->id }}">
                        
                        <div class="mt-1">
                            <div class="form-group">
                                <label class="" for="fname">Title</label>
                                <input name="title" placeholder="Enter expense title" type="text" class="form-control" id="title" required>
                            </div>

                            <div class="form-group">
                                <label class="" for="amount">Amount</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">&#8358;</span>
                                    </div>
                                    <input name="amount" placeholder="Enter amont" type="number" step="0.01" class="form-control" id="amount" required>
                                </div>
                                <small class="text-muted" id="min"></small>
                            </div>

                            <div class="form-group">
                                <label class="" for="info">Info (Optional but recommended)</label>
                                <textarea name="info" placeholder="Enter a brief description of the expense" type="text" class="form-control" id="info"></textarea>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-sm btn-dark">Close</button>
                <div id="submitBtnArea">
                    <button type="submit" form="addExpenseForm" class="btn btn-sm btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
  
  