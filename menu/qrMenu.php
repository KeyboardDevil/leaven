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
  if ($rowCount > 0) {
    while ($row = $dbOutput->fetch_assoc()) {
      $dbName = $row["name"];
      $dbAbv = $row["abv"];
      $dbDesc = $row["description"];
      echo "<div class=\"beer\">\n";
      echo "<h1>$dbName</h1>\n";
      echo "<h2>$dbAbv</h2>\n";
      echo "<h3>$dbDesc</h3>\n";
      echo "</div>\n";
    }
    echo '<img src="img/poweredBy.gif" id="BeerMSLogo">';
  }
  ?>
</body>

</html>