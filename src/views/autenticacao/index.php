<?php
include_once '../shared/topo.inc.php'; 
?>
<div class="row form-login">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h2>Autenticação</h2>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <form id="formLogin">
            <div class="form-group">
                <label>Usuário</label>
                <input type="text" class="form-control" name="usuario" />
            </div>
            <div class="form-group">
                <label>Senha</label>
                <input type="password" class="form-control" name="senha">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="isManterLogado">
                <label class="form-check-label">Mater logado</label>
            </div>
            <button type="button" class="btn btn-primary buttonLogin">Entrar</button>
            <button type="button" class="btn btn-primary buttonCadastrar">Cadastrar-se</button>
        </form>
    </div>
</div>
<form id="formCadastro">
<div id="modalCadastroUsuario" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cadastrar-se</h4>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label>E-mail</label>
                    <input type="text" name="email" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">                    
                    <label>Usuário</label>
                    <input type="text" name="usuario" class="form-control" />
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <label>Senha</label>
                    <input type="password" name="senha" class="form-control" />
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary buttonCadastro">Salvar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
</form>
<?php
$jsFile = array("login.js");
include_once '../shared/rodape.inc.php'; 