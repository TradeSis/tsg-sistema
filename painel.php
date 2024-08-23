<?php 
//Lucas 29022024 - id862 Empresa Administradora
?>


<!-- MENU PAINEL -->

    <div class="ts-sidebar pt-2 d-none d-md-none d-lg-block ts-bgAplicativos">
        <a href="#"><img src="../img/meucontrole.png" width="100vh 100vw"></a>
        <div class="list-group mt-4" id="menu">
        <?php
        if (in_array("Servicos", $_SESSION['aplicativo'])) { ?>
            <a class="ts-itemsiderbar <?php if ($url == URLROOT . "/servicos/") {echo " active ";} ?> p-3" 
            href="<?php echo URLROOT ?>/servicos/">Serviços</a>
        <?php }
        if (in_array("Notas", $_SESSION['aplicativo'])) { ?>
            <a class="ts-itemsiderbar <?php if ($url == URLROOT . "/notas/") {echo " active ";} ?> p-3" 
            href="<?php echo URLROOT ?>/notas/">Notas</a>
        <?php }
        if (in_array("Financeiro", $_SESSION['aplicativo'])) { ?>
            <a class="ts-itemsiderbar <?php if ($url == URLROOT . "/financeiro/") {echo " active ";} ?> p-3" 
            href="<?php echo URLROOT ?>/financeiro/">Financeiro</a>
        <?php }
        if (in_array("Cadastros", $_SESSION['aplicativo'])) { ?>
            <a class="ts-itemsiderbar <?php if ($url == URLROOT . "/cadastros/") {echo " active ";} ?> p-3" 
            href="<?php echo URLROOT ?>/cadastros/">Cadastros</a>
        <?php }
        /** DESATIVADO EM 15/12/2023
        if (in_array("Paginas", $_SESSION['aplicativo'])) { ?>
            <a class="ts-itemsiderbar <?php if ($url == URLROOT . "/paginas/") {echo " active ";} ?> p-3" 
            href="<?php echo URLROOT ?>/paginas/">Paginas</a>
        <?php }
        **/
        if (in_array("Crediario", $_SESSION['aplicativo'])) { ?>
            <a class="ts-itemsiderbar <?php if ($url == URLROOT . "/crediario/") {echo " active ";} ?> p-3" 
            href="<?php echo URLROOT ?>/crediario/">Crediario</a>
        <?php }
        if (in_array("Vendas", $_SESSION['aplicativo'])) { ?>
            <a class="ts-itemsiderbar <?php if ($url == URLROOT . "/vendas/") {echo " active ";} ?> p-3" 
            href="<?php echo URLROOT ?>/vendas/">Vendas</a>
        <?php }
        if (in_array("Relatorios", $_SESSION['aplicativo'])) { ?>
            <a class="ts-itemsiderbar <?php if ($url == URLROOT . "/relatorios/") {echo " active ";} ?> p-3" 
            href="<?php echo URLROOT ?>/relatorios/">Relatorios</a>
        <?php }
        if (in_array("Impostos", $_SESSION['aplicativo'])) { ?>
            <a class="ts-itemsiderbar <?php if ($url == URLROOT . "/impostos/") {echo " active ";} ?> p-3" 
            href="<?php echo URLROOT ?>/impostos/">Impostos</a>
        <?php }
        //Lucas 29022024 - id862 alterado campo idEmpresa para administradora
        if ($_SESSION['administradora'] == 1 && in_array("Sistema", $_SESSION['aplicativo'])) { ?>
            <a class="ts-itemsiderbar <?php if ($url == URLROOT . "/sistema/") {echo " active ";} ?> p-3" 
            href="<?php echo URLROOT ?>/sistema/">Sistema</a>
        <?php }  
        //Lucas 02042024 - id876 Empresa administradora
        if ($_SESSION['administradora'] == 1 && in_array("Sistema", $_SESSION['aplicativo'])) { ?>
            <a class="ts-itemsiderbar <?php if ($url == URLROOT . "/admin/") {echo " active ";} ?> p-3" 
            href="<?php echo URLROOT ?>/admin/">Admin</a>
        <?php }  ?>
        
        </div>
    </div>
<!-- MENU PAINEL -->

