<!-- pega url -->
<?php 
include_once 'header.php';
include_once ROOT . "/sistema/database/aplicativo.php";
$aplicativos = buscaAplicativosMenu($_SESSION['idLogin']);


$aplicativo = array();
if (isset($aplicativos['nomeAplicativo'])) {
    $aplicativo[] = $aplicativos["nomeAplicativo"];
} else {
    foreach ($aplicativos as $unico) {
        //echo '<hr> aplicativos -> ' . json_encode($unico);
        $aplicativo[] = $unico["nomeAplicativo"];
    }
}

$URL_ATUAL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$url = (parse_url($URL_ATUAL, PHP_URL_PATH));
?>

<!-- MENU MOBILE -->
        <nav class="navbar-dark d-lg-none p-2 ts-bgAplicativos">
            <div class="row d-flex flex">
                <div class="col-6 col-sm-8 ">
                    <a class="navbar-brand" href="#"><img src="../img/meucontrole.png" width="100vh 100vw"></a>
                </div>
                <div class="col-6 col-sm-4 text-end ">
                
                    <select class="form-select mt-2 ts-selectAplicativos" id="tabaplicativosmobile">
                        <?php
                        if (in_array("Services", $aplicativo)) { ?>
                        <option value="<?php echo URLROOT ?>/services/" <?php if ($url == URLROOT . "/services/") {
                                            echo " selected ";
                                        } ?>>Serviços</option>
                        <?php }
                        if (in_array("Notas", $aplicativo)) { ?>
                        <option value="<?php echo URLROOT ?>/notas/" <?php if ($url == URLROOT . "/notas/") {
                                            echo " selected ";
                                        } ?>>Notas</option>
                        <?php }
                        if (in_array("Financeiro", $aplicativo)) { ?>
                        <option value="<?php echo URLROOT ?>/financeiro/" <?php if ($url == URLROOT . "/financeiro/") {
                                            echo " selected ";
                                        } ?>>Financeiro</option>
                        <?php }
                        if (in_array("Cadastros", $aplicativo)) { ?>
                        <option value="<?php echo URLROOT ?>/cadastros/" <?php if ($url == URLROOT . "/cadastros/") {
                                            echo " selected ";
                                        } ?>>Cadastros</option>
                        <?php }
                        if (in_array("Vendas", $aplicativo)) { ?>
                        <option value="<?php echo URLROOT ?>/vendas/" <?php if ($url == URLROOT . "/vendas/") {
                                            echo " selected ";
                                        } ?>>Vendas</option>
                        <?php }
                        if (in_array("Crediario", $aplicativo)) { ?>
                            <option value="<?php echo URLROOT ?>/crediario/" <?php if ($url == URLROOT . "/crediario/") {
                                                echo " selected ";
                                            } ?>>Crediario</option>
                            <?php }
                            if (in_array("Relatorios", $aplicativo)) { ?>
                        <option value="<?php echo URLROOT ?>/relatorios/" <?php if ($url == URLROOT . "/relatorios/") {
                                            echo " selected ";
                                        } ?>>Relatorios</option>
                        <?php }
                        if (in_array("Impostos", $aplicativo)) { ?>
                        <option value="<?php echo URLROOT ?>/impostos/" <?php if ($url == URLROOT . "/impostos/") {
                                            echo " selected ";
                                        } ?>>Impostos</option>
                        <?php }
                        if ($_SESSION['administradora'] == 1 && in_array("Sistema", $aplicativo)) { ?>
                        <option value="<?php echo URLROOT ?>/sistema/" <?php if ($url == URLROOT . "/sistema/") {
                                            echo " selected ";
                                        } ?>>Sistema</option>
                        <?php }
                        if ($_SESSION['administradora'] == 1 && in_array("Sistema", $aplicativo)) { ?>
                        <option value="<?php echo URLROOT ?>/admin/" <?php if ($url == URLROOT . "/admin/") {
                                            echo " selected ";
                                        } ?>>Admin</option>
                        <?php }  ?>                
                    </select>
                </div>
            </div>
        </nav>

        
<!-- MENU MOBILE -->        