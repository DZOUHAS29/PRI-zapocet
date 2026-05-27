<?php
session_start();

require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $sql = "
    SELECT m.id, recipe_name, description, prep_time_minutes, COALESCE(ROUND(AVG(r.rating), 1), 0) AS average_rating,
    COUNT(r.id) AS total_reviews
    FROM menu m
    LEFT JOIN recipe_reviews r ON m.id = r.menu_id
    GROUP BY m.id, m.recipe_name
    ORDER BY average_rating DESC; 
    ";

    try {
        $query = $pdo->prepare($sql);

        $query->execute();

        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($data);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    echo "Chyba!";
}
