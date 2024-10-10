<?php
include_once "header.php";


$selectedMenu = null;
if ($_GET['menu'] && isset($_SESSION['menu'])) {
    foreach ($_SESSION['menu'] as $menu) {
        if ($menu['tabMenu'] == $_GET['menu']) {
            $selectedMenu = $menu;
            break;
        }
    }
}
?>

<!doctype html>
<html lang="pt-BR">

<head>
    <?php include_once ROOT . "/vendor/head_css.php"; ?>
</head>

<body>
    <div class="container-fluid pt-4">
        <div class="row">

            <?php if ($selectedMenu && isset($selectedMenu['idMenuSuperior'])) {
                $subMenus = $selectedMenu['idMenuSuperior'];
                foreach ($subMenus as $index => $subMenu) {
                    if ($index % 2 == 0) { ?>
                        <div class="row">
                    <?php } ?>

                    <div class="col">
                        <div class="list-group">
                            <a href="<?php echo $subMenu['srcMenu']; ?>" class="list-group-item">
                                <div class="row g-0">
                                    <div class="col-1 text-center" style="width: 50px;">
                                        <i class="bi bi-file-earmark-text" style="font-size: 35px;"></i>
                                    </div>
                                    <div class="col ms-2 me-auto">
                                        <div class="fw-bold"><?php echo $subMenu['idMenu']; ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <?php
                    if ($index % 2 == 1 || $index == count($subMenus) - 1) { ?>
                        </div>
                    <?php } ?>
                <?php }
            } ?>

        </div>
    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>


    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>