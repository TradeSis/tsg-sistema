<!--------- MODAL DEVOLVER --------->
<div class="modal" id="alterarSenhaModal" tabindex="-1" role="dialog" aria-labelledby="alterarSenhaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alterar Senha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../database/login.php?operacao=senha" method="post">
                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <label class="form-label ts-label">Senha Atual</label>
                            <input type="password" name="senhaatual" class="form-control ts-input" autocomplete="off"
                                onfocus="this.value='';" placeholder="Senha" required>
                            <small id="senhaAtualMsg" style="display: none; color: red;">Senha atual incorreta</small>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm">
                            <label class="form-label ts-label">Nova Senha</label>
                            <input type="password" name="password" class="form-control ts-input" autocomplete="off"
                                onfocus="this.value='';" placeholder="Senha" required disabled>
                            <input type="hidden" class="form-control ts-input" name="idLogin" value="<?php echo $usuario['idLogin'] ?>">
                            <input type="hidden" class="form-control ts-input" name="ultimaulr" value="<?php echo $_SESSION['ultimaulr'] ?>">
                        </div>
                        <div class="col-sm">
                            <label class="form-label ts-label">Repetir Senha</label>
                            <input type="password" name="senhausuario2" class="form-control ts-input" autocomplete="off"
                                onfocus="this.value='';" placeholder="Repetir Senha" required
                                oninput="validaSenha(this)" disabled>
                            <small id="repeteMsg" style="display: none">Precisa ser igual a senha digitada.</small>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Salvar</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>
    var senhaCorreta = false;

    function validaSenha(input) {
        var senha1 = $("input[name='password']").val();
        var senha2 = input.value;

        if (senha1 !== senha2) {
            $("#repeteMsg").show();
        } else {
            $("#repeteMsg").hide();
        }
        salvarbtn();
    }
    $("input[name='senhaatual']").on("input", function () {
        var senhaAtual = $(this).val();
        $.ajax({
            type: "POST",
            url: "../database/login.php?operacao=verificaSenha",
            data: { senhaAtual: senhaAtual },
            success: function (response) {
                var senhaAtualStored = "<?php echo $usuario['password']; ?>";
                response = response.trim();
                senhaAtualStored = senhaAtualStored.trim();

                if (response == senhaAtualStored) {
                    $("input[name='password']").removeAttr('disabled');
                    $("input[name='senhausuario2']").removeAttr('disabled');
                    $("#senhaAtualMsg").hide();
                    senhaCorreta = true;
                } else {
                    $("input[name='password']").attr('disabled', 'disabled');
                    $("input[name='senhausuario2']").attr('disabled', 'disabled');
                    $("#senhaAtualMsg").show();
                    senhaCorreta = false; 
                }
                salvarbtn();
            }
        });
    });

    function salvarbtn() {
        var senhaNova = $("input[name='password']").val();
        var senhaRepetida = $("input[name='senhausuario2']").val();
        
        if (senhaCorreta  && senhaNova == senhaRepetida) {
            $("#salvarSenha").removeAttr('disabled');
        } else {
            $("#salvarSenha").attr('disabled', 'disabled');
        }
    }

    salvarbtn();

</script>