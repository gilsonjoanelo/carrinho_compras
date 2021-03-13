$(document).ready(function(){
    loadData();
});

window.loadData = function() {
    $tabela = $("#tableProdutos");
    var fieldCount = 0;
    var fieldList = [];
    var orderList = [];
    $tabela.find("thead > tr > th").each(function () {
       fieldCount++;
       fieldList.push($(this).attr("fieldName"));
       if($(this).attr("orderBy")) {
           orderList.push($(this).attr("orderBy"))
       }
    });
    var fields = fieldList.join(',');
    var orders = orderList.join(',')
    invokeHttp(
        "/controllers/homeController.php?methodName=loadGridView&fields=" + fields + "&order=" + orders, 
        {
            method: "GET"
        }, 
        function(data){
             var dados = JSON.parse(data);
             

            //  $body=$("#corpoProduto");
            //  $body=$("#corpoProduto");
             if(dados.sucesso) {
                 
             } else {

                 exibirNotificacao(dados.mensagem, dados.mensagemTipo);
             }
        }
    );
};