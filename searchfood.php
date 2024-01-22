<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cf.css">
    <title>Voedingsinformatie Zoeken</title>
    <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
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
              <!-- Search Icon incase you want to use it uncomment this line. -->
              <!-- <form class="form-inline my-2 my-lg-0 ml-0 ml-lg-4 mb-3 mb-lg-0">
                <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit"></button>
              </form> -->
            </div>
            <div class="quote_btn-container ml-0 ml-lg-4 d-flex justify-content-center">
            </div>
          </div>
        </nav>
      </div>
    </header>

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
