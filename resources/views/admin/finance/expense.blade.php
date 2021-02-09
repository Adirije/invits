@extends('admin.app')

@section('page-header')
<div class="d-flex">
    <a href="{{  route('admin.finance.index', ['eventId' => $event->id]) }}">Financial Records</a>
    <span class="px-2">/</span>
    <span>Expenditure</span>
</div>
@endsection

@section('actionBtn')
<div class="d-flex">
    <button data-toggle="modal" data-target="#addExpenseModal" id="addBtn" class="btn btn-success mr-3"><i class="fas fa-plus"></i> Add</button>
    <button id="exportBtn" class="btn btn-info"><i class="fas fa-print"></i> Export</button>
</div>
@endsection

@section('styles')
    <link rel="stylesheet" href="/css/swiper.min.css">
    <style>
     
        .w-40-px{
            width: 40px;
        }

        .bg-md-white{
            box-shadow: none;
            background-color: #f4f6f9;
        }

        @media(min-width: 576px){
            .w-sm-100-px{
                width: 100px;
            }
        }

        @media(min-width: 768px){
            .bg-md-white{
                background-color: var(--white) !important;
                box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2);
            }
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">

    <div class="card direct-chat direct-chat-primary shadow-none">
        <div class="card-header">
            <h3 class="card-title">{{$event->name}}</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
        </div>

        <div class="card-body">
            <div class="direct-chat-messages" style="height: auto">
                <div>Summary of Expenditure</div>
                <div class="row">
                    <div class="col-3">
                        <div class="small-box bg-info">
                            <div class="inner">
                              <h4>@naira($event->budget)</h4>
              
                              <p>Budget</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                        </div>
                    </div>
                  
                    <div class="col-3">
                        <div class="small-box bg-info">
                            <div class="inner">
                              <h4>@naira($totalExpense)</h4>
              
                              <p>Total Expenditure</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-3">
                        <div class="small-box bg-info">
                            <div class="inner">
                              <h4>{{ $precentageBudgetSpent }}<sup style="font-size: 15px">%</sup></h4>
              
                              <p>Percentage of budget spent</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="small-box bg-info">
                            <div class="inner">
                              <h4>{{ $precentageBudgetLeft}}<sup style="font-size: 15px">%</sup></h4>
              
                              <p>Percentage of budget left</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-md-white shadow-none shadow">
        <div class="card-body p-0 p-md-3">
            <table class="table w-100" id="usersTable">
                <thead>
                    <tr>
                        <th class="d-none d-md-table-cell" style="width: 10px">#</th>
                        <th style="width:200px">Name</th>
                        <th class="d-none d-md-table-cell" style="width:50px">Amount</th>
                        <th class="w-sm-100-px w-40-px">Info</th>
                        <th class="w-sm-100-px w-40-px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($event->expenses as $i => $expense)
                        <tr data-expense="{{ $expense }}">
                            <td class="d-none d-md-table-cell">{{ $i + 1 }}</td>
                            <td>{{ $expense->title }}</td>
                            <td class="d-none d-md-table-cell">@naira($expense->amount)</td>
                            <td>{{ $expense->info }}</td>
                            <td>
                                <button class="btn btn-xs btn-warning __editBtn mr-2" title="edit"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-xs btn-danger __delBtn" data-link="{{ $expense->destroy__link }}" title="delete"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.finance._add-expense-modal')
@include('admin.finance._edit-expense-modal')

@endsection

@section('scripts')
<script src="/js/utils.js"></script>
<script>

    (function($){
        var expenseToEdit = null;

        $('#usersTable').DataTable({
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
        });
            
        $('#exportBtn').click(function(e){
            window.open("{{  route('admin.finance.expenses.print', ['eventId' => $event->id]) }}", '_blank')
        });

        $('.__delBtn').click(function(e){
            _confirmAction('Are you sure?', 'Expense will be permanently deleted').then(() => {
                axios.post($(this).data('link'), {}).then(response => {
                    location.reload();
                })
            })
        })

        $('.__editBtn').click(function(e){
            expenseToEdit = $(this).parents('tr').first().data('expense');

            $('#titleEdit').val(expenseToEdit.title)
            $('#amountEdit').val(expenseToEdit.amount)
            $('#infoEdit').val(expenseToEdit.info)

            $('#editExpenseModal').modal('show');
        });

        $('#editExpenseForm').submit(function(e)
        {
            e.preventDefault();

            var amount = parseFloat(this.amount.value);

            if(amount < 1){
                PNotify.error({
                    title: 'Invalid details!',
                    text: 'Enter an amount greater than zero'
                });
                
                return;
            }
            
            if(! this.title.value){
                PNotify.error({
                    title: 'Invalid details!',
                    text: 'Please give the expenditure a name or title'
                });
                
                return;
            }

            var formData = new FormData(this);
            
            $('#submitBtnAreaEdit').html(createLoadingBtn());

            clearErrors('#editErrors');

            axios.post(expenseToEdit.update_link, formData)
            .then(response => {

                location.reload();
            
            })
            .catch(e => {
                $('#submitBtnArea').html(createSubmitBtn(this.id));
                        
                let ul = $('<ul></ul>').addClass('list-unstyled alert alert-danger').attr('id', 'editErrors');
                
                if(e.response.status == 422){

                    let errs = Object.values(e.response.data.errors).reduce((acc, val) =>  acc.concat(val), []);

                    for(let err of errs){
                        ul.append($('<li></li>').text(err));
                    }

                }else{
                    var li = $('<li></li>').text('An uknown error has occured. Please try again later.');
                    ul.append(li);
                }

                $(this).append(ul);

                $('#editExpenseModal').modal('handleUpdate');
                
                ul[0].scrollIntoView();
            })
        })


        $('#addExpenseForm').submit(function(e)
        {
            e.preventDefault();

            var amount = parseFloat(this.amount.value);

            if(amount < 1){
                PNotify.error({
                    title: 'Invalid details!',
                    text: 'Enter an amount greater than zero'
                });
                
                return;
            }
            
            if(! this.title.value){
                PNotify.error({
                    title: 'Invalid details!',
                    text: 'Please give the expenditure a name or title'
                });
                
                return;
            }

            var formData = new FormData(this);
            
            $('#submitBtnArea').html(createLoadingBtn());

            clearErrors('#saveErrors');

            axios.post(this.action, formData)
            .then(response => {

                location.reload();
            
            })
            .catch(e => {
                $('#submitBtnArea').html(createSubmitBtn(this.id));
                        
                let ul = $('<ul></ul>').addClass('list-unstyled alert alert-danger').attr('id', 'saveErrors');
                
                if(e.response.status == 422){

                    let errs = Object.values(e.response.data.errors).reduce((acc, val) =>  acc.concat(val), []);

                    for(let err of errs){
                        ul.append($('<li></li>').text(err));
                    }

                }else{
                    var li = $('<li></li>').text('An uknown error has occured. Please try again later.');
                    ul.append(li);
                }

                $(this).append(ul);

                $('#addExpenseModal').modal('handleUpdate');
                
                ul[0].scrollIntoView();
            })
        })
           
    })(jQuery);

</script>
@endsection