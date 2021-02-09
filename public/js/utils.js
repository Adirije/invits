function clearErrors(id){
    try{
        $(id).remove();
    }catch(e){}
}

function preserveLineBreaks(str){
    return (str) ? str.replace(/\n/g, '<br>') : str;
}

function createLoadingBtn(){
    let loadingBtn = $('<button></button>').addClass('btn btn-sm btn-danger')
                                            .attr({disabled: true, type: 'button'})
                                            .text('wait...');

    let spinner = $('<span></span>').addClass('spinner-border spinner-border-sm mr-2')
                                    .attr({"role": "status", "aria-hidden": "true"});
    
    loadingBtn.prepend(spinner);

    return loadingBtn;
}

function createSubmitBtn(form){
    return $('<button></button>').addClass('btn btn-danger btn-sm')
                                .attr({type: 'submit', form})
                                .text('Save');
}