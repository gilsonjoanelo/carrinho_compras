//https://codeseven.github.io/toastr/demo.html
function exibirNotificacao(mensagem, mensagemTipo) {
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        rtl: true,
        positionClass: 'toast-top-right',
        preventDuplicates: false,
        onclick: null
    };
    var msg = mensagem;
    var shortCutFunction = "warning";
    if(mensagemTipo == "C" || mensagemTipo == "RI" || mensagemTipo == "RU" || mensagemTipo == "RD") {
        shortCutFunction = "success";
        if(!msg || msg === "") {
            if (mensagemTipo === "RI") {
                msg = "Registro incluído com sucesso";
            } else if (mensagemTipo === "RU") {
                msg = "Registro atualizado com sucesso";
            } else if (mensagemTipo === "RD") {
                msg = "Registro excluído com sucesso";
            }
        }
    } else if(mensagemTipo == "I") {
        shortCutFunction = "info";
    } else if(mensagemTipo == "E" || mensagemTipo == "FI" || mensagemTipo == "FU" || mensagemTipo == "FD") {
        shortCutFunction = "error";
        if(!msg || msg === "") {
            if (mensagemTipo === "FI") {
                msg = "Ocorreu uma falha na tentativa de incluir registro";
            } else if (mensagemTipo === "FU") {
                msg = "Ocorreu uma falha na tentativa de modificar registro";
            } else if (mensagemTipo === "FD") {
                msg = "Ocorreu uma falha na tentativa de excluir registro";
            }
        }
    }
    var title = "Carrinho de Compras";
    var $toast = toastr[shortCutFunction](msg, title);
    $toastlast = $toast;

    if(typeof $toast === 'undefined'){
        return;
    }

    if ($toast.find('#okBtn').length) {
        $toast.delegate('#okBtn', 'click', function () {
            alert('you clicked me. i was toast #' + toastIndex + '. goodbye!');
            $toast.remove();
        });
    }
    if ($toast.find('#surpriseBtn').length) {
        $toast.delegate('#surpriseBtn', 'click', function () {
            alert('Surprise! you clicked me. i was toast #' + toastIndex + '. You could perform an action here.');
        });
    }
    if ($toast.find('.clear').length) {
        $toast.delegate('.clear', 'click', function () {
            toastr.clear($toast, { force: true });
        });
    }
}