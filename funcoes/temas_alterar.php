<?php

include_once('../head.php');
include_once('../database/temas.php');
$tema = buscaTemas($_GET['idTema']);
//echo json_encode($tema);

$programaForm = $tema['programaForm'];
$temporaria = explode('.', $programaForm);
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
            <form action="../database/temas.php?operacao=<?php echo $temporaria[0] ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-6" style="margin-top: 10px">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal' style="margin-top: -40px;">Nome</label>
                            <input type="text" name="nomeTema" class="form-control" value="<?php echo $tema['nomeTema'] ?>">
                            <input type="text" class="form-control" name="idTema" value="<?php echo $tema['idTema'] ?>" style="display: none">
                        </div>
                    </div>

                    <div class="col-sm-3" style="margin-top: 10px">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal' style="margin-top: -40px;">Arquivo Css</label>
                            <input type="text" name="css" class="form-control" value="<?php echo $tema['css'] ?>">
                        </div>
                    </div>
                    <div class="col-sm-3" style="margin-top: 40px">
                        <div class="select-form-group">
                            <label for="ativo">Não ativo</label>
                            <input type="range" id="ativo" name="ativo" min="0" max="1" value="<?php echo $tema['ativo'] ?>" style="width: 25%;">
                            <label for="ativo">Ativo</label>
                        </div>
                    </div>
                </div>
<!-- 
                <div class="row form-group">
                    <div class="col-sm-6">
                        <label class='control-label' for='inputNormal' style="margin-top: -50px;">Menu</label>
                        <textarea name="menu" id="" cols="130" rows="5"><?php echo $tema['menu'] ?></textarea>
                    </div>
                </div> -->

                <div class="row">
                    <div class="col-sm-12" style="margin-top: 10px;">

                        <div class="form-group">
                            <?php
                            $programaForm = $tema['programaForm'];
                            $temporaria = explode('.', $programaForm);
                            //echo json_encode($temporaria[0]);
                            //return;
                            $programaForm = $temporaria[0] . '-form.' . $temporaria[1];
                            include ROOT . '/paginas/programaForm/' . $programaForm;
                            ?>

                        </div>
                    </div>

                </div>

                <div style="text-align:right; margin-right:-20px">
                    <button type="submit" class="btn btn-sm btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>


    </div>


</body>

</html>