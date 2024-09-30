<?php
//Helio 05102023 padrao novo
//Lucas 04042023 criado
include_once(__DIR__ . '/../header.php');
include_once(__DIR__ . '/../database/perfil.php');

$perfis = buscaPerfil();
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

        <div class="row align-items-center"> <!-- LINHA SUPERIOR A TABLE -->
            <div class="col-3 text-start">
                <!-- TITULO -->
                <h2 class="ts-tituloPrincipal">Perfils</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <?php if (operacaoDisponivel("Perfil", "INS")) { ?>
                    <button type="button" class="btn btn-success" id="modalBtn"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
                <?php } ?>
            </div>
        </div>

        <div class="table mt-2 ts-divTabela">
            <table class="table table-hover table-sm align-middle">
                <thead class="ts-headertabelafixo">
                    <tr>
                        <th>Nome Perfil</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <?php 
                if (isset($perfis[0]['idPerfil'])) {
                foreach ($perfis as $perfil) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $perfil['idPerfil'] ?>
                        </td>

                        <td>
                            <?php if (operacaoDisponivel("Perfil", "ALT")) { ?>
                            <a class="btn btn-warning btn-sm"
                                href="perfil_alterar.php?idPerfil=<?php echo $perfil['idPerfil'] ?>" role="button"><i
                                    class="bi bi-pencil-square"></i></a>
                            <?php } ?>
                            <?php if (operacaoDisponivel("Perfil", "EXC")) { ?>
                            <!-- <a class="btn btn-danger btn-sm"
                            href="perfil_excluir.php?idPerfil=<?php echo $perfil['idPerfil'] ?>"
                            role="button"><i class="bi bi-trash3"></i></a> -->
                            <?php } ?>
                        </td>
                    </tr>
                <?php }} ?>

            </table>
        </div>


    </div>

    <!--------- INSERIR --------->
    <div class="modal" id="inserirmodal" tabindex="-1" aria-labelledby="inserirmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Inserir Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="inserirForm">
                        <div class="row">
                            <div class="col">
                                <label class="form-label ts-label">Nome Perfil</label>
                                <input type="text" class="form-control ts-input" name="idPerfil" required>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="row">
                                <div class="col"><label>Aplicativos:</label></div>
                                <div class="col"><input type="checkbox" id="checarTodos"
                                        class="form-check-input"> <label for="checarTodos">Marcar tudo</label>
                                </div>
                            </div>
                            <div class="row mt-2" id="aplicativosContainer">
                            </div>
                        </div>
                </div><!--body-->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
      $(document).ready(function() {
            $('#inserirForm').submit(function (e) {
                e.preventDefault();
                var idPerfil = $('input[name="idPerfil"]').val(); 
                var aplicativos = [];
                $('.menu-checkbox:checked').each(function () { aplicativos.push($(this).next('label').text().trim()); });
                var apiEntrada = {
                    idPerfil: idPerfil,
                    aplicativos: aplicativos.join(',')
                };
                $.ajax({
                    type: 'POST',
                    url: "../database/perfil.php?operacao=inserir",
                    data: apiEntrada, 
                    success: function (msg) {
                        window.location.reload();
                    }
                });
            });

            $('#checarTodos').on('change', function () {
                $('.menu-checkbox').prop('checked', $(this).is(':checked'));
            });
            $('.menu-checkbox').on('change', function () {
                var allChecked = $('.menu-checkbox').length === $('.menu-checkbox:checked').length;
                $('#checarTodos').prop('checked', allChecked);
            });

            $('#modalBtn').on('click', function () {
                $('body').css('cursor', 'wait');
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '../database/aplicativo.php?operacao=buscar',
                    data: {
                        idAplicativo: null
                    },
                    success: function (aplicativos) {
                        var aplicativosHtml = '';
                        var counter = 0;
                        aplicativos.forEach(function (aplicativo) {
                            if (counter % 3 === 0) {
                                if (counter > 0) { aplicativosHtml += '</div>'; }
                                aplicativosHtml += '<div class="row mt-2">';
                            }
                            aplicativosHtml += `
                                <div class="col-md-4">
                                    <input class="form-check-input menu-checkbox" type="checkbox" value="${aplicativo.idAplicativo}">
                                    <label>&nbsp;${aplicativo.nomeAplicativo}</label>
                                </div>`;
                            counter++;
                        });
                        if (counter % 3 !== 0) {
                            aplicativosHtml += '</div>';
                        }
                        $('#aplicativosContainer').html(aplicativosHtml);
                        $('#inserirmodal').modal('show');
                        $('body').css('cursor', 'default');
                    }
                });
            });
        });
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>