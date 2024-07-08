<?php
include_once('../head.php');
?>

<body class="bg-transparent">

    <div class="container" style="margin-top:10px">

        <div class="row mt-4">
            <div class="col-sm-8">
                <h3 class="col">Tema</h3>
            </div>
            <div class="col-sm-4" style="text-align:right">
                <a href="temas.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
            </div>
        </div>

        <div class="container" style="margin-top: 10px">
            <form action="../database/temas.php?operacao=inserir" method="post">
                <div class="row">
                    <div class="col-sm-6" style="margin-top: 10px">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal' style="margin-top: -40px;">Nome</label>
                            <input type="text" name="nomeTema" class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-3" style="margin-top: 10px">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal' style="margin-top: -40px;">Arquivo Css</label>
                            <input type="text" name="css" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3" style="margin-top: 10px">
                        <div class="select-form-group">

                            <label class="labelForm">Tipo</label>
                            <select class="select form-control" name="ativo">
                                <option value="1">Ativo</option>
                                <option value="0">Não Ativo</option>
                            </select>

                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6" style="margin-top: 10px">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal' style="margin-top: -50px;">Menu</label>
                            <textarea name="menu" id="" cols="130" rows="5"></textarea>
                        </div>
                    </div>
                </div>

                <div style="text-align:right; margin-right:-20px">
                    <button type="submit" class="btn btn-sm btn-success">Salvar</button>
                </div>
            </form>
        </div>

    </div>


</body>

</html>