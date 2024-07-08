<?php
include_once('../head.php');
include_once('../database/secao.php');
include_once('../database/paginas.php');
include_once('../database/secaoPagina.php');

$secoes = buscaSecao();
$paginas = buscaPaginas($_GET["idPagina"]);
//echo json_encode($secoes);
?>



<body class="bg-transparent">

    <div class="container" style="margin-top:30px">
        
            <div class="row mt-4">
               
                    <div class="col-sm-8">
                        <h3 class="col">Seções das Paginas</h3>
                    </div>
                    <div class="col-sm-4" style="text-align:right">
                        <a href="paginas.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
               
            </div>
            <div class="container" style="margin-top: 10px">

                <form action="../database/secaoPagina.php?operacao=inserir" method="post">



                    <div class="row">
                        <div class="col-sm-3" style="margin-top: -5px">
                            <div class="select-form-group">                               
                                <label class="labelForm">Pagina</label>
                                <input type="text" class="form-control" name="tituloPagina" value="<?php echo $paginas['tituloPagina'] ?>" readonly>
                                <input type="text" class="form-control" name="idPagina" value="<?php echo $paginas['idPagina'] ?>" hidden>
                            </div>
                        </div>

                        <div class="col-sm-3" style="margin-top: 10px">
                            <div class="select-form-group">

                                <label class="labelForm">Seção</label>
                                <select class="select form-control" name="idSecao">
                                    <?php
                                    foreach ($secoes as $secao) {
                                    ?>
                                        <option value="<?php echo $secao['idSecao'] ?>"><?php echo $secao['tituloSecao']  ?></option>
                                    <?php  } ?>
                                </select>

                            </div>
                        </div>

                        <div class="col-sm-3" style="margin-top: 10px">
                            <div class="select-form-group">
                                    <label class="labelForm">Ordem</label>
                                    <select class="select form-control" name="ordem">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                       
                                    </select>                            
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12" style="margin-top: 10px">
                   
                            <div class="form-group">
                                <label>Parametros</label>
                                <textarea name="parametros" cols="130" rows="10"></textarea>
                               
                            </div>
                        </div>

                    </div>

                </div>

      
                    <div style="text-align:right; margin-right:-20px; margin-top: 30px">
                    <button type="submit" class="btn btn-sm btn-success">Adicionar</button>
                </div>
                </form>
            </div>
        
    </div>

</body>

</html>