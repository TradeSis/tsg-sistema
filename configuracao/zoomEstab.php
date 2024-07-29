<!--------- MODAL --------->
<div class="modal" id="zoomEstabModal" tabindex="-1" role="dialog" aria-labelledby="zoomEstabModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Busca Estabelecimentos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-10 col-9 mt-3">
                                    <input type="text" placeholder="Digite o codigo do estabelecimento"
                                        class="form-control ts-input" id="buscaEstab" name="buscaEstab">
                                </div>
                                <div class="col-sm-2 col-3 mt-2">
                                    <button class="btn btn btn-success" type="button" id="buscar">Buscar</i></button>
                                </div>
                            </div>

                        </div>
                        <div class="container-fluid mb-2">
                            <div class="table mt-4 ts-tableFiltros text-center">
                                <table class="table table-sm table-hover ts-tablecenter">
                                    <thead class="ts-headertabelafixo">
                                        <tr class="ts-headerTabelaLinhaCima">
                                            <th>etbcod</th>
                                            <th>Nome</th>
                                            <th>Municipio</th>
                                        </tr>
                                    </thead>

                                    <tbody id='dados' class="fonteCorpo">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="container text-center my-1">
                            <button id="prevPage" class="btn btn-primary mr-2" style="display:none;">Anterior</button>
                            <button id="nextPage" class="btn btn-primary" style="display:none;">Proximo</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>








<!-- LOCAL PARA COLOCAR OS JS -->

<?php include_once ROOT . "/vendor/footer_js.php"; ?>

<script>
    var pagina = 0;

    <?php if (isset($_GET['idEmpresa'])) { ?>
        vidEmpresa = <?php echo $_GET['idEmpresa'] ?>
    <?php } ?>

    $(document).on('click', 'button[data-bs-target="#zoomEstabModal"]', function() {
        buscar($("#buscaEstab").val(), pagina);
    });


    function buscar(buscaEstab, pagina) {
        //alert (buscaEstab);
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: "<?php echo URLROOT ?>/cadastros/database/estab.php?operacao=buscar",
            beforeSend: function () {
                $("#dados").html("Carregando...");
            },
            data: {
                etbcod: buscaEstab,
                pagina: pagina,
                idEmpresa: vidEmpresa
            },
            async: false,
            success: function (msg) {
                var json = JSON.parse(msg);
                var linha = "";
                if (json === null) {
                        $("#dados").html("Erro ao buscar");
                } 
                if (json.status === 400) {
                        $("#dados").html("Nenhum estabelecimento foi encontrado");
                } else {
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];

                        linha = linha + "<tr>";
                        linha = linha + "<td class='ts-click' data-etbcod='" + object.etbcod + "'>" + object.etbcod + "</td>";
                        linha = linha + "<td class='ts-click' data-etbcod='" + object.etbcod + "'>" + object.etbnom + "</td>";
                        linha = linha + "<td class='ts-click' data-etbcod='" + object.etbcod + "'>" + object.munic + "</td>";
                        linha = linha + "</tr>";
                    }
                    $("#dados").html(linha);

                    $("#prevPage, #nextPage").show();
                    if (pagina == 0) {
                        $("#prevPage").hide();
                    }
                    if (json.length < 10) {
                        $("#nextPage").hide();
                    }
                }
            }
        });
    }
    $("#buscar").click(function () {
        buscar($("#buscaEstab").val(), pagina);
    })

    document.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            buscar($("#buscaEstab").val(), pagina);
        }
    });

    $("#prevPage").click(function () {
        if (pagina > 0) {
            pagina -= 10;
            buscar($("#buscaEstab").val(), pagina);
        }
    });

    $("#nextPage").click(function () {
        pagina += 10;
        buscar($("#buscaEstab").val(), pagina);
    });

</script>


<!-- LOCAL PARA COLOCAR OS JS -FIM -->
</body>

</html>