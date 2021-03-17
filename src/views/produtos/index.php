<?php
include_once '../shared/topo.inc.php'; 
include_once '../shared/menu.inc.php';
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h2>Produtos</h2>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table id="tableProdutos" class="table table-condensed">
            <thead>
                <tr>
                    <th fieldName="prod.codigo" orderBy="prod.codigo ASC" style="width: 6%">Código</th>
                    <th fieldName="prod.nome">Nome</th>
                    <th fieldName="prod.codigoBarras">Código de Barras</th>
                    <th fieldName="prod.dataValidade" class="text-center" style="width: 10%">Valido Até</th>
                    <th fieldName="prod.fabricanteId">Fabricante</th>
                    <th fieldName="prod.id" class="text-right">
                        <button type="button" class="btn btn-primary btnAddProduto"><i class="glyphicon glyphicon-plus"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody>&nbsp;</tbody>
        </table>
    </div>
</div>
<?php
include 'edit.inc.php';
$jsFile = array("produtos.js");
include_once '../shared/rodape.inc.php'; 