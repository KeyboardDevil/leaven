<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Menu</title>
  <link rel="stylesheet" href="qr.css">
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
  <META HTTP-EQUIV="EXPIRES" CONTENT="0">
</head>

<body>
  <?php
  require '../cms/beersDB.php';
  $sql = 'SELECT * FROM beers WHERE active=1';
  $dbOutput = $conn->query($sql);
  $rowCount = $dbOutput->num_rows;

  echo '<img id="QrTitle" src="img/qrTitle.png">';
  // Call BeerMS for the list
  $response = file_get_contents('https://www.beerms.com/thebeer/?uid=0731ff47');
  $beers = json_decode($response);
  foreach ($beers as $beer) {
    echo "<div class=\"beer\">\n";
    echo "<h1>".$beer->name."</h1>\n";
    echo "<h2>".$beer->abv."% ABV</h2>\n";
    echo "<h3>".$beer->description."</h3>\n";
    echo "</div>\n";
    }
    echo '<a href="https://www.beerms.com"><img src="img/poweredBy.gif" id="BeerMSLogo"></a>';
  ?>
</body>

</html>