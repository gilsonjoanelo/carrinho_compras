$('.menu-sair').click(function(e){
    e.preventDefault();
    window.localStorage.removeItem("CAR_TOKEN");
    window.location = "/views/autenticacao";
});