$("#formCadastro").submit(function(e){
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
        exibirNotificacao("O campo Usuário é de preenchimento obrigatório", "W");
    } else if(!item.senha || item.senha === "") {
        exibirNotificacao("O campo Senha é de preenchimento obrigatório", "W");
    } else {
        invokeHttp(
            "/controllers/homecontroller.php?methodName=efetuarLogin", 
            {
                data: item,
                method: "POST"
            }, 
            function(data){
                var dados = JSON.parse(data);
                if(dados.sucesso) {
                    
                } else {
                    exibirNotificacao(dados.mensagem, dados.mensagemTipo);
                }
            }
        );
    }
});
