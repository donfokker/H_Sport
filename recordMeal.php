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
    <title>H+ Sport</title>
</head>

<body>


<h1>H-Sport</h1>

<div class="food-container">
    <div class="food-info">
<form id="compareForm" action="" method="post">
    <label for="foodQuery1">Voedsel 1 Zoeken:</label>
    <input type="text" id="foodQuery1" name="foodQuery1" required>
    <button type="submit" name="compareSubmit">Vergelijken</button>
</form>
</div>
</div>

<?php
    function displayFoodInfo0($data, $listId)
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
function compareFoodInfo0($data1)
{
    echo "<div class='food-container'>";
    echo "<div class='food-info'>";
    echo "<h2>Voedsel 1</h2>";
    displayFoodInfo0($data1, 'foodInfoList1');
    echo "</div>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $app_id = 'a3e54bf3';
    $app_key = 'a65f889508bc702ec27a1044bd5fba6b';

    $food_query1 = isset($_POST['foodQuery1']) ? $_POST['foodQuery1'] : '';
    $food_query2 = isset($_POST['foodQuery2']) ? $_POST['foodQuery2'] : '';

    $api_url1 = "https://api.edamam.com/api/food-database/v2/parser?ingr=$food_query1&app_id=$app_id&app_key=$app_key";

    $ch1 = curl_init($api_url1);
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    $json_data1 = curl_exec($ch1);
    curl_close($ch1);
    $data1 = json_decode($json_data1, true);
}
if (isset($_POST['compareSubmit'])) {
    compareFoodInfo0($data1);
}
?>


<hr>
<br>
<?php
session_start();

if (!isset($_SESSION['selectedItems'])) {
    $_SESSION['selectedItems'] = array();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $app_id = 'a3e54bf3';
    $app_key = 'a65f889508bc702ec27a1044bd5fba6b';

    $food_query1 = isset($_POST['foodQuery1']) ? $_POST['foodQuery1'] : '';

    $api_url1 = "https://api.edamam.com/api/food-database/v2/parser?ingr=$food_query1&app_id=$app_id&app_key=$app_key";

    $ch1 = curl_init($api_url1);
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    $json_data1 = curl_exec($ch1);
    curl_close($ch1);
    $data1 = json_decode($json_data1, true);

    if (isset($_POST['compareSubmit'])) {
        saveSelectedItemToSession($data1);
    }
}

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

function compareFoodInfo1($data1)
{
    echo "<div class='food-container'>";
    echo "<div class='food-info'>";
    echo "<h2>Voedsel 1</h2>";
    displayFoodInfo($data1, 'foodInfoList1');
    echo "</div>";
}

function saveSelectedItemToSession($data)
{
    if (isset($data['hints'][0]['food']['label'])) {
        $food_label = $data['hints'][0]['food']['label'];
        $nutrients = $data['hints'][0]['food']['nutrients'];

        $_SESSION['selectedItems'][] = array('foodName' => $food_label, 'nutrients' => $nutrients);
    }
}
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
            <button type="submit" name="compareSubmit">Vergelijken</button>
        </form>
    </div>
</div>

<h2>Selected Food Items</h2>
<ul>
    <?php
    foreach ($_SESSION['selectedItems'] as $selectedItem) {
        echo "<li>";
        echo "<strong>{$selectedItem['foodName']}</strong><br>";
        echo "<ul>";
        foreach ($selectedItem['nutrients'] as $nutrient_name => $nutrient_value) {
            echo "<li>$nutrient_name: $nutrient_value</li>";
        }
        echo "</ul>";
        echo "</li>";
    }
    ?>
</ul>

<form method="post" action="">
    <button type="submit" name="deleteList">Delete List</button>
</form>

</body>
</html>
</body>
</html>