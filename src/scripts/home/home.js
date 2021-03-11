$(document).ready(function(){
    loadData();
});

window.loadData = function() {
    invokeHttp(
        "/controllers/homeController.php?methodName=loadGridView", 
        {
            method: "GET"
        }, 
        function(data){
            console.log('dados: ', data);
            // var dados = JSON.parse(data);
            // if(dados.sucesso) {
            //     $("#modalCadastroUsuario").modal('hide');
            // } else {
            //     exibirNotificacao(dados.mensagem, dados.mensagemTipo);
            // }
        }
    );
};