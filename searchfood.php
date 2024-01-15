<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cf.css">
    <title>Voedingsinformatie Zoeken</title>
</head>
<body>

<h1>H+Sport | Voedingsinformatie Zoeken</h1>

<div class="food-container">
    <div class="food-info">
        <form id="foodSearchForm" action="" method="post">
            <label for="foodQuery">Voedsel Zoeken:</label>
            <input type="text" id="foodQuery" name="foodQuery" required>
            <button type="submit">Zoeken</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $food_query = isset($_POST['foodQuery']) ? $_POST['foodQuery'] : '';
           
            $app_id = 'a3e54bf3';
            $app_key = 'a65f889508bc702ec27a1044bd5fba6b';

            // Bouw de API-url op
            $api_url = "https://api.edamam.com/api/food-database/v2/parser?ingr=$food_query&app_id=$app_id&app_key=$app_key";

            // Haal gegevens op van de API
            $json_data = file_get_contents($api_url);
            $data = json_decode($json_data, true);

            // Controleer of de API-oproep succesvol was
            if (isset($data['hints'][0]['food']['label'])) {
                // Toon de nuttige informatie
                $food_label = $data['hints'][0]['food']['label'];
                $nutrients = $data['hints'][0]['food']['nutrients'];

                echo "<h2>$food_label</h2>";
                echo "<h3>Nutritional Content:</h3>";
                echo "<ul>";
                foreach ($nutrients as $nutrient_name => $nutrient_value) {
                    echo "<li>$nutrient_name: $nutrient_value</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Product niet gevonden of er is een probleem opgetreden bij het ophalen van de gegevens.</p>";
            }
        }
        ?>
    </div>
</div>

</body>
</html>
