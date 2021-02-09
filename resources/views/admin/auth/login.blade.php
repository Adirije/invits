@extends('admin.auth.app')

@section('title', 'Login')
    
@section('page-class', 'login-page')

@section('content')
    <div class="login-box">

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign In</p>

                <form method="post" id="loginForm">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="submitBtnArea"></div>
                    </div>
                </form>

            </div>
        </div>
    </div> 
@endsection

@section('scripts')
    <script>
        $(function(){

            let createLoadingBtn = function(){
                let loadingBtn = $('<button></button>').addClass('btn btn-danger btn-block')
                                                        .attr({disabled: true, type: 'button'})
                                                        .text('wait...');

                let spinner = $('<span></span>').addClass('spinner-border spinner-border-sm mr-2')
                                                .attr({"role": "status", "aria-hidden": "true"});
                
                loadingBtn.prepend(spinner);

                return loadingBtn;
            }

            let createSubmitBtn = function(){
                return $('<button></button>').addClass('btn btn-danger btn-block')
                                            .attr('type', 'submit')
                                            .text('Sign In');
            }

            $('#submitBtnArea').html(createSubmitBtn());

            $('#loginForm').submit(function(e){
                e.preventDefault();

                $('#submitBtnArea').html(createLoadingBtn());

                let formData = new FormData(this);

                try{
                    $('#loginErrors').remove()
                }catch(e){}

                axios.post('/admin/login', formData).then((r) => {
                    window.location = r.data.intended;

                    console.log(r.data.intended);
                }).catch(e => {
                    console.log(e.response)
                    let ul = $('<ul></ul>').addClass('list-unstyled alert alert-danger').attr('id', 'loginErrors');
                    
                    if(e.response.status == 422){

                        let errs = Object.values(e.response.data.errors).reduce((acc, val) =>  acc.concat(val), []);

                        for(let err of errs){
                            let li = $('<li></li>').text(err);
                            ul.append(li);
                        }

                    }else{
                        let li = $('<li></li>').text('An uknown error has occured. Please try again later.');
                        ul.append(li);
                    }

                    $(this).prepend(ul);
                    $('#submitBtnArea').html(createSubmitBtn());
                });;
            });
        })
    </script>
@endsection
