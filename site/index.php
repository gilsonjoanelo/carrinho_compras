<?php
include_once './includes/topo.inc.php'; 
?>
<div class="row">
    <div class="col">
        <h2>Autenticação</h2>
    </div>
</div>
<div class="row">
    <div class="col">
    <div class="row">
            <div class="col">
                <h3>Cadastrar-se</h3>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form id="formCadastro">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <h3>Já sou cadastrado</h3>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form id="formLogin">
                    <div class="form-group">
                        <label for="inputUsuario">Usuário</label>
                        <input type="text" class="form-control" id="inputUsuario" name="Usuario" />
                    </div>
                    <div class="form-group">
                        <label for="inputSenha">Password</label>
                        <input type="password" class="form-control" id="inputSenha" name="Senha">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="checkManterLogado" name="IsManterLogado">
                        <label class="form-check-label" for="checkManterLogado">Mater logado</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$jsFile = array("site/login.js", "site/cadastro.js");
include_once './includes/rodape.inc.php'; 