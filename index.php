<?php
session_start();

    $_SESSION;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>H-Sport</title>
</head>

<body>

    <h1>H-Sport</h1>

    <div class="food-container">
        <div class="food-info">
    <form id="compareForm" action="" method="post">
        <label for="foodQuery1">Voedsel 1 Zoeken:</label>
        <input type="text" id="foodQuery1" name="foodQuery1" required>

        <label for="foodQuery2">Voedsel 2 Zoeken:</label>
        <input type="text" id="foodQuery2" name="foodQuery2" required>

        <button type="submit" name="compareSubmit">Vergelijken</button>
    </form>
</div>
</div>

    <?php
    function displayFoodInfo($data, $listId)
    {
        if (isset($data['hints'][0]['food']['label'])) {
            $food_label = $data['hints'][0]['food']['label'];
            $nutrients = $data['hints'][0]['food']['nutrients'];

            echo "<h3>$food_label</h3>";
            echo "<ul id='$listId'>";
            foreach ($nutrients as $nutrient_name => $nutrient_value) {
                echo "<li>$nutrient_name: $nutrient_value</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Product niet gevonden of er is een probleem opgetreden bij het ophalen van de gegevens.</p>";
        }
    }

    function compareFoodInfo($data1, $data2)
    {
        // Voeg hier je vergelijkingslogica toe
        // Je kunt bijvoorbeeld de voedingsinformatie van beide producten vergelijken en de resultaten weergeven
        echo "<div class='food-container'>";
        echo "<div class='food-info'>";
        echo "<h2>Voedsel 1</h2>";
        displayFoodInfo($data1, 'foodInfoList1');
        echo "</div>";

        echo "<div class='food-info'>";
        echo "<h2>Voedsel 2</h2>";
        displayFoodInfo($data2, 'foodInfoList2');
        echo "</div>";
        echo "</div>";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $app_id = 'a3e54bf3';
        $app_key = 'a65f889508bc702ec27a1044bd5fba6b';

        $food_query1 = isset($_POST['foodQuery1']) ? $_POST['foodQuery1'] : '';
        $food_query2 = isset($_POST['foodQuery2']) ? $_POST['foodQuery2'] : '';

        $api_url1 = "https://api.edamam.com/api/food-database/v2/parser?ingr=$food_query1&app_id=$app_id&app_key=$app_key";
        $api_url2 = "https://api.edamam.com/api/food-database/v2/parser?ingr=$food_query2&app_id=$app_id&app_key=$app_key";

        $ch1 = curl_init($api_url1);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        $json_data1 = curl_exec($ch1);
        curl_close($ch1);
        $data1 = json_decode($json_data1, true);

        $ch2 = curl_init($api_url2);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        $json_data2 = curl_exec($ch2);
        curl_close($ch2);
        $data2 = json_decode($json_data2, true);

        if (isset($_POST['compareSubmit'])) {
            compareFoodInfo($data1, $data2);
        }
    }
    ?>