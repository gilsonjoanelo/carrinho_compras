//https://codeseven.github.io/toastr/demo.html

window.exibirNotificacao = function (mensagem, mensagemTipo) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      };
      var msg = mensagem;
      var titulo = "Carrinho de Compras";
      if(mensagemTipo== "C" || mensagemTipo== "RI" || mensagemTipo== "RU" || mensagemTipo== "RD") {
        if (!msg) {
            if(mensagemTipo== "RI") {
                msg = "Item incluído com sucesso";
            } else if(mensagemTipo== "RU") {
                msg = "Item modificado com sucesso";
            } else if(mensagemTipo== "RD") {
                msg = "Item excluído com sucesso";
            }
        }  
      } else if(mensagemTipo== "E" || mensagemTipo== "FI" || mensagemTipo== "FU" || mensagemTipo== "FD") {
        if (!msg) {
            if(mensagemTipo== "FI") {
                msg = "Ocorreu uma falha na tentativa de incluir o item";
            } else if(mensagemTipo== "FU") {
                msg = "Ocorreu uma falha na tentativa de modificar o item";
            } else if(mensagemTipo== "FD") {
                msg = "Ocorreu uma falha na tentativa de excluir o item";
            }
        } 
      }
    if(mensagemTipo== "C" || mensagemTipo== "RI" || mensagemTipo== "RU" || mensagemTipo== "RD") {
        toastr.success(msg, titulo);
    } else if(mensagemTipo== "E" || mensagemTipo== "FI" || mensagemTipo== "FU" || mensagemTipo== "FD") {
        toastr.error(msg, titulo);
    } else if(mensagemTipo== "I") {
        toastr.info(msg, titulo);
    } else {
        toastr.warning(msg, titulo);
    }
};

window.invokeHttp = function(url, dados, successMethod, errorMethod) {
    if (!dados.method || dados.method == "GET") {
        $.get(url, function (result) {
            successMethod(result);
        })
        .fail(function(xhr, status, error){
            if($.isFunction(errorMethod)) {
                errorMethod(status, error);
            } else {
                console.error('Ocorreu uma falha na tentativa de executar a requisição');
                console.error('status: ', status);
                console.error('error: ', error);
            }
        });
    } else if (dados.method == "PUT" || dados.method == "POST") {
        var jsonData = JSON.stringify(dados.data);
        $.ajax({
            type: dados.method,
            url: url,
            data: jsonData,
            contentType: "application/json;charset=utf-8",
            //dataType: "json",
            success: successMethod,
        })
        .fail(function(xhr, status, error){
            if($.isFunction(errorMethod)) {
                errorMethod(status, error);
            } else {
                console.error('Ocorreu uma falha na tentativa de executar a requisição');
                console.error('status: ', status);
                console.error('error: ', error);
            }
        });
    }  else if (method == "DELETE") {
        $.ajax({
            type: "DELETE",
            url: url,
            success: successMethod
        })
        .fail(function(xhr, status, error){
            if($.isFunction(errorMethod)) {
                errorMethod();
            } else {
                console.error('Ocorreu uma falha na tentativa de executar a requisição');
                console.error('status: ', status);
                console.error('error: ', error);
            }
        });
    }
};