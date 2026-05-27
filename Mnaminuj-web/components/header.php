<?php
session_start();
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/styles.css">
</head>

<body>
    <div class="top-menu">
        <div class="logo horizontal-stack" style="padding-left: 0;">
            <img src="/assets/logo.svg" />
            <h3 class="logo">Mňaminuj</h3>
        </div>

        <?php
        if (!isset($_SESSION["email"]))
            echo "
            <div class='horizontal-stack' id='profile'>
            <img src='/assets/not-logged.svg' />
            </div>
        ";
        else
            echo "
            <div class='horizontal-stack' id='profile'>
            <img src='/assets/logged.svg' title='Odhlásit se' />
                "
                . htmlspecialchars($_SESSION["email"]) .
                "
            </div>
            ";
        ?>

    </div>
</body>

</html>