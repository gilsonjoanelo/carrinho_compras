<form id="formProdutoEdit">
<div id="modalCadastroProduto" class="modal fade" tabindex="-1" role="dialog">
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
                    <label>Código de Barras</label>
                    <input type="text" name="codigoBarras" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <label>Fabricante</label>
                    <select name="fabricanteId" class="form-control"></select>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <label>Valido Até</label>
                    <input type="date" name="dataValidade" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                   
                    <label>Descrição</label>
                    <textarea class="form-control" name="descricao" rows="3"></textarea>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary buttonSalvarProduto">Salvar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
</form>