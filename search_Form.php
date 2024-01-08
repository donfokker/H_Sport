<html>
    <head>
        <title>Search</title>
    </head>
    <body>
        <form>
            <input type="text" name="search" required/>
            <input type="submit" value="search" required/>
        </form>
<?php

if(isset($_POST['search'])){
    require "search.php";
    if (count($results) > 0){
        foreach ($result as $r){
            echo "<div>" . $r['name'] . " - " . $r['Description'] . "</div>";
        }
    }else{
         {echo "<div> Nothing found </div>"; }
    }
}
?>
    </body>
</html>