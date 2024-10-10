<?php
include_once __DIR__ . "/../config.php";
include_once "header.php";


if (
    !isset($_SESSION['nomeAplicativo']) || 
    $_SESSION['nomeAplicativo'] !== 'Sistema' || 
    !isset($_SESSION['menu']) || 
    $_SESSION['menu'] === [""]
) { 
    $_SESSION['nomeAplicativo'] = 'Sistema';
    include_once ROOT . "/sistema/database/perfil.php";
    $menus = buscaPerfilMenu($_SESSION['idPerfil'],$_SESSION['nomeAplicativo']);
    $menu = array();
    $buscaMenu = array();
    foreach ($menus as $unico) {
        $buscaMenu[$unico['idMenu']] = array(
            "idMenu" => $unico["idMenu"],
            "tabMenu" => $unico["tabMenu"],
            "srcMenu" => $unico["srcMenu"],
            "titleMenu" => $unico["titleMenu"],
            "operacoes" => $unico["operacoes"],
            "subMenus" => array() 
        );
    }
    foreach ($menus as $unico) {
        if (!empty($unico['idMenuSuperior'])) {
            $buscaMenu[$unico['idMenuSuperior']]['subMenus'][] = array(
                "idMenu" => $unico["idMenu"],
                "tabMenu" => $unico["tabMenu"],
                "srcMenu" => $unico["srcMenu"],
                "titleMenu" => $unico["titleMenu"],
                "operacoes" => $unico["operacoes"]
            );
        }
    }
    $menu = array();
    foreach ($buscaMenu as $idMenu => $menuItem) {
        if (empty($menus[array_search($idMenu, array_column($menus, 'idMenu'))]['idMenuSuperior'])) {
            if (!empty($menuItem['subMenus'])) {
                $menuItem['idMenuSuperior'] = $menuItem['subMenus'];
            }
            unset($menuItem['subMenus']); 
            $menu[] = $menuItem;
        }
    }

    $_SESSION['menu'] = $menu;
} 
// helio 051023 - TODO PROGRAMA PRECISA TER DOCTYPE/HTML/HEAD no seu inicio
?>
<!doctype html>
<html lang="pt-BR">
<head>
    
    <?php include_once ROOT. "/vendor/head_css.php";?>
    <title>Sistema</title>

</head>

<body>

    <?php include_once  ROOT . "/sistema/painelmobile.php"; ?>

    <div class="d-flex">

        <?php include_once  ROOT . "/sistema/painel.php"; ?>

        <div class="container-fluid">

            <div class="row ">
                <div class="col-lg-10 d-none d-md-none d-lg-block pr-0 pl-0 ts-bgAplicativos">
                    <ul class="nav a" id="myTabs">

                        <?php
                        $tab = '';

                        if (isset($_GET['menu'])) {
                            $tab = $_GET['menu'];
                        }
                        ?>
                        <?php 
                            foreach ($_SESSION['menu'] as $menu) { ?>
                                <li class="nav-item mr-1 ">
                                    <a class="nav-link 
                                    <?php if ($tab == $menu['tabMenu']) {echo " active ";} ?>" 
                                    href="?menu=<?php echo $menu['tabMenu'] ?>" role="tab"><?php echo $menu['idMenu'] ?></a>
                                </li>
                        <?php  } ?>

                    </ul>
                </div>
                <!--Essa coluna só vai aparecer em dispositivo mobile-->
                <div class="col-7 col-md-9 d-md-block d-lg-none ts-bgAplicativos">
                <!--atraves do GET testa o valor para selecionar um option no select-->
                <?php if(isset($_GET['menu'])){
                    $getTab = $_GET['menu'];
                }else{
                    $getTab = '';
                }?>
                    <select class="form-select mt-2 ts-selectSubMenuAplicativos" id="subtabSistema">

                        <?php 
                            foreach ($_SESSION['menu'] as $menu) { 
                            if ($menu['idMenuSuperior'] === "") {?>
                                <option value="<?php echo URLROOT ?>/sistema/?menu=<?php echo $menu['tabMenu'] ?>"
                                <?php if ($getTab == $menu['tabMenu']) {echo " selected ";} ?>><?php echo $menu['idMenu'] ?></option>
                        <?php } } ?>

                    </select>
                </div>
                
                <?php include_once  ROOT . "/sistema/novoperfil.php"; ?>

            </div><!--row-->
         
            <?php

            $src = "";
            $title = "Sistema";

            foreach ($_SESSION['menu'] as $menu) { 
                if ($tab == $menu['tabMenu']) {
                    $src = $menu['srcMenu'];
                    $title = $menu['titleMenu'];
                }
                if (isset($_GET['stab'])) {
                    $src = $src . "?stab=" . $_GET['stab'];
                }
            } 

            if ($src !== "") { ?>
                <div class="container-fluid p-0 m-0">
                    <iframe class="row p-0 m-0 ts-iframe"  src="<?php echo URLROOT ?>/sistema/<?php echo $src ?>"></iframe>
                </div>
            <?php } ?>

        </div><!-- div container -->
    </div><!-- div class="d-flex" -->


    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT. "/vendor/footer_js.php";?>

    <script src="js/mobileSelectTabs.js"></script>


    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>