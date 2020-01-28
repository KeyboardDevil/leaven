<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="StyleSheet" href="style.css" />
    <title>Menu</title>
  </head>
  <body>
    <?php
      require '../cms/beersDB.php';
      $iCount = 0;
      $sql = 'SELECT * FROM beers WHERE active=1';
      $dbOutput = $conn->query($sql);
      $rowCount = $dbOutput -> num_rows;
      if ($rowCount > 0) {
        while($row = $dbOutput ->fetch_assoc()) {
          $dbName = $row["name"];
          $dbAbv = $row["abv"];
          $dbShortDesc = $row["shortdescription"];
          $renderRow = false;
          // Let's render this son of a bitch!
          if ($iCount%2==0) {$renderRow = true;}
          if($renderRow) {
            echo"<div class=\"row\">\n";
          }
          echo "<div class=\"beer\">\n";
          echo "<h1>$dbName</h1>\n";
          echo "<h2>$dbAbv</h2>\n";
          echo "<h3>$dbShortDesc</h3>\n";
          echo "</div>\n";
          if(!$renderRow) { // if false, end of row, close that bastard
            echo"</div>\n";
          }
          $iCount++;
          // After 6 beers, BREAK YO SELF FOOL!
          if($iCount>5){break;}
        }
      }
    ?>
    <img id="MenuFooter" src="img/menuFooter.gif">
  </body>
</html>