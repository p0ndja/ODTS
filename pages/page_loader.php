<?php 
    require_once '../static/functions/connect.php';
    require_once '../static/functions/function.php';
    require_once '../vendor/parsedown/Parsedown.php';
?>

<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
    <head>
        <?php require_once '../static/functions/head.php'; ?>
    </head>
    <body>
        <?php require_once '../static/functions/navbar.php'; ?>
        <div id="page_loader">
            <?php if (isset($_GET['target']) && file_exists($_GET['target'])) require_once $_GET['target']; ?>
        </div>

        <?php require_once '../static/functions/popup.php'; ?>
        <?php require_once '../static/functions/footer.php'; ?>
    </body>
</html>