<?php
session_start();

    $_SESSION;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cf.css">
    <title>H-Sport</title>
    <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />
</head>
<body>
<header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container pt-3">
          <a class="navbar-brand" href="index.html">
            <img src="images/logo.png" alt="" /><span>
              H+ Sports
            </span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex ml-auto flex-column flex-lg-row align-items-center">
              <ul class="navbar-nav  ">
                <li class="nav-item active">
                  <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="searchfood.php"> Search Foods</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="comparefood.php"> Compare Foods </a>
                </li>
              </ul>
            </div>
            <div class="quote_btn-container ml-0 ml-lg-4 d-flex justify-content-center">
            </div>
          </div>
        </nav>
      </div>
    </header>


    <h1>H+Sport | Voedsel vergelijken</h1>

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

</body>

</html>