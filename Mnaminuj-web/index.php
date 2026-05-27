<?php
session_start();

if (isset($_SESSION["id"])) {
    header("Location: /pages/home.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/svg+xml" href="/assets/logo.svg">
    <title>Login</title>
</head>

<body>
    <header id="header"></header>

    <div class="vertical-stack form-layout">
        <form class="vertical-stack form-size" id="login-form">
            <h3 class="title">Přihlásit se</h3>
            <p>Vítejte zpět! Přihlaste se a mrkněte, co je u nás nového dobrého!</p>
            <input type="email" placeholder="Email*" name="email" id="email" required />
            <input type="password" placeholder="Heslo*" name="password" id="password" required />
            <input type="submit" value="Přihlásit" class="button" />
            <div id="login-output" style="color: red;"></div>
            <a href="pages/register.html">Registrovat</a>
        </form>
    </div>

    <script src="scripts/layout.js"></script>
    <script>
        document.getElementById("login-form").addEventListener("submit", event => {
            event.preventDefault();

            const data = new FormData(event.target);

            fetch("/server/login.php", {
                    method: "POST",
                    body: data
                })
                .then(response => response.text())
                .then(data => {
                    if (data == "200") {
                        window.location.href = "/pages/home.php";
                        return;
                    }

                    document.getElementById("login-output").innerHTML = data;
                })
                .catch(err => console.error(err))
        })
    </script>
</body>

</html>