$("#formLogin").submit(function(e){
    var item = {};
    $("form#formLogin :input").each(function(){
        if($(this).attr('name')) {
            if($(this).attr('type') == "checkbox") {
                item[$(this).attr('name')] = this.checked;
            } else if($(this).attr('type') == "radio") {
                item[$(this).attr('name')] = this.checked;
            } else {
                item[$(this).attr('name')] = $(this).val();
            }
        }
    });
    
    e.preventDefault();
    if(!item.usuario || item.usuario === "") {

    } else if(!item.senha || item.senha === "") {
        
    } else {

    }
    exibirNotificacao("dsds", "C");
});
