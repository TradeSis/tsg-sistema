<?php

include_once('../head.php');
include_once('../database/temas.php');
$tema = buscaTemas($_GET['idTema']);
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
            <form action="../database/temas.php?operacao=excluir" method="post">
                <div class="row">
                    <div class="col-sm-6" style="margin-top: 10px">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal' style="margin-top: -40px;">Nome</label>
                            <input type="text" name="nomeTema" class="form-control" value="<?php echo $tema['nomeTema'] ?>">
                            <input type="text" class="form-control" name="idTema" value="<?php echo $tema['idTema'] ?>" style="display: none">
                        </div>
                    </div>
                </div>
        

                <div style="text-align:right; margin-right:-20px">
                    <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                </div>
            </form>
        </div>
    </div>


    </div>


</body>

</html>