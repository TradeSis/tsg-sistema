<?php
include_once('../head.php');
include_once('../database/temas.php');
$temas = buscaTemas();
?>



<body class="bg-transparent">

    <div class="container" style="margin-top:10px">

        <div class="row mt-4">
            <div class="col-sm-8">
                <h3 class="col">Paginas</h3>
            </div>
            <div class="col-sm-4" style="text-align:right">
                <a href="paginas.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
            </div>
        </div>

        <div class="container" style="margin-top: 10px">
            <form action="../database/paginas.php?operacao=inserir" method="post">
                <div class="row">
                    <div class="col-sm-3" style="margin-top: 10px">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal' style="margin-top: -20px;">Slug</label>
                            <input type="text" name="slug" class="form-control" required autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-3" style="margin-top: 10px">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal' style="margin-top: -20px;">Titulo</label>
                            <input type="text" name="tituloPagina" class="form-control" required autocomplete="off">
                        </div>
                    </div>

                    <div class="col-sm-3" style="margin-top: 10px">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal' style="margin-top: -20px;">Arquivo Fonte</label>
                            <input type="text" name="arquivoFonte" class="form-control" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-sm-3" style="margin-top: 10px">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal' style="margin-top: -20px;">Arquivo Single</label>
                            <input type="text" name="arquivoSingle" class="form-control" autocomplete="off">
                        </div>
                    </div>

                </div>
                <div class="row">
                        <div class="col-sm-3" style="margin-top: 10px">
                            <div class="select-form-group">

                                <label class="labelForm">Tema</label>
                                <select class="select form-control" name="idTema">
                                    <?php
                                    foreach ($temas as $tema) {
                                    ?>
                                        <option value="<?php echo $tema['idTema'] ?>"><?php echo $tema['nomeTema']  ?></option>
                                    <?php  } ?>
                                </select>

                            </div>
                        </div>
                </div>


                <div style="text-align:right; margin-right:-20px">
                    <button type="submit" class="btn btn-sm btn-success">Cadastrar</button>
                </div>
            </form>
        </div>

    </div>


</body>

</html>