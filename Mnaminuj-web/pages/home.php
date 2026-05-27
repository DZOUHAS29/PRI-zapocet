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
    <title>Home</title>
</head>

<body>
    <header id="header"></header>

    <div class="vertical-stack">
        <div class="vertical-stack filters">
            <div class="horizontal-stack filters-button" id="show-filters">
                Filtry
                <div id="arrow">
                    <img src='/assets/down.svg' />
                </div>
            </div>
            <div class="filter-layout" id="expand">
                <div class="horizontal-stack filter-content">
                    <div class="vertical-stack filter-option">
                        <label for="minutes">Doba tvrvání: <span id="show-minutes"> </span> minut</label>
                        <input type="range" id="minutes" min="0" max="200" value="200" />
                    </div>
                    <div class="vertical-stack filter-option">
                        <label for="sort">Filtrovat podle:</label>
                        <select name="sort" id="sort">
                            <option value="1">Nejoblíbenější</option>
                            <option value="2">Nejméně oblíbené</option>
                            <option value="3">Nejrychlejší</option>
                            <option value="4">Nejdelší</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <input type="text" id="search" placeholder="Hledat" onchange="" />
        <div class="recipes-layout">

        </div>
    </div>


    <script src="/scripts/layout.js"></script>
    <script>
        let recipeArray = [];
        const recipesLayout = document.querySelector(".recipes-layout");
        let showFilters = false;

        const generateRecipe = (id, name, description, minutes, rating, reviews) => {
            const recipeEl = document.createElement("div");
            recipeEl.className = "recipe-card";
            recipeEl.id = id;
            recipeEl.onclick = () => {
                window.location.href = `/pages/recipe.php?id=${id}`
            }
            recipeEl.innerHTML = `
                        <div class="name-layout vertical-stack">
                            <h3 class="recipe-name">${name}</h3>
                        </div>
                        <div class="recipe-text">
                            <p>${description}</p>
                            <p style='text-align: right;'>${rating}☆ (${reviews})</p>
                            <p class="recipe-minutes">${minutes} minut</p>
                        </div>
                    `;

            recipesLayout.appendChild(recipeEl);
        }

        fetch("/server/recipes.php")
            .then(response => response.json())
            .then(recipes => {
                recipeArray = recipes;

                recipeArray.forEach(({
                    id,
                    recipe_name,
                    description,
                    prep_time_minutes,
                    average_rating,
                    total_reviews
                }) => generateRecipe(id, recipe_name, description, prep_time_minutes, average_rating, total_reviews));
            })
            .catch(err => console.error(err));

        document.getElementById("search").addEventListener("input", event => {
            recipesLayout.innerHTML = "";

            recipeArray.filter(({
                recipe_name
            }) => recipe_name.toLowerCase().startsWith(event.target.value.toLowerCase())).forEach(({
                id,
                recipe_name,
                description,
                prep_time_minutes,
                average_rating,
                total_reviews
            }) => generateRecipe(id, recipe_name, description, prep_time_minutes, average_rating, total_reviews));
        })

        const arrow = document.getElementById("arrow");
        const filters = document.getElementById("expand");

        document.getElementById("show-filters").addEventListener("click", () => {
            filters.classList.toggle("open")

            if (filters.classList.contains("open")) {
                arrow.innerHTML = "<img src='/assets/up.svg' />";
            } else {
                arrow.innerHTML = "<img src='/assets/down.svg' />";
            }
        });

        const showMinutes = document.getElementById("show-minutes");
        const range = document.getElementById("minutes");

        showMinutes.innerHTML = range.value;

        range.addEventListener("change", event => {
            recipesLayout.innerHTML = "";
            showMinutes.innerHTML = event.target.value;

            recipeArray.filter(({
                prep_time_minutes
            }) => prep_time_minutes <= Number(event.target.value)).forEach(({
                id,
                recipe_name,
                description,
                prep_time_minutes,
                average_rating,
                total_reviews
            }) => generateRecipe(id, recipe_name, description, prep_time_minutes, average_rating, total_reviews));
        });

        const select = document.getElementById("sort");

        select.addEventListener("input", event => {
            const option = event.target.value;
            recipesLayout.innerHTML = "";
            let sorted;

            if (option == 1)
                sorted = recipeArray.sort((a, b) => b.average_rating - a.average_rating);
            else if (option == 2)
                sorted = recipeArray.sort((a, b) => a.average_rating - b.average_rating);

            else if (option == 3)
                sorted = recipeArray.sort((a, b) => a.prep_time_minutes - b.prep_time_minutes);

            else if (option == 4)
                sorted = recipeArray.sort((a, b) => b.prep_time_minutes - a.prep_time_minutes);

            sorted.forEach(({
                id,
                recipe_name,
                description,
                prep_time_minutes,
                average_rating,
                total_reviews
            }) => generateRecipe(id, recipe_name, description, prep_time_minutes, average_rating, total_reviews));
        });
    </script>
</body>

</html>