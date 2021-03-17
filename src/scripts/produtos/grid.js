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
        "/controllers/produtosController.php?methodName=loadGridView&fields=" + fields + "&order=" + orders, 
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

$(".btnAddProduto").click(function(e){
    e.preventDefault();
    loadFabricanteLista();
});

$(".buttonSalvarProduto").click(function(e){
    var item = {};
    $("form#formProdutoEdit :input").each(function(){
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
    //adicionar o select
    e.preventDefault();
    console.log(item);
    $("#modalCadastroProduto").modal('hide');
    
});

window.loadFabricanteLista = function() {
    invokeHttp(
        "/controllers/produtosController.php?methodName=getFabricanteLista", 
        {
            method: "GET"
        }, 
        function(data){
             var dados = JSON.parse(data);
             if(dados.sucesso) {
                $("#modalCadastroProduto .modal-title").html("Inclusão de Produtos");
                $("#modalCadastroProduto").modal('show');
             } else {
                 exibirNotificacao(dados.mensagem, dados.mensagemTipo);
             }
        }
    );
};