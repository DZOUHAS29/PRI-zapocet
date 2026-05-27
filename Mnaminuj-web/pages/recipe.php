<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: /index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles.css">
    <link rel="icon" type="image/svg+xml" href="/assets/logo.svg">
    <title>Recipe</title>
</head>

<body>
    <header id="header"></header>

    <button class="back-button" id="go-back">
        <div class="horizontal-stack">
            <img src="/assets/back.svg" />
            <div>
                Zpět
            </div>
        </div>
    </button>

    <div id="recipe-body">
        <div class="name-layout vertical-stack">
            <h2 id="name" class="recipe-name" style="margin: 0;">

            </h2>
        </div>
        <div class="recipe-text">
            <h4>Budete potřebovat:</h4>
            <ul class="ingredients">

            </ul>
            <h4>Postup:</h4>
            <p id="instructions" style="white-space: pre-wrap;">

            </p>
            <div class="vertical-stack rating">
                <h4>Hodnocení</h4>
                <p id="stars">

                </p>
                <h4>Ohodnoťte tento recept</h4>
                <div class="horizontal-stack option-layout" id="rate-form">
                    <div class="vertical-stack rate-option">
                        <input type="radio" id="1-star" value="1" name="rating" />
                        <label for="1-star">1☆</label>
                    </div>
                    <div class="vertical-stack rate-option">
                        <input type="radio" id="2-star" value="2" name="rating" />
                        <label for="2-star">2☆</label>
                    </div>
                    <div class="vertical-stack rate-option">
                        <input type="radio" id="3-star" value="3" name="rating" />
                        <label for="1-star">3☆</label>
                    </div>
                    <div class="vertical-stack rate-option">
                        <input type="radio" id="4-star" value="4" name="rating" />
                        <label for="1-star">4☆</label>
                    </div>
                    <div class="vertical-stack rate-option">
                        <input type="radio" id="5-star" value="5" name="rating" />
                        <label for="1-star">5☆</label>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <script src="/scripts/layout.js"></script>
    <script>
        const id = new URLSearchParams(window.location.search).get("id");
        const nameEl = document.getElementById("name");
        const instrEl = document.getElementById("instructions");
        const starEl = document.getElementById("stars");

        fetch("/server/details.php", {
                method: "POST",
                body: new URLSearchParams({
                    id
                })
            })
            .then(response => response.json())
            .then(({
                info,
                ingredients,
                review
            }) => {
                if (info) {
                    nameEl.textContent = info.recipe_name || "";
                    instrEl.textContent = info.instructions || "";
                    starEl.textContent = info.average_rating + "☆" || "";
                }

                if (review) {
                    document.getElementById(`${review.rating}-star`).checked = true;
                }

                const ingredientsLayout = document.querySelector(".ingredients");

                ingredients.forEach(({
                    id: ingId,
                    ingredient_name,
                    quantity,
                    unit
                }) => {
                    const ingEl = document.createElement("li");
                    ingEl.key = ingId;
                    ingEl.textContent = `${Math.round(quantity)} ${unit || ""} ${ingredient_name}`;
                    ingredientsLayout.appendChild(ingEl);
                });

            })
            .catch(err => console.error(err));

        document.getElementById("rate-form").addEventListener("input", event => {
            fetch("/server/rate.php", {
                    method: "POST",
                    body: new URLSearchParams({
                        menu_id: id,
                        rating: Number(event.target.value)
                    })
                })
                .then(response => response.json())
                .then(({
                    average_rating
                }) => starEl.textContent = average_rating + "☆")
        });

        document.getElementById("go-back").addEventListener("click", () => {
            history.back();
        })
    </script>
</body>

</html>