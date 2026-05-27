<?php
session_start();

require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $clean_email = trim(htmlspecialchars($email));
    $clean_password = htmlspecialchars($password);

    if ($clean_email == "" || $clean_password == "") {
        echo "Prosím vyplňte všechna pole";
        return;
    }

    $sql = "SELECT * FROM users WHERE email = :email";

    try {
        $query = $pdo->prepare($sql);

        $query->execute([
            ":email" => $clean_email
        ]);

        $user = $query->fetch();

        if (!$user) {
            echo "Uživatel nenalezen.";
            return;
        }

        $hash = $user["password"];

        if (!password_verify($clean_password, $hash)) {
            echo "Neplatné heslo.";
            return;
        }

        $_SESSION["id"] = $user["id"];
        $_SESSION["email"] = $user["email"];

        echo 200;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    echo "Prosím vyplňte formuář!";
}
