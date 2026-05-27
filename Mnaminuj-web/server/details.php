<?php
session_start();

require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json; charset=UTF-8');

    $id = $_POST["id"];

    $sql_info = "
    SELECT m.id, recipe_name, instructions, prep_time_minutes, COALESCE(ROUND(AVG(r.rating), 1), 0) AS average_rating FROM menu m
    LEFT JOIN recipe_reviews r ON m.id = r.menu_id
    WHERE m.id=:id
    ";

    $sql_review = "
    SELECT rating FROM recipe_reviews
    WHERE menu_id=:menu AND user_id = :user
    ";

    $sql_ingredients = "
    SELECT i.id, i.ingredient_name, ri.quantity, ri.unit FROM menu m
    JOIN recipe_ingredients ri ON m.id = ri.menu_id
    JOIN ingredients i ON ri.ingredient_id = i.id
    WHERE m.id=:id
    ";

    try {
        $ing_query = $pdo->prepare($sql_ingredients);
        $info_query = $pdo->prepare($sql_info);
        $review_query = $pdo->prepare($sql_review);

        $ing_query->execute([
            ":id" => $_POST["id"]
        ]);

        $info_query->execute([
            ":id" => $_POST["id"]
        ]);

        $review_query->execute([
            ":menu" => $_POST["id"],
            ":user" => $_SESSION["id"]
        ]);

        $ingredients = $ing_query->fetchAll();
        $info = $info_query->fetch();
        $reviewed = $review_query->fetch();

        $json = [
            "info" => $info,
            "ingredients" => $ingredients,
            "review" => $reviewed
        ];

        echo json_encode($json);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    echo "Chyba!";
}
