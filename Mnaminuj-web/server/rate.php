<?php
session_start();

require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = $_SESSION["id"];
    $menu = $_POST["menu_id"];
    $rating = $_POST["rating"];

    if (!is_numeric($user) || !is_numeric($menu) || !is_numeric($rating)) {
        echo "Inputy musí být čísla.";
        return;
    }

    $find_sql = "SELECT * FROM recipe_reviews WHERE user_id = :user AND menu_id = :menu";
    $update_sql = "UPDATE recipe_reviews SET rating=:rating  WHERE user_id = :user AND menu_id = :menu";
    $insert_sql = "INSERT INTO recipe_reviews (menu_id, user_id, rating) VALUES (:menu, :user, :rating)";
    $rating_sql = "
    SELECT COALESCE(ROUND(AVG(r.rating), 1), 0) AS average_rating FROM menu m
    LEFT JOIN recipe_reviews r ON m.id = r.menu_id
    WHERE m.id=:id
    ";

    try {
        $exists = $pdo->prepare($find_sql);

        $exists->execute([
            ":user" => $user,
            ":menu" => $menu
        ]);

        $rated = $exists->fetch();

        if ($rated) {
            $update = $pdo->prepare($update_sql);

            $update->execute([
                ":user" => $user,
                ":menu" => $menu,
                ":rating" => $rating
            ]);
        } else {
            $insert = $pdo->prepare($insert_sql);

            $insert->execute([
                ":user" => $user,
                ":menu" => $menu,
                ":rating" => $rating
            ]);
        }

        $new_rating = $pdo->prepare($rating_sql);

        $new_rating->execute([
            ":id" => $menu
        ]);

        $stars = $new_rating->fetch();

        echo json_encode($stars);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    echo "Potřebné informace jsou undefined!";
}
