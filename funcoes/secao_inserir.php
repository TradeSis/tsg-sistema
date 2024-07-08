<?php
include_once('../head.php');
?>



<body class="bg-transparent">

    <div class="container" style="margin-top:10px">

        <div class="row mt-4">
            <div class="col-sm-8">
                <h3 class="col">Seções</h3>
            </div>
            <div class="col-sm-4" style="text-align:right">
                <a href="secao.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
            </div>
        </div>

        <div class="container" style="margin-top: 10px">
            <form action="../database/secao.php?operacao=inserir" method="post">
                <div class="row">
                    <div class="col-sm-6" style="margin-top: 10px">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal' style="margin-top: -20px;">Titulo</label>
                            <input type="text" name="tituloSecao" class="form-control" required autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-3" style="margin-top: 10px">
                        <div class="form-group">
                            <label class='control-label' for='inputNormal' style="margin-top: -20px;">Arquivo Fonte</label>
                            <input type="text" name="arquivoFonte" class="form-control" required autocomplete="off">
                        </div>
                    </div>

                    <div class="col-sm-3" style="margin-top: 10px">
                        <div class="select-form-group">

                            <label class="labelForm">Tipo</label>
                            <select class="select form-control" name="tipoSecao">
                                <option value="header">Header</option>
                                <option value="footer">Footer</option>
                                <option value="html">Html</option>
                                <option value="card">Card</option>
                                <option value="form">Form</option>
                                <option value="quemSomos">Quem Somos</option>
                                <option value="principal">Principal</option>
                                <option value="divisorPagina">Divisor de Pagina</option>
                                <option value="lista">Lista</option>
                                <option value="slides">Slides</option>
                                <option value="blog">Blog</option>
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