<?php
//Lucas 29022024 - id862 Empresa Administradora
// Lucas 06102023 padrao novo
// helio 01022023 altereado para include_once
// helio 26012023 16:16

include_once('../header.php');
include_once('../database/empresa.php');
include_once(ROOT . '/cadastros/database/pessoas.php');
$empresa = buscaEmpresas($_GET['idEmpresa']);
$pessoas = buscarPessoa();
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <BR> <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <BR> <!-- BOTOES AUXILIARES -->
        </div>
        <div class="row"> <!-- LINHA SUPERIOR A TABLE -->
            <div class="col-3">
                <!-- TITULO -->
                <h2 class="ts-tituloPrincipal">Alterar Empresa</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="/sistema/configuracao/empresa.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form action="../database/empresa.php?operacao=alterar" method="post">
            <div class="row mt-3">
                <div class="col-md-6">
                    <label class='form-label ts-label'></label>
                    <input type="text" class="form-control ts-input" name="nomeEmpresa" value="<?php echo $empresa['nomeEmpresa'] ?>">
                    <input type="hidden" class="form-control ts-input" name="idEmpresa" value="<?php echo $empresa['idEmpresa'] ?>">
                </div>
                <div class="col-md-4">
                    <label class='form-label ts-label'>CNPJ</label>
                    <input type="text" value="<?php echo $empresa['cnpj'] ?>" class="form-control ts-input" name="cnpj" autocomplete="off">
                </div>

                <!-- Lucas 29022024 - id862 adicionado Select para administradora -->
                <div class="col-md-2">
                    <label class="form-label ts-label">Administradora</label>
                    <select class="form-select ts-input" name="administradora">
                        <option <?php if ($empresa['administradora'] == "1") {
                                    echo "selected";
                                } ?> value="1">Sim</option>
                        <option <?php if ($empresa['administradora'] == "0") {
                                    echo "selected";
                                } ?> value="0">Não</option>
                    </select>
                </div>
                <div class="row mt-3">
                    <div class="col-md-2">
                        <label class='form-label ts-label'>Tempo Sessão</label>
                        <input type="number" min="1" value="<?php echo $empresa['timeSessao'] ?>" class="form-control ts-input" name="timeSessao" autocomplete="off" required>
                    </div>
                    <div class="col-md-2">
                        <label class='form-label ts-label'>Estab Padrão</label>
                        <input type="number" min="0" value="<?php echo $empresa['etbcodPadrao'] ?>" class="form-control ts-input" name="etbcodPadrao" autocomplete="off" required>
                    </div>
                    <div class="col-md-4">
                        <label class='form-label ts-label'>progressdb</label>
                        <input type="text" value="<?php echo $empresa['progressdb'] ?>" class="form-control ts-input" name="progressdb" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <label class='form-label ts-label'>progressld</label>
                        <input type="text" value="<?php echo $empresa['progressld'] ?>" class="form-control ts-input" name="progressld" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-3">
                    <label class='form-label ts-label'>Host</label>
                    <input type="text" value="<?php echo $empresa['host'] ?>" class="form-control ts-input" name="host" autocomplete="off">
                    <br>
                    <label class='form-label ts-label'>Base</label>
                    <input type="text" value="<?php echo $empresa['base'] ?>" class="form-control ts-input" name="base" autocomplete="off">
                    <br>
                    <label class='form-label ts-label'>Usuario DB</label>
                    <input type="text" value="<?php echo $empresa['usuario'] ?>" class="form-control ts-input" name="usuario" autocomplete="off">
                    <br>
                    <label class='form-label ts-label'>Senha DB</label>
                    <input type="text" value="<?php echo $empresa['senhadb'] ?>" class="form-control ts-input" name="senhadb" autocomplete="off">
                </div>
                <div class="col-md-9">
                    <div class="container-fluid p-0">
                    <!-- lucas 27022024 - id853 nova chamada editor quill -->
                        <div class="col">
                            <span class="tituloEditor">Menu</span>
                        </div>
                        <div id="ql-toolbarMenu">
                            <?php include ROOT."/sistema/quilljs/ql-toolbar-min.php"  ?>
                            <input type="file" id="anexarMenu" class="custom-file-upload" name="nomeAnexo" onchange="uploadFileMenu()" style=" display:none">
                            <label for="anexarMenu">
                                <a class="btn p-0 ms-1"><i class="bi bi-paperclip"></i></a>
                            </label>
                        </div>
                        <div id="ql-editorMenu" style="height:30vh !important">
                        </div>
                        <textarea style="display: none" id="quill-menu" name="menu"><?php echo $empresa['menu'] ?></textarea>
                    </div>
                </div>
            </div>    

            <div class="text-end mt-4">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
            </div>
        </form>

    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <!-- QUILL editor -->
    
    <script>
        var quillMenu = new Quill('#ql-editorMenu', {
            modules: {
                toolbar: '#ql-toolbarMenu'
            },
            placeholder: 'Digite o texto...',
            theme: 'snow'
        });

        quillMenu.on('text-change', function (delta, oldDelta, source) {
            $('#quill-menu').val(quillMenu.container.firstChild.innerHTML);
        });

        async function uploadFileMenu() {

            let endereco = '/tmp/';
            let formData = new FormData();
            var custombutton = document.getElementById("anexarMenu");
            var arquivo = custombutton.files[0]["name"];

            formData.append("arquivo", custombutton.files[0]);
            formData.append("endereco", endereco);

            destino = endereco + arquivo;

            await fetch('/sistema/quilljs/quill-uploadFile.php', {
                method: "POST",
                body: formData
            });

            const range = this.quillMenu.getSelection(true)

            this.quillMenu.insertText(range.index, arquivo, 'user');
            this.quillMenu.setSelection(range.index, arquivo.length);
            this.quillMenu.theme.tooltip.edit('link', destino);
            this.quillMenu.theme.tooltip.save();

            this.quillMenu.setSelection(range.index + destino.length);

        }
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>