<?php
session_start();

require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];

    $clean_email = trim(htmlspecialchars($email));
    $clean_password = htmlspecialchars($password);
    $clean_password2 = htmlspecialchars($password2);

    if ($clean_email == "" || $clean_password == "" || $clean_password2 == "") {
        echo "Prosím vyplňte všechna pole";
        return;
    }

    if ($clean_password != $clean_password2) {
        echo "Hesla se neshodují!";
        return;
    }

    $hash = password_hash($clean_password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";

    try {
        $query = $pdo->prepare($sql);

        $query->execute([
            ":email" => $clean_email,
            ":password" => $hash
        ]);

        $id = $pdo->lastInsertId();

        $_SESSION["id"] = $id;
        $_SESSION["email"] = $clean_email;

        echo 200;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "Uživatel existuje.";
            return;
        }
        echo $e->getMessage();
    }
} else {
    echo "Prosím vyplňte formuář!";
}
